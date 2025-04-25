<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('articles', \App\Http\Controllers\Article\ArticleController::class)->middleware('permission:manage-articles');

    Route::prefix('roles')->middleware('permission:manage-roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'createRole']);
        Route::post('/assign/{userId}', [RoleController::class, 'assignRole']);
        Route::post('/permissions', [RoleController::class, 'createPermission']);
        Route::post('/permissions/assign/{roleName}', [RoleController::class, 'assignPermissionToRole']);
    });

    Route::apiResource('users', UserController::class)
        ->middleware('permission:manage-users');
});
