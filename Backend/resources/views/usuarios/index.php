<?php ob_start(); ?>
<div class="gradient-bg" style="min-height: calc(100vh - 76px); padding: 40px 20px;">
<div class="container-fluid" x-data="usuariosPage()" x-init="init()">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/menu"><i class="bi bi-house-door"></i> Início</a></li>
            <li class="breadcrumb-item active">Usuários</li>
        </ol>
    </nav>
    <div class="card shadow">
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-people me-2"></i>Usuários</h3>
            <a href="/usuarios/create" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Novo Usuário
            </a>
        </div>
        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-auto">
                    <a href="/menu" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Voltar</span>
                    </a>
                </div>
                <div class="col-12 col-md">
                    <input type="text" class="form-control" x-model.debounce.300ms="search" placeholder="🔍 Pesquisar...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="cursor:pointer" @click="sortBy('id')">ID <i class="bi bi-arrow-down-up"></i></th>
                            <th style="cursor:pointer" @click="sortBy('username')">Usuário <i class="bi bi-arrow-down-up"></i></th>
                            <th>Cadastrado em</th>
                            <th width="100">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="user in data" :key="user.id">
                            <tr>
                                <td x-text="user.id"></td>
                                <td><i class="bi bi-person-circle me-2"></i><span x-text="user.username"></span></td>
                                <td x-text="user.created_at ? new Date(user.created_at).toLocaleString('pt-BR') : '-'"></td>
                                <td>
                                    <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger" :disabled="user.id == currentUserId">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
<?php $content = ob_get_clean(); ob_start(); $authUser = JWT::getUser(); ?>
<script>
function usuariosPage() {
    return {
        data: [],
        search: '',
        currentPage: 1,
        perPage: 10,
        totalPages: 1,
        total: 0,
        sortField: 'id',
        sortDir: 'desc',
        currentUserId: <?= $authUser['id'] ?? 0 ?>,
        
        async init() {
            this.$watch('search', () => { this.currentPage = 1; this.load(); });
            this.$watch('currentPage', () => this.load());
            
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
                const res = await fetch('/api/users?' + params);
                const result = await res.json();
                this.data = result.data;
                this.total = result.meta.total;
                this.totalPages = result.meta.last_page;
                this.currentPage = result.meta.page;
            } catch (e) {
                this.$store.toast.show('Erro ao carregar usuários', 'error');
            } finally {
                this.$store.loading.hide();
            }
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
        
        deleteUser(id) {
            if (id == this.currentUserId) {
                this.$store.toast.show('Você não pode excluir seu próprio usuário', 'error');
                return;
            }
            
            window.confirmDelete(
                `Tem certeza que deseja excluir este usuário?`,
                async () => {
                    this.$store.loading.show();
                    try {
                        const res = await fetch('/api/users/' + id, { method: 'DELETE' });
                        const data = await res.json();
                        
                        if (res.ok) {
                            this.$store.toast.show('Usuário excluído!', 'success');
                            await this.load();
                        } else {
                            this.$store.toast.show(data.message || 'Erro ao excluir', 'error');
                        }
                    } catch (e) {
                        this.$store.toast.show('Erro ao excluir usuário', 'error');
                    } finally {
                        this.$store.loading.hide();
                    }
                }
            );
        }
    };
}
</script>
<?php $scripts = ob_get_clean(); $title = 'Usuários'; include __DIR__ . '/../layout.php'; ?>
</div>
