<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="produtosPage()" x-init="init()">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item active">Produtos</li>
        </ol>
    </nav>
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
                        <div class="col-auto" x-show="selected.length > 0" x-transition>
                            <button class="btn btn-danger" @click="deleteSelected()">
                                <i class="bi bi-trash"></i> Excluir (<span x-text="selected.length"></span>)
                            </button>
                        </div>
                        <div class="col-auto">
                            <select class="form-select" x-model="perPage" @change="currentPage=1" style="width:auto">
                                <option value="10">10 por página</option>
                                <option value="25">25 por página</option>
                                <option value="50">50 por página</option>
                                <option value="100">100 por página</option>
                            </select>
                        </div>
                        <div class="col-12 col-md">
                            <input type="text" class="form-control" x-model.debounce.1000ms="search" placeholder="🔍 Pesquisar...">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-secondary" type="button" @click="showFilters = !showFilters">
                                <i class="bi bi-funnel"></i> Filtros
                            </button>
                        </div>
                    </div>
                    
                    <!-- Filtros Avançados -->
                    <div x-show="showFilters" x-collapse class="mt-3">
                        <div class="card card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small">Preço Mínimo</label>
                                    <input type="number" class="form-control form-control-sm" x-model.number="filters.priceMin" step="0.01">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Preço Máximo</label>
                                    <input type="number" class="form-control form-control-sm" x-model.number="filters.priceMax" step="0.01">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">&nbsp;</label>
                                    <button class="btn btn-sm btn-primary w-100" @click="currentPage=1">
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
                                        <input type="checkbox" class="form-check-input" 
                                            :checked="selected.length === paginatedData.length && paginatedData.length > 0"
                                            :indeterminate="selected.length > 0 && selected.length < paginatedData.length"
                                            @change="toggleAll($event.target.checked)">
                                    </th>
                                    <th style="cursor:pointer" @click="sortBy('codigo')">
                                        Código <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th style="cursor:pointer" @click="sortBy('descricao')">
                                        Descrição <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th class="d-none d-md-table-cell">Cód. Barras</th>
                                    <th style="cursor:pointer" @click="sortBy('valor_venda')">
                                        Valor <i class="bi bi-arrow-down-up"></i>
                                    </th>
                                    <th class="d-none d-lg-table-cell">P. Bruto</th>
                                    <th class="d-none d-lg-table-cell">P. Líquido</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="p in paginatedData" :key="p.codigo">
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input" 
                                                :value="p.codigo"
                                                :checked="selected.includes(p.codigo)"
                                                @change="toggleSelect(p.codigo)">
                                        </td>
                                        <td x-text="p.codigo"></td>
                                        <td x-text="p.descricao"></td>
                                        <td class="d-none d-md-table-cell" x-text="p.codigo_barras || '-'"></td>
                                        <td class="text-nowrap" x-text="`R$ ${parseFloat(p.valor_venda).toFixed(2)}`"></td>
                                        <td class="d-none d-lg-table-cell" x-text="`${parseFloat(p.peso_bruto).toFixed(3)} kg`"></td>
                                        <td class="d-none d-lg-table-cell" x-text="`${parseFloat(p.peso_liquido).toFixed(3)} kg`"></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-info" @click="view(p)" title="Ver">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <a :href="`/produtos/edit/${p.codigo}?page=${currentPage}`" class="btn btn-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button class="btn btn-danger" @click="del(p)" title="Deletar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <template x-if="currentPage > 1">
                                <li class="page-item">
                                    <a class="page-link" href="#" @click.prevent="currentPage--">Anterior</a>
                                </li>
                            </template>
                            <template x-for="page in pageNumbers" :key="page">
                                <li class="page-item" :class="{'active': page === currentPage}">
                                    <a class="page-link" href="#" @click.prevent="currentPage = page" x-text="page"></a>
                                </li>
                            </template>
                            <template x-if="currentPage < totalPages">
                                <li class="page-item">
                                    <a class="page-link" href="#" @click.prevent="currentPage++">Próximo</a>
                                </li>
                            </template>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" x-data="{ produto: null }">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detalhes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" x-show="produto">
                    <div class="col-6"><strong>Código:</strong></div><div class="col-6" x-text="produto?.codigo"></div>
                    <div class="col-6"><strong>Descrição:</strong></div><div class="col-6" x-text="produto?.descricao"></div>
                    <div class="col-6"><strong>Cód. Barras:</strong></div><div class="col-6" x-text="produto?.codigo_barras || '-'"></div>
                    <div class="col-6"><strong>Valor:</strong></div><div class="col-6" x-text="produto ? `R$ ${parseFloat(produto.valor_venda).toFixed(2)}` : ''"></div>
                    <div class="col-6"><strong>Peso Bruto:</strong></div><div class="col-6" x-text="produto ? `${parseFloat(produto.peso_bruto).toFixed(3)} kg` : ''"></div>
                    <div class="col-6"><strong>Peso Líquido:</strong></div><div class="col-6" x-text="produto ? `${parseFloat(produto.peso_liquido).toFixed(3)} kg` : ''"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function produtosPage() {
    return {
        data: [],
        search: '',
        currentPage: 1,
        perPage: 10,
        totalPages: 1,
        total: 0,
        sortField: 'codigo',
        sortDir: 'desc',
        selected: [],
        showFilters: false,
        filters: { priceMin: 0, priceMax: 999999 },
        loading: false,
        
        async init() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page');
            if (page) this.currentPage = parseInt(page);
            
            this.$watch('search', () => { this.currentPage = 1; this.load(); });
            this.$watch('currentPage', () => this.load());
            this.$watch('perPage', () => { this.currentPage = 1; this.load(); });
            
            await this.load();
        },
        
        async load() {
            this.$store.loading.show();
            try {
                const params = new URLSearchParams({
                    search: this.search,
                    sort_by: this.sortField,
                    sort_dir: this.sortDir,
                    page: this.currentPage,
                    per_page: this.perPage,
                });
                const res = await fetch('/api/produtos?' + params);
                const result = await res.json();
                this.data = result.data;
                this.total = result.meta.total;
                this.totalPages = result.meta.last_page;
                this.currentPage = result.meta.page;
            } catch (e) {
                this.$store.toast.show('Erro ao carregar produtos', 'error');
            } finally {
                this.$store.loading.hide();
            }
        },
        
        get paginatedData() {
            return this.data;
        },
        
        get pageNumbers() {
            const pages = [];
            for (let i = 1; i <= this.totalPages; i++) {
                if (i === 1 || i === this.totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) {
                    pages.push(i);
                }
            }
            return pages;
        },
        
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDir = 'asc';
            }
            this.currentPage = 1;
            this.load();
        },
        
        toggleSelect(id) {
            const idx = this.selected.indexOf(id);
            idx === -1 ? this.selected.push(id) : this.selected.splice(idx, 1);
        },
        
        toggleAll(checked) {
            this.selected = checked ? this.paginatedData.map(p => p.codigo) : [];
        },
        
        view(p) {
            const modal = document.querySelector('#viewModal [x-data]');
            Alpine.$data(modal).produto = p;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        },
        
        del(p) {
            confirmDelete(
                `<p>Deseja realmente excluir o produto?</p><p class="fw-bold mb-0">${p.descricao}</p>`,
                async () => {
                    this.$store.loading.show();
                    try {
                        await fetch('/api/produtos/' + p.codigo, {method: 'DELETE'});
                        this.$store.toast.show('Produto excluído com sucesso!', 'success');
                        await this.load();
                    } catch (e) {
                        this.$store.toast.show('Erro ao excluir produto', 'error');
                        this.$store.loading.hide();
                    }
                }
            );
        },
        
        deleteSelected() {
            confirmDelete(
                `<p>Deseja realmente excluir <strong>${this.selected.length}</strong> produto(s)?</p>`,
                async () => {
                    this.$store.loading.show();
                    try {
                        await Promise.all(this.selected.map(id => fetch('/api/produtos/' + id, {method: 'DELETE'})));
                        this.$store.toast.show(`${this.selected.length} produto(s) excluído(s)!`, 'success');
                        this.selected = [];
                        await this.load();
                    } catch (e) {
                        this.$store.toast.show('Erro ao excluir produtos', 'error');
                        this.$store.loading.hide();
                    }
                }
            );
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Produtos'; include __DIR__ . '/../layout.php'; ?>
</div>
