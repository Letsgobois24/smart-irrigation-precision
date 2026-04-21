<?php

namespace Database\Seeders;

use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use InfluxDB2\ApiException;
use InfluxDB2\Client;
use InfluxDB2\Point;

class NodeSeeder extends Seeder
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
            for ($tree_id = 1; $tree_id <= 4; $tree_id++) {
                $points[] = Point::measurement('node')
                    ->addTag('node_id', '1')
                    ->addTag('tree_id', str($tree_id))
                    ->addField('soil_moisture', fake()->randomFloat(1, 40, 80))
                    ->addField('valve', fake()->boolean(75))
                    ->time($date->getTimestamp());
            }
        }

        try {
            $writeApi->write($points);
        } catch (ApiException $e) {
            dump("Connection Timeout. Detail: " . $e->getMessage());
        }
    }
}
