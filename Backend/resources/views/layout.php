<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Softline' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-bg { 
            background: var(--primary-gradient); 
            min-height: 100vh; 
            padding: 20px;
        }
        .card { 
            border-radius: 15px; 
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background: var(--primary-gradient) !important;
            padding: 1.5rem;
        }
        .btn { border-radius: 8px; }
        .table-responsive { border-radius: 10px; }
        
        /* Toast Notifications */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .toast { min-width: 300px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .toast-header { font-weight: 600; }
        
        /* Loading Spinner */
        .spinner-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); z-index: 9998; display: none;
            align-items: center; justify-content: center;
        }
        .spinner-overlay.show { display: flex; }
        
        /* Form Validation */
        .form-control.is-valid { border-color: #198754; padding-right: calc(1.5em + 0.75rem); }
        .form-control.is-invalid { border-color: #dc3545; padding-right: calc(1.5em + 0.75rem); }
        .char-counter { font-size: 0.875rem; color: #6c757d; text-align: right; margin-top: 0.25rem; }
        .char-counter.text-danger { color: #dc3545 !important; }
        
        @media (max-width: 768px) {
            .table { font-size: 0.875rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .toast-container { right: 10px; left: 10px; }
            .toast { min-width: auto; }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loadingSpinner">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="confirmMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    
    <?= $content ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        
        // Toast Notification System
        function showToast(message, type = 'success') {
            const icons = { success: 'check-circle', error: 'x-circle', warning: 'exclamation-triangle', info: 'info-circle' };
            const colors = { success: 'success', error: 'danger', warning: 'warning', info: 'info' };
            
            const toastHtml = `
                <div class="toast align-items-center text-bg-${colors[type]} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${icons[type]} me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            const container = document.getElementById('toastContainer');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = toastHtml.trim();
            const toastElement = wrapper.firstChild;
            container.appendChild(toastElement);
            
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();
            
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
        
        // Loading Spinner
        function showLoading() { document.getElementById('loadingSpinner').classList.add('show'); }
        function hideLoading() { document.getElementById('loadingSpinner').classList.remove('show'); }
        
        // Confirmation Modal
        let confirmCallback = null;
        let confirmModalInstance = null;
        
        function confirmDelete(message, callback) {
            document.getElementById('confirmMessage').innerHTML = message;
            confirmCallback = callback;
            const modalEl = document.getElementById('confirmModal');
            confirmModalInstance = new bootstrap.Modal(modalEl);
            confirmModalInstance.show();
        }
        
        const confirmBtn = document.getElementById('confirmDelete');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                this.blur(); // Remove focus antes de fechar
                
                if (confirmCallback) {
                    confirmCallback();
                    confirmCallback = null;
                }
                if (confirmModalInstance) {
                    confirmModalInstance.hide();
                }
            });
        }
        
        // Fix aria-hidden warning
        const confirmModalEl = document.getElementById('confirmModal');
        if (confirmModalEl) {
            confirmModalEl.addEventListener('hidden.bs.modal', function() {
                if (confirmModalInstance) {
                    confirmModalInstance.dispose();
                    confirmModalInstance = null;
                }
            });
        }
        
        // Form Validation with Real-time Feedback
        function setupFormValidation(formId) {
            const form = document.getElementById(formId);
            if (!form) return;
            
            form.querySelectorAll('input, textarea').forEach(input => {
                const maxLength = input.getAttribute('maxlength');
                
                // Add character counter
                if (maxLength && input.type !== 'number') {
                    const counter = document.createElement('div');
                    counter.className = 'char-counter';
                    counter.textContent = `0/${maxLength}`;
                    input.parentElement.appendChild(counter);
                    
                    input.addEventListener('input', function() {
                        const length = this.value.length;
                        counter.textContent = `${length}/${maxLength}`;
                        counter.classList.toggle('text-danger', length >= maxLength * 0.9);
                    });
                }
                
                // Real-time validation
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') || this.value) {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        } else {
                            this.classList.remove('is-valid');
                            this.classList.add('is-invalid');
                        }
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') || this.classList.contains('is-valid')) {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        } else {
                            this.classList.remove('is-valid');
                            this.classList.add('is-invalid');
                        }
                    }
                });
            });
        }
        
        // Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+F - Focus search
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.getElementById('search');
                if (searchInput) searchInput.focus();
            }
            
            // Ctrl+N - New record
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                const newBtn = document.querySelector('a[href*="/create"]');
                if (newBtn) window.location.href = newBtn.href;
            }
            
            // ESC - Close modals
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    bootstrap.Modal.getInstance(modal)?.hide();
                });
            }
            
            // Ctrl+S - Save form
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                const form = document.querySelector('form');
                if (form) form.requestSubmit();
            }
        });
    </script>
    <?= $scripts ?? '' ?>
</body>
</html>
