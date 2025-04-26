<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admindashboard()
    {
        $username = session('username'); // get username from session

        // Dashboard data
        $totalSensors = \App\Models\Sensor::count();
        $activeSensors = \App\Models\Sensor::where('is_active', true)->count();
        $simulationStatus = 4; // Mocked, replace with real logic if available
        $alertsToday = 0; // Mocked, replace with real logic if available

        // Mocked recent alerts
        $recentAlerts = [
            [
                'message' => 'Sensor #123 is overheating',
                'link' => '#',
                'time' => '3:22 PM',
            ],
            [
                'message' => 'Sensor #123 is overheating',
                'link' => '#',
                'time' => '3:22 PM',
            ],
            [
                'message' => 'Sensor #123 is overheating',
                'link' => '#',
                'time' => '3:22 PM',
            ],
            [
                'message' => 'Sensor #123 is overheating',
                'link' => '#',
                'time' => '3:22 PM',
            ],
        ];

        $sensors = \App\Models\Sensor::all();
        return view('admindashboard', compact(
            'username',
            'totalSensors',
            'activeSensors',
            'simulationStatus',
            'alertsToday',
            'recentAlerts',
            'sensors'
        ));
    }

    public function createSensor()
    {
        return view('add-sensor');
    }

    public function storeSensor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sensor_id' => 'required|string|unique:sensors|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_active' => 'required|boolean',
        ]);

        try {
            \App\Models\Sensor::create($validated);
            return redirect()->route('admin.dashboard')->with('success', 'Sensor added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding sensor: ' . $e->getMessage());
        }
    }

    public function alertConfiguration()
    {
        $alertLevels = [
            ['name' => 'Good', 'min_aqi' => 0, 'max_aqi' => 50, 'color' => '#00e400'],
            ['name' => 'Moderate', 'min_aqi' => 51, 'max_aqi' => 100, 'color' => '#ffff00'],
            ['name' => 'Unhealthy for Sensitive Groups', 'min_aqi' => 101, 'max_aqi' => 150, 'color' => '#ff7e00'],
            ['name' => 'Unhealthy', 'min_aqi' => 151, 'max_aqi' => 200, 'color' => '#ff0000'],
            ['name' => 'Very Unhealthy', 'min_aqi' => 201, 'max_aqi' => 300, 'color' => '#8f3f97'],
            ['name' => 'Hazardous', 'min_aqi' => 301, 'max_aqi' => 500, 'color' => '#7e0023']
        ];

        return view('alert_configuration', compact('alertLevels'));
    }

    public function storeAlertConfiguration(Request $request)
    {
        $validated = $request->validate([
            'levels.*.min_aqi' => 'required|integer|min:0',
            'levels.*.max_aqi' => 'required|integer|min:0',
            'levels.*.color' => 'required|string',
            'visual_alerts' => 'boolean'
        ]);

        // TODO: Store the configuration in the database
        // For now, we'll just redirect back with a success message
        return redirect()->back()->with('success', 'Alert configuration saved successfully!');
    }

    public function systemConfiguration()
    {
        return view('system_configuration');
    }

    public function storeSystemConfiguration(Request $request)
    {
        $validated = $request->validate([
            'database_url' => 'required|string',
            'timezone' => 'required|string|timezone',
            'map_latitude' => 'required|numeric|between:-90,90',
            'map_longitude' => 'required|numeric|between:-180,180',
            'debug_mode' => 'boolean'
        ]);

        // TODO: Store the configuration in the database
        // For now, we'll just redirect back with a success message
        return redirect()->back()->with('success', 'System configuration saved successfully!');
    }

    public function userManagement()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    public function reports()
    {
        return view('admin.reports');
    }
}
