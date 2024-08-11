<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameLogsController;
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\PlayPlayStationPageController;
use App\Http\Controllers\PlayStationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/home', [MainDashboardController::class, 'index']);

Route::get('/playstation', [PlayStationController::class, 'index']);
Route::post('/playstation', [PlayStationController::class, 'store']);
Route::put('/playstation/{id}', [PlayStationController::class, 'update']);
Route::delete('/playstation/{id}', [PlayStationController::class, 'delete']);


Route::get('/gameLogs', [GameLogsController::class, 'index']);
Route::post('/gameLogs', [GameLogsController::class, 'store']);


Route::get('/play-playStation', [PlayPlayStationPageController::class, 'index']);
Route::post('/play-playStation/endGame/{id}', [PlayPlayStationPageController::class, 'endGame']);
Route::post('/play-playStation', [PlayPlayStationPageController::class, 'store']);
Route::put('/play-playStation/edit/{id}', [PlayPlayStationPageController::class, 'update']);
Route::delete('/play-playStation/delete/{id}', [PlayPlayStationPageController::class, 'delete']);
