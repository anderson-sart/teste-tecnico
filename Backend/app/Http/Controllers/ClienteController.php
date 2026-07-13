<?php

class ClienteController extends Controller {
    
    public function index() {
        $input = PaginationInputData::fromRequest('codigo');
        $useCase = new ListarClientesUseCase();
        
        return ApiResponse::paginated($useCase->execute($input));
    }
    
    public function show($id) {
        $useCase = new ShowClienteUseCase();
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function store() {
        $input = ClienteInputData::fromRequest();
        $useCase = new StoreClienteUseCase();
        
        return ApiResponse::created($useCase->execute($input));
    }
    
    public function update($id) {
        $input = ClienteInputData::fromRequest();
        $useCase = new UpdateClienteUseCase();
        $result = $useCase->execute((int) $id, $input);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok($result);
    }
    
    public function destroy($id) {
        $useCase = new DeleteClienteUseCase();
        $result = $useCase->execute((int) $id);
        
        if (!$result) {
            return ApiResponse::notFound('Cliente não encontrado');
        }
        
        return ApiResponse::ok(['message' => 'Cliente excluído com sucesso']);
    }
}
