<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;" x-data="dashboard()" x-init="init()">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="text-white fw-bold display-5 mb-2">Bem-vindo, <?= $_SESSION['username'] ?? 'Usuário' ?>!</h1>
            <p class="text-white-50 fs-5">Gerencie seus produtos e clientes</p>
        </div>
        
        <!-- Estatísticas -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-box-seam text-primary" style="font-size: 3.5rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" x-text="stats.produtos">0</h3>
                        <p class="text-muted mb-0">Produtos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-people text-success" style="font-size: 3.5rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" x-text="stats.clientes">0</h3>
                        <p class="text-muted mb-0">Clientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-currency-dollar text-warning" style="font-size: 3.5rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1">R$ <span x-text="stats.valorTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})">0,00</span></h3>
                        <p class="text-muted mb-0">Valor Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-graph-up text-info" style="font-size: 3.5rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" x-text="stats.produtos + stats.clientes">0</h3>
                        <p class="text-muted mb-0">Total de Registros</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ações Rápidas -->
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
            <div class="col-lg-4">
                <a href="/change-password" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-lg hover-lift">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-shield-lock text-warning mb-3" style="font-size: 4rem;"></i>
                            <h4 class="fw-bold mb-2">Segurança</h4>
                            <p class="text-muted mb-0">Alterar senha de acesso</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function dashboard() {
    return {
        stats: { produtos: 0, clientes: 0, valorTotal: 0 },
        theme: localStorage.getItem('theme') || 'light',
        
        async init() {
            await this.loadStats();
        },
        
        async loadStats() {
            this.$store.loading.show();
            try {
                const [produtos, clientes] = await Promise.all([
                    fetch('/api/produtos').then(r => r.json()),
                    fetch('/api/clientes').then(r => r.json())
                ]);
                
                this.stats.produtos = produtos.length;
                this.stats.clientes = clientes.length;
                this.stats.valorTotal = produtos.reduce((sum, p) => sum + parseFloat(p.valor_venda || 0), 0);
            } catch (e) {
                this.$store.toast.show('Erro ao carregar estatísticas', 'error');
            } finally {
                this.$store.loading.hide();
            }
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Menu'; include __DIR__ . '/layout.php'; ?>
