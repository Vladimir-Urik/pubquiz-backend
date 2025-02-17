<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix("/auth")->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth:sanctum')->prefix("/user")->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::post('/update', [UserSettingsController::class, 'update']);
});

Route::get('/avatars', [UserSettingsController::class, 'getAvatars']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);

Route::prefix("/quizzes")->group(function () {
    Route::get('', [QuizController::class, 'index']);
    Route::get('/{id}/questions', [QuizController::class, 'showQuestions']);
    Route::post('/{id}/submit', [QuizController::class, 'submit']);
})->middleware('auth:sanctum');