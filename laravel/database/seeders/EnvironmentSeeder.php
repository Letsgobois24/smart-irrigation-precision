<?php

namespace Database\Seeders;

use App\Services\InfluxDBService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Throwable;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(InfluxDBService $influx): void
    {
        $rows = [];

        $end = now()->startOfHour();
        $start = (clone $end)->subDays(14);
        $period = CarbonPeriod::create($start, '5 minutes', $end);

        foreach ($period as $date) {
            $rows[] = [
                'measurement' => 'environment',
                'fields' => [
                    'water_flow' => fake()->randomFloat(1, 0.1, 2),
                    'ph' => fake()->randomFloat(2, 6, 8),
                    'main_valve' => fake()->boolean(75)
                ],
                'time' => $date->getTimestamp()
            ];
        }

        try {
            $influx->storeMultiple(rows: $rows);
            dump('successfull');
        } catch (Throwable $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
