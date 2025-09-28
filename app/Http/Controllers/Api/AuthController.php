<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(compact('token'));
    }

    public function me()
    {
        return response()->json(['data' => auth()->user()]);
    }

    public function logout()
    {
        auth()->logout();
        
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'token' => auth()->refresh()
        ]);
    }
}
