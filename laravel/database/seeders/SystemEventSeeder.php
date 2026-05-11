<?php

namespace Database\Seeders;

use App\Services\InfluxDBService;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(InfluxDBService $influx): void
    {
        $rows = [];

        $end = now()->startOfHour();
        $start = (clone $end)->subDays(1);
        $randomMinutes = random_int(60, 180);
        $period = CarbonPeriod::create($start, "$randomMinutes minutes", $end);

        foreach ($period as $date) {
            $valve_status = fake()->boolean(50);

            $current_before = $valve_status ? 1.0 : fake()->randomFloat(1, 100, 120);
            $current_after = !$valve_status ? 1.0 : fake()->randomFloat(1, 100, 120);

            $rows[] = [
                'measurement' => 'system_event',
                'tags' => [
                    'node_id' => 1,
                    'tree_id' => random_int(1, 4)
                ],
                'fields' => [
                    'valve' => $valve_status,
                    'current_before' => (float) $current_before,
                    'current_avg' => ($current_before + $current_after) / 2,
                    'current_after_2s' => (float) $current_after,
                    'moisture_before' => $valve_status ? fake()->randomFloat(1, 50, 60) : fake()->randomFloat(1, 70, 80),
                    'moisture_after_10m' => !$valve_status ? fake()->randomFloat(1, 50, 60) : fake()->randomFloat(1, 70, 80),
                    'water_flow' => $valve_status ? fake()->randomFloat(1, 0.1, 0.5) : fake()->randomFloat(1, 1, 2),
                    'duration' => 600,
                ],
                'time' => now()->getTimestamp()
            ];
        }

        dump($rows[0]);
        dump($randomMinutes);

        try {
            $influx->storeMultiple(rows: $rows);
        } catch (Exception $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
