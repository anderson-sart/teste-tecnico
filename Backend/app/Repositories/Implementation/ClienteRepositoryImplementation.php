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
}
