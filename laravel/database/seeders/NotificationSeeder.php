<?php

namespace Database\Seeders;

use App\Models\Notification;
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
            'source_type' => 'pohon',
            'sensor_type' => 'kelembaban tanah',
            'severity' => 'tinggi',
            'value' => 32,
            'threshold' => 45,
            'node_id' => 1,
            'tree_id' => 2,
            'is_active' => fake()->boolean(80),
            'is_read' => fake()->boolean(80),
        ]);

        Notification::create([
            'title' => 'Arus Air Tidak Normal',
            'message' => 'Terdapat aliran air meskipun valve dalam kondisi OFF.',
            'recomendation' => 'Periksa kemungkinan kebocoran',
            'source_type' => 'global',
            'sensor_type' => 'arus air',
            'severity' => 'sedang',
            'value' => 2.1,
            'threshold' => 1.9,
            'node_id' => null,
            'tree_id' => null,
            'is_active' => fake()->boolean(80),
            'is_read' => fake()->boolean(80),
        ]);


        Notification::factory(5)->create();
    }
}
