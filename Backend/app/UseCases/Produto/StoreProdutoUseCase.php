<?php

/**
 * UseCase: Criar um novo Produto.
 */
class StoreProdutoUseCase {
    
    /**
     * @param ProdutoInputData $input
     * @return ProdutoOutputData
     */
    public function execute(ProdutoInputData $input): ProdutoOutputData {
        Validator::validate($input->toArray(), [
            'descricao' => 'required|max:60',
            'codigo_barras' => 'barcode',
            'valor_venda' => 'required|numeric|max:99999999.99',
            'peso_bruto' => 'required|numeric|max:9999999.999',
            'peso_liquido' => 'required|numeric|max:9999999.999'
        ]);
        
        $result = Produto::create($input->toArray());
        $produto = Produto::find($result['codigo']);
        
        return ProdutoOutputData::from($produto);
    }
}
