<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;

class InfluxDBProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client([
                "url" => config('services.influxdb.url'),
                "token" => config('services.influxdb.token'),
                "bucket" => config('services.influxdb.bucket'),
                "org" => config('services.influxdb.org'),
                "precision" => WritePrecision::S,
            ]);
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
