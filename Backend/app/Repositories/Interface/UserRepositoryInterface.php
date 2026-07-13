<?php

/**
 * Interface do Repository de User.
 * Estende o contrato base.
 */
interface UserRepositoryInterface extends BaseRepositoryInterface {
    
    /**
     * Buscar usuário por username
     */
    public function findByUsername(string $username): ?array;
}
