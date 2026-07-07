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
                'title' => 'Kondisi Awal Tanah Tidak Normal',
                'description' => 'Kelembaban tanah sebelum penyiraman tidak sesuai dengan kondisi yang seharusnya.',
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
                'title' => 'Hasil Penyiraman Tidak Sesuai',
                'description' => 'Kelembaban tanah setelah penyiraman belum mencapai kondisi yang diharapkan.',
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
                'feature' => 'duration',
                'name' => 'durasi penyiraman',
                'title' => 'Perhitungan Durasi Penyiraman Tidak Sesuai',
                'description' => 'Durasi penyiraman yang dihasilkan sistem tidak sesuai dengan kondisi yang diharapkan.',
                'problem' => json_encode([
                    'Kesalahan Rule Base Logika Fuzzy',
                    'Fungsi Keanggotaan Tidak Sesuai',
                    'Data Masukan Sensor Tidak Valid',
                    'Kesalahan Logika Kontrol'
                ]),
                'recommendation' => json_encode([
                    'Evaluasi dan Perbaiki Rule Base',
                    'Kalibrasi Fungsi Keanggotaan',
                    'Validasi dan Kalibrasi Sensor',
                    'Evaluasi Parameter dan Algoritma Kontrol'
                ])
            ],

            [
                'feature' => 'moisture_gain',
                'name' => 'peningkatan kelembaban',
                'title' => 'Peningkatan Kelembaban Tidak Normal',
                'description' => 'Peningkatan kelembaban tanah setelah penyiraman tidak sesuai dengan yang diharapkan.',
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
                'title' => 'Laju Peningkatan Kelembaban Tidak Normal',
                'description' => 'Laju peningkatan kelembaban tanah selama penyiraman tidak sesuai dengan kondisi normal.',
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
        ];

        foreach ($rules as $rule) {
            NotificationRule::create($rule);
        }
    }
}
