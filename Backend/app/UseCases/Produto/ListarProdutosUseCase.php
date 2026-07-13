<?php

/**
 * UseCase: Listar Produtos com paginação, busca e ordenação.
 *
 * Responsabilidade única: executar a consulta paginada e retornar
 * os dados transformados via OutputData.
 */
class ListarProdutosUseCase {
    
    /**
     * @param PaginationInputData $input
     * @return array Estrutura paginada com data transformada em ProdutoOutputData
     */
    public function execute(PaginationInputData $input): array {
        $result = Produto::paginate($input->toArray());
        
        $result['data'] = ProdutoOutputData::collection($result['data']);
        
        return $result;
    }
}
