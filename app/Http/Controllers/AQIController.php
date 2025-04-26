<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AirQualityReading;

class AQIController extends Controller
{
   // API to send AQI data
   public function getAqiData()
   {
       $data = Sensor::with(['readings' => function($query) {
           $query->where('created_at', '>=', now()->subDays(7))
                 ->orderBy('created_at');
       }])->get();

       $result = $data->map(function($sensor) {
           return [
               'sensor_name' => $sensor->name,
               'data' => $sensor->readings->map(function($reading) {
                   return [
                       'x' => $reading->created_at->toIso8601String(),
                       'y' => (float) $reading->aqi,
                   ];
               })
           ];
       });

       return response()->json($result);
   }

   // Blade page
   public function showAqiChart()
   {
       return view('aqi');
   }
}