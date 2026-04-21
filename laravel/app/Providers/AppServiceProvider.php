<?php

namespace App\Providers;

use App\Services\InfluxDBService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(InfluxDBService::class, function () {
            return new InfluxDBService(
                url: config('services.influxdb.url'),
                token: config('services.influxdb.token'),
                db: config('services.influxdb.db'),
                precision: 'second'
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
