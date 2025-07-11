<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group Autenticação
 * Gerenciamento de autenticação de usuários.
 */
class AuthController extends Controller
{
    /**
     * @group Autenticação
     * Registra um novo usuário.
     *
     * Registra um usuário com nome, email, senha e papel (admin ou normal).
     *
     * @bodyParam name string required Nome do usuário. Example: João Silva
     * @bodyParam email string required Email único do usuário. Example: joao@email.com
     * @bodyParam password string required Senha com no mínimo 6 caracteres. Example: secret123
     * @bodyParam role string required Papel do usuário. Valores válidos: admin, normal. Example: normal
     *
     * @response 201 {
     *   "message": "Usuário criado com sucesso"
     * }
     * @response 422 {
     *   "email": ["The email has already been taken."]
     * }
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
     * @group Autenticação
     * Realiza o login do usuário.
     *
     * Retorna token JWT para autenticação nas demais rotas.
     *
     * @bodyParam email string required Email do usuário. Example: joao@email.com
     * @bodyParam password string required Senha do usuário. Example: secret123
     *
     * @response 200 {
     *   "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
     *   "token_type": "bearer",
     *   "expires_in": 3600
     * }
     * @response 401 {
     *   "message": "Credenciais inválidas"
     * }
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
     * @group Autenticação
     * Valida o token de autenticação do usuário.
     *
     * Verifica se o token JWT está válido e se o usuário tem permissão.
     *
     * @header X-Original-Method string Método HTTP original da requisição. Example: GET
     *
     * @response 204 - Sem conteúdo, token válido.
     * @response 401 {
     *   "message": "Usuário não encontrado"
     * }
     * @response 401 {
     *   "message": "Acesso negado"
     * }
     * @response 401 {
     *   "message": "Exception"
     * }
     */
    public function validateToken(Request $request)
    {  
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado'], 401);
            }
            
            if (!$user->isAdmin() && $request->header('X-Original-Method') !== 'GET') {
                return response()->json(['message' => 'Acesso negado'], 401);
            }

            return response()->noContent(); // 204
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Exception'], 401);
        }
    }
}