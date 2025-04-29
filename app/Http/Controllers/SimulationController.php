<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $simulation = Simulation::first();
        return view('simulation', compact('simulation'));
    }

    public function update(Request $request)
    {
        $simulation = Simulation::first();

        $simulation->update([
            'is_running' => $request->has('is_running'),
            'frequency' => $request->input('frequency'),
            'aqi_min' => $request->input('aqi_min'),
            'aqi_max' => $request->input('aqi_max'),
            'pattern_variation' => $request->input('pattern_variation')
        ]);

        return redirect()->back()->with('success', 'Simulation settings updated.');
    }

    public function toggle()
    {
        $simulation = Simulation::first();
        $simulation->is_running = !$simulation->is_running;
        $simulation->save();

        return redirect()->back();
    }
}
