<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token inválido ou não fornecido.'], 401);
        }

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Acesso não autorizado para este papel.'], 403);
        }

        return $next($request);
    }
}
