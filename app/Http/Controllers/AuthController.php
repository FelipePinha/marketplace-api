<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $request->user()->createToken($user->name)->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user 
             ], 201);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create($credentials);

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Deslogado(a) com sucesso'
        ], 200);
    }
}
