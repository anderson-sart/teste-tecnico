<?php

class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    public static function all() {
        $instance = new static();
        $pdo = DB::connection();
        $stmt = $pdo->query("SELECT * FROM {$instance->table} WHERE deleted_at IS NULL ORDER BY {$instance->primaryKey} DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function find($id) {
        $instance = new static();
        $pdo = DB::connection();
        $stmt = $pdo->prepare("SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function create($data) {
        $instance = new static();
        $pdo = DB::connection();
        
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        
        $sql = "INSERT INTO {$instance->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        
        return [$instance->primaryKey => $pdo->lastInsertId()];
    }
    
    public static function update($id, $data) {
        $instance = new static();
        $pdo = DB::connection();
        
        $fields = array_map(fn($key) => "$key = ?", array_keys($data));
        $sql = "UPDATE {$instance->table} SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE {$instance->primaryKey} = ? AND deleted_at IS NULL";
        
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        
        return ['success' => true];
    }
    
    public static function delete($id) {
        $instance = new static();
        $pdo = DB::connection();
        $stmt = $pdo->prepare("UPDATE {$instance->table} SET deleted_at = NOW() WHERE {$instance->primaryKey} = ?");
        $stmt->execute([$id]);
        return ['success' => true];
    }
}
