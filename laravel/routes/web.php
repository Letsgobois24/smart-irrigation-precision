<?php

use App\Livewire\Pages\Energy;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Location;
use App\Models\Tree;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);
Route::get('/energy', Energy::class);
Route::get('/location', Location::class);

Route::get('/try', function () {
    $trees = Tree::all();
    dd($trees);
});


Route::get('/add', function (InfluxDBService $influx) {
    $rows = [];
    $time = now('UTC')->startOfMinute()->addHours(7);

    $rows[] = [
        'measurement' => 'global',
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
