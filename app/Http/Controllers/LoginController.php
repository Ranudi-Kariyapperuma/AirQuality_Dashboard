<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $user = DB::table('users')->where('username', $request->username)->first();

        if ($user && $request->password === $user->password) {
            if ($user->username === 'admin') {
                // Store username in session
                session(['username' => $user->username]);
                
                // Get dashboard data
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
                    'totalSensors',
                    'activeSensors',
                    'simulationStatus',
                    'alertsToday',
                    'recentAlerts',
                    'sensors'
                ));
            } else {
                return back()->with('error', 'Access denied. Only admin can access the dashboard.');
            }
        } else {
            return back()->with('error', 'Invalid username or password');
        }
    }

    public function forgetPassword()
    {
        return "Please contact admin to reset your password.";
    }

    public function logout(Request $request)
    {
        // Clear the session
        $request->session()->flush();
        
        // Redirect to login page
        return redirect()->route('login');
    }
}
