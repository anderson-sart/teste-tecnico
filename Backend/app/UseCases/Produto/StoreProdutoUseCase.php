<?php

namespace App\UseCases\Produto;

use App\Data\Produto\Input\ProdutoInputData;
use App\Data\Produto\Output\ProdutoOutputData;
use App\Http\Validator;
use App\Repositories\Interface\ProdutoRepositoryInterface;

class StoreProdutoUseCase {

    public function __construct(private ProdutoRepositoryInterface $repository) {}

    public function execute(ProdutoInputData $input): ProdutoOutputData {
        Validator::validate($input->toArray(), [
            'descricao'    => 'required|max:60',
            'valor_venda'  => 'required|numeric',
            'peso_bruto'   => 'required|numeric',
            'peso_liquido' => 'required|numeric',
        ]);

        return ProdutoOutputData::from($this->repository->create($input->toArray()));
    }
}
