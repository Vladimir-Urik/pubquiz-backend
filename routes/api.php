<?php

use App\Http\Controllers\AvatarsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix("/auth")->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth:sanctum')->prefix("/user")->group(function () {
    Route::get('/me', function (Request $request) {
        return User::with('avatar')->find($request->user()->id);
    });

    Route::post('/update', [UserSettingsController::class, 'update']);
});

Route::get('/avatars', [AvatarsController::class, 'all']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);

Route::middleware('auth:sanctum')->prefix("/quizzes")->group(function () {
    Route::get('', [QuizController::class, 'index']);
    Route::get('/{id}/questions', [QuizController::class, 'showQuestions']);
    Route::post('/{id}/submit', [QuizController::class, 'submit']);
});
