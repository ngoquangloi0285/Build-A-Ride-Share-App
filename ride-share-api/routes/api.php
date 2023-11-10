<?php

use App\Http\Controllers\API\V1\AuthenticationController;
use App\Http\Controllers\API\V1\DriverController;
use App\Http\Controllers\API\V1\TripController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/login/verify', [AuthenticationController::class, 'verify']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'update']);

    Route::post('/trip', [TripController::class, 'store']);
    Route::get('/trip/{trips}', [TripController::class, 'show']);
    
    Route::post('/trip/{trips}/accept', [TripController::class, 'accept']);
    Route::post('/trip/{trips}/start', [TripController::class, 'start']);
    Route::post('/trip/{trips}/end', [TripController::class, 'end']);
    Route::post('/trip/{trips}/loctation', [TripController::class, 'location']);

    Route::get('/user', function (Request $request) {
    });
});
