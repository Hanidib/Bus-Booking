<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    UserAuthController,
    AdminAuthController,
    BusController,
    RouteController,
    SeatController,
    BookingController,
    PnrController,
    UserController
};

// Admin auth routes
Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
});

// User auth routes
Route::prefix('user')->group(function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
});

// Route search must be before apiResource
Route::get('routes/search', [RouteController::class, 'search']);

// API Resources
Route::apiResource('users', UserController::class);
Route::apiResource('buses', BusController::class);
Route::apiResource('routes', RouteController::class);
Route::apiResource('seats', SeatController::class);
Route::apiResource('pnrs', PnrController::class);
Route::apiResource('bookings', BookingController::class);

// Custom routes
Route::get('/routes/{routeId}/buses', [RouteController::class, 'buses']);
Route::get('/buses/{busId}/seats', [BusController::class, 'availableSeats']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::post('/pnrs', [PnrController::class, 'store']);
