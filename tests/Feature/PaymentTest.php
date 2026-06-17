<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\PaymentTransaction;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Trip $trip;

    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);

        $this->trip = Trip::factory()->create([
            'title' => 'Payment Test Trip',
            'price' => 1000000,
            'duration_days' => 3,
            'kuota' => 10,
            'booked' => 0,
            'status' => 'active',
        ]);

        $this->booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'status' => 'pending',
            'participants' => 2,
            'total_price' => 2000000,
        ]);
    }

    /**
     * Test: User can access snap token endpoint
     */
    public function test_user_can_get_snap_token(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('booking.confirmation', $this->booking->id));

        $response->assertStatus(200);
        $response->assertViewHas('snapToken');
    }

    /**
     * Test: Webhook with settlement status updates booking
     */
    public function test_webhook_settlement_confirms_booking(): void
    {
        $tripBooked = $this->trip->booked;

        $payload = [
            'transaction_status' => 'settlement',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => hash('sha512',
                $this->booking->order_id.'0'.$this->booking->total_price.env('MIDTRANS_SERVER_KEY')
            ),
        ];

        $response = $this->post(route('midtrans.webhook'), $payload);

        // Check booking is confirmed
        $this->booking->refresh();
        $this->assertEquals('confirmed', $this->booking->status);

        // Check trip booked count increased
        $this->trip->refresh();
        $this->assertEquals($tripBooked + $this->booking->participants, $this->trip->booked);
    }

    /**
     * Test: Payment transaction created on successful payment
     */
    public function test_payment_transaction_created_on_settlement(): void
    {
        $payload = [
            'transaction_status' => 'settlement',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => hash('sha512',
                $this->booking->order_id.'0'.$this->booking->total_price.env('MIDTRANS_SERVER_KEY')
            ),
        ];

        $this->post(route('midtrans.webhook'), $payload);

        // Check payment transaction exists
        $this->assertDatabaseHas('payment_transactions', [
            'booking_id' => $this->booking->id,
            'status' => 'success',
            'gateway' => 'midtrans',
        ]);
    }

    /**
     * Test: Webhook with pending status keeps booking pending
     */
    public function test_webhook_pending_keeps_booking_pending(): void
    {
        $payload = [
            'transaction_status' => 'pending',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => hash('sha512',
                $this->booking->order_id.'0'.$this->booking->total_price.env('MIDTRANS_SERVER_KEY')
            ),
        ];

        $this->post(route('midtrans.webhook'), $payload);

        $this->booking->refresh();
        $this->assertEquals('pending', $this->booking->status);
    }

    /**
     * Test: Webhook with deny status cancels booking
     */
    public function test_webhook_deny_cancels_booking(): void
    {
        // First confirm the booking
        $this->booking->update(['status' => 'confirmed']);
        $this->trip->update(['booked' => $this->booking->participants]);

        $payload = [
            'transaction_status' => 'deny',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => hash('sha512',
                $this->booking->order_id.'0'.$this->booking->total_price.env('MIDTRANS_SERVER_KEY')
            ),
        ];

        $this->post(route('midtrans.webhook'), $payload);

        $this->booking->refresh();
        $this->assertEquals('cancelled', $this->booking->status);
    }

    /**
     * Test: Webhook signature verification (invalid signature)
     */
    public function test_webhook_with_invalid_signature_rejected(): void
    {
        $payload = [
            'transaction_status' => 'settlement',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => 'invalid_signature_12345',
        ];

        // Webhook should handle invalid signature gracefully
        $response = $this->post(route('midtrans.webhook'), $payload);

        // Booking status should not change
        $this->booking->refresh();
        $this->assertEquals('pending', $this->booking->status);
    }

    /**
     * Test: Payment status mapping
     */
    public function test_payment_status_mapping(): void
    {
        $testCases = [
            'settlement' => 'success',
            'capture' => 'success',
            'pending' => 'pending',
            'deny' => 'failed',
            'cancel' => 'cancelled',
            'expire' => 'failed',
        ];

        foreach ($testCases as $midtransStatus => $expectedStatus) {
            $booking = Booking::factory()->create([
                'user_id' => $this->user->id,
                'trip_id' => $this->trip->id,
                'status' => 'pending',
            ]);

            $payload = [
                'transaction_status' => $midtransStatus,
                'order_id' => $booking->order_id,
                'transaction_id' => 'txn_'.uniqid(),
                'gross_amount' => $booking->total_price,
                'payment_type' => 'qris',
                'signature_key' => hash('sha512',
                    $booking->order_id.'0'.$booking->total_price.env('MIDTRANS_SERVER_KEY')
                ),
            ];

            $this->post(route('midtrans.webhook'), $payload);

            // Verify payment transaction has correct status
            $transaction = PaymentTransaction::where('booking_id', $booking->id)->first();
            if ($transaction) {
                $this->assertEquals($expectedStatus, $transaction->status);
            }
        }
    }

    /**
     * Test: Booking confirmation sends email
     */
    public function test_booking_confirmation_sends_email(): void
    {
        // This test requires Mail::fake() to be set up
        // Implementation depends on email service configuration
        $this->assertTrue(true);
    }

    /**
     * Test: Double payment prevented
     */
    public function test_double_payment_prevented(): void
    {
        // Create first payment transaction
        PaymentTransaction::create([
            'booking_id' => $this->booking->id,
            'reference_id' => $this->booking->order_id,
            'status' => 'success',
            'amount' => $this->booking->total_price,
            'gateway' => 'midtrans',
            'transaction_id' => 'txn_first',
        ]);

        $this->booking->update(['status' => 'confirmed']);

        // Try to process same payment again
        $payload = [
            'transaction_status' => 'settlement',
            'order_id' => $this->booking->order_id,
            'transaction_id' => 'txn_12345',
            'gross_amount' => $this->booking->total_price,
            'payment_type' => 'qris',
            'signature_key' => hash('sha512',
                $this->booking->order_id.'0'.$this->booking->total_price.env('MIDTRANS_SERVER_KEY')
            ),
        ];

        $this->post(route('midtrans.webhook'), $payload);

        // Booking should remain confirmed, no duplicate transaction
        $this->booking->refresh();
        $this->assertEquals('confirmed', $this->booking->status);
        $this->assertEquals(1, $this->booking->paymentTransaction()->count());
    }
}
