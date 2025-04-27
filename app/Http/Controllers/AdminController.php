<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;

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

    // User Management Methods
    public function userManagement()
    {
        // Get all users with their roles
        $users = UserRole::all();
        
        return view('user_management', compact('users'));
    }
    
    public function createUser()
    {
        $roles = ['MonitoringAdmin', 'WebMaster'];
        return view('create_user', compact('roles'));
    }
    
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:user_roles',
            'password' => 'required|string|min:8',
            'role' => 'required|in:MonitoringAdmin,WebMaster',
        ]);
        
        try {
            UserRole::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);
            
            return redirect()->route('users')->with('success', 'User added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding user: ' . $e->getMessage());
        }
    }
    
    public function editUser($id)
    {
        $user = UserRole::findOrFail($id);
        $roles = ['MonitoringAdmin', 'WebMaster'];
        
        return view('edit_user', compact('user', 'roles'));
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = UserRole::findOrFail($id);
        
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:user_roles,username,' . $id,
            'role' => 'required|in:MonitoringAdmin,WebMaster',
            'password' => 'nullable|string|min:8',
        ]);
        
        try {
            $user->username = $validated['username'];
            $user->role = $validated['role'];
            
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            
            $user->save();
            
            return redirect()->route('users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }
    
    public function deleteUser($id)
    {
        $user = UserRole::findOrFail($id);
        
        try {
            $user->delete();
            return redirect()->route('users')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
    
    public function resetUserPassword($id)
    {
        $user = UserRole::findOrFail($id);
        return view('reset_password', compact('user'));
    }
    
    public function updateUserPassword(Request $request, $id)
    {
        $user = UserRole::findOrFail($id);
        
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        try {
            $user->password = Hash::make($validated['password']);
            $user->save();
            
            return redirect()->route('admin.users')->with('success', 'Password reset successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error resetting password: ' . $e->getMessage());
        }
    }

    public function reports()
    {
        return view('admin.reports');
    }
}