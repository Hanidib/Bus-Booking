<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\BusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\RouteController;
use App\Http\Controllers\API\SeatController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\PnrController;

Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/admin/logout', [AdminAuthController::class, 'logout']);


Route::prefix('user')->group(function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bus', [BusController::class, 'index']);
    Route::get('/bus/{id}', [BusController::class, 'show']);
    Route::post('/bus', [BusController::class, 'store']);
    Route::put('/bus/{id}', [BusController::class, 'update']);
    Route::delete('/bus/{id}', [BusController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/routes', [RouteController::class, 'index']);
    Route::post('/routes', [RouteController::class, 'store']);
    Route::get('/routes/{id}', [RouteController::class, 'show']);
    Route::put('/routes/{id}', [RouteController::class, 'update']);
    Route::delete('/routes/{id}', [RouteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/seats', [SeatController::class, 'store']);
    Route::get('/seats', [SeatController::class, 'index']);
    Route::put('/seats/{id}', [SeatController::class, 'update']);
    Route::delete('/seats/{id}', [SeatController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('pnrs', PnrController::class);
});
