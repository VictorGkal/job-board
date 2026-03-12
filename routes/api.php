<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobPostController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::get('/job-posts', [JobPostController::class, 'index']);
Route::get('/job-posts/{jobPost}', [JobPostController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});