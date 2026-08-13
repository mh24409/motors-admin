<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\V1\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
|
| All API routes for frontend/mobile applications.
| Base URL: /api/v1
|
| Authentication: Laravel Sanctum (token-based)
|
*/

Route::prefix('v1')->group(function () {

    // Public routes (no authentication required)
    Route::post('/register', [AuthController::class, 'register'])->name('api.v1.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.v1.login');

    // Protected routes (Sanctum token required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.logout');
        Route::get('/me', [AuthController::class, 'me'])->name('api.v1.me');
    });

});
