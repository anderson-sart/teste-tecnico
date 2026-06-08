<?php ob_start(); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produtos</h3>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-3">
                        <div class="col-auto">
                            <a href="/menu" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Voltar</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/produtos/create" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Novo
                            </a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-danger" id="btnDeleteSelected" style="display:none">
                                <i class="bi bi-trash"></i> Excluir Selecionados (<span id="selectedCount">0</span>)
                            </button>
                        </div>
                        <div class="col-12 col-md">
                            <input type="text" class="form-control" id="search" placeholder="🔍 Pesquisar...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:40px">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th style="cursor:pointer" onclick="sortBy('codigo')">
                                        Código <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th style="cursor:pointer" onclick="sortBy('descricao')">
                                        Descrição <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th class="d-none d-md-table-cell">Cód. Barras</th>
                                    <th style="cursor:pointer" onclick="sortBy('valor_venda')">
                                        Valor <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th class="d-none d-lg-table-cell">P. Bruto</th>
                                    <th class="d-none d-lg-table-cell">P. Líquido</th>
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
const perPage = 10;
let allProdutos = [];
let filteredProdutos = [];
let sortField = 'codigo';
let sortDir = 'desc';

async function loadProdutos(keepPage = false) {
    showLoading();
    try {
        const response = await fetch('/api/produtos');
        allProdutos = await response.json();
        filteredProdutos = allProdutos;
        
        if (keepPage) {
            // Verifica se a página atual ainda tem dados
            const totalPages = Math.ceil(filteredProdutos.length / perPage);
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages; // Vai para última página se atual ficou vazia
            }
            renderPage(currentPage);
        } else {
            renderPage(1);
        }
    } catch (error) {
        showToast('Erro ao carregar produtos', 'error');
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
    
    filteredProdutos.sort((a, b) => {
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
    const term = e.target.value.trim().toLowerCase();
    filteredProdutos = allProdutos.filter(p => 
        p.descricao.toLowerCase().includes(term) ||
        p.codigo.toString().includes(term) ||
        (p.codigo_barras && p.codigo_barras.includes(term))
    );
    renderPage(1);
});

function renderPage(page) {
    currentPage = page;
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const produtos = filteredProdutos.slice(start, end);
    
    const tbody = document.getElementById('tbody');
    tbody.innerHTML = produtos.map(p => `
        <tr>
            <td>
                <input type="checkbox" class="form-check-input row-checkbox" value="${p.codigo}" onchange="updateSelection()">
            </td>
            <td>${p.codigo}</td>
            <td>${p.descricao}</td>
            <td class="d-none d-md-table-cell">${p.codigo_barras || '-'}</td>
            <td class="text-nowrap">R$ ${parseFloat(p.valor_venda).toFixed(2)}</td>
            <td class="d-none d-lg-table-cell">${parseFloat(p.peso_bruto).toFixed(3)} kg</td>
            <td class="d-none d-lg-table-cell">${parseFloat(p.peso_liquido).toFixed(3)} kg</td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-info" onclick="view(${p.codigo})" title="Ver">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="/produtos/edit/${p.codigo}?page=${currentPage}" class="btn btn-warning" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-danger" onclick="del(${p.codigo})" title="Deletar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredProdutos.length / perPage);
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
    const response = await fetch('/api/produtos/' + id);
    const p = await response.json();
    document.getElementById('modalContent').innerHTML = `
        <div class="row g-3">
            <div class="col-6"><strong>Código:</strong></div><div class="col-6">${p.codigo}</div>
            <div class="col-6"><strong>Descrição:</strong></div><div class="col-6">${p.descricao}</div>
            <div class="col-6"><strong>Cód. Barras:</strong></div><div class="col-6">${p.codigo_barras || '-'}</div>
            <div class="col-6"><strong>Valor:</strong></div><div class="col-6">R$ ${parseFloat(p.valor_venda).toFixed(2)}</div>
            <div class="col-6"><strong>Peso Bruto:</strong></div><div class="col-6">${parseFloat(p.peso_bruto).toFixed(3)} kg</div>
            <div class="col-6"><strong>Peso Líquido:</strong></div><div class="col-6">${parseFloat(p.peso_liquido).toFixed(3)} kg</div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

async function del(id) {
    const produto = allProdutos.find(p => p.codigo == id);
    const message = `<p>Deseja realmente excluir o produto?</p><p class="fw-bold mb-0">${produto ? produto.descricao : 'Produto #' + id}</p>`;
    
    confirmDelete(message, async () => {
        showLoading();
        try {
            await fetch('/api/produtos/' + id, {method: 'DELETE'});
            showToast('Produto excluído com sucesso!', 'success');
            loadProdutos(true); // Mantém a página atual
        } catch (error) {
            showToast('Erro ao excluir produto', 'error');
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
    
    const message = `<p>Deseja realmente excluir <strong>${count}</strong> produto(s) selecionado(s)?</p>`;
    
    confirmDelete(message, async () => {
        showLoading();
        try {
            await Promise.all(ids.map(id => fetch('/api/produtos/' + id, {method: 'DELETE'})));
            showToast(`${count} produto(s) excluído(s) com sucesso!`, 'success');
            document.getElementById('selectAll').checked = false;
            document.getElementById('btnDeleteSelected').style.display = 'none';
            document.getElementById('selectedCount').textContent = '0';
            loadProdutos(true);
        } catch (error) {
            showToast('Erro ao excluir produtos', 'error');
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

loadProdutos();
</script>
<?php $scripts = ob_get_clean(); $title = 'Produtos'; include __DIR__ . '/../layout.php'; ?>
