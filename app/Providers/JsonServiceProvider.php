<?php

namespace App\Providers;

use App\Services\JSonDataClient;
use App\Services\NIBSSClient;
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
        $this->app->singleton(NIBSSClient::class, function ($app) {
            return new NIBSSClient([]);
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
