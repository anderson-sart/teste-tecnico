<?php

namespace App\UseCases\Produto;

use App\Data\Produto\Input\ProdutoInputData;
use App\Data\Produto\Output\ProdutoOutputData;
use App\Http\Validator;
use App\Repositories\Interface\ProdutoRepositoryInterface;

class UpdateProdutoUseCase {

    public function __construct(private ProdutoRepositoryInterface $repository) {}

    public function execute(int $id, ProdutoInputData $input): ?ProdutoOutputData {
        if (!$this->repository->find($id)) return null;

        Validator::validate($input->toArray(), [
            'descricao'    => 'required|max:60',
            'valor_venda'  => 'required|numeric',
            'peso_bruto'   => 'required|numeric',
            'peso_liquido' => 'required|numeric',
        ]);

        $this->repository->update($id, $input->toArray());
        return ProdutoOutputData::from($this->repository->find($id));
    }
}
