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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Cadastrado em</th>
                            <th width="100">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="user in users" :key="user.id">
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
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ob_start(); ?>
<script>
function usuariosPage() {
    return {
        users: [],
        currentUserId: <?= $_SESSION['user_id'] ?? 0 ?>,
        
        async init() {
            await this.load();
        },
        
        async load() {
            this.$store.loading.show();
            try {
                const res = await fetch('/api/users');
                this.users = await res.json();
            } catch (e) {
                this.$store.toast.show('Erro ao carregar usuários', 'error');
            } finally {
                this.$store.loading.hide();
            }
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
