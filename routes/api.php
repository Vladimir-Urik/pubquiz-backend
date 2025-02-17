<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/auth/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->prefix("/user")->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // User Settings Route
    Route::post('/update', [UserSettingsController::class, 'update']);
});

Route::get('/avatars', [UserSettingsController::class, 'getAvatars']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);