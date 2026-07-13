<?php

class UserController extends Controller {
    
    private UserRepositoryInterface $repository;
    
    public function __construct() {
        $this->repository = new UserRepositoryImplementation();
    }
    
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
        $result = $this->repository->paginate([
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
        
        return ApiResponse::paginated($result);
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
        if ($this->repository->findByUsername($username)) {
            http_response_code(422);
            return ['errors' => ['username' => ['Este usuário já existe']]];
        }
        
        $user = $this->repository->create([
            'username' => $username,
            'password' => $password
        ]);
        
        return ApiResponse::created(['id' => $user['id'], 'message' => 'Usuário criado com sucesso']);
    }
    
    public function destroy($id) {
        $this->requireAdmin();
        
        // Não permitir excluir o próprio usuário
        $currentUser = JWT::getUser();
        if ($id == $currentUser['id']) {
            http_response_code(422);
            return ['errors' => ['user' => ['Você não pode excluir seu próprio usuário']]];
        }
        
        $result = $this->repository->delete((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Usuário não encontrado');
        }
        
        return ApiResponse::ok(['message' => 'Usuário excluído com sucesso']);
    }
}
