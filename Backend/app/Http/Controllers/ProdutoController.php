<?php

class ProdutoController {
    
    public function index() {
        return Produto::all();
    }
    
    public function show($id) {
        return Produto::find($id);
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        return Produto::create($data);
    }
    
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        return Produto::update($id, $data);
    }
    
    public function destroy($id) {
        return Produto::delete($id);
    }
}
