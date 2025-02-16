<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login Routes
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Registration Routes
Route::post('register', [RegisterController::class, 'register']);
