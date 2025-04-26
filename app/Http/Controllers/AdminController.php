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
}
