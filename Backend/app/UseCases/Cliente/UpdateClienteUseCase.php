<?php

class UpdateClienteUseCase {

    public function __construct(private ClienteRepositoryInterface $repository) {}

    public function execute(int $id, ClienteInputData $input): ?ClienteOutputData {
        if (!$this->repository->find($id)) return null;

        Validator::validate($input->toArray(), [
            'nome'      => 'required|max:60',
            'documento' => 'required|max:18',
            'endereco'  => 'nullable|max:255',
        ]);

        $this->repository->update($id, $input->toArray());
        return ClienteOutputData::from($this->repository->find($id));
    }
}
