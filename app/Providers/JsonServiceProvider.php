<?php

namespace App\Providers;

use App\Services\JSonDataClient;
use Illuminate\Support\ServiceProvider;

class JsonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(JSonDataClient::class, function ($app) {
            return new JSonDataClient([]);
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
