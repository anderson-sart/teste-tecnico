<?php

/**
 * Output Data para Cliente.
 * Garante a estrutura e tipagem da resposta.
 */
class ClienteOutputData {
    
    public function __construct(
        public readonly int $codigo,
        public readonly string $nome,
        public readonly ?string $fantasia,
        public readonly string $documento,
        public readonly ?string $endereco,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
    ) {}
    
    /**
     * Cria instância a partir de um array (row do banco)
     */
    public static function from(array $data): self {
        return new self(
            codigo: (int) ($data['codigo'] ?? 0),
            nome: $data['nome'] ?? '',
            fantasia: $data['fantasia'] ?? null,
            documento: $data['documento'] ?? '',
            endereco: $data['endereco'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
    
    /**
     * Cria coleção de OutputData a partir de array de rows
     */
    public static function collection(array $items): array {
        return array_map(fn($item) => self::from($item), $items);
    }
    
    /**
     * Converte para array
     */
    public function toArray(): array {
        return [
            'codigo' => $this->codigo,
            'nome' => $this->nome,
            'fantasia' => $this->fantasia,
            'documento' => $this->documento,
            'endereco' => $this->endereco,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
