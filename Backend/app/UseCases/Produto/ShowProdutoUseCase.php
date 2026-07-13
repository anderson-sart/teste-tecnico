<?php

/**
 * UseCase: Buscar um Produto por ID.
 */
class ShowProdutoUseCase {
    
    /**
     * @param int $id
     * @return ProdutoOutputData|null
     */
    public function execute(int $id): ?ProdutoOutputData {
        $produto = Produto::find($id);
        
        if (!$produto) {
            return null;
        }
        
        return ProdutoOutputData::from($produto);
    }
}
