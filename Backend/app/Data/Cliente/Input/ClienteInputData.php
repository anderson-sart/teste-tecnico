<?php

namespace App\Data\Cliente\Input;

use App\Http\Request;

/**
 * Input Data para criar/atualizar Cliente.
 */
class ClienteInputData {
    
    public function __construct(
        public readonly string $nome,
        public readonly ?string $fantasia,
        public readonly string $documento,
        public readonly ?string $endereco,
    ) {}
    
    /**
     * Cria instância a partir da Request
     */
    public static function fromRequest(): self {
        return new self(
            nome: Request::input('nome', ''),
            fantasia: Request::input('fantasia'),
            documento: Request::input('documento', ''),
            endereco: Request::input('endereco'),
        );
    }
    
    /**
     * Converte para array para persistência
     */
    public function toArray(): array {
        return [
            'nome' => $this->nome,
            'fantasia' => $this->fantasia,
            'documento' => $this->documento,
            'endereco' => $this->endereco,
        ];
    }
}
