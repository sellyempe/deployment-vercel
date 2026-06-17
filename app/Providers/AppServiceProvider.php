<?php

namespace App\Providers;

use App\Models\Booking;
use App\Policies\BookingPolicy;
use App\Services\BookingService;
use App\Services\MidtransService;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Services
        $this->app->singleton(BookingService::class, function ($app) {
            return new BookingService;
        });

        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Gate $gate): void
    {
        // Register Policies
        $gate->policy(Booking::class, BookingPolicy::class);

        // Morph Map for cleaner polymorphic types
        Relation::morphMap([
            'trip' => 'App\Models\Trip',
            'destination' => 'App\Models\Destination',
            'category' => 'App\Models\Category',
        ]);
    }
}
