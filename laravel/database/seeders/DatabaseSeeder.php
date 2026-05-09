<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GlobalSeeder::class,
            NodeSeeder::class,
            NotificationSeeder::class,
            ConfigurationSeeder::class
        ]);
    }
}
