<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: 100vh; padding: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="text-white fw-bold">Dashboard</h2>
            <p class="text-white-50">Visão geral do sistema</p>
        </div>
        
        <!-- Estatísticas -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total de Produtos</h6>
                                <h2 class="mb-0" id="totalProdutos">-</h2>
                                <small class="text-success"><i class="bi bi-arrow-up"></i> Valor total: R$ <span id="valorTotal">0,00</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-people text-success" style="font-size: 3rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total de Clientes</h6>
                                <h2 class="mb-0" id="totalClientes">-</h2>
                                <small class="text-primary"><i class="bi bi-person-check"></i> Cadastrados no sistema</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Menu de Ações -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-menu-button-wide text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 fw-bold">Menu Principal</h3>
                            <p class="text-muted">Selecione uma opção</p>
                        </div>
                        <div class="d-grid gap-3">
                            <a href="/produtos" class="btn btn-primary btn-lg text-start">
                                <i class="bi bi-box-seam me-2"></i> Produtos
                                <span class="badge bg-white text-primary float-end" id="badgeProdutos">0</span>
                            </a>
                            <a href="/clientes" class="btn btn-success btn-lg text-start">
                                <i class="bi bi-people me-2"></i> Clientes
                                <span class="badge bg-white text-success float-end" id="badgeClientes">0</span>
                            </a>
                            <button onclick="toggleTheme()" class="btn btn-outline-secondary btn-lg text-start" id="themeToggle">
                                <i class="bi bi-moon-stars me-2"></i> Modo Escuro
                            </button>
                            <button onclick="logout()" class="btn btn-outline-danger btn-lg text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> Sair
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
async function loadStats() {
    try {
        const [produtos, clientes] = await Promise.all([
            fetch('/api/produtos').then(r => r.json()),
            fetch('/api/clientes').then(r => r.json())
        ]);
        
        document.getElementById('totalProdutos').textContent = produtos.length;
        document.getElementById('badgeProdutos').textContent = produtos.length;
        
        const valorTotal = produtos.reduce((sum, p) => sum + parseFloat(p.valor_venda || 0), 0);
        document.getElementById('valorTotal').textContent = valorTotal.toFixed(2).replace('.', ',');
        
        document.getElementById('totalClientes').textContent = clientes.length;
        document.getElementById('badgeClientes').textContent = clientes.length;
    } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
    }
}

function logout() {
    localStorage.clear();
    fetch('/api/logout', { method: 'POST' })
        .finally(() => {
            window.location.href = '/';
        });
}

function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeButton();
}

function updateThemeButton() {
    const theme = localStorage.getItem('theme') || 'light';
    const btn = document.getElementById('themeToggle');
    if (theme === 'dark') {
        btn.innerHTML = '<i class="bi bi-sun me-2"></i> Modo Claro';
    } else {
        btn.innerHTML = '<i class="bi bi-moon-stars me-2"></i> Modo Escuro';
    }
}

// Atualiza botão de tema na carga
updateThemeButton();
loadStats();
</script>
<?php $scripts = ob_get_clean(); $title = 'Menu'; include __DIR__ . '/layout.php'; ?>
