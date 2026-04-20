<?php

namespace Database\Seeders;

use App\Services\InfluxService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(InfluxService $influxService): void
    {
        $rooms = ['Kitchen', 'Meeting Room', 'Living Room', 'Dining Room'];
        $data = [];

        $end = now()->startOfDay()->subHours(7);
        $start = (clone $end)->subDays(14);
        $period = CarbonPeriod::create($start, '3 hours', $end);

        foreach ($rooms as $room) {
            foreach ($period as $date) {
                $data[] = [
                    'room' => $room,
                    'hum' => fake()->randomFloat(1, 20, 60),
                    'temp' => fake()->randomFloat(2, 10, 35),
                    'time' => $date->getTimestamp()
                ];
            }
        }

        $influxService->storeMultiple($data);
    }
}
