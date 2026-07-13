<?php

class UserController extends Controller {
    
    private function requireAdmin() {
        $user = JWT::getUser();
        if (empty($user['is_admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso negado. Apenas administradores podem gerenciar usuários.']);
            exit;
        }
    }
    
    public function index() {
        $this->requireAdmin();
        $result = User::paginate([
            'search' => Request::query('search', ''),
            'sort_by' => Request::query('sort_by', 'id'),
            'sort_dir' => Request::query('sort_dir', 'DESC'),
            'page' => Request::query('page', 1),
            'per_page' => Request::query('per_page', 10),
        ]);
        
        // Remover senha da resposta
        $result['data'] = array_map(function($user) {
            unset($user['password']);
            return $user;
        }, $result['data']);
        
        return $result;
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
        if (User::where('username', $username)) {
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
        $currentUser = JWT::getUser();
        if ($id == $currentUser['id']) {
            http_response_code(422);
            return ['errors' => ['user' => ['Você não pode excluir seu próprio usuário']]];
        }
        
        User::delete($id);
        
        return $this->success(null, 'Usuário excluído com sucesso');
    }
}
