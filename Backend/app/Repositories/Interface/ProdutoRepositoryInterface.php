<?php

/**
 * Interface do Repository de Produto.
 * Estende o contrato base e adiciona métodos específicos de Produto.
 */
interface ProdutoRepositoryInterface extends BaseRepositoryInterface {
    
    /**
     * Somar valor de uma coluna numérica
     */
    public function sum(string $column): float;
}
