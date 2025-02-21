<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('avatar')->orderBy('xp', 'desc')->take(25)->get();
        
        return response()->json($users);
    }
}