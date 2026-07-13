<?php

/**
 * UseCase: Criar um novo Produto.
 */
class StoreProdutoUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}
    
    public function execute(ProdutoInputData $input): ProdutoOutputData {
        Validator::validate($input->toArray(), [
            'descricao' => 'required|max:60',
            'codigo_barras' => 'barcode',
            'valor_venda' => 'required|numeric|max:99999999.99',
            'peso_bruto' => 'required|numeric|max:9999999.999',
            'peso_liquido' => 'required|numeric|max:9999999.999'
        ]);
        
        $result = $this->repository->create($input->toArray());
        $produto = $this->repository->find($result['codigo']);
        
        return ProdutoOutputData::from($produto);
    }
}
