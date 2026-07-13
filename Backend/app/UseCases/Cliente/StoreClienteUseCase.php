<?php

namespace App\UseCases\Cliente;

use App\Data\Cliente\Input\ClienteInputData;
use App\Data\Cliente\Output\ClienteOutputData;
use App\Http\Validator;
use App\Repositories\Interface\ClienteRepositoryInterface;

class StoreClienteUseCase {

    public function __construct(private ClienteRepositoryInterface $repository) {}

    public function execute(ClienteInputData $input): ClienteOutputData {
        Validator::validate($input->toArray(), [
            'nome'      => 'required|max:60',
            'documento' => 'required|max:18',
            'endereco'  => 'nullable|max:255',
        ]);

        return ClienteOutputData::from($this->repository->create($input->toArray()));
    }
}
