<?php

/**
 * Input Data para criar/atualizar Produto.
 */
class ProdutoInputData {
    
    public function __construct(
        public readonly string $descricao,
        public readonly ?string $codigo_barras,
        public readonly float $valor_venda,
        public readonly float $peso_bruto,
        public readonly float $peso_liquido,
    ) {}
    
    /**
     * Cria instância a partir da Request
     */
    public static function fromRequest(): self {
        return new self(
            descricao: Request::input('descricao', ''),
            codigo_barras: Request::input('codigo_barras'),
            valor_venda: (float) Request::input('valor_venda', 0),
            peso_bruto: (float) Request::input('peso_bruto', 0),
            peso_liquido: (float) Request::input('peso_liquido', 0),
        );
    }
    
    /**
     * Converte para array para persistência
     */
    public function toArray(): array {
        return [
            'descricao' => $this->descricao,
            'codigo_barras' => $this->codigo_barras,
            'valor_venda' => $this->valor_venda,
            'peso_bruto' => $this->peso_bruto,
            'peso_liquido' => $this->peso_liquido,
        ];
    }
}
