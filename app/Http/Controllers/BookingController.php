<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Trip;
use App\Models\TripDate;
use App\Models\User;
use App\Services\BookingService;
use App\Services\MidtransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    protected MidtransService $midtransService;

    public function __construct(
        BookingService $bookingService,
        MidtransService $midtransService
    ) {
        $this->bookingService = $bookingService;
        $this->midtransService = $midtransService;
    }

    /**
     * Show booking form untuk trip
     */
    public function create($tripId)
    {
        $trip = Trip::with(['tripDates'])
            ->findOrFail($tripId);

        // Cek jika ada tanggal yang sudah terpilih (misal dari redirect back)
        $preferredDate = old('preferred_date');
        $availableSeats = 0;

        if ($preferredDate) {
            $availableSeats = $this->bookingService->getAvailableSeatsForDate($tripId, $preferredDate);
        }

        return view('booking.create', [
            'trip' => $trip,
            'availableSeats' => $availableSeats,
        ]);
    }

    /**
     * Store booking baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'participants' => 'required|integer|min:1',
            'preferred_date' => 'required|date',
            'phone' => 'required|string|min:10|max:15',
            'special_request' => 'nullable|string|max:500',
        ]);

        $isValidDate = TripDate::where(
            'trip_id',
            $validated['trip_id']
        )
            ->where(
                'date',
                $validated['preferred_date']
            )
            ->exists();

        if (! $isValidDate) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tanggal keberangkatan yang dipilih tidak valid atau sudah tidak tersedia.'
                );
        }

        try {
            $booking =
                $this->bookingService
                    ->createBooking(
                        Auth::id(),
                        $validated['trip_id'],
                        $validated['participants'],
                        $validated
                    );

            return redirect()->route(
                'booking.confirmation',
                $booking->id
            );
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Cek ketersediaan kursi via AJAX
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'date' => 'required|date',
        ]);

        $isValidDate = TripDate::where(
            'trip_id',
            $request->trip_id
        )
            ->where(
                'date',
                $request->date
            )
            ->exists();

        if (! $isValidDate) {
            return response()->json([
                'available_seats' => 0,
                'message' => 'Tanggal tidak tersedia',
            ]);
        }

        $availableSeats =
            $this->bookingService
                ->getAvailableSeatsForDate(
                    $request->trip_id,
                    $request->date
                );

        return response()->json([
            'available_seats' => $availableSeats,
        ]);
    }

    /**
     * Show booking confirmation page
     */
    public function confirmation($bookingId)
    {
        $booking = Booking::with([
            'trip',
            'user',
        ])->findOrFail($bookingId);

        if (
            Auth::id() !==
            $booking->user_id
        ) {
            abort(
                403,
                'Unauthorized'
            );
        }

        try {
            $snapToken =
                $this->midtransService
                    ->createSnapToken(
                        $booking
                    );
        } catch (\Exception $e) {

            Log::error(
                'Failed to generate Snap token: '
                    .$e->getMessage()
            );

            return back()->with(
                'error',
                'Gagal membuat token pembayaran. Silakan coba lagi.'
            );
        }

        return view(
            'booking.confirmation',
            [
                'booking' => $booking,
                'snapToken' => $snapToken,
                'clientKey' => config('midtrans.client_key'),
                'snapUrl' => config('midtrans.snap_url'),
            ]
        );
    }

    /**
     * Handle Midtrans notification
     */
    public function handleNotification(Request $request)
    {
        $notification = $request->all();

        try {
            $this->midtransService
                ->verifySignature(
                    $notification
                );

            $result =
                $this->midtransService
                    ->handleNotification(
                        $notification
                    );

            $orderId =
                $result['order_id'];

            $status =
                $result['status'];

            $booking =
                Booking::where(
                    'order_id',
                    $orderId
                )->firstOrFail();

            DB::transaction(
                function () use (
                    $booking,
                    $status
                ) {

                    if (
                        $status === 'success'
                        &&
                        $booking->status === 'pending'
                    ) {
                        $this->bookingService
                            ->confirmBooking(
                                $booking
                            );
                    } elseif (
                        $status === 'failed'
                        &&
                        $booking->status === 'pending'
                    ) {
                        $booking->update([
                            'status' => 'cancelled',
                        ]);
                    }
                }
            );

            return response()->json([
                'status' => 'ok',
            ]);
        } catch (\Exception $e) {

            Log::error(
                'Midtrans Notification Error: '
                    .$e->getMessage()
            );

            return response()->json(
                ['status' => 'error'],
                400
            );
        }
    }

    /**
     * Show user's bookings
     */
    public function index()
    {
        $user =
            User::find(
                Auth::id()
            );

        if (! $user) {
            abort(403);
        }

        $bookings =
            $user->bookings()
                ->with('trip')
                ->orderBy(
                    'created_at',
                    'desc'
                )
                ->get();

        return view(
            'booking.index',
            [
                'bookings' => $bookings,
            ]
        );
    }

    /**
     * User dashboard
     */
    public function userDashboard()
    {
        $user =
            User::find(
                Auth::id()
            );

        if (! $user) {
            abort(403);
        }

        $bookings =
            $user->bookings()
                ->with('trip')
                ->latest()
                ->get();

        $stats = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        $recentBookings =
            $bookings->take(5);

        return view(
            'user.dashboard',
            compact(
                'user',
                'stats',
                'recentBookings'
            )
        );
    }

    /**
     * Show booking detail
     */
    public function show($bookingId)
    {
        $booking =
            Booking::with([
                'trip',
                'user',
                'paymentTransaction',
            ])
                ->findOrFail(
                    $bookingId
                );

        if (
            Auth::id() !==
            $booking->user_id
        ) {
            abort(
                403,
                'Unauthorized'
            );
        }

        $hasReviewed =
            Review::where(
                'user_id',
                Auth::id()
            )
                ->where(
                    'reviewable_type',
                    'App\Models\Trip'
                )
                ->where(
                    'reviewable_id',
                    $booking->trip_id
                )
                ->exists();

        return view(
            'booking.show',
            [
                'booking' => $booking,

                'hasReviewed' => $hasReviewed,
            ]
        );
    }

    public function downloadTicket($bookingId)
    {
        $booking = Booking::with(['trip', 'user'])->findOrFail($bookingId);

        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'confirmed' && $booking->status !== 'completed') {
            return back()->with('error', 'E-Ticket hanya tersedia untuk pesanan yang sudah lunas/dikonfirmasi.');
        }

        $pdf = Pdf::loadView('emails.ticket', compact('booking'));
        
        return $pdf->download('E-Ticket-' . $booking->order_id . '.pdf');
    }

    /**
     * Cancel booking
     */
    public function cancel($bookingId)
    {
        $booking =
            Booking::findOrFail(
                $bookingId
            );

        if (
            Auth::id() !==
            $booking->user_id
        ) {
            abort(
                403,
                'Unauthorized'
            );
        }

        if (
            ! in_array(
                $booking->status,
                [
                    'pending',
                    'confirmed',
                ]
            )
        ) {
            return back()->with(
                'error',
                'Booking dengan status "'
                    .$booking->status.
                    '" tidak dapat dibatalkan.'
            );
        }

        try {

            $this->bookingService
                ->cancelBooking(
                    $booking
                );

            return back()->with(
                'success',
                'Booking berhasil dibatalkan.'
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
