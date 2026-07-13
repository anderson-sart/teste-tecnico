<?php

/**
 * UseCase: Listar Clientes com paginação, busca e ordenação.
 */
class ListarClientesUseCase {
    
    public function execute(PaginationInputData $input): array {
        $result = Cliente::paginate($input->toArray());
        
        $result['data'] = ClienteOutputData::collection($result['data']);
        
        return $result;
    }
}
