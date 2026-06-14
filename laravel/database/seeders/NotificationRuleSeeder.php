<?php

namespace Database\Seeders;

use App\Models\NotificationRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'feature' => 'moisture_before',
                'name' => 'kelembaban awal tanah',
                'title' => 'Anomali Kondisi Awal Tanah',
                'description' => 'Nilai moisture_before menunjukkan kondisi awal tanah yang tidak normal.',
                'problem' => json_encode([
                    'Sensor Drift',
                    'Sensor Freeze',
                    'Sensor Disconnect',
                    'Noise Sensor'
                ]),
                'recommendation' => json_encode([
                    'Kalibrasi Sensor',
                    'Periksa Koneksi Sensor',
                    'Ganti atau Kalibrasi Sensor'
                ])
            ],

            [
                'feature' => 'moisture_after',
                'name' => 'kelembaban setelah penyiraman',
                'title' => 'Anomali Hasil Penyiraman',
                'description' => 'Nilai moisture_after menunjukkan hasil penyiraman yang tidak sesuai target.',
                'problem' => json_encode([
                    'Under Irrigation',
                    'Over Irrigation',
                    'Valve Macet',
                    'Sensor Error Setelah Penyiraman'
                ]),
                'recommendation' => json_encode([
                    'Evaluasi Target dan Durasi Penyiraman',
                    'Kurangi Durasi Penyiraman',
                    'Periksa Valve',
                    'Validasi Sensor'
                ])
            ],

            [
                'feature' => 'moisture_gain',
                'name' => 'peningkatan kelembaban',
                'title' => 'Anomali Efektivitas Penyiraman',
                'description' => 'Nilai moisture_gain menunjukkan efektivitas distribusi air yang tidak normal.',
                'problem' => json_encode([
                    'Pipa Bocor',
                    'Nozzle Tersumbat',
                    'Tekanan Air Rendah',
                    'Pompa Melemah',
                    'Filter Tersumbat'
                ]),
                'recommendation' => json_encode([
                    'Periksa Pipa dan Sambungan',
                    'Bersihkan Nozzle',
                    'Periksa Tekanan Air',
                    'Servis Pompa',
                    'Bersihkan Filter'
                ])
            ],

            [
                'feature' => 'moisture_rate',
                'name' => 'kecepatan peningkatan kelembaban',
                'title' => 'Anomali Efisiensi Penyiraman',
                'description' => 'Nilai moisture_rate menunjukkan proses distribusi air yang tidak efisien.',
                'problem' => json_encode([
                    'Endapan Pipa',
                    'Kebocoran Kecil',
                    'Penurunan Performa Pompa'
                ]),
                'recommendation' => json_encode([
                    'Flushing Pipa',
                    'Inspeksi Jalur Distribusi',
                    'Pemeliharaan Pompa'
                ])
            ],

            [
                'feature' => 'valve_duration',
                'name' => 'durasi valve',
                'title' => 'Anomali Durasi Penyiraman',
                'description' => 'Nilai durasi valve menunjukkan operasi valve yang tidak normal.',
                'problem' => json_encode([
                    'Valve Macet',
                    'Valve Tidak Terbuka Penuh',
                    'Aktuator Rusak',
                    'Kesalahan Logika Kontrol'
                ]),
                'recommendation' => json_encode([
                    'Periksa Mekanisme Valve',
                    'Bersihkan Valve',
                    'Periksa atau Ganti Aktuator',
                    'Evaluasi Parameter Kontrol'
                ])
            ],
        ];

        foreach ($rules as $rule) {
            NotificationRule::create($rule);
        }
    }
}
