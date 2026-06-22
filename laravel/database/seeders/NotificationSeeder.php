<?php

namespace Database\Seeders;

use App\Models\Notification;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $end = now()->startOfHour();
        $start = (clone $end)->subDays(10);
        $period = CarbonPeriod::create($start, '120 minutes', $end)->toArray();

        Notification::factory()
            ->count(50)
            ->state(fn() => [
                'created_at' => fake()->randomElement($period),
            ])
            ->create();
    }
}
