<?php

use Illuminate\Support\Facades\Route;
use Modules\Accesscontrol\Http\Controllers\PermissionController;
use Modules\Accesscontrol\Http\Controllers\RoleController;

Route::prefix('api/v1/access-control')->middleware(['auth:sanctum'])->group(function () {
    Route::get('permissions', PermissionController::class);
    Route::apiResource('role', RoleController::class);
    Route::post('role/attach-permissions/{role}', [RoleController::class, 'attachPermissions']);
    Route::post('role/detach-permissions/{role}', [RoleController::class, 'detachPermissions']);
});
