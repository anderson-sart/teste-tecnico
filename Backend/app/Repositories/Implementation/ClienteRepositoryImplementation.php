<?php

namespace App\Repositories\Implementation;

use App\Models\Cliente;
use App\Repositories\Interface\ClienteRepositoryInterface;

/**
 * Implementação do Repository de Cliente.
 */
class ClienteRepositoryImplementation extends BaseRepositoryImplementation implements ClienteRepositoryInterface {
    
    public function __construct() {
        parent::__construct(Cliente::class);
    }

    public function findByDocumento(string $documento, ?int $excludeId = null): ?array {
        $doc = preg_replace('/\D/', '', $documento);
        $query = Cliente::whereRaw("regexp_replace(documento, '\D', '', 'g') = ?", [$doc]);
        if ($excludeId) $query->where('codigo', '!=', $excludeId);
        return $query->first()?->toArray();
    }
}
