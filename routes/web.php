<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AQIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AqiDataExportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//authentication 

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/forget-password', [LoginController::class, 'forgetPassword']);
// Public routes
Route::get('/', [SensorController::class, 'index'])->name('dashboard');
Route::get('/reports', [SensorController::class, 'reports'])->name('reports');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/aqi-chart', [AQIController::class, 'index']);
Route::get('/export-aqi-data', [AqiDataExportController::class, 'exportToJson']);
Route::get('/export/csv', [AqiDataExportController::class, 'exportToCsv']);

// API routes
Route::prefix('api')->group(function () {
    Route::get('/sensors', [SensorController::class, 'index']);
    Route::get('/sensors/{sensor}/readings', [SensorController::class, 'getReadings']);
    
});
