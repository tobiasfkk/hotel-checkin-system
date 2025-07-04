<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Registra um novo usuário.
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|in:admin,normal'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return response()->json(['message' => 'Usuário criado com sucesso'], 201);
    }

    /**
     * Realiza o login do usuário.
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    /**
     * Valida o token de autenticação do usuário.
     * @param Request $request
     * @return Response
     */
    public function validateToken(Request $request)
    {  
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado'], 401);
            }

            if (!$user->isAdmin() && !$request->isMethod('GET')) {
                return response()->json(['message' => 'Acesso negado'], 401);
            }

            return response()->noContent(); // 204
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Exception'], 401);
        }
    }
}
