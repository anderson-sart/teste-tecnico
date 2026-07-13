<?php

/**
 * UseCase: Excluir (soft delete) um Cliente.
 */
class DeleteClienteUseCase {
    
    public function execute(int $id): bool {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            return false;
        }
        
        Cliente::delete($id);
        return true;
    }
}
