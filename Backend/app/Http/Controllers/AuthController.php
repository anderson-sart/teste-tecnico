<?php

class AuthController extends Controller {
    
    public function login() {
        $username = Request::input('username');
        $password = Request::input('password');

        $repo = new UserRepositoryImplementation();
        $user = $repo->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            $token = JWT::encode([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'is_admin' => $user['is_admin'] ?? false,
            ]);
            
            // Set cookie for web routes (httpOnly for security)
            $expiration = (int)env('JWT_EXPIRATION', 86400);
            setcookie('auth_token', $token, [
                'expires' => time() + $expiration,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            
            return [
                'success' => true,
                'username' => $user['username'],
                'is_admin' => $user['is_admin'] ?? false,
                'token' => $token,
            ];
        }
        
        return ['success' => false, 'message' => 'Usuário ou senha inválidos'];
    }
    
    public function logout() {
        // Clear the auth cookie
        setcookie('auth_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        
        return ['success' => true];
    }
    
    public function changePassword() {
        $user = JWT::getUser();
        if (!$user || !$user['id']) {
            return ['success' => false, 'message' => 'Não autenticado'];
        }
        
        $userId = $user['id'];
        $currentPassword = Request::input('current_password');
        $newPassword = Request::input('new_password');
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
        
        $dbUser = User::find($userId);
        
        if (!$dbUser || !password_verify($currentPassword, $dbUser['password'])) {
            return ['success' => false, 'message' => 'Senha atual incorreta'];
        }
        
        User::update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
        
        return ['success' => true, 'message' => 'Senha alterada com sucesso'];
    }
}
