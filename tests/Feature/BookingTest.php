<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Trip $trip;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create(['role' => 'user']);

        // Create test trip with kuota
        $this->trip = Trip::factory()->create([
            'title' => 'Test Trip',
            'price' => 1000000,
            'duration_days' => 3,
            'kuota' => 10,
            'booked' => 0,
            'status' => 'active',
        ]);
    }

    /**
     * Test: User can view booking creation form
     */
    public function test_user_can_view_booking_form(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('booking.create', $this->trip->id));

        $response->assertStatus(200);
        $response->assertViewIs('booking.create');
        $response->assertViewHas('trip', $this->trip);
    }

    /**
     * Test: User must be authenticated to create booking
     */
    public function test_guest_cannot_access_booking_creation(): void
    {
        $response = $this->get(route('booking.create', $this->trip->id));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User can create booking with valid data
     */
    public function test_user_can_store_booking(): void
    {
        $data = [
            'participants' => 2,
            'phone' => '081234567890',
            'preferred_date' => now()->addMonths(1)->format('Y-m-d'),
            'special_request' => 'Makanan halal please',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('booking.store'), array_merge([
                'trip_id' => $this->trip->id,
            ], $data));

        // Should redirect to confirmation
        $response->assertRedirect();

        // Check booking created in database
        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'participants' => 2,
            'phone' => '081234567890',
            'status' => 'pending',
        ]);

        // Check booking exists
        $booking = Booking::where('user_id', $this->user->id)->first();
        $this->assertNotNull($booking);
    }

    /**
     * Test: Booking creation fails with invalid participant count
     */
    public function test_booking_fails_with_invalid_participant_count(): void
    {
        $data = [
            'trip_id' => $this->trip->id,
            'participants' => 15, // More than kuota (10)
            'phone' => '081234567890',
            'preferred_date' => now()->addMonths(1)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('booking.store'), $data);

        $response->assertSessionHasErrors();
    }

    /**
     * Test: Booking fails if kuota exceeded
     */
    public function test_booking_fails_when_kuota_exceeded(): void
    {
        // Set trip to almost full
        $this->trip->update(['booked' => 9]);

        $data = [
            'trip_id' => $this->trip->id,
            'participants' => 3, // 3 > 1 available seat
            'phone' => '081234567890',
            'preferred_date' => now()->addMonths(1)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('booking.store'), $data);

        $response->assertSessionHasErrors();
    }

    /**
     * Test: User can view booking confirmation
     */
    public function test_user_can_view_booking_confirmation(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('booking.confirmation', $booking->id));

        $response->assertStatus(200);
        $response->assertViewHas('booking', $booking);
    }

    /**
     * Test: User cannot view others' booking confirmation
     */
    public function test_user_cannot_view_others_booking(): void
    {
        $otherUser = User::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $otherUser->id,
            'trip_id' => $this->trip->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('booking.confirmation', $booking->id));

        $response->assertStatus(403);
    }

    /**
     * Test: User can view their bookings
     */
    public function test_user_can_view_their_bookings(): void
    {
        Booking::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('booking.index'));

        $response->assertStatus(200);
        $this->assertEquals(3, $this->user->bookings()->count());
    }

    /**
     * Test: User can view booking detail
     */
    public function test_user_can_view_booking_detail(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('booking.show', $booking->id));

        $response->assertStatus(200);
        $response->assertViewHas('booking', $booking);
    }

    /**
     * Test: User can cancel pending booking
     */
    public function test_user_can_cancel_pending_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('booking.cancel', $booking->id));

        // Refresh booking from database
        $booking->refresh();

        // Should be cancelled
        $this->assertEquals('cancelled', $booking->status);
    }

    /**
     * Test: User cannot cancel confirmed booking
     */
    public function test_user_cannot_cancel_confirmed_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('booking.cancel', $booking->id));

        $booking->refresh();

        // Status should not change
        $this->assertEquals('confirmed', $booking->status);
    }

    /**
     * Test: Total price calculated correctly
     */
    public function test_booking_total_price_calculated_correctly(): void
    {
        $this->trip->update(['price' => 500000]);

        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'trip_id' => $this->trip->id,
            'participants' => 4,
        ]);

        // 4 participants * 500000 = 2000000
        $this->assertEquals(2000000, $booking->total_price);
    }
}
