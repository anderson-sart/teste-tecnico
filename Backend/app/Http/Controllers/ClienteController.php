<?php

class ClienteController {
    
    public function index() {
        $pdo = DB::connection();
        $stmt = $pdo->query('SELECT * FROM clientes WHERE deleted_at IS NULL ORDER BY codigo DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function show($id) {
        $pdo = DB::connection();
        $stmt = $pdo->prepare('SELECT * FROM clientes WHERE codigo = ? AND deleted_at IS NULL');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        $pdo = DB::connection();
        $stmt = $pdo->prepare('INSERT INTO clientes (nome, fantasia, documento, endereco) VALUES (?, ?, ?, ?)');
        $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco']]);
        return ['codigo' => $pdo->lastInsertId()];
    }
    
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $pdo = DB::connection();
        $stmt = $pdo->prepare('UPDATE clientes SET nome=?, fantasia=?, documento=?, endereco=?, updated_at=NOW() WHERE codigo=? AND deleted_at IS NULL');
        $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco'], $id]);
        return ['success' => true];
    }
    
    public function destroy($id) {
        $pdo = DB::connection();
        $stmt = $pdo->prepare('UPDATE clientes SET deleted_at = NOW() WHERE codigo = ?');
        $stmt->execute([$id]);
        return ['success' => true];
    }
}
