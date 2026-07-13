<?php

namespace App\UseCases\Produto;

use App\Data\Pagination\PaginationInputData;
use App\Data\Produto\Output\ProdutoOutputData;
use App\Repositories\Interface\ProdutoRepositoryInterface;

/**
 * UseCase: Listar Produtos com paginação, busca e ordenação.
 */
class ListarProdutosUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}
    
    public function execute(PaginationInputData $input): array {
        $result = $this->repository->paginate($input->toArray());
        
        $result['data'] = ProdutoOutputData::collection($result['data']);
        
        return $result;
    }
}
