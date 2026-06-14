<?php

use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\Energy;
use App\Livewire\Pages\EventMonitoring;
use App\Livewire\Pages\GlobalMonitoring;
use App\Livewire\Pages\Location;
use App\Livewire\Pages\NodeMonitoring;
use App\Models\Notification;
use App\Services\InfluxDBService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class);
Route::get('/global-monitoring', GlobalMonitoring::class);
Route::get('/node-monitoring', NodeMonitoring::class);
Route::get('/event-monitoring', EventMonitoring::class);
Route::get('/location', Location::class);
Route::get('/energy', Energy::class);

Route::get('/try', function () {
    $notifications = Notification::select('*')->with('rule:feature_name,title')->first();
    dd($notifications->rule->title);
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
