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
            return ['success' => true, 'username' => $user['username']];
        }
        
        return ['success' => false, 'message' => 'Usuário ou senha inválidos'];
    }
    
    public function logout() {
        session_destroy();
        return ['success' => true];
    }
}
