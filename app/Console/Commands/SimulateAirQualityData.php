<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use App\Models\AirQualityReading;

class SimulateAirQualityData extends Command
{
    protected $signature = 'air-quality:simulate';
    protected $description = 'Simulate air quality data for all active sensors';

    public function handle()
    {
        $sensors = Sensor::where('is_active', true)->get();

        foreach ($sensors as $sensor) {
            // Base AQI value with some randomness
            $baseAqi = rand(30, 150);
            
            // Add time-based variation (higher during rush hours)
            $hour = now()->hour;
            if (($hour >= 7 && $hour <= 9) || ($hour >= 16 && $hour <= 19)) {
                $baseAqi += rand(10, 30);
            }

            // Add weather-based variation (higher on hot, dry days)
            $weatherFactor = rand(0, 20);
            $baseAqi += $weatherFactor;

            // Ensure AQI stays within reasonable bounds
            $aqi = min(max($baseAqi, 0), 500);

            // Calculate other pollutants based on AQI
            $pm25 = $aqi * 0.5 + rand(-5, 5);
            $pm10 = $aqi * 0.7 + rand(-5, 5);
            $co = $aqi * 0.1 + rand(-1, 1);
            $no2 = $aqi * 0.2 + rand(-2, 2);
            $o3 = $aqi * 0.3 + rand(-3, 3);
            $so2 = $aqi * 0.15 + rand(-2, 2);

            AirQualityReading::create([
                'sensor_id' => $sensor->id,
                'aqi' => $aqi,
                'pm25' => $pm25,
                'pm10' => $pm10,
                'co' => $co,
                'no2' => $no2,
                'o3' => $o3,
                'so2' => $so2
            ]);

            $this->info("Generated reading for sensor {$sensor->name}: AQI = {$aqi}");
        }
    }
} 