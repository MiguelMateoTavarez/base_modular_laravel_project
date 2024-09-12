<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\LogoutController;
use Modules\Authentication\Http\Controllers\RegisterController;

Route::prefix('v1/auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', RegisterController::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', LogoutController::class);
    });
});
