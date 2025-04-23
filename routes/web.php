<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AQIController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [SensorController::class, 'index'])->name('dashboard');
Route::get('/reports', [SensorController::class, 'reports'])->name('reports');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// API routes
Route::prefix('api')->group(function () {
    Route::get('/sensors', [SensorController::class, 'index']);
    Route::get('/sensors/{sensor}/readings', [SensorController::class, 'getReadings']);
    Route::get('/aqi-chart', [AQIController::class, 'index']);
});
