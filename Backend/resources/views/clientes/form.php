<?php ob_start(); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h3 class="mb-0"><i class="bi bi-people me-2"></i>Formulário de Cliente</h3>
                </div>
                <div class="card-body p-4">
                    <a href="/clientes" class="btn btn-outline-secondary mb-4">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <form id="form">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nome (máx 60) *</label>
                                <input type="text" class="form-control" id="nome" maxlength="60" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nome Fantasia (máx 100)</label>
                                <input type="text" class="form-control" id="fantasia" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Documento (CPF ou CNPJ) *</label>
                                <input type="text" class="form-control" id="documento" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Endereço</label>
                                <textarea class="form-control" id="endereco" rows="3"></textarea>
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

document.getElementById('documento').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length <= 11) {
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        v = v.replace(/^(\d{2})(\d)/, '$1.$2');
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
        v = v.replace(/(\d{4})(\d)/, '$1-$2');
    }
    e.target.value = v;
});

if (isEdit) {
    fetch('/api/clientes/' + id).then(r => r.json()).then(c => {
        document.getElementById('nome').value = c.nome;
        document.getElementById('fantasia').value = c.fantasia || '';
        document.getElementById('documento').value = c.documento;
        document.getElementById('endereco').value = c.endereco || '';
    });
}

document.getElementById('form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        nome: document.getElementById('nome').value,
        fantasia: document.getElementById('fantasia').value,
        documento: document.getElementById('documento').value.replace(/\D/g, ''),
        endereco: document.getElementById('endereco').value
    };
    
    const url = isEdit ? '/api/clientes/' + id : '/api/clientes';
    const method = isEdit ? 'PUT' : 'POST';
    
    await fetch(url, {
        method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });
    
    document.getElementById('message').innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>Salvo com sucesso!</div>';
    setTimeout(() => window.location.href = '/clientes', 1500);
});
</script>
<?php $scripts = ob_get_clean(); $title = 'Cliente'; include __DIR__ . '/../layout.php'; ?>
