<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Notification;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/notification', Notification::class)->name('notification');

Route::get('/try', function () {
    dump(config('database.connections.influxdb.url'));
});


Route::get('/add', function (InfluxDBService $influx) {
    $rows = [];
    $time = now('UTC')->startOfMinute()->addHours(7);

    $rows[] = [
        'measurement' => 'environment',
        'fields' => [
            'water_flow' => fake()->randomFloat(1, 0.1, 2),
            'ph' => fake()->randomFloat(2, 6, 8),
            'main_valve' => fake()->boolean(75)
        ],
        'time' => $time->getTimestamp()
    ];

    try {
        $influx->storeMultiple(rows: $rows);
        dump('successfull');
    } catch (Throwable $e) {
        dump("Connection Timeout. Detail: " . $e->getMessage());
    }
});
