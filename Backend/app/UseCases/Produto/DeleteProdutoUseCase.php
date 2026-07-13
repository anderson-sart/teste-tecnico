<?php

/**
 * UseCase: Excluir (soft delete) um Produto.
 */
class DeleteProdutoUseCase {
    
    /**
     * @param int $id
     * @return bool true se excluiu, false se não encontrou
     */
    public function execute(int $id): bool {
        $produto = Produto::find($id);
        
        if (!$produto) {
            return false;
        }
        
        Produto::delete($id);
        return true;
    }
}
