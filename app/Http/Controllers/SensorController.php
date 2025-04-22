<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\AirQualityReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::with('latestReading')->get();
        return view('dashboard', compact('sensors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sensor_id' => 'required|string|unique:sensors',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string'
        ]);

        $sensor = Sensor::create($validated);
        return response()->json($sensor, 201);
    }

    public function update(Request $request, Sensor $sensor)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'is_active' => 'sometimes|boolean',
            'description' => 'nullable|string'
        ]);

        $sensor->update($validated);
        return response()->json($sensor);
    }

    public function getReadings(Sensor $sensor, $timeframe = '24h')
    {
        $query = $sensor->readings()->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('AVG(aqi) as avg_aqi'),
            DB::raw('AVG(pm25) as avg_pm25'),
            DB::raw('AVG(pm10) as avg_pm10')
        )->groupBy('date');

        switch ($timeframe) {
            case '24h':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case '7d':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case '30d':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
        }

        return response()->json($query->get());
    }
} 