<?php

class AuthController {
    
    public function login() {
        $username = Request::input('username');
        $password = Request::input('password');
        
        $pdo = DB::connection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'] ?? false;
            return ['success' => true, 'username' => $user['username']];
        }
        
        return ['success' => false, 'message' => 'Usuário ou senha inválidos'];
    }
    
    public function logout() {
        session_destroy();
        return ['success' => true];
    }
    
    public function changePassword() {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return ['success' => false, 'message' => 'Não autenticado'];
        }
        
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
        
        $pdo = DB::connection();
        $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return ['success' => false, 'message' => 'Senha atual incorreta'];
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$hashedPassword, $userId]);
        
        return ['success' => true, 'message' => 'Senha alterada com sucesso'];
    }
}
