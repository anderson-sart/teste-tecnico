<?php

/**
 * UseCase: Atualizar um Cliente existente.
 */
class UpdateClienteUseCase {
    
    public function __construct(
        private ClienteRepositoryInterface $repository
    ) {}
    
    public function execute(int $id, ClienteInputData $input): ?ClienteOutputData {
        $cliente = $this->repository->find($id);
        
        if (!$cliente) {
            return null;
        }
        
        Validator::validate($input->toArray(), [
            'nome' => 'required|max:60',
            'documento' => 'required|cpf_cnpj|max:18',
            'endereco' => 'max:255'
        ]);
        
        $this->repository->update($id, $input->toArray());
        $cliente = $this->repository->find($id);
        
        return ClienteOutputData::from($cliente);
    }
}
