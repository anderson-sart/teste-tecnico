<?php ob_start(); ?>
<div class="gradient-bg d-flex align-items-center justify-content-center">
    <div class="card shadow-lg" style="width: 100%; max-width: 450px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-menu-button-wide text-primary" style="font-size: 3rem;"></i>
                <h2 class="mt-3 fw-bold">Menu Principal</h2>
                <p class="text-muted">Selecione uma opção</p>
            </div>
            <div class="d-grid gap-3">
                <a href="/produtos" class="btn btn-primary btn-lg text-start">
                    <i class="bi bi-box-seam me-2"></i> Produtos
                </a>
                <a href="/clientes" class="btn btn-success btn-lg text-start">
                    <i class="bi bi-people me-2"></i> Clientes
                </a>
                <button onclick="logout()" class="btn btn-outline-danger btn-lg text-start">
                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                </button>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function logout() {
    localStorage.clear();
    window.location.href = '/';
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Menu'; include __DIR__ . '/layout.php'; ?>
