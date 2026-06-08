<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('username', $request->username)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'username' => $usuario->username
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuário ou senha inválidos'
        ], 401);
    }
}
