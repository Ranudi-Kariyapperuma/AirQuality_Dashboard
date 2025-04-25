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

        // Compare plain text password
        if ($user && $request->password === $user->password) {
            return "Login Successful. Welcome, {$user->username}!";
        } else {
            return back()->with('error', 'Invalid username or password');
        }
    }

    public function forgetPassword()
    {
        return "Please contact admin to reset your password.";
    }
}
