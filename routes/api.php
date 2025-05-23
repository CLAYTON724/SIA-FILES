<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BloodRequestController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\MapController;

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

// Public API routes
Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/register', [UserController::class, 'register']);

// Map data routes (public access for now)
Route::get('/map/donors', [MapController::class, 'getDonors']);
Route::get('/map/blood-banks', [MapController::class, 'getBloodBanks']);
Route::get('/map/data', [MapController::class, 'getMapData']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    
    // Blood Requests
    Route::get('/blood-requests', [BloodRequestController::class, 'index']);
    Route::post('/blood-requests', [BloodRequestController::class, 'store']);
    Route::get('/blood-requests/{id}', [BloodRequestController::class, 'show']);
    Route::put('/blood-requests/{id}', [BloodRequestController::class, 'update']);
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::patch('/notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});
