<?php

/**
 * UseCase: Obter estatísticas do dashboard.
 */
class GetStatsUseCase {
    
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository,
        private ClienteRepositoryInterface $clienteRepository,
    ) {}
    
    public function execute(): array {
        return [
            'produtos' => $this->produtoRepository->count(),
            'clientes' => $this->clienteRepository->count(),
            'valor_total' => $this->produtoRepository->sum('valor_venda'),
        ];
    }
}
