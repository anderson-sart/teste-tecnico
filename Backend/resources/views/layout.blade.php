<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root { --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        body { padding-top: 76px; }
        .navbar-brand { font-size: 1.5rem; font-weight: bold; }
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.1); background-color: white !important; }
        .text-gradient { background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .gradient-bg { background: var(--primary-gradient); min-height: calc(100vh - 76px); padding: 20px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .card-header { border-radius: 15px 15px 0 0 !important; background: linear-gradient(135deg, #8b9cee 0%, #9b7bc2 100%) !important; padding: 1.5rem; }
        .btn { border-radius: 8px; }
        .breadcrumb { background-color: rgba(255,255,255,0.15) !important; backdrop-filter: blur(10px); border-radius: 10px; padding: 12px 20px; }
        .breadcrumb-item a { color: white; text-decoration: none; }
        .breadcrumb-item a:hover { color: #f8f9fa; }
        .breadcrumb-item.active { color: rgba(255,255,255,0.8); }
        .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.6); }
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .toast { min-width: 300px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .spinner-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; display: none; align-items: center; justify-content: center; }
        .spinner-overlay.show { display: flex; }
        @media (max-width: 768px) { .table { font-size: 0.875rem; } .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; } .toast-container { right: 10px; left: 10px; } .toast { min-width: auto; } }
    </style>
</head>
<body>
    @php $authUser = \App\Http\JWT::getUser(); @endphp
    @if($authUser)
    <nav class="navbar navbar-expand-lg fixed-top" data-bs-theme="light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/menu">
                <i class="bi bi-building text-primary me-2" style="font-size: 1.8rem;"></i>
                <span class="text-gradient">Sistema</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="/menu"><i class="bi bi-house-door me-1"></i>Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="/produtos"><i class="bi bi-box-seam me-1"></i>Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/clientes"><i class="bi bi-people me-1"></i>Clientes</a></li>
                    @if(!empty($authUser['is_admin']))
                    <li class="nav-item"><a class="nav-link" href="/usuarios"><i class="bi bi-person-gear me-1"></i>Usuários</a></li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ $authUser['username'] ?? 'Usuário' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/change-password"><i class="bi bi-shield-lock me-2"></i>Trocar Senha</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="localStorage.removeItem('auth_token');window.location.href='/logout';"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <div class="toast-container" id="toastContainer"></div>

    <div class="spinner-overlay" id="loadingSpinner" x-data x-show="$store.loading.visible" style="display: none;">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"></div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" x-data="confirmModal()">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" x-html="message"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" @click="confirm()">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            const token = localStorage.getItem('auth_token');
            if (token) {
                options.headers = options.headers || {};
                options.headers['Authorization'] = 'Bearer ' + token;
            }
            return originalFetch(url, options).then(response => {
                if (response.status === 401 && !url.includes('/api/login')) {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/';
                }
                return response;
            });
        };
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                show(message, type = 'success') {
                    const icons = { success: 'check-circle', error: 'x-circle', warning: 'exclamation-triangle', info: 'info-circle' };
                    const colors = { success: 'success', error: 'danger', warning: 'warning', info: 'info' };
                    const toastHtml = `<div class="toast align-items-center text-bg-${colors[type]} border-0" role="alert"><div class="d-flex"><div class="toast-body"><i class="bi bi-${icons[type]} me-2"></i>${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
                    const container = document.getElementById('toastContainer');
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = toastHtml.trim();
                    const toastElement = wrapper.firstChild;
                    container.appendChild(toastElement);
                    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
                    toast.show();
                    toastElement.addEventListener('hidden.bs.toast', () => toastElement.remove());
                }
            });
            Alpine.store('loading', {
                visible: false,
                show() { this.visible = true; },
                hide() { this.visible = false; }
            });
        });
        function confirmModal() {
            return {
                message: '', callback: null, modal: null,
                init() {
                    this.modal = new bootstrap.Modal(this.$el);
                    window.confirmDelete = (msg, cb) => { this.message = msg; this.callback = cb; this.modal.show(); };
                },
                confirm() { if (this.callback) this.callback(); this.modal.hide(); this.callback = null; }
            };
        }
    </script>
    @yield('scripts')
</body>
</html>
