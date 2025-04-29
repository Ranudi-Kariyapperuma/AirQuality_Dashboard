<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Get the user from the user_roles table
        $user = DB::table('user_roles')->where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store username in session
            session(['username' => $user->username]);

            // Check user role
            if ($user->role === 'MonitoringAdmin') {
                // Admin dashboard logic
                $totalSensors = \App\Models\Sensor::count();
                $activeSensors = \App\Models\Sensor::where('is_active', true)->count();
                $simulationStatus = 4; // Mocked value, update if necessary
                $alertsToday = 0; // Mocked value, update if necessary

                // Mocked recent alerts
                $recentAlerts = [
                    [
                        'message' => 'Sensor #123 is overheating',
                        'link' => '#',
                        'time' => '3:22 PM',
                    ],
                    [
                        'message' => 'Sensor #456 is offline',
                        'link' => '#',
                        'time' => '4:10 PM',
                    ],
                    [
                        'message' => 'Sensor #789 has low battery',
                        'link' => '#',
                        'time' => '5:45 PM',
                    ],
                ];

                $sensors = \App\Models\Sensor::all();
                
                return view('admindashboard', compact(
                    'totalSensors',
                    'activeSensors',
                    'simulationStatus',
                    'alertsToday',
                    'recentAlerts',
                    'sensors'
                ));
            } else {
                // You can customize this to redirect based on different roles
                return back()->with('error', 'Access denied. Only MonitoringAdmin can access the dashboard.');
            }
        } else {
            return back()->with('error', 'Invalid username or password.');
        }
    }

    public function forgetPassword()
    {
        return "Please contact admin to reset your password.";
    }

    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->flush();
        
        // Redirect to login page
        return redirect()->route('login');
    }
}
