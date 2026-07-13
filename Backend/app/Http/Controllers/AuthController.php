<?php

namespace App\Http\Controllers;

use App\Http\JWT;
use App\Http\Request;
use App\Models\User;

class AuthController extends Controller {

    public function login() {
        $username = Request::input('username');
        $password = Request::input('password');

        // Busca direta para incluir campo hidden 'password'
        $user = User::where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            $token = JWT::encode([
                'user_id'  => $user->id,
                'username' => $user->username,
                'is_admin' => (bool) $user->is_admin,
            ]);

            setcookie('auth_token', $token, [
                'expires'  => time() + (int) env('JWT_EXPIRATION', 86400),
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            return [
                'success'  => true,
                'username' => $user->username,
                'is_admin' => (bool) $user->is_admin,
                'token'    => $token,
            ];
        }

        return ['success' => false, 'message' => 'Usuário ou senha inválidos'];
    }

    public function logout() {
        setcookie('auth_token', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        return ['success' => true];
    }

    public function changePassword() {
        $authUser = JWT::getUser();
        if (!$authUser) return ['success' => false, 'message' => 'Não autenticado'];

        $currentPassword = Request::input('current_password');
        $newPassword     = Request::input('new_password');
        $confirmPassword = Request::input('confirm_password');

        if (!$currentPassword || !$newPassword || !$confirmPassword) {
            return ['success' => false, 'message' => 'Todos os campos são obrigatórios'];
        }
        if ($newPassword !== $confirmPassword) {
            return ['success' => false, 'message' => 'As senhas não coincidem'];
        }
        if (strlen($newPassword) < 6) {
            return ['success' => false, 'message' => 'A senha deve ter no mínimo 6 caracteres'];
        }

        $user = User::find($authUser['id']);

        if (!$user || !password_verify($currentPassword, $user->password)) {
            return ['success' => false, 'message' => 'Senha atual incorreta'];
        }

        $user->update(['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);

        return ['success' => true, 'message' => 'Senha alterada com sucesso'];
    }
}
