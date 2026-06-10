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
        $users = User::all();
        
        // Remover senha da resposta
        return array_map(function($user) {
            unset($user['password']);
            return $user;
        }, $users);
    }
    
    public function store() {
        $this->requireAdmin();
        Validator::validate(Request::all(), [
            'username' => 'required|max:50',
            'password' => 'required|min:6'
        ]);
        
        $username = Request::input('username');
        $password = password_hash(Request::input('password'), PASSWORD_DEFAULT);
        
        // Verificar se usuário já existe
        $pdo = DB::connection();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            http_response_code(422);
            return ['errors' => ['username' => ['Este usuário já existe']]];
        }
        
        $user = User::create([
            'username' => $username,
            'password' => $password
        ]);
        
        return $this->success($user, 'Usuário criado com sucesso');
    }
    
    public function destroy($id) {
        $this->requireAdmin();
        
        // Não permitir excluir o próprio usuário
        if ($id == $_SESSION['user_id']) {
            http_response_code(422);
            return ['errors' => ['user' => ['Você não pode excluir seu próprio usuário']]];
        }
        
        User::delete($id);
        
        return $this->success(null, 'Usuário excluído com sucesso');
    }
}
