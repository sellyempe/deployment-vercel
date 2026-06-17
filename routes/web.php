<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [LandingController::class, 'index']);

// Public Routes
// =====================

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/destination/{id}', [DestinationController::class, 'show'])->name('destination.show');
Route::get('/trip/{id}', [TripController::class, 'detail'])->name('trip.detail');

// =====================
// Auth Routes
// =====================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// =====================
// Email Verification Routes
// =====================

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerifyEmailController::class, 'show'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// =====================
// User Routes
// =====================

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Booking
    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('booking.index');
        Route::get('/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check_availability');
        Route::get('/create/{trip_id}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
        Route::get('/{id}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
        Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
        Route::get('/{id}/download-ticket', [BookingController::class, 'downloadTicket'])->name('booking.download_ticket');
    });
});

// =====================
// Admin Routes
// =====================

Route::middleware(['auth', 'admin', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Trips Management
    Route::prefix('trips')->group(function () {
        Route::get('/create', [AdminController::class, 'createTrip'])->name('admin.trips.create');
        Route::post('/', [AdminController::class, 'storeTrip'])->name('admin.trips.store');
        Route::get('/{id}/edit', [AdminController::class, 'editTrip'])->name('admin.trips.edit');
        Route::put('/{id}', [AdminController::class, 'updateTrip'])->name('admin.trips.update');
        Route::delete('/{id}', [AdminController::class, 'destroyTrip'])->name('admin.trips.destroy');
    });

    // Destinations Management
    Route::prefix('destinations')->group(function () {
        Route::get('/', [AdminController::class, 'destinationsDashboard'])->name('admin.destinations.dashboard');
        Route::get('/create', [AdminController::class, 'createDestination'])->name('admin.destinations.create');
        Route::post('/', [AdminController::class, 'storeDestination'])->name('admin.destinations.store');
        Route::get('/{id}/edit', [AdminController::class, 'editDestination'])->name('admin.destinations.edit');
        Route::put('/{id}', [AdminController::class, 'updateDestination'])->name('admin.destinations.update');
        Route::delete('/{id}', [AdminController::class, 'destroyDestination'])->name('admin.destinations.destroy');
    });

    // Bookings Management
    Route::prefix('bookings')->group(function () {
        Route::get('/', [AdminController::class, 'bookingsDashboard'])->name('admin.bookings.dashboard');
        Route::get('/export/{status}', [AdminController::class, 'exportBookings'])->name('admin.bookings.export');
        Route::post('/{id}/complete', [AdminController::class, 'completeBooking'])->name('admin.bookings.complete');
    });

    // Reviews Management
    Route::prefix('reviews')->group(function () {
        Route::get('/', [AdminController::class, 'reviewsDashboard'])->name('admin.reviews.dashboard');
        Route::put('/{id}/approve', [AdminController::class, 'approveReview'])->name('admin.reviews.approve');
        Route::put('/{id}/reject', [AdminController::class, 'rejectReview'])->name('admin.reviews.reject');
    });

    // Company Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Image Management
    Route::delete('/images/{id}', [AdminController::class, 'destroyImage'])->name('admin.images.destroy');
});

// =====================
// Webhooks
// =====================

Route::post('/midtrans-webhook', [BookingController::class, 'handleNotification'])->name('midtrans.webhook');

// =====================
// User Dashboard Route
// =====================

Route::middleware(['auth', 'user', 'verified'])->prefix('user')->group(function () {
    Route::get('/dashboard', [BookingController::class, 'userDashboard'])->name('user.dashboard');
});