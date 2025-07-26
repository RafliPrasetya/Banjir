<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/sensor-terbaru', [SensorController::class, 'getLatest']);
Route::get('/sensor-history', [SensorController::class, 'getSensorHistory']);
Route::get('/sensor-chart', [SensorController::class, 'getChartData']);
Route::post('/sensor', [SensorController::class, 'store']);
