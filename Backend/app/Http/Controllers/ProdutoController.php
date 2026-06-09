<?php

class ProdutoController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function index() {
        $stmt = $this->pdo->query('SELECT * FROM produtos WHERE deleted_at IS NULL ORDER BY codigo DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function show($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE codigo = ? AND deleted_at IS NULL');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare('INSERT INTO produtos (descricao, codigo_barras, valor_venda, peso_bruto, peso_liquido) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$data['descricao'], $data['codigo_barras'], $data['valor_venda'], $data['peso_bruto'], $data['peso_liquido']]);
        return ['codigo' => $this->pdo->lastInsertId()];
    }
    
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare('UPDATE produtos SET descricao=?, codigo_barras=?, valor_venda=?, peso_bruto=?, peso_liquido=?, updated_at=NOW() WHERE codigo=? AND deleted_at IS NULL');
        $stmt->execute([$data['descricao'], $data['codigo_barras'], $data['valor_venda'], $data['peso_bruto'], $data['peso_liquido'], $id]);
        return ['success' => true];
    }
    
    public function destroy($id) {
        $stmt = $this->pdo->prepare('UPDATE produtos SET deleted_at = NOW() WHERE codigo = ?');
        $stmt->execute([$id]);
        return ['success' => true];
    }
}
