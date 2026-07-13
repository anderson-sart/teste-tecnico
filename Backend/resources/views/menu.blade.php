@extends('layout')

@section('title', 'Menu')

@section('content')
@php $authUser = \App\Http\JWT::getUser(); @endphp
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;" x-data="dashboard()" x-init="init()">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="text-white fw-bold display-5 mb-2">Bem-vindo, {{ $authUser['username'] ?? 'Usuário' }}!</h1>
            <p class="text-white-50 fs-5">Gerencie seus produtos e clientes</p>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-box-seam text-primary mb-3" style="font-size: 3.5rem;"></i>
                        <h3 class="fw-bold mb-1" x-text="stats.produtos">0</h3>
                        <p class="text-muted mb-0">Produtos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-people text-success mb-3" style="font-size: 3.5rem;"></i>
                        <h3 class="fw-bold mb-1" x-text="stats.clientes">0</h3>
                        <p class="text-muted mb-0">Clientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-currency-dollar text-warning mb-3" style="font-size: 3.5rem;"></i>
                        <h3 class="fw-bold mb-1">R$ <span x-text="stats.valorTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})">0,00</span></h3>
                        <p class="text-muted mb-0">Valor Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-graph-up text-info mb-3" style="font-size: 3.5rem;"></i>
                        <h3 class="fw-bold mb-1" x-text="stats.produtos + stats.clientes">0</h3>
                        <p class="text-muted mb-0">Total de Registros</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="/produtos" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-lg hover-lift">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-box-seam text-primary mb-3" style="font-size: 4rem;"></i>
                            <h4 class="fw-bold mb-2">Produtos</h4>
                            <p class="text-muted mb-0">Gerenciar produtos cadastrados</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="/clientes" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-lg hover-lift">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-people text-success mb-3" style="font-size: 4rem;"></i>
                            <h4 class="fw-bold mb-2">Clientes</h4>
                            <p class="text-muted mb-0">Gerenciar clientes cadastrados</p>
                        </div>
                    </div>
                </a>
            </div>
            @if(!empty($authUser['is_admin']))
            <div class="col-lg-4">
                <a href="/usuarios" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-lg hover-lift">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-person-gear text-info mb-3" style="font-size: 4rem;"></i>
                            <h4 class="fw-bold mb-2">Usuários</h4>
                            <p class="text-muted mb-0">Gerenciar usuários do sistema</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <a href="/change-password" class="text-decoration-none">
                    <div class="card border-0 shadow-lg hover-lift">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-shield-lock text-warning mb-2" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold mb-1">Segurança</h5>
                            <p class="text-muted mb-0">Alterar senha de acesso</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function dashboard() {
    return {
        stats: { produtos: 0, clientes: 0, valorTotal: 0 },
        async init() { await this.loadStats(); },
        async loadStats() {
            this.$store.loading.show();
            try {
                const res = await fetch('/api/stats');
                const stats = await res.json();
                this.stats.produtos = stats.produtos;
                this.stats.clientes = stats.clientes;
                this.stats.valorTotal = stats.valor_total;
            } catch (e) {
                this.$store.toast.show('Erro ao carregar estatísticas', 'error');
            } finally {
                this.$store.loading.hide();
            }
        }
    };
}
</script>
@endsection
