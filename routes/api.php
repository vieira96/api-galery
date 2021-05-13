<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/me', [AuthController::class, 'getCurrentUser']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
