<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $username = session('username'); // get username from session

        return view('admindashboard', compact('username'));
    }
}
