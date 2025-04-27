<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AQIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AqiDataExportController;
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

// Alert Configuration Routes
Route::get('/admin/alert-configuration', [AdminController::class, 'alertConfiguration'])->name('alert-configuration');
Route::post('/admin/alert-configuration', [AdminController::class, 'storeAlertConfiguration'])->name('alert-configuration.store');

// System Configuration Routes
Route::get('/admin/system-configuration', [AdminController::class, 'systemConfiguration'])->name('system-configuration');
Route::post('/admin/system-configuration', [AdminController::class, 'storeSystemConfiguration'])->name('system-configuration.store');

// User Management Routes
Route::get('/users', [AdminController::class, 'userManagement'])->name('admin.users');
Route::get('/users/create', [AdminController::class, 'createUser'])->name('create_user');
Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::get('/users/{id}/reset-password', [AdminController::class, 'resetUserPassword'])->name('admin.users.reset-password');
Route::put('/users/{id}/password', [AdminController::class, 'updateUserPassword'])->name('admin.users.update-password');

Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

Route::get('/forget-password', [LoginController::class, 'forgetPassword']);
// Public routes
Route::get('/', [SensorController::class, 'index'])->name('dashboard');
Route::get('/reports', [SensorController::class, 'reports'])->name('reports');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/aqi-chart', [AQIController::class, 'showAqiChart']);
Route::get('/export-aqi-data', [AqiDataExportController::class, 'exportToJson']);
Route::get('/export/csv', [AqiDataExportController::class, 'exportToCsv']);


Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// API routes
Route::prefix('api')->group(function () {
    Route::get('/sensors', [SensorController::class, 'index']);
    Route::get('/sensors/{sensor}/readings', [SensorController::class, 'getReadings']);
    
});
Route::get('/dashboard', [SensorController::class, 'dashboard'])->name('dashboard');