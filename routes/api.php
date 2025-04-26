use App\Http\Controllers\AQIController;

Route::get('/aqi-data', [AQIController::class, 'getAqiData']);
