<?php

/**
 * UseCase: Buscar um Cliente por ID.
 */
class ShowClienteUseCase {
    
    public function execute(int $id): ?ClienteOutputData {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            return null;
        }
        
        return ClienteOutputData::from($cliente);
    }
}
