<?php

namespace App\Repositories\Interface;

/**
 * Interface do Repository de Cliente.
 * Estende o contrato base.
 */
interface ClienteRepositoryInterface extends BaseRepositoryInterface {
    public function findByDocumento(string $documento, ?int $excludeId = null): ?array;
}
