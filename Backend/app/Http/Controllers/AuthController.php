<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'senha' => 'required'
        ]);

        $usuario = Usuario::where('Usuario', $request->usuario)
                         ->where('Senha', $request->senha)
                         ->first();

        if ($usuario) {
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'usuario' => $usuario->Usuario
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuário ou senha inválidos'
        ], 401);
    }
}
