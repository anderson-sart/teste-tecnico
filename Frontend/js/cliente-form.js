const API_URL = 'http://localhost:8000/api';
const urlParams = new URLSearchParams(window.location.search);
const clienteId = urlParams.get('id');

if (clienteId) {
    document.getElementById('formTitle').textContent = 'Editar Cliente';
    loadCliente();
}

const documentoInput = document.getElementById('documento');
documentoInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    }
    
    e.target.value = value;
});

async function loadCliente() {
    try {
        const response = await fetch(`${API_URL}/clientes/${clienteId}`);
        const cliente = await response.json();
        
        document.getElementById('nome').value = cliente.nome;
        document.getElementById('fantasia').value = cliente.fantasia || '';
        document.getElementById('documento').value = cliente.documento;
        document.getElementById('endereco').value = cliente.endereco || '';
    } catch (error) {
        alert('Erro ao carregar cliente');
    }
}

document.getElementById('clienteForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const data = {
        nome: document.getElementById('nome').value,
        fantasia: document.getElementById('fantasia').value,
        documento: document.getElementById('documento').value.replace(/\D/g, ''),
        endereco: document.getElementById('endereco').value
    };
    
    const messageDiv = document.getElementById('message');
    
    try {
        const url = clienteId ? `${API_URL}/clientes/${clienteId}` : `${API_URL}/clientes`;
        const method = clienteId ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            messageDiv.className = 'success';
            messageDiv.textContent = 'Cliente salvo com sucesso!';
            setTimeout(() => window.location.href = 'clientes.html', 1500);
        } else {
            messageDiv.className = 'error';
            messageDiv.textContent = 'Erro ao salvar cliente';
        }
    } catch (error) {
        messageDiv.className = 'error';
        messageDiv.textContent = 'Erro ao conectar com o servidor';
    }
});
