<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $request->user()->createToken('access-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user 
             ], 201);
        }
    }
}
