<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="produtoForm()" x-init="init()">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item"><a href="/produtos">Produtos</a></li>
            <li class="breadcrumb-item active">Formulário</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Formulário de Produto</h3>
                </div>
                <div class="card-body p-4">
                    <a href="/produtos" class="btn btn-outline-secondary mb-4">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <form @submit.prevent="save()">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Descrição (máx 60) *</label>
                                <input type="text" class="form-control" x-model="form.descricao" maxlength="60" required>
                                <div class="char-counter" x-text="`${form.descricao.length}/60`" 
                                     :class="{'text-danger': form.descricao.length >= 54}"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Código de Barras</label>
                                <input type="text" class="form-control" x-model="form.codigo_barras" maxlength="14">
                                <div class="char-counter" x-text="`${form.codigo_barras.length}/14`"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Valor de Venda *</label>
                                <input type="number" class="form-control" x-model.number="form.valor_venda" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Peso Bruto (kg) *</label>
                                <input type="number" class="form-control" x-model.number="form.peso_bruto" step="0.001" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Peso Líquido (kg) *</label>
                                <input type="number" class="form-control" x-model.number="form.peso_liquido" step="0.001" required>
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
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function produtoForm() {
    return {
        id: null,
        form: {
            descricao: '',
            codigo_barras: '',
            valor_venda: '',
            peso_bruto: '',
            peso_liquido: ''
        },
        
        async init() {
            const path = window.location.pathname;
            const match = path.match(/\/produtos\/edit\/(\d+)/);
            if (match) {
                this.id = match[1];
                await this.load();
            }
        },
        
        async load() {
            this.$store.loading.show();
            try {
                const res = await fetch('/api/produtos/' + this.id);
                const data = await res.json();
                this.form = {
                    descricao: data.descricao,
                    codigo_barras: data.codigo_barras || '',
                    valor_venda: data.valor_venda,
                    peso_bruto: data.peso_bruto,
                    peso_liquido: data.peso_liquido
                };
            } catch (e) {
                this.$store.toast.show('Erro ao carregar produto', 'error');
            } finally {
                this.$store.loading.hide();
            }
        },
        
        async save() {
            this.$store.loading.show();
            try {
                const url = this.id ? '/api/produtos/' + this.id : '/api/produtos';
                const method = this.id ? 'PUT' : 'POST';
                
                const res = await fetch(url, {
                    method,
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(this.form)
                });
                
                const data = await res.json();
                
                if (res.ok) {
                    this.$store.toast.show(this.id ? 'Produto atualizado!' : 'Produto criado!', 'success');
                    setTimeout(() => window.location.href = '/produtos', 1000);
                } else {
                    if (data.errors) {
                        const errorMsg = Object.values(data.errors).flat().join(', ');
                        this.$store.toast.show(errorMsg, 'error');
                    } else {
                        this.$store.toast.show(data.message || 'Erro ao salvar produto', 'error');
                    }
                    this.$store.loading.hide();
                }
            } catch (e) {
                this.$store.toast.show('Erro ao salvar produto', 'error');
                this.$store.loading.hide();
            }
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Formulário de Produto'; include __DIR__ . '/../layout.php'; ?>
</div>
