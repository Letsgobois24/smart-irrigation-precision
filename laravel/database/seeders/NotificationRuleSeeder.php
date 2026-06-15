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
                'title' => 'Kesalahan Kondisi Awal Tanah',
                'description' => 'Nilai kelembaban awal tanah menunjukkan kondisi yang tidak normal.',
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
                'title' => 'Kesalahan Hasil Penyiraman',
                'description' => 'Nilai kelembaban setelah penyiraman menunjukkan hasil yang tidak sesuai target.',
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
                'title' => 'Kesalahan Efektivitas Penyiraman',
                'description' => 'Nilai kelembaban yang meningkat menunjukkan efektivitas distribusi air yang tidak normal.',
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
                'title' => 'Kesalahan Efisiensi Penyiraman',
                'description' => 'Nilai kecepatan peningkatan kelembaban menunjukkan proses distribusi air yang tidak efisien.',
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
                'name' => 'durasi siklus penyiraman',
                'title' => 'Kesalahan Durasi Penyiraman',
                'description' => 'Nilai durasi siklus penyiraman menunjukkan operasi valve yang tidak normal.',
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
