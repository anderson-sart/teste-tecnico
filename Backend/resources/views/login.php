<?php ob_start(); ?>
<div class="gradient-bg d-flex align-items-center justify-content-center">
    <div class="card shadow-lg" style="width: 100%; max-width: 450px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                <h2 class="mt-3 fw-bold">Softline</h2>
                <p class="text-muted">Sistema de Cadastro</p>
            </div>
            <form id="loginForm">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person"></i> Usuário
                    </label>
                    <input type="text" class="form-control form-control-lg" id="username" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-lock"></i> Senha
                    </label>
                    <input type="password" class="form-control form-control-lg" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                </button>
                <div id="error" class="alert alert-danger mt-3 d-none"></div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const response = await fetch('/api/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            username: document.getElementById('username').value,
            password: document.getElementById('password').value
        })
    });
    const data = await response.json();
    if (data.success) {
        localStorage.setItem('username', data.username);
        window.location.href = '/menu';
    } else {
        const error = document.getElementById('error');
        error.textContent = data.message;
        error.classList.remove('d-none');
    }
});
</script>
<?php $scripts = ob_get_clean(); $title = 'Login'; include __DIR__ . '/layout.php'; ?>
