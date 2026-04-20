<?php

use App\Livewire\Pages\Home;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Route;
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

    $writeApi->write($point);
    return dump('ok');
});

Route::get('/try2', function (Client $client) {
    $writeApi = $client->createWriteApi();
    $points = [];

    $end = now()->startOfDay()->subHours(7);
    $start = (clone $end)->subDays(14);
    $period = CarbonPeriod::create($start, '3 hours', $end);

    foreach ($period as $date) {
        $points[] = Point::measurement('environment')
            ->addField('water_flow', fake()->randomFloat(1, 0.1, 2))
            ->addField('ph', fake()->randomFloat(2, 6, 8))
            ->addField('main_valve', fake()->boolean(75))
            ->time($date->getTimestamp());
    }

    $writeApi->write($points);
    return dump('ok');
});

Route::get('/try3', function (Client $client) {
    $writeApi = $client->createWriteApi();
    $points = [];

    $end = now()->startOfDay()->subHours(7);
    $start = (clone $end)->subDays(14);
    $period = CarbonPeriod::create($start, '3 hours', $end);

    foreach ($period as $date) {
        for ($tree_id = 1; $tree_id <= 4; $tree_id++) {
            $points[] = Point::measurement('node')
                ->addTag('node_id', '1')
                ->addTag('tree_id', str($tree_id))
                ->addField('soil_moisture', fake()->randomFloat(1, 40, 80))
                ->addField('valve', fake()->boolean(75))
                ->time($date->getTimestamp());
        }
    }

    $writeApi->write($points);
    return dump('ok');
});
