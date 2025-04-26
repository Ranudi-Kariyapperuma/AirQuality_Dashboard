<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AirQualityReading;

class AQIController extends Controller
{
    public function index()
    {
        // ✅ Un-comment and get readings
        $readings = AirQualityReading::with('sensor')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at')
            ->get();
    
        $grouped = $readings->groupBy('sensor_id');
        $chartData = [];
    
        foreach ($grouped as $sensorId => $sensorReadings) {
            $sensor = $sensorReadings->first()?->sensor;
            $dataPoints = [];
    
            foreach ($sensorReadings as $reading) {
                $dataPoints[] = [
                    'x' => $reading->created_at->toIso8601String(),
                    'y' => (float)$reading->aqi,
                ];
            }

            $label = $sensor ? ($sensor->name ?? 'Unnamed Sensor') : 'Missing Sensor'; // ✅ Fixed
            $chartData[] = [
                'label' => $label,
                'data' => $dataPoints,
                'borderColor' => $this->randomColor(),
                'fill' => false,
            ];
        }
    
        return view('aqi_chart', compact('chartData'));
    }

    // ✅ Add a function to generate random colors
    private function randomColor()
    {
        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        return $color;
    }
}
