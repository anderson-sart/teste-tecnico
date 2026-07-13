<?php

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
