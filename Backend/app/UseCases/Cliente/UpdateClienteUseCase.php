<?php

namespace App\UseCases\Cliente;

use App\Data\Cliente\Input\ClienteInputData;
use App\Data\Cliente\Output\ClienteOutputData;
use App\Http\Validator;
use App\Repositories\Interface\ClienteRepositoryInterface;

class UpdateClienteUseCase {

    public function __construct(private ClienteRepositoryInterface $repository) {}

    public function execute(int $id, ClienteInputData $input): ?ClienteOutputData {
        if (!$this->repository->find($id)) return null;

        Validator::validate($input->toArray(), [
            'nome'      => 'required|max:60',
            'documento' => 'required|max:18',
            'endereco'  => 'nullable|max:255',
        ]);

        if (!Validator::validarCPFCNPJ($input->documento)) {
            http_response_code(422);
            echo json_encode(['errors' => ['documento' => ['CPF ou CNPJ inválido.']]]);
            exit;
        }

        if ($this->repository->findByDocumento($input->documento, $id)) {
            http_response_code(422);
            echo json_encode(['errors' => ['documento' => ['Documento já cadastrado.']]]);
            exit;
        }

        $this->repository->update($id, $input->toArray());
        return ClienteOutputData::from($this->repository->find($id));
    }
}
