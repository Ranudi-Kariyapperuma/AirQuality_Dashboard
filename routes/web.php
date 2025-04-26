<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AQIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//authentication 

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/dashboard', [AdminController::class, 'admindashboard'])->name('admin.dashboard');
Route::get('/admin/sensors/create', [AdminController::class, 'createSensor'])->name('sensors.create');
Route::post('/admin/sensors', [AdminController::class, 'storeSensor'])->name('sensors.store');
Route::get('/forget-password', [LoginController::class, 'forgetPassword']);
// Public routes
Route::get('/', [SensorController::class, 'index'])->name('dashboard');
Route::get('/reports', [SensorController::class, 'reports'])->name('reports');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/aqi-chart', [AQIController::class, 'index'])->name('aqi.index');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// API routes
Route::prefix('api')->group(function () {
    Route::get('/sensors', [SensorController::class, 'index']);
    Route::get('/sensors/{sensor}/readings', [SensorController::class, 'getReadings']);
    
});
Route::get('/dashboard', [SensorController::class, 'dashboard'])->name('dashboard');