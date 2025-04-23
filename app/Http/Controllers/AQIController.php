<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AirQualityReading;

class AQIController extends Controller
{
    public function index()
    {
        $readings = AirQualityReading::with('sensor')
            ->where('timestamp', '>=', now()->subDays(7))
            ->orderBy('timestamp')
            ->get();

        $grouped = $readings->groupBy('sensor_id');
        $chartData = [];

        foreach ($grouped as $sensorId => $sensorReadings) {
            $sensor = $sensorReadings->first()->sensor->location ?? 'Unknown Sensor';
            $dataPoints = [];

            foreach ($sensorReadings as $reading) {
                $dataPoints[] = [
                    'x' => $reading->timestamp->format('Y-m-d H:i:s'),
                    'y' => $reading->aqi,
                ];
            }

            $chartData[] = [
                'label' => $sensor,
                'data' => $dataPoints,
                'borderColor' => $this->randomColor(),
                'fill' => false,
            ];
        }

        return view('aqi_chart', compact('chartData'));
    }

    private function randomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
