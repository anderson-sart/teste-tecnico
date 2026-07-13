<?php

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
