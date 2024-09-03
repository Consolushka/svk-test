<?php

namespace App\Providers;

use App\Services\Booking\ExternalClients\ExternalBookingClientInterface;
use App\Services\Booking\ExternalClients\LeadBookAPIClient;
use Exception;
use Illuminate\Support\ServiceProvider;

class BookingClientProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ExternalBookingClientInterface::class, function () {
            return match (config('services.booking.external_client')) {
                'leadbook' => new LeadBookAPIClient(
                    config('services.booking.external_clients.leadbook.url'),
                    config('services.booking.external_clients.leadbook.token')
                ),
                default => throw new Exception('Unknown booking client'),
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
