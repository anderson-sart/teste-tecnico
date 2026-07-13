<?php

class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $softDelete = true;
    protected $searchable = [];
    
    public static function all() {
        $instance = new static();
        $pdo = DB::connection();
        $where = $instance->softDelete ? "WHERE deleted_at IS NULL" : "";
        $stmt = $pdo->query("SELECT * FROM {$instance->table} {$where} ORDER BY {$instance->primaryKey} DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Paginate with search, sort and filtering
     * 
     * @param array $params [search, sort_by, sort_dir, page, per_page]
     * @return array [data, total, page, per_page, last_page]
     */
    public static function paginate(array $params = []) {
        $instance = new static();
        $pdo = DB::connection();
        
        $search = trim($params['search'] ?? '');
        $sortBy = $params['sort_by'] ?? $instance->primaryKey;
        $sortDir = strtoupper($params['sort_dir'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';
        $page = max(1, (int)($params['page'] ?? 1));
        $perPage = min(100, max(1, (int)($params['per_page'] ?? 10)));
        
        // Validate sort column (prevent SQL injection)
        $validColumns = array_merge($instance->fillable, [$instance->primaryKey]);
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = $instance->primaryKey;
        }
        
        // Build WHERE clause
        $conditions = [];
        $bindings = [];
        
        if ($instance->softDelete) {
            $conditions[] = "deleted_at IS NULL";
        }
        
        if ($search !== '' && !empty($instance->searchable)) {
            $searchConditions = [];
            foreach ($instance->searchable as $field) {
                $searchConditions[] = "CAST({$field} AS TEXT) ILIKE ?";
                $bindings[] = "%{$search}%";
            }
            $conditions[] = '(' . implode(' OR ', $searchConditions) . ')';
        }
        
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        
        // Count total
        $countSql = "SELECT COUNT(*) FROM {$instance->table} {$whereClause}";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($bindings);
        $total = (int)$countStmt->fetchColumn();
        
        // Fetch data
        $offset = ($page - 1) * $perPage;
        $dataSql = "SELECT * FROM {$instance->table} {$whereClause} ORDER BY {$sortBy} {$sortDir} LIMIT ? OFFSET ?";
        $dataBindings = array_merge($bindings, [$perPage, $offset]);
        $dataStmt = $pdo->prepare($dataSql);
        $dataStmt->execute($dataBindings);
        $data = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => (int)ceil($total / $perPage),
        ];
    }
    
    /**
     * Count total records (optionally with search)
     */
    public static function count(string $search = '') {
        $instance = new static();
        $pdo = DB::connection();
        $search = trim($search);
        
        $conditions = [];
        $bindings = [];
        
        if ($instance->softDelete) {
            $conditions[] = "deleted_at IS NULL";
        }
        
        if ($search !== '' && !empty($instance->searchable)) {
            $searchConditions = [];
            foreach ($instance->searchable as $field) {
                $searchConditions[] = "CAST({$field} AS TEXT) ILIKE ?";
                $bindings[] = "%{$search}%";
            }
            $conditions[] = '(' . implode(' OR ', $searchConditions) . ')';
        }
        
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM {$instance->table} {$whereClause}");
        $stmt->execute($bindings);
        return (int)$stmt->fetchColumn();
    }
    
    /**
     * Sum a numeric column
     */
    public static function sum(string $column) {
        $instance = new static();
        $pdo = DB::connection();
        
        // Validate column
        if (!in_array($column, $instance->fillable)) {
            return 0;
        }
        
        $where = $instance->softDelete ? "WHERE deleted_at IS NULL" : "";
        $stmt = $pdo->query("SELECT COALESCE(SUM({$column}), 0) FROM {$instance->table} {$where}");
        return (float)$stmt->fetchColumn();
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
    
    public static function where($field, $value) {
        $instance = new static();
        $pdo = DB::connection();
        $where = $instance->softDelete ? "AND deleted_at IS NULL" : "";
        $stmt = $pdo->prepare("SELECT * FROM {$instance->table} WHERE {$field} = ? {$where}");
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
