<?php

class ProdutoController extends Controller {
    
    public function index() {
        $input = PaginationInputData::fromRequest('codigo');
        $useCase = new ListarProdutosUseCase();
        
        return ApiResponse::paginated($useCase->execute($input));
    }
    
    public function show($id) {
        $useCase = new ShowProdutoUseCase();
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function store() {
        $input = ProdutoInputData::fromRequest();
        $useCase = new StoreProdutoUseCase();
        
        return ApiResponse::created($useCase->execute($input));
    }
    
    public function update($id) {
        $input = ProdutoInputData::fromRequest();
        $useCase = new UpdateProdutoUseCase();
        $result = $useCase->execute((int) $id, $input);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function destroy($id) {
        $useCase = new DeleteProdutoUseCase();
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok(['message' => 'Produto excluído com sucesso']);
    }
}
