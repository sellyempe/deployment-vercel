<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {

    Route::get('/destinations', [DestinationController::class, 'index']);
    Route::get('/destinations/{id}', [DestinationController::class, 'getDetail']);

    Route::get('/trips', [TripController::class, 'index']);
    Route::get('/trips/{id}', [TripController::class, 'show']);

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index']);
        Route::get('/by-key/{key}', [SettingsController::class, 'getByKey']);
        Route::get('/by-category/{category}', [SettingsController::class, 'getByCategory']);
    });

    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{type}/{itemId}', [ReviewController::class, 'getByItem']);

    Route::middleware(['web', 'auth'])->group(function () {

        Route::prefix('wishlists')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('/', [WishlistController::class, 'store']);
            Route::delete('/{id}', [WishlistController::class, 'destroy']);
            Route::delete('/item/{type}/{itemId}', [WishlistController::class, 'destroyByItem']);
            Route::get('/check/{type}/{itemId}', [WishlistController::class, 'check']);
        });

        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{id}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

        Route::prefix('payments')->group(function () {
            Route::get('/', [PaymentTransactionController::class, 'index']);
            Route::get('/by-reference/{referenceId}', [PaymentTransactionController::class, 'getByReference']);
            Route::get('/{id}', [PaymentTransactionController::class, 'show']);
            Route::post('/', [PaymentTransactionController::class, 'store']);
            Route::put('/{id}', [PaymentTransactionController::class, 'update']);
        });

        Route::middleware('admin')->group(function () {

            Route::post('/destinations', [DestinationController::class, 'store']);
            Route::put('/destinations/{id}', [DestinationController::class, 'update']);
            Route::delete('/destinations/{id}', [DestinationController::class, 'destroy']);
            Route::post('/trips', [TripController::class, 'store']);
            Route::put('/trips/{id}', [TripController::class, 'update']);
            Route::delete('/trips/{id}', [TripController::class, 'destroy']);

            Route::post('/settings', [SettingsController::class, 'store']);
            Route::put('/settings/{id}', [SettingsController::class, 'update']);
            Route::delete('/settings/{id}', [SettingsController::class, 'destroy']);
        });
    });
});
