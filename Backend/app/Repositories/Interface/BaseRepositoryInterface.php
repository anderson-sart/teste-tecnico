<?php

/**
 * Interface base para todos os repositories.
 * Define o contrato padrão de operações CRUD e consultas.
 */
interface BaseRepositoryInterface {
    
    /**
     * Buscar todos os registros
     */
    public function all(): array;
    
    /**
     * Buscar com paginação, busca e ordenação
     */
    public function paginate(array $params = []): array;
    
    /**
     * Buscar por ID
     */
    public function find(int $id): ?array;
    
    /**
     * Criar registro
     */
    public function create(array $data): array;
    
    /**
     * Atualizar registro
     */
    public function update(int $id, array $data): bool;
    
    /**
     * Excluir registro
     */
    public function delete(int $id): bool;
    
    /**
     * Buscar por campo específico
     */
    public function findBy(string $field, mixed $value): ?array;
    
    /**
     * Contar registros
     */
    public function count(string $search = ''): int;
}
