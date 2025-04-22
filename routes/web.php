<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

// Public routes
Route::get('/', [SensorController::class, 'index'])->name('dashboard');

// API routes
Route::prefix('api')->group(function () {
    Route::get('/sensors', [SensorController::class, 'index']);
    Route::get('/sensors/{sensor}/readings', [SensorController::class, 'getReadings']);
    Route::get('/aqi-chart', [AQIController::class, 'index']);

});
