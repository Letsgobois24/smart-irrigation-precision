<?php

use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;
use InfluxDB2\ApiException;
use InfluxDB2\Client;
use InfluxDB2\Point;

Route::get('/', Home::class)->name('home');

Route::get('/try', function (Client $client) {
    $writeApi = $client->createWriteApi();

    $point = Point::measurement('environment')
        ->addField('water_flow', fake()->randomFloat(1, 0.1, 2))
        ->addField('ph', fake()->randomFloat(2, 6, 8))
        ->addField('main_valve', fake()->boolean(75))
        ->time(time());

    try {
        $writeApi->write($point);
    } catch (ApiException $e) {
        dump("Connection Timeout. Detail: " . $e->getMessage());
    } catch (Throwable $e) {
        dump($e->getMessage());
    }
});
