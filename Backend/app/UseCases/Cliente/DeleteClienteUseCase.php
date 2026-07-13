<?php

/**
 * UseCase: Excluir (soft delete) um Cliente.
 */
class DeleteClienteUseCase {
    
    public function __construct(
        private ClienteRepositoryInterface $repository
    ) {}
    
    public function execute(int $id): bool {
        return $this->repository->delete($id);
    }
}
