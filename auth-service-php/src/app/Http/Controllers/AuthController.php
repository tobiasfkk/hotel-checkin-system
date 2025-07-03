<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json(['message' => 'Login bem-sucedido']);
    }
}
