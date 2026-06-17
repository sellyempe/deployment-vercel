<?php

namespace App\Services;

use App\Mail\BookingConfirmedWithTicket;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\TripDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingService
{
    /**
     * Buat booking baru
     */
    public function createBooking($userId, $tripId, $participants, $additionalData = [])
    {
        return DB::transaction(function () use ($userId, $tripId, $participants, $additionalData) {
            $trip = Trip::lockForUpdate()->findOrFail($tripId);

            // Validasi kuota per tanggal
            $preferredDate = $additionalData['preferred_date'] ?? null;
            if (! $preferredDate) {
                throw new \Exception('Tanggal keberangkatan harus dipilih.');
            }

            $availableSeats = $this->getAvailableSeatsForDate($tripId, $preferredDate);

            if ($participants > $availableSeats) {
                throw new \Exception("Pada tanggal {$preferredDate}, hanya tersisa {$availableSeats} kursi.");
            }

            // Hitung total harga
            $totalPrice = $trip->price * $participants;

            // Generate Order ID
            $timestamp = time();
            $orderIdBase = "PINK-{$tripId}-{$timestamp}";

            // Cek uniqueness order_id
            $orderCount = Booking::where('order_id', 'like', $orderIdBase.'%')->count();
            $orderId = $orderIdBase.($orderCount > 0 ? '-'.($orderCount + 1) : '');

            // Buat booking
            $booking = Booking::create([
                'user_id' => $userId,
                'trip_id' => $tripId,
                'participants' => $participants,
                'total_price' => $totalPrice,
                'order_id' => $orderId,
                'status' => 'pending',
                'preferred_date' => $additionalData['preferred_date'] ?? null,
                'phone' => $additionalData['phone'] ?? null,
                'special_request' => $additionalData['special_request'] ?? null,
            ]);

            return $booking;
        });
    }

    /**
     * Konfirmasi booking setelah pembayaran sukses
     */
    public function confirmBooking($booking)
    {
        return DB::transaction(function () use ($booking) {
            // Update booking status
            $booking->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            // Send confirmation email with PDF Ticket
            try {
                Mail::to($booking->user->email)->send(new BookingConfirmedWithTicket($booking));
            } catch (\Exception $e) {
                // Log email sending error but don't fail the transaction
                \Log::error('Failed to send booking confirmation email with ticket', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return $booking;
        });
    }

    /**
     * Batalkan booking
     */
    public function cancelBooking($booking)
    {
        return DB::transaction(function () use ($booking) {
            // Jika sudah confirmed, kurangi kuota
            if ($booking->status === 'confirmed') {
                $booking->trip->decrement('booked', $booking->participants);
            }

            $booking->update(['status' => 'cancelled']);

            return $booking;
        });
    }

    /**
     * Get available seats untuk trip per tanggal tertentu
     */
    public function getAvailableSeatsForDate($tripId, $date)
    {
        $tripDate = TripDate::where('trip_id', $tripId)
            ->where('date', $date)
            ->first();

        if (! $tripDate) {
            return 0;
        }

        $bookedOnDate = Booking::where('trip_id', $tripId)
            ->whereDate('preferred_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('participants');

        return max(0, $tripDate->kuota - $bookedOnDate);
    }
}
