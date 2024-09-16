<?php

use Illuminate\Support\Facades\Route;
use Modules\Accesscontrol\Http\Controllers\PermissionController;
use Modules\Accesscontrol\Http\Controllers\RoleController;

Route::prefix('api/v1/access-control')->group(function () {
    Route::get('permissions', PermissionController::class);
    Route::apiResource('role', RoleController::class);
});
