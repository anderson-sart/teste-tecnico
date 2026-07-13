<?php

namespace App\Data\Produto\Output;

/**
 * Output Data para Produto.
 * Garante a estrutura e tipagem da resposta.
 */
class ProdutoOutputData {
    
    public function __construct(
        public readonly int $codigo,
        public readonly string $descricao,
        public readonly ?string $codigo_barras,
        public readonly float $valor_venda,
        public readonly float $peso_bruto,
        public readonly float $peso_liquido,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
    ) {}
    
    /**
     * Cria instância a partir de um array (row do banco)
     */
    public static function from(array $data): self {
        return new self(
            codigo: (int) ($data['codigo'] ?? 0),
            descricao: $data['descricao'] ?? '',
            codigo_barras: $data['codigo_barras'] ?? null,
            valor_venda: (float) ($data['valor_venda'] ?? 0),
            peso_bruto: (float) ($data['peso_bruto'] ?? 0),
            peso_liquido: (float) ($data['peso_liquido'] ?? 0),
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
            'descricao' => $this->descricao,
            'codigo_barras' => $this->codigo_barras,
            'valor_venda' => $this->valor_venda,
            'peso_bruto' => $this->peso_bruto,
            'peso_liquido' => $this->peso_liquido,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
