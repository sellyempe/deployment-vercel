<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\PaymentTransaction;
use App\Services\BookingService;
use Illuminate\Console\Command;

class CheckBookingStatus extends Command
{
    protected $signature = 'booking:check-status';

    protected $description = 'Check and fix booking status based on payment';

    public function handle()
    {
        $booking = Booking::latest()->first();

        if (! $booking) {
            $this->error('No booking found');

            return;
        }

        $this->info('=== BOOKING INFO ===');
        $this->line('ID: '.$booking->id);
        $this->line('Order ID: '.$booking->order_id);
        $this->line('Status: '.$booking->status);
        $this->line('Total Price: Rp '.number_format($booking->total_price, 0, ',', '.'));
        $this->line('User: '.$booking->user->name);
        $this->line('Trip: '.$booking->trip->title);
        $this->newLine();

        // Check payment transaction
        $payment = PaymentTransaction::where('reference_id', $booking->order_id)->first();

        if ($payment) {
            $this->info('=== PAYMENT TRANSACTION ===');
            $this->line('ID: '.$payment->id);
            $this->line('Reference: '.$payment->reference_id);
            $this->line('Amount: Rp '.number_format($payment->amount, 0, ',', '.'));
            $this->line('Status: '.$payment->status);
            $this->line('Gateway: '.$payment->gateway);
            $this->line('Gateway TX ID: '.($payment->gateway_transaction_id ?? 'N/A'));
            $this->newLine();

            // Auto confirm if payment success
            if ($payment->status === 'success' && $booking->status === 'pending') {
                if ($this->confirm('Payment success tapi booking masih pending. Update status ke confirmed?')) {
                    $bookingService = app(BookingService::class);
                    $bookingService->confirmBooking($booking);

                    $booking->refresh();
                    $this->info('✓ Booking status updated to: '.$booking->status);
                    $this->info('✓ Trip booked count: '.$booking->trip->booked);
                }
            }
        } else {
            $this->warn('No payment transaction found for this booking');
            $this->info('Maybe payment belum di-create, atau webhook belum trigger');
        }
    }
}
