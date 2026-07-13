<?php

/**
 * UseCase: Obter estatísticas do dashboard.
 * Retorna contagens e agregações sem trazer todos os registros.
 */
class GetStatsUseCase {
    
    /**
     * @return array{produtos: int, clientes: int, valor_total: float}
     */
    public function execute(): array {
        return [
            'produtos' => Produto::count(),
            'clientes' => Cliente::count(),
            'valor_total' => Produto::sum('valor_venda'),
        ];
    }
}
