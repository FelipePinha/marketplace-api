<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $request->user()->createToken($user->name)->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user 
             ], 201);
        }

        return response()->json([
            'errors' => [
                'email' => ['Email ou Senha incorretos']
            ] 
        ], 401);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ]);

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
