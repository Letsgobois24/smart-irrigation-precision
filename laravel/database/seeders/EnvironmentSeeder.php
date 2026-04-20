<?php

namespace Database\Seeders;

use App\Services\InfluxService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(InfluxService $influxService): void
    {
        $data = [];

        $end = now()->startOfDay()->subHours(7);
        $start = (clone $end)->subDays(1);
        $period = CarbonPeriod::create($start, '3 hours', $end);

        foreach ($period as $date) {
            $data[] = [
                'water_flow' => fake()->randomFloat(1, 0.1, 2),
                'ph' => fake()->randomFloat(2, 6, 8),
                'main_valve' => fake()->boolean(75),
                'time' => $date->getTimestamp()
            ];
        }

        $influxService->storeMultiple($data, 'environtment');
    }
}
