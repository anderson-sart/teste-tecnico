<?php

class ClienteController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function index() {
        $stmt = $this->pdo->query('SELECT * FROM clientes WHERE deleted_at IS NULL ORDER BY codigo DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function show($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE codigo = ? AND deleted_at IS NULL');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare('INSERT INTO clientes (nome, fantasia, documento, endereco) VALUES (?, ?, ?, ?)');
        $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco']]);
        return ['codigo' => $this->pdo->lastInsertId()];
    }
    
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare('UPDATE clientes SET nome=?, fantasia=?, documento=?, endereco=?, updated_at=NOW() WHERE codigo=? AND deleted_at IS NULL');
        $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco'], $id]);
        return ['success' => true];
    }
    
    public function destroy($id) {
        $stmt = $this->pdo->prepare('UPDATE clientes SET deleted_at = NOW() WHERE codigo = ?');
        $stmt->execute([$id]);
        return ['success' => true];
    }
}
