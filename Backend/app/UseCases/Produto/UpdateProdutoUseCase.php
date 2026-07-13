<?php

/**
 * UseCase: Atualizar um Produto existente.
 */
class UpdateProdutoUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}
    
    public function execute(int $id, ProdutoInputData $input): ?ProdutoOutputData {
        $produto = $this->repository->find($id);
        
        if (!$produto) {
            return null;
        }
        
        Validator::validate($input->toArray(), [
            'descricao' => 'required|max:60',
            'codigo_barras' => 'barcode',
            'valor_venda' => 'required|numeric|max:99999999.99',
            'peso_bruto' => 'required|numeric|max:9999999.999',
            'peso_liquido' => 'required|numeric|max:9999999.999'
        ]);
        
        $this->repository->update($id, $input->toArray());
        $produto = $this->repository->find($id);
        
        return ProdutoOutputData::from($produto);
    }
}
