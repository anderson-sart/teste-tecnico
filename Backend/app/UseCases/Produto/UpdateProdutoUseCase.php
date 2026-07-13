<?php

/**
 * UseCase: Atualizar um Produto existente.
 */
class UpdateProdutoUseCase {
    
    /**
     * @param int $id
     * @param ProdutoInputData $input
     * @return ProdutoOutputData|null
     */
    public function execute(int $id, ProdutoInputData $input): ?ProdutoOutputData {
        $produto = Produto::find($id);
        
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
        
        Produto::update($id, $input->toArray());
        $produto = Produto::find($id);
        
        return ProdutoOutputData::from($produto);
    }
}
