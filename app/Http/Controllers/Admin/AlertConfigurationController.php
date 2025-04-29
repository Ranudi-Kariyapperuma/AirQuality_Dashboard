<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertConfigurationController extends Controller
{
    public function index()
    {
        $alerts = AlertThreshold::all();
        return view('admin.alert-configuration', compact('alerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string',
            'min_aqi' => 'required|integer',
            'max_aqi' => 'required|integer',
            'message' => 'required|string',
        ]);

        AlertThreshold::create($request->all());

        return redirect()->route('alert-configuration')->with('success', 'Alert threshold added.');
    }

    public function destroy($id)
    {
        AlertThreshold::findOrFail($id)->delete();
        return back()->with('success', 'Alert threshold deleted.');
    }
}

