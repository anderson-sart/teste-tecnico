<?php

namespace App\UseCases\Cliente;

use App\Data\Pagination\PaginationInputData;
use App\Data\Cliente\Output\ClienteOutputData;
use App\Repositories\Interface\ClienteRepositoryInterface;

/**
 * UseCase: Listar Clientes com paginação, busca e ordenação.
 */
class ListarClientesUseCase {
    
    public function __construct(
        private ClienteRepositoryInterface $repository
    ) {}
    
    public function execute(PaginationInputData $input): array {
        $result = $this->repository->paginate($input->toArray());
        
        $result['data'] = ClienteOutputData::collection($result['data']);
        
        return $result;
    }
}
