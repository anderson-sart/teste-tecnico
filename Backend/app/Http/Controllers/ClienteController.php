<?php

class ClienteController extends Controller {
    
    public function index() {
        return Cliente::all();
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
