<?php ob_start(); ?>
<div class="gradient-bg d-flex align-items-center justify-content-center" style="padding: 40px 20px;" x-data="loginForm()">
    <div class="card shadow-lg" style="width: 100%; max-width: 450px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                <h2 class="mt-3 fw-bold">Softline</h2>
                <p class="text-muted">Sistema de Cadastro</p>
            </div>
            <form @submit.prevent="login()">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person"></i> Usuário
                    </label>
                    <input type="text" class="form-control form-control-lg" x-model="username" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-lock"></i> Senha
                    </label>
                    <div class="input-group input-group-lg">
                        <input :type="showPassword ? 'text' : 'password'" class="form-control" x-model="password" required>
                        <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100" :disabled="loading">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                </button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function loginForm() {
    return {
        username: '',
        password: '',
        showPassword: false,
        loading: false,
        
        async login() {
            this.loading = true;
            this.$store.loading.show();
            
            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        username: this.username,
                        password: this.password
                    })
                });
                
                const data = await res.json();
                
                if (data.success) {
                    localStorage.setItem('username', data.username);
                    this.$store.toast.show('Login realizado com sucesso!', 'success');
                    setTimeout(() => window.location.href = '/menu', 1000);
                } else {
                    this.$store.toast.show(data.message || 'Usuário ou senha incorretos', 'error');
                    this.loading = false;
                    this.$store.loading.hide();
                }
            } catch (e) {
                this.$store.toast.show('Erro ao fazer login', 'error');
                this.loading = false;
                this.$store.loading.hide();
            }
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Login'; include __DIR__ . '/layout.php'; ?>
