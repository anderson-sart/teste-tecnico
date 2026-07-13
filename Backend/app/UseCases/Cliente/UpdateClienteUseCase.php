<?php

/**
 * UseCase: Atualizar um Cliente existente.
 */
class UpdateClienteUseCase {
    
    public function execute(int $id, ClienteInputData $input): ?ClienteOutputData {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            return null;
        }
        
        Validator::validate($input->toArray(), [
            'nome' => 'required|max:60',
            'documento' => 'required|cpf_cnpj|max:18',
            'endereco' => 'max:255'
        ]);
        
        Cliente::update($id, $input->toArray());
        $cliente = Cliente::find($id);
        
        return ClienteOutputData::from($cliente);
    }
}
