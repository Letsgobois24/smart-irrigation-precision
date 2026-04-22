<?php

namespace Database\Seeders;

use App\Services\InfluxDBService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Throwable;

class NodeSeeder extends Seeder
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
            for ($tree_id = 1; $tree_id <= 4; $tree_id++) {
                $rows[] = [
                    'measurement' => 'node',
                    'tags' => [
                        'node_id' => 1,
                        'tree_id' => $tree_id
                    ],
                    'fields' => [
                        'soil_moisture' => fake()->randomFloat(1, 50, 80),
                        'valve' => fake()->boolean(75)
                    ],
                    'time' => $date->getTimestamp()
                ];
            }
        }

        try {
            $influx->storeMultiple(rows: $rows);
            dump('successfull');
        } catch (Throwable $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
