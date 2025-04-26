<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AqiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AqiData::create([
            'sensor_id' => 1,
            'aqi' => 50,
            'air_quality' => 'Good',
            'temperature' => 22.5,
            'humidity' => 60.0,
            'recorded_at' => Carbon::now()->subHours(1),  // 1 hour ago
        ]);

        AqiData::create([
            'sensor_id' => 2,
            'aqi' => 120,
            'air_quality' => 'Unhealthy',
            'temperature' => 28.0,
            'humidity' => 55.0,
            'recorded_at' => Carbon::now()->subHours(2),  // 2 hours ago
        ]);


    }
}
