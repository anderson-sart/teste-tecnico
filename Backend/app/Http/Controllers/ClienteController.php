<?php

class ClienteController {
    
    public function index() {
        return Cliente::all();
    }
    
    public function show($id) {
        return Cliente::find($id);
    }
    
    public function store() {
        return Cliente::create(Request::all());
    }
    
    public function update($id) {
        return Cliente::update($id, Request::all());
    }
    
    public function destroy($id) {
        return Cliente::delete($id);
    }
}
