<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AirQualityReading;
use Carbon\Carbon;

class AirQualityReadingSeeder extends Seeder
{
    public function run()
    {
        $sensorIds = [1, 2, 3, 4, 5];
        $startDate = Carbon::now()->subDays(6); // 7 days including today

        foreach ($sensorIds as $sensorId) {
            for ($i = 0; $i < 7; $i++) {
                $date = (clone $startDate)->addDays($i);
                AirQualityReading::create([
                    'sensor_id' => $sensorId,
                    'aqi' => rand(40, 180), // Random AQI for demo
                    'pm25' => rand(10, 80),
                    'pm10' => rand(20, 120),
                    'co' => rand(5, 20),
                    'no2' => rand(10, 40),
                    'o3' => rand(10, 50),
                    'so2' => rand(5, 25),
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}