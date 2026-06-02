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
        Notification::create([
            'title' => 'Kelembapan Tanah Rendah',
            'message' => 'Kelembapan tanah berada di bawah threshold optimal selama 15 menit.',
            'recomendation' => 'Aktifkan irigasi',
            'source_type' => 'tree',
            'sensor_type' => 'kelembaban tanah',
            'severity' => 'high',
            'value' => 32,
            'threshold' => 45,
            'node_id' => 1,
            'tree_id' => 6,
            'is_active' => fake()->boolean(80),
            'is_read' => fake()->boolean(60),
        ]);

        Notification::create([
            'title' => 'Arus Air Tidak Normal',
            'message' => 'Terdapat aliran air meskipun valve dalam kondisi OFF.',
            'recomendation' => 'Periksa kemungkinan kebocoran',
            'source_type' => 'global',
            'sensor_type' => 'arus air',
            'severity' => 'medium',
            'value' => 2.1,
            'threshold' => 1.9,
            'node_id' => null,
            'tree_id' => null,
            'is_active' => fake()->boolean(80),
            'is_read' => fake()->boolean(60),
        ]);

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
