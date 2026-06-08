<?php ob_start(); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-people me-2"></i>Clientes</h3>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-3">
                        <div class="col-auto">
                            <a href="/menu" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Voltar</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/clientes/create" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Novo
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th class="d-none d-md-table-cell">Fantasia</th>
                                    <th>Documento</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detalhes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function formatDoc(doc) {
    const n = doc.replace(/\D/g, '');
    return n.length === 11 ? n.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') :
           n.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
}

async function loadClientes() {
    const response = await fetch('/api/clientes');
    const clientes = await response.json();
    const tbody = document.getElementById('tbody');
    tbody.innerHTML = clientes.map(c => `
        <tr>
            <td>${c.codigo}</td>
            <td>${c.nome}</td>
            <td class="d-none d-md-table-cell">${c.fantasia || '-'}</td>
            <td class="text-nowrap">${formatDoc(c.documento)}</td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-info" onclick="view(${c.codigo})" title="Ver">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="/clientes/edit/${c.codigo}" class="btn btn-warning" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-danger" onclick="del(${c.codigo})" title="Deletar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

async function view(id) {
    const response = await fetch('/api/clientes/' + id);
    const c = await response.json();
    document.getElementById('modalContent').innerHTML = `
        <div class="row g-3">
            <div class="col-5"><strong>Código:</strong></div><div class="col-7">${c.codigo}</div>
            <div class="col-5"><strong>Nome:</strong></div><div class="col-7">${c.nome}</div>
            <div class="col-5"><strong>Fantasia:</strong></div><div class="col-7">${c.fantasia || '-'}</div>
            <div class="col-5"><strong>Documento:</strong></div><div class="col-7">${formatDoc(c.documento)}</div>
            <div class="col-5"><strong>Endereço:</strong></div><div class="col-7">${c.endereco || '-'}</div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

async function del(id) {
    if (!confirm('Deletar cliente?')) return;
    await fetch('/api/clientes/' + id, {method: 'DELETE'});
    loadClientes();
}

loadClientes();
</script>
<?php $scripts = ob_get_clean(); $title = 'Clientes'; include __DIR__ . '/../layout.php'; ?>
