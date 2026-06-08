<?php ob_start(); ?>
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>
    </nav>
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
                        <div class="col-auto">
                            <button class="btn btn-danger" id="btnDeleteSelected" style="display:none">
                                <i class="bi bi-trash"></i> Excluir Selecionados (<span id="selectedCount">0</span>)
                            </button>
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="perPageSelect" style="width:auto">
                                <option value="10">10 por página</option>
                                <option value="25">25 por página</option>
                                <option value="50">50 por página</option>
                                <option value="100">100 por página</option>
                            </select>
                        </div>
                        <div class="col-12 col-md">
                            <input type="text" class="form-control" id="search" placeholder="🔍 Pesquisar...">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                                <i class="bi bi-funnel"></i> Filtros
                            </button>
                        </div>
                    </div>
                    
                    <!-- Filtros Avançados -->
                    <div class="collapse mt-3" id="advancedFilters">
                        <div class="card card-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small">Tipo de Documento</label>
                                    <select class="form-select form-select-sm" id="docType">
                                        <option value="">Todos</option>
                                        <option value="cpf">CPF</option>
                                        <option value="cnpj">CNPJ</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">&nbsp;</label>
                                    <button class="btn btn-sm btn-primary w-100" onclick="applyFilters()">
                                        <i class="bi bi-check2"></i> Aplicar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:40px">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th style="cursor:pointer" onclick="sortBy('codigo')">
                                        Código <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th style="cursor:pointer" onclick="sortBy('nome')">
                                        Nome <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th class="d-none d-md-table-cell">Fantasia</th>
                                    <th>Documento</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
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
let currentPage = 1;
let perPage = 10;
let allClientes = [];
let filteredClientes = [];
let sortField = 'codigo';
let sortDir = 'desc';

function formatDoc(doc) {
    const n = doc.replace(/\D/g, '');
    return n.length === 11 ? n.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') :
           n.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
}

async function loadClientes(keepPage = false) {
    showLoading();
    try {
        const response = await fetch('/api/clientes');
        allClientes = await response.json();
        filteredClientes = allClientes;
        
        if (keepPage) {
            const totalPages = Math.ceil(filteredClientes.length / perPage);
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            }
            renderPage(currentPage);
        } else {
            renderPage(1);
        }
    } catch (error) {
        showToast('Erro ao carregar clientes', 'error');
    } finally {
        hideLoading();
    }
}

function sortBy(field) {
    if (sortField === field) {
        sortDir = sortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sortField = field;
        sortDir = 'asc';
    }
    
    filteredClientes.sort((a, b) => {
        let aVal = a[field];
        let bVal = b[field];
        
        if (typeof aVal === 'string') {
            aVal = aVal.toLowerCase();
            bVal = bVal.toLowerCase();
        }
        
        if (sortDir === 'asc') {
            return aVal > bVal ? 1 : -1;
        } else {
            return aVal < bVal ? 1 : -1;
        }
    });
    
    renderPage(1);
}

document.getElementById('search').addEventListener('input', function(e) {
    applyFilters();
});

function applyFilters() {
    const searchTerm = document.getElementById('search').value.trim().toLowerCase();
    const docType = document.getElementById('docType').value;
    
    filteredClientes = allClientes.filter(c => {
        const matchSearch = !searchTerm || 
            c.nome.toLowerCase().includes(searchTerm) ||
            c.codigo.toString().includes(searchTerm) ||
            (c.fantasia && c.fantasia.toLowerCase().includes(searchTerm)) ||
            c.documento.includes(searchTerm);
        
        let matchDocType = true;
        if (docType === 'cpf') {
            matchDocType = c.documento.replace(/\D/g, '').length === 11;
        } else if (docType === 'cnpj') {
            matchDocType = c.documento.replace(/\D/g, '').length === 14;
        }
        
        return matchSearch && matchDocType;
    });
    
    renderPage(1);
}
});

document.getElementById('perPageSelect').addEventListener('change', function() {
    perPage = parseInt(this.value);
    currentPage = 1;
    renderPage(1);
});

function renderPage(page) {
    currentPage = page;
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const clientes = filteredClientes.slice(start, end);
    
    const tbody = document.getElementById('tbody');
    tbody.innerHTML = clientes.map(c => `
        <tr>
            <td>
                <input type="checkbox" class="form-check-input row-checkbox" value="${c.codigo}" onchange="updateSelection()">
            </td>
            <td>${c.codigo}</td>
            <td>${c.nome}</td>
            <td class="d-none d-md-table-cell">${c.fantasia || '-'}</td>
            <td class="text-nowrap">${formatDoc(c.documento)}</td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-info" onclick="view(${c.codigo})" title="Ver">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="/clientes/edit/${c.codigo}?page=${currentPage}" class="btn btn-warning" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-danger" onclick="del(${c.codigo})" title="Deletar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredClientes.length / perPage);
    const pagination = document.getElementById('pagination');
    
    let html = '';
    if (currentPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="renderPage(${currentPage - 1}); return false;">Anterior</a></li>`;
    }
    
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="renderPage(${i}); return false;">${i}</a>
            </li>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    if (currentPage < totalPages) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="renderPage(${currentPage + 1}); return false;">Próximo</a></li>`;
    }
    
    pagination.innerHTML = html;
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
    const cliente = allClientes.find(c => c.codigo == id);
    const message = `<p>Deseja realmente excluir o cliente?</p><p class="fw-bold mb-0">${cliente ? cliente.nome : 'Cliente #' + id}</p>`;
    
    confirmDelete(message, async () => {
        showLoading();
        try {
            await fetch('/api/clientes/' + id, {method: 'DELETE'});
            showToast('Cliente excluído com sucesso!', 'success');
            loadClientes(true);
        } catch (error) {
            showToast('Erro ao excluir cliente', 'error');
            hideLoading();
        }
    });
}

// Seleção múltipla
function updateSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkboxes.length;
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('btnDeleteSelected').style.display = count > 0 ? 'block' : 'none';
    
    const total = document.querySelectorAll('.row-checkbox').length;
    document.getElementById('selectAll').checked = count === total && total > 0;
    document.getElementById('selectAll').indeterminate = count > 0 && count < total;
}

document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.checked = this.checked;
    });
    updateSelection();
});

document.getElementById('btnDeleteSelected').addEventListener('click', async function() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    const count = ids.length;
    
    const message = `<p>Deseja realmente excluir <strong>${count}</strong> cliente(s) selecionado(s)?</p>`;
    
    confirmDelete(message, async () => {
        showLoading();
        try {
            await Promise.all(ids.map(id => fetch('/api/clientes/' + id, {method: 'DELETE'})));
            showToast(`${count} cliente(s) excluído(s) com sucesso!`, 'success');
            document.getElementById('selectAll').checked = false;
            document.getElementById('btnDeleteSelected').style.display = 'none';
            document.getElementById('selectedCount').textContent = '0';
            loadClientes(true);
        } catch (error) {
            showToast('Erro ao excluir clientes', 'error');
            hideLoading();
        }
    });
});

// Restaura página da URL
const urlParams = new URLSearchParams(window.location.search);
const pageParam = urlParams.get('page');
if (pageParam) {
    currentPage = parseInt(pageParam);
}

loadClientes();
</script>
<?php $scripts = ob_get_clean(); $title = 'Clientes'; include __DIR__ . '/../layout.php'; ?>
