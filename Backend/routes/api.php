<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\AdminMiddleware;



Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');



// Public Api

Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/technologies', [TechnologyController::class, 'index']);

Route::middleware(['auth:sanctum',AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'Welcome, Admin!']);
    });

    // Admin CRUD API resources
    Route::apiResource('projects', \App\Http\Controllers\Api\Admin\ProjectAdminController::class);
    Route::apiResource('skills', \App\Http\Controllers\Api\Admin\SkillAdminController::class);
    Route::apiResource('technologies', \App\Http\Controllers\Api\Admin\TechnologyAdminController::class);

    // Profile management (single resource)
    Route::get('profile', [\App\Http\Controllers\Api\Admin\ProfileAdminController::class, 'show']);
    Route::post('profile', [\App\Http\Controllers\Api\Admin\ProfileAdminController::class, 'store']);
    Route::put('profile', [\App\Http\Controllers\Api\Admin\ProfileAdminController::class, 'update']);
});
 



// Authentication routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');