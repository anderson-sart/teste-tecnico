<?php

namespace App\Repositories\Implementation;

use App\Models\Produto;
use App\Repositories\Interface\ProdutoRepositoryInterface;

/**
 * Implementação do Repository de Produto.
 */
class ProdutoRepositoryImplementation extends BaseRepositoryImplementation implements ProdutoRepositoryInterface {
    
    public function __construct() {
        parent::__construct(Produto::class);
    }
}
