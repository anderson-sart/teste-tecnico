<?php

/**
 * UseCase: Criar um novo Cliente.
 */
class StoreClienteUseCase {
    
    public function execute(ClienteInputData $input): ClienteOutputData {
        Validator::validate($input->toArray(), [
            'nome' => 'required|max:60',
            'documento' => 'required|cpf_cnpj|max:18',
            'endereco' => 'max:255'
        ]);
        
        $result = Cliente::create($input->toArray());
        $cliente = Cliente::find($result['codigo']);
        
        return ClienteOutputData::from($cliente);
    }
}
