<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\LoginController;
use Modules\Authentication\Http\Controllers\LogoutController;
use Modules\Authentication\Http\Controllers\RegisterController;

Route::prefix('api/v1/auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', LogoutController::class);
    });
});
