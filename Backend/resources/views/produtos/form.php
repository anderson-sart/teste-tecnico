<?php ob_start(); ?>
<div class="container-fluid py-4">
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
                    <form id="form">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Descrição (máx 60) *</label>
                                <input type="text" class="form-control" id="descricao" maxlength="60" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Código de Barras</label>
                                <input type="text" class="form-control" id="codigo_barras" maxlength="14">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Valor de Venda *</label>
                                <input type="number" class="form-control" id="valor_venda" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Peso Bruto (kg) *</label>
                                <input type="number" class="form-control" id="peso_bruto" step="0.001" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Peso Líquido (kg) *</label>
                                <input type="number" class="form-control" id="peso_liquido" step="0.001" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Salvar
                                </button>
                            </div>
                        </div>
                        <div id="message" class="mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
const id = window.location.pathname.split('/').pop();
const isEdit = id !== 'create';

if (isEdit) {
    fetch('/api/produtos/' + id).then(r => r.json()).then(p => {
        document.getElementById('descricao').value = p.descricao;
        document.getElementById('codigo_barras').value = p.codigo_barras || '';
        document.getElementById('valor_venda').value = p.valor_venda;
        document.getElementById('peso_bruto').value = p.peso_bruto;
        document.getElementById('peso_liquido').value = p.peso_liquido;
    });
}

document.getElementById('form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        descricao: document.getElementById('descricao').value,
        codigo_barras: document.getElementById('codigo_barras').value,
        valor_venda: document.getElementById('valor_venda').value,
        peso_bruto: document.getElementById('peso_bruto').value,
        peso_liquido: document.getElementById('peso_liquido').value
    };
    
    const url = isEdit ? '/api/produtos/' + id : '/api/produtos';
    const method = isEdit ? 'PUT' : 'POST';
    
    await fetch(url, {
        method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });
    
    document.getElementById('message').innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>Salvo com sucesso!</div>';
    setTimeout(() => window.location.href = '/produtos', 1500);
});
</script>
<?php $scripts = ob_get_clean(); $title = 'Produto'; include __DIR__ . '/../layout.php'; ?>
