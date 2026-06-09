<?php

class ProdutoController {
    
    public function index() {
        return Produto::all();
    }
    
    public function show($id) {
        return Produto::find($id);
    }
    
    public function store() {
        return Produto::create(Request::all());
    }
    
    public function update($id) {
        return Produto::update($id, Request::all());
    }
    
    public function destroy($id) {
        return Produto::delete($id);
    }
}
