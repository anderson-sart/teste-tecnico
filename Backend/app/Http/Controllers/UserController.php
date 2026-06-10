<?php

class UserController extends Controller {
    
    private function requireAdmin() {
        if (empty($_SESSION['is_admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso negado. Apenas administradores podem gerenciar usuários.']);
            exit;
        }
    }
    
    public function index() {
        $this->requireAdmin();
        
        $pdo = DB::connection();
        $stmt = $pdo->query('SELECT id, username, is_admin, created_at FROM users ORDER BY id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function store() {
        $this->requireAdmin();
        Validator::validate(Request::all(), [
            'username' => 'required|max:50',
            'password' => 'required|min:6'
        ]);
        
        $username = Request::input('username');
        $password = password_hash(Request::input('password'), PASSWORD_DEFAULT);
        
        $pdo = DB::connection();
        
        // Verificar se usuário já existe
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            http_response_code(422);
            return ['errors' => ['username' => ['Este usuário já existe']]];
        }
        
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?) RETURNING id');
        $stmt->execute([$username, $password]);
        
        return $this->success(['id' => $stmt->fetchColumn()], 'Usuário criado com sucesso');
    }
    
    public function destroy($id) {
        $this->requireAdmin();
        
        $pdo = DB::connection();
        
        // Não permitir excluir o próprio usuário
        if ($id == $_SESSION['user_id']) {
            http_response_code(422);
            return ['errors' => ['user' => ['Você não pode excluir seu próprio usuário']]];
        }
        
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        
        return $this->success(null, 'Usuário excluído com sucesso');
    }
}
