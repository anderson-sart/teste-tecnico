@extends('layout')

@section('title', 'Novo Usuário')

@section('content')
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="usuarioForm()">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item"><a href="/usuarios">Usuários</a></li>
            <li class="breadcrumb-item active">Novo</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i>Novo Usuário</h3>
                </div>
                <div class="card-body p-4">
                    <a href="/usuarios" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar</a>
                    <form @submit.prevent="save()">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nome de Usuário *</label>
                                <input type="text" class="form-control" x-model="form.username" maxlength="50" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Senha *</label>
                                <div class="input-group">
                                    <input :type="showPassword ? 'text' : 'password'" class="form-control" x-model="form.password" required>
                                    <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Mínimo 6 caracteres</small>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
function usuarioForm() {
    return {
        form: { username: '', password: '' },
        showPassword: false,
        async save() {
            this.$store.loading.show();
            try {
                const res = await fetch('/api/users', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(this.form)
                });
                const data = await res.json();
                if (res.ok) {
                    this.$store.toast.show('Usuário criado!', 'success');
                    setTimeout(() => window.location.href = '/usuarios', 1000);
                } else {
                    this.$store.toast.show(data.errors ? Object.values(data.errors).flat().join(', ') : data.message || 'Erro ao salvar', 'error');
                    this.$store.loading.hide();
                }
            } catch (e) {
                this.$store.toast.show('Erro ao salvar usuário', 'error');
                this.$store.loading.hide();
            }
        }
    };
}
</script>
@endsection
