<?php

class DB {
    private static $connection = null;
    
    public static function connection() {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $name = getenv('DB_DATABASE') ?: 'softline_db';
            $user = getenv('DB_USERNAME') ?: 'softline_user';
            $pass = getenv('DB_PASSWORD') ?: 'softline_pass';
            
            try {
                self::$connection = new PDO(
                    "pgsql:host=$host;dbname=$name",
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                throw new Exception('Database connection failed: ' . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
    
    public static function table($table) {
        return new QueryBuilder(self::connection(), $table);
    }
}

class QueryBuilder {
    private $pdo;
    private $table;
    private $where = [];
    
    public function __construct($pdo, $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }
    
    public function where($column, $value) {
        $this->where[] = [$column, $value];
        return $this;
    }
    
    public function whereNull($column) {
        $this->where[] = [$column, null, 'IS NULL'];
        return $this;
    }
    
    public function get() {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($this->where)) {
            $conditions = [];
            foreach ($this->where as $w) {
                if (isset($w[2]) && $w[2] === 'IS NULL') {
                    $conditions[] = "{$w[0]} IS NULL";
                } else {
                    $conditions[] = "{$w[0]} = ?";
                    $params[] = $w[1];
                }
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function first() {
        $results = $this->get();
        return $results[0] ?? null;
    }
}
