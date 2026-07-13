<?php

/**
 * UseCase: Excluir (soft delete) um Produto.
 */
class DeleteProdutoUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}
    
    public function execute(int $id): bool {
        return $this->repository->delete($id);
    }
}
