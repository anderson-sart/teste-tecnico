<?php

class ProdutoController extends Controller {
    
    private ProdutoRepositoryInterface $repository;
    
    public function __construct() {
        $this->repository = new ProdutoRepositoryImplementation();
    }
    
    public function index() {
        $input = PaginationInputData::fromRequest('codigo');
        $useCase = new ListarProdutosUseCase($this->repository);
        
        return ApiResponse::paginated($useCase->execute($input));
    }
    
    public function show($id) {
        $useCase = new ShowProdutoUseCase($this->repository);
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function store() {
        $input = ProdutoInputData::fromRequest();
        $useCase = new StoreProdutoUseCase($this->repository);
        
        return ApiResponse::created($useCase->execute($input));
    }
    
    public function update($id) {
        $input = ProdutoInputData::fromRequest();
        $useCase = new UpdateProdutoUseCase($this->repository);
        $result = $useCase->execute((int) $id, $input);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function destroy($id) {
        $useCase = new DeleteProdutoUseCase($this->repository);
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Produto não encontrado');
        }
        
        return ApiResponse::ok(['message' => 'Produto excluído com sucesso']);
    }
}
