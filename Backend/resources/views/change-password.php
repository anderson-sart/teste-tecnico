<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: calc(100vh - 76px); display: flex; align-items: center; justify-content: center; padding: 20px;" x-data="changePassword()">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 fw-bold">Trocar Senha</h3>
                            <p class="text-muted">Altere sua senha de acesso</p>
                        </div>

                        <form @submit.prevent="submit()">
                            <!-- Senha Atual -->
                            <div class="mb-3">
                                <label class="form-label">Senha Atual</label>
                                <div class="input-group">
                                    <input :type="show.current ? 'text' : 'password'" class="form-control" x-model="form.current_password" required>
                                    <button type="button" class="btn btn-outline-secondary" @click="show.current = !show.current">
                                        <i :class="show.current ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Nova Senha -->
                            <div class="mb-3">
                                <label class="form-label">Nova Senha</label>
                                <div class="input-group">
                                    <input :type="show.new ? 'text' : 'password'" class="form-control" x-model="form.new_password" @input="checkStrength()" required>
                                    <button type="button" class="btn btn-outline-secondary" @click="show.new = !show.new">
                                        <i :class="show.new ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>
                                
                                <!-- Medidor de Força -->
                                <div class="mt-2" x-show="form.new_password">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">Força da senha:</small>
                                        <span class="badge" :class="strength.class" x-text="strength.text"></span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" :class="strength.class" :style="`width: ${strength.percent}%`"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirmar Nova Senha -->
                            <div class="mb-3">
                                <label class="form-label">Confirmar Nova Senha</label>
                                <div class="input-group">
                                    <input :type="show.confirm ? 'text' : 'password'" class="form-control" x-model="form.confirm_password" required>
                                    <button type="button" class="btn btn-outline-secondary" @click="show.confirm = !show.confirm">
                                        <i :class="show.confirm ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>
                                <small class="text-danger" x-show="form.confirm_password && form.new_password !== form.confirm_password">
                                    As senhas não coincidem
                                </small>
                            </div>

                            <!-- Botões -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" :disabled="!isValid()">
                                    <i class="bi bi-check-circle me-2"></i>Alterar Senha
                                </button>
                                <a href="/menu" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function changePassword() {
    return {
        form: {
            current_password: '',
            new_password: '',
            confirm_password: ''
        },
        show: {
            current: false,
            new: false,
            confirm: false
        },
        strength: {
            text: '',
            class: '',
            percent: 0
        },
        
        checkStrength() {
            const pwd = this.form.new_password;
            let score = 0;
            
            if (pwd.length >= 6) score++;
            if (pwd.length >= 8) score++;
            if (/[a-z]/.test(pwd) && /[A-Z]/.test(pwd)) score++;
            if (/\d/.test(pwd)) score++;
            if (/[^a-zA-Z0-9]/.test(pwd)) score++;
            
            if (score <= 2) {
                this.strength = { text: 'Fraca', class: 'bg-danger', percent: 33 };
            } else if (score <= 3) {
                this.strength = { text: 'Média', class: 'bg-warning', percent: 66 };
            } else {
                this.strength = { text: 'Forte', class: 'bg-success', percent: 100 };
            }
        },
        
        isValid() {
            return this.form.current_password && 
                   this.form.new_password && 
                   this.form.new_password === this.form.confirm_password &&
                   this.form.new_password.length >= 6;
        },
        
        async submit() {
            this.$store.loading.show();
            try {
                const response = await fetch('/api/change-password', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.$store.toast.show('Senha alterada com sucesso!', 'success');
                    setTimeout(() => window.location.href = '/menu', 1500);
                } else {
                    this.$store.toast.show(data.message || 'Erro ao alterar senha', 'error');
                }
            } catch (e) {
                this.$store.toast.show('Erro ao alterar senha', 'error');
            } finally {
                this.$store.loading.hide();
            }
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Trocar Senha'; include __DIR__ . '/layout.php'; ?>
