<?php

class ClienteController extends Controller {
    
    public function index() {
        return Cliente::paginate([
            'search' => Request::query('search', ''),
            'sort_by' => Request::query('sort_by', 'codigo'),
            'sort_dir' => Request::query('sort_dir', 'DESC'),
            'page' => Request::query('page', 1),
            'per_page' => Request::query('per_page', 10),
        ]);
    }
    
    public function show($id) {
        return $this->validateExists(Cliente::class, $id, 'Cliente não encontrado');
    }
    
    public function store() {
        Validator::validate(Request::all(), [
            'nome' => 'required|max:60',
            'documento' => 'required|cpf_cnpj|max:18',
            'endereco' => 'max:255'
        ]);
        
        return $this->success(Cliente::create(Request::all()), 'Cliente criado com sucesso');
    }
    
    public function update($id) {
        $this->validateExists(Cliente::class, $id, 'Cliente não encontrado');
        
        Validator::validate(Request::all(), [
            'nome' => 'required|max:60',
            'documento' => 'required|cpf_cnpj|max:18',
            'endereco' => 'max:255'
        ]);
        
        return $this->success(Cliente::update($id, Request::all()), 'Cliente atualizado com sucesso');
    }
    
    public function destroy($id) {
        $this->validateExists(Cliente::class, $id, 'Cliente não encontrado');
        return $this->success(Cliente::delete($id), 'Cliente excluído com sucesso');
    }
}
