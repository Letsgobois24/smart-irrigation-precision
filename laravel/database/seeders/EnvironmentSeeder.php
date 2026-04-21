<?php

namespace Database\Seeders;

use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use InfluxDB2\ApiException;
use InfluxDB2\Client;
use InfluxDB2\Point;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Client $client): void
    {
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

        try {
            $writeApi->write($points);
        } catch (ApiException $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
