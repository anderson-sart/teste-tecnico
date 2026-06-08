const API_URL = 'http://localhost:8000/api';

async function loadClientes() {
    try {
        const response = await fetch(`${API_URL}/clientes`);
        const clientes = await response.json();
        
        const tbody = document.querySelector('#clientesTable tbody');
        tbody.innerHTML = '';
        
        clientes.forEach(cliente => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${cliente.codigo}</td>
                <td>${cliente.nome}</td>
                <td>${cliente.fantasia || '-'}</td>
                <td>${formatDocument(cliente.documento)}</td>
                <td class="actions">
                    <button class="btn-view" onclick="viewCliente(${cliente.codigo})">Ver</button>
                    <button class="btn-edit" onclick="editCliente(${cliente.codigo})">Editar</button>
                    <button class="btn-delete" onclick="deleteCliente(${cliente.codigo})">Deletar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        alert('Erro ao carregar clientes');
    }
}

function formatDocument(doc) {
    const numbers = doc.replace(/\D/g, '');
    if (numbers.length === 11) {
        return numbers.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (numbers.length === 14) {
        return numbers.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }
    return doc;
}

async function viewCliente(id) {
    try {
        const response = await fetch(`${API_URL}/clientes/${id}`);
        const cliente = await response.json();
        
        const modal = document.getElementById('viewModal');
        const content = document.getElementById('modalContent');
        
        content.innerHTML = `
            <p><strong>Código:</strong> ${cliente.codigo}</p>
            <p><strong>Nome:</strong> ${cliente.nome}</p>
            <p><strong>Nome Fantasia:</strong> ${cliente.fantasia || '-'}</p>
            <p><strong>Documento:</strong> ${formatDocument(cliente.documento)}</p>
            <p><strong>Endereço:</strong> ${cliente.endereco || '-'}</p>
        `;
        
        modal.style.display = 'block';
    } catch (error) {
        alert('Erro ao visualizar cliente');
    }
}

function editCliente(id) {
    window.location.href = `cliente-form.html?id=${id}`;
}

async function deleteCliente(id) {
    if (!confirm('Deseja realmente deletar este cliente?')) return;
    
    try {
        await fetch(`${API_URL}/clientes/${id}`, { method: 'DELETE' });
        loadClientes();
    } catch (error) {
        alert('Erro ao deletar cliente');
    }
}

document.querySelector('.close').onclick = function() {
    document.getElementById('viewModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('viewModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

loadClientes();
