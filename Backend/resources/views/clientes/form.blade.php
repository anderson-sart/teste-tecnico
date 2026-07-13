@extends('layout')

@section('title', 'Formulário de Cliente')

@section('content')
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="clienteForm()" x-init="init()">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item"><a href="/clientes">Clientes</a></li>
            <li class="breadcrumb-item active">Formulário</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h3 class="mb-0"><i class="bi bi-people me-2"></i>Formulário de Cliente</h3>
                </div>
                <div class="card-body p-4">
                    <a href="/clientes" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar</a>
                    <form @submit.prevent="save()">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nome (máx 60) *</label>
                                <input type="text" class="form-control" x-model="form.nome" maxlength="60" required>
                                <div class="char-counter" x-text="`${form.nome.length}/60`" :class="{'text-danger': form.nome.length >= 54}"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Fantasia (máx 100)</label>
                                <input type="text" class="form-control" x-model="form.fantasia" maxlength="100">
                                <div class="char-counter" x-text="`${form.fantasia.length}/100`"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Documento (CPF/CNPJ) *</label>
                                <input type="text" class="form-control" x-model="form.documento" @input="maskDocument()" maxlength="18" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Endereço (máx 255)</label>
                                <textarea class="form-control" x-model="form.endereco" rows="3" maxlength="255"></textarea>
                                <div class="char-counter" x-text="`${form.endereco.length}/255`" :class="{'text-danger': form.endereco.length >= 240}"></div>
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
function clienteForm() {
    return {
        id: null,
        form: { nome: '', fantasia: '', documento: '', endereco: '' },
        async init() {
            const match = window.location.pathname.match(/\/clientes\/edit\/(\d+)/);
            if (match) { this.id = match[1]; await this.load(); }
        },
        async load() {
            this.$store.loading.show();
            try {
                const res = await fetch('/api/clientes/' + this.id);
                const data = await res.json();
                this.form = { nome: data.nome, fantasia: data.fantasia || '', documento: data.documento, endereco: data.endereco || '' };
            } catch (e) {
                this.$store.toast.show('Erro ao carregar cliente', 'error');
            } finally { this.$store.loading.hide(); }
        },
        maskDocument() {
            let val = this.form.documento.replace(/\D/g, '');
            if (val.length <= 11) {
                val = val.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            } else {
                val = val.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                         .replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2');
            }
            this.form.documento = val;
        },
        async save() {
            this.$store.loading.show();
            try {
                const res = await fetch(this.id ? '/api/clientes/' + this.id : '/api/clientes', {
                    method: this.id ? 'PUT' : 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(this.form)
                });
                const data = await res.json();
                if (res.ok) {
                    this.$store.toast.show(this.id ? 'Cliente atualizado!' : 'Cliente criado!', 'success');
                    setTimeout(() => window.location.href = '/clientes', 1000);
                } else {
                    this.$store.toast.show(data.errors ? Object.values(data.errors).flat().join(', ') : data.message || 'Erro ao salvar', 'error');
                    this.$store.loading.hide();
                }
            } catch (e) {
                this.$store.toast.show('Erro ao salvar cliente', 'error');
                this.$store.loading.hide();
            }
        }
    };
}
</script>
@endsection
