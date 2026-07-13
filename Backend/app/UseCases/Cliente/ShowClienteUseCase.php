<?php

namespace App\UseCases\Cliente;

use App\Data\Cliente\Output\ClienteOutputData;
use App\Repositories\Interface\ClienteRepositoryInterface;

/**
 * UseCase: Buscar um Cliente por ID.
 */
class ShowClienteUseCase {
    
    public function __construct(
        private ClienteRepositoryInterface $repository
    ) {}
    
    public function execute(int $id): ?ClienteOutputData {
        $cliente = $this->repository->find($id);
        
        if (!$cliente) {
            return null;
        }
        
        return ClienteOutputData::from($cliente);
    }
}
