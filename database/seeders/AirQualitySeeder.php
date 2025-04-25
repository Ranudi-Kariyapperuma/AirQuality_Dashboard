<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AirQualityReading;
use Carbon\Carbon;

class AirQualityReadingSeeder extends Seeder
{
    public function run()
    {
        $readings = [
            [
                'sensor_id' => 1,
                'aqi' => 136.00,
                'pm25' => 70.00,
                'pm10' => 96.20,
                'co' => 13.60,
                'no2' => 29.20,
                'o3' => 43.80,
                'so2' => 22.40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sensor_id' => 2,
                'aqi' => 134.00,
                'pm25' => 65.00,
                'pm10' => 94.80,
                'co' => 14.40,
                'no2' => 26.80,
                'o3' => 38.20,
                'so2' => 19.10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sensor_id' => 3,
                'aqi' => 49.00,
                'pm25' => 24.50,
                'pm10' => 31.30,
                'co' => 4.90,
                'no2' => 10.80,
                'o3' => 16.70,
                'so2' => 6.35,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sensor_id' => 4,
                'aqi' => 131.00,
                'pm25' => 65.50,
                'pm10' => 94.70,
                'co' => 14.10,
                'no2' => 26.20,
                'o3' => 41.30,
                'so2' => 17.65,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sensor_id' => 5,
                'aqi' => 138.00,
                'pm25' => 68.00,
                'pm10' => 92.60,
                'co' => 12.80,
                'no2' => 26.60,
                'o3' => 38.40,
                'so2' => 18.70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($readings as $reading) {
            AirQualityReading::create($reading);
        }
    }
}