<?php

namespace App\Providers;

use App\Services\FastAPIServices;
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
                url: config('database.connections.influxdb.url'),
                token: config('database.connections.influxdb.token'),
                db: config('database.connections.influxdb.db'),
                precision: 'second'
            );
        });

        $this->app->singleton(FastAPIServices::class, function () {
            return new FastAPIServices(
                url: config('services.fastapi.url')
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
