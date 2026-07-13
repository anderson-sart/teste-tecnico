<?php

/**
 * Implementação do Repository de Produto.
 */
class ProdutoRepositoryImplementation extends BaseRepositoryImplementation implements ProdutoRepositoryInterface {
    
    public function __construct() {
        parent::__construct(Produto::class);
    }
    
    public function sum(string $column): float {
        return Produto::sum($column);
    }
}
