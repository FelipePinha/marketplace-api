<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'O email é obrigatório.',
                'email.email' => 'Email inválido.',
                'password.required' => 'A senha é obrigatória.',
            ]
        );

        if($validateUser->fails()) {
            return response()->json([
                'errors' => $validateUser->errors()
            ], 400);
        }

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

    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6'
            ], [
                'name' => 'O nome é obrigatório.',
                'email.required' => 'O email é obrigatório.',
                'email.email' => 'Email inválido.',
                'email.unique' => 'Este email já foi cadastrado.',
                'password.required' => 'A senha é obrigatória.', 
                'password.confirmed' => 'As senhas precisam ser iguais.',
                'password.min' => 'A senha deve ter mais do que 6 caractéres.' 
            ]
        );

        if($validateUser->fails()) {
            return response()->json([
                'errors' => $validateUser->errors()
            ], 400);
        }

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
