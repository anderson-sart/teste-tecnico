<?php

class ClienteController {
    
    public function index() {
        return Cliente::all();
    }
    
    public function show($id) {
        return Cliente::find($id);
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        return Cliente::create($data);
    }
    
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        return Cliente::update($id, $data);
    }
    
    public function destroy($id) {
        return Cliente::delete($id);
    }
}
