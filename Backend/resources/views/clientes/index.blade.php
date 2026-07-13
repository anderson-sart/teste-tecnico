@extends('layout')

@section('title', 'Clientes')

@section('content')
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="clientesPage()" x-init="init()">
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
                            <a href="/menu" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Voltar</span></a>
                        </div>
                        <div class="col-auto">
                            <a href="/clientes/create" class="btn btn-success"><i class="bi bi-plus-circle"></i> Novo</a>
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
                                    <th style="cursor:pointer" @click="sortBy('codigo')">Código <i class="bi bi-arrow-down-up"></i></th>
                                    <th style="cursor:pointer" @click="sortBy('nome')">Nome <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="d-none d-md-table-cell">Fantasia</th>
                                    <th>Documento</th>
                                    <th class="d-none d-lg-table-cell">Endereço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="c in paginatedData" :key="c.codigo">
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input"
                                                :value="c.codigo" :checked="selected.includes(c.codigo)"
                                                @change="toggleSelect(c.codigo)">
                                        </td>
                                        <td x-text="c.codigo"></td>
                                        <td x-text="c.nome"></td>
                                        <td class="d-none d-md-table-cell" x-text="c.fantasia || '-'"></td>
                                        <td x-text="c.documento"></td>
                                        <td class="d-none d-lg-table-cell" x-text="c.endereco || '-'"></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-info" @click="view(c)" title="Ver"><i class="bi bi-eye"></i></button>
                                                <a :href="`/clientes/edit/${c.codigo}?page=${currentPage}`" class="btn btn-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <button class="btn btn-danger" @click="del(c)" title="Deletar"><i class="bi bi-trash"></i></button>
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
                                <li class="page-item"><a class="page-link" href="#" @click.prevent="currentPage--">Anterior</a></li>
                            </template>
                            <template x-for="page in pageNumbers" :key="page">
                                <li class="page-item" :class="{'active': page === currentPage}">
                                    <a class="page-link" href="#" @click.prevent="currentPage = page" x-text="page"></a>
                                </li>
                            </template>
                            <template x-if="currentPage < totalPages">
                                <li class="page-item"><a class="page-link" href="#" @click.prevent="currentPage++">Próximo</a></li>
                            </template>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" x-data="{ cliente: null }">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detalhes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" x-show="cliente">
                    <div class="col-6"><strong>Código:</strong></div><div class="col-6" x-text="cliente?.codigo"></div>
                    <div class="col-6"><strong>Nome:</strong></div><div class="col-6" x-text="cliente?.nome"></div>
                    <div class="col-6"><strong>Fantasia:</strong></div><div class="col-6" x-text="cliente?.fantasia || '-'"></div>
                    <div class="col-6"><strong>Documento:</strong></div><div class="col-6" x-text="cliente?.documento"></div>
                    <div class="col-6"><strong>Endereço:</strong></div><div class="col-6" x-text="cliente?.endereco || '-'"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
function clientesPage() {
    return {
        data: [], search: '', currentPage: 1, perPage: 10,
        totalPages: 1, total: 0, sortField: 'codigo', sortDir: 'desc', selected: [],
        async init() {
            const page = new URLSearchParams(window.location.search).get('page');
            if (page) this.currentPage = parseInt(page);
            this.$watch('search', () => { this.currentPage = 1; this.load(); });
            this.$watch('currentPage', () => this.load());
            this.$watch('perPage', () => { this.currentPage = 1; this.load(); });
            await this.load();
        },
        async load() {
            this.$store.loading.show();
            try {
                const params = new URLSearchParams({ search: this.search, sort_by: this.sortField, sort_dir: this.sortDir, page: this.currentPage, per_page: this.perPage });
                const res = await fetch('/api/clientes?' + params);
                const result = await res.json();
                this.data = result.data; this.total = result.meta.total;
                this.totalPages = result.meta.last_page; this.currentPage = result.meta.page;
            } catch (e) {
                this.$store.toast.show('Erro ao carregar clientes', 'error');
            } finally { this.$store.loading.hide(); }
        },
        get paginatedData() { return this.data; },
        get pageNumbers() {
            const pages = [];
            for (let i = 1; i <= this.totalPages; i++) {
                if (i === 1 || i === this.totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) pages.push(i);
            }
            return pages;
        },
        sortBy(field) {
            if (this.sortField === field) this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            else { this.sortField = field; this.sortDir = 'asc'; }
            this.currentPage = 1; this.load();
        },
        toggleSelect(id) { const idx = this.selected.indexOf(id); idx === -1 ? this.selected.push(id) : this.selected.splice(idx, 1); },
        toggleAll(checked) { this.selected = checked ? this.paginatedData.map(c => c.codigo) : []; },
        view(c) {
            Alpine.$data(document.querySelector('#viewModal [x-data]')).cliente = c;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        },
        del(c) {
            confirmDelete(`<p>Deseja realmente excluir o cliente?</p><p class="fw-bold mb-0">${c.nome}</p>`, async () => {
                this.$store.loading.show();
                try {
                    await fetch('/api/clientes/' + c.codigo, { method: 'DELETE' });
                    this.$store.toast.show('Cliente excluído com sucesso!', 'success');
                    await this.load();
                } catch (e) { this.$store.toast.show('Erro ao excluir cliente', 'error'); this.$store.loading.hide(); }
            });
        },
        deleteSelected() {
            confirmDelete(`<p>Deseja realmente excluir <strong>${this.selected.length}</strong> cliente(s)?</p>`, async () => {
                this.$store.loading.show();
                try {
                    await Promise.all(this.selected.map(id => fetch('/api/clientes/' + id, { method: 'DELETE' })));
                    this.$store.toast.show(`${this.selected.length} cliente(s) excluído(s)!`, 'success');
                    this.selected = []; await this.load();
                } catch (e) { this.$store.toast.show('Erro ao excluir clientes', 'error'); this.$store.loading.hide(); }
            });
        }
    };
}
</script>
@endsection
