<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validace pro jméno
        if ($request->has('name')) {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $user->name = $request->name;
        }

        // Validace pro avatar
        if ($request->has('avatar_id')) {
            $request->validate([
                'avatar_id' => 'required|exists:avatars,id',
            ]);
            $avatar = Avatar::find($request->avatar_id);
            $user->avatar = $avatar->path; // Uložení cesty k avataru
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function getAvatars()
    {
        $user = Auth::user();
        $avatars = Avatar::all();

        return response()->json([
            'avatars' => $avatars,
            'current_avatar' => $user->avatar,
        ]);
    }

    public function leaderboard()
    {
        $users = User::orderBy('level', 'desc')->get();

        return response()->json($users);
    }
} 