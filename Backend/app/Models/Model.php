<?php

class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $softDelete = true;
    
    public static function all() {
        $instance = new static();
        $pdo = DB::connection();
        $where = $instance->softDelete ? "WHERE deleted_at IS NULL" : "";
        $stmt = $pdo->query("SELECT * FROM {$instance->table} {$where} ORDER BY {$instance->primaryKey} DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function find($id) {
        $instance = new static();
        $pdo = DB::connection();
        $where = $instance->softDelete ? "AND deleted_at IS NULL" : "";
        $stmt = $pdo->prepare("SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = ? {$where}");
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
        $updateTime = $instance->softDelete ? ", updated_at = NOW()" : "";
        $where = $instance->softDelete ? "AND deleted_at IS NULL" : "";
        
        $sql = "UPDATE {$instance->table} SET " . implode(', ', $fields) . "{$updateTime} WHERE {$instance->primaryKey} = ? {$where}";
        
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        
        return ['success' => true];
    }
    
    public static function delete($id) {
        $instance = new static();
        $pdo = DB::connection();
        
        if ($instance->softDelete) {
            $stmt = $pdo->prepare("UPDATE {$instance->table} SET deleted_at = NOW() WHERE {$instance->primaryKey} = ?");
        } else {
            $stmt = $pdo->prepare("DELETE FROM {$instance->table} WHERE {$instance->primaryKey} = ?");
        }
        
        $stmt->execute([$id]);
        return ['success' => true];
    }
}
