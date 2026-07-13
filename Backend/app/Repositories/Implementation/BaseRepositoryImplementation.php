<?php

/**
 * Implementação base do Repository.
 * Encapsula o acesso ao Model, permitindo trocar a fonte de dados sem alterar UseCases.
 */
class BaseRepositoryImplementation implements BaseRepositoryInterface {
    
    protected string $modelClass;
    
    public function __construct(string $modelClass) {
        $this->modelClass = $modelClass;
    }
    
    public function all(): array {
        return $this->modelClass::all();
    }
    
    public function paginate(array $params = []): array {
        return $this->modelClass::paginate($params);
    }
    
    public function find(int $id): ?array {
        $result = $this->modelClass::find($id);
        return $result ?: null;
    }
    
    public function create(array $data): array {
        return $this->modelClass::create($data);
    }
    
    public function update(int $id, array $data): bool {
        $existing = $this->modelClass::find($id);
        if (!$existing) {
            return false;
        }
        $this->modelClass::update($id, $data);
        return true;
    }
    
    public function delete(int $id): bool {
        $existing = $this->modelClass::find($id);
        if (!$existing) {
            return false;
        }
        $this->modelClass::delete($id);
        return true;
    }
    
    public function findBy(string $field, mixed $value): ?array {
        $result = $this->modelClass::where($field, $value);
        return $result ?: null;
    }
    
    public function count(string $search = ''): int {
        return $this->modelClass::count($search);
    }
}
