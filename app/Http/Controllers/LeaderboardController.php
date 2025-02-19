<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    /**
     * Get the leaderboard of the top 13 users by XP.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::orderBy('xp', 'desc')->take(13)->get(['id', 'name', 'xp', 'avatar']);
        
        return response()->json($users);
    }
}