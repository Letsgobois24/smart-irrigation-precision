<?php

namespace Database\Seeders;

use App\Services\InfluxDBService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Throwable;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(InfluxDBService $influx): void
    {
        $rows = [];

        $end = now()->startOfHour();
        $start = (clone $end)->subDays(7);
        $period = CarbonPeriod::create($start, '4 minutes', $end);

        foreach ($period as $date) {
            $rows[] = [
                'measurement' => 'global',
                'fields' => [
                    'fertilizer_pump' => fake()->boolean(10),
                    'water_pump' => fake()->boolean(60),
                    'water_flow' => fake()->randomFloat(1, 0.1, 2),
                    'light' => fake()->randomFloat(0, 100, 1),
                    'ph' => fake()->randomFloat(2, 6, 8),
                    'main_valve' => fake()->boolean(75)
                ],
                'time' => $date->getTimestamp()
            ];
        }

        try {
            $influx->storeMultiple(rows: $rows);
        } catch (Throwable $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
