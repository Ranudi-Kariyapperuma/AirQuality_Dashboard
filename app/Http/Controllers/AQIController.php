<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AirQualityReading;
use Carbon\Carbon;

class AQIController extends Controller
{
    public function index()
    {
        // Sample data for Sri Lankan air quality (typical values for Colombo)
        $locations = [
            'Fort Area' => [
                'color' => '#4ED47F',
                'data' => [
                    ['x' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'), 'y' => 85],
                    ['x' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'), 'y' => 92],
                    ['x' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'), 'y' => 78],
                    ['x' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'), 'y' => 95],
                    ['x' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'), 'y' => 88],
                    ['x' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), 'y' => 82],
                    ['x' => Carbon::now()->format('Y-m-d H:i:s'), 'y' => 90],
                ]
            ],
            'Pettah Market' => [
                'color' => '#01BFBC',
                'data' => [
                    ['x' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'), 'y' => 95],
                    ['x' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'), 'y' => 102],
                    ['x' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'), 'y' => 98],
                    ['x' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'), 'y' => 105],
                    ['x' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'), 'y' => 110],
                    ['x' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), 'y' => 97],
                    ['x' => Carbon::now()->format('Y-m-d H:i:s'), 'y' => 103],
                ]
            ],
            'Marine Drive' => [
                'color' => '#3D246C',
                'data' => [
                    ['x' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'), 'y' => 65],
                    ['x' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'), 'y' => 70],
                    ['x' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'), 'y' => 68],
                    ['x' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'), 'y' => 72],
                    ['x' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'), 'y' => 75],
                    ['x' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), 'y' => 69],
                    ['x' => Carbon::now()->format('Y-m-d H:i:s'), 'y' => 71],
                ]
            ],
            'Bambalapitiya' => [
                'color' => '#1C34FC',
                'data' => [
                    ['x' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'), 'y' => 75],
                    ['x' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'), 'y' => 80],
                    ['x' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'), 'y' => 78],
                    ['x' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'), 'y' => 82],
                    ['x' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'), 'y' => 85],
                    ['x' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), 'y' => 79],
                    ['x' => Carbon::now()->format('Y-m-d H:i:s'), 'y' => 81],
                ]
            ],
            'Narahenpita' => [
                'color' => '#2060B3',
                'data' => [
                    ['x' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'), 'y' => 88],
                    ['x' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'), 'y' => 92],
                    ['x' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'), 'y' => 85],
                    ['x' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'), 'y' => 95],
                    ['x' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'), 'y' => 90],
                    ['x' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), 'y' => 87],
                    ['x' => Carbon::now()->format('Y-m-d H:i:s'), 'y' => 93],
                ]
            ]
        ];

        $chartData = [];
        foreach ($locations as $location => $data) {
            $chartData[] = [
                'label' => $location,
                'data' => $data['data'],
                'borderColor' => $data['color'],
                'fill' => false,
                'tension' => 0.4,
                'pointRadius' => 4,
                'pointHoverRadius' => 6,
            ];
        }

        return view('aqi_chart', compact('chartData'));
    }

    private function getColorForSensor($sensorId)
    {
        $colors = [
            '#4ED47F', // Green
            '#01BFBC', // Teal
            '#3D246C', // Purple
            '#1C34FC', // Blue
            '#2060B3', // Dark Blue
            '#FF6B6B', // Red
            '#FFD93D', // Yellow
            '#6C5CE7', // Indigo
        ];

        return $colors[$sensorId % count($colors)];
    }
}