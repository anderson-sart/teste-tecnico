<?php

namespace App\UseCases\Produto;

use App\Data\Produto\Output\ProdutoOutputData;
use App\Repositories\Interface\ProdutoRepositoryInterface;

/**
 * UseCase: Buscar um Produto por ID.
 */
class ShowProdutoUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}
    
    public function execute(int $id): ?ProdutoOutputData {
        $produto = $this->repository->find($id);
        
        if (!$produto) {
            return null;
        }
        
        return ProdutoOutputData::from($produto);
    }
}
