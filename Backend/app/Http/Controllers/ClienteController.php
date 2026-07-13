<?php

class ClienteController extends Controller {
    
    private ClienteRepositoryInterface $repository;
    
    public function __construct() {
        $this->repository = new ClienteRepositoryImplementation();
    }
    
    public function index() {
        $input = PaginationInputData::fromRequest('codigo');
        $useCase = new ListarClientesUseCase($this->repository);
        
        return ApiResponse::paginated($useCase->execute($input));
    }
    
    public function show($id) {
        $useCase = new ShowClienteUseCase($this->repository);
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function store() {
        $input = ClienteInputData::fromRequest();
        $useCase = new StoreClienteUseCase($this->repository);
        
        return ApiResponse::created($useCase->execute($input));
    }
    
    public function update($id) {
        $input = ClienteInputData::fromRequest();
        $useCase = new UpdateClienteUseCase($this->repository);
        $result = $useCase->execute((int) $id, $input);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function destroy($id) {
        $useCase = new DeleteClienteUseCase($this->repository);
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok(['message' => 'Cliente excluído com sucesso']);
    }
}
