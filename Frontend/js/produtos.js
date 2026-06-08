const API_URL = 'http://localhost:8000/api';

async function loadProdutos() {
    try {
        const response = await fetch(`${API_URL}/produtos`);
        const produtos = await response.json();
        
        const tbody = document.querySelector('#produtosTable tbody');
        tbody.innerHTML = '';
        
        produtos.forEach(produto => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${produto.codigo}</td>
                <td>${produto.descricao}</td>
                <td>${produto.codigo_barras || '-'}</td>
                <td>R$ ${parseFloat(produto.valor_venda).toFixed(2)}</td>
                <td>${parseFloat(produto.peso_bruto).toFixed(3)} kg</td>
                <td>${parseFloat(produto.peso_liquido).toFixed(3)} kg</td>
                <td class="actions">
                    <button class="btn-view" onclick="viewProduto(${produto.codigo})">Ver</button>
                    <button class="btn-edit" onclick="editProduto(${produto.codigo})">Editar</button>
                    <button class="btn-delete" onclick="deleteProduto(${produto.codigo})">Deletar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        alert('Erro ao carregar produtos');
    }
}

async function viewProduto(id) {
    try {
        const response = await fetch(`${API_URL}/produtos/${id}`);
        const produto = await response.json();
        
        const modal = document.getElementById('viewModal');
        const content = document.getElementById('modalContent');
        
        content.innerHTML = `
            <p><strong>Código:</strong> ${produto.codigo}</p>
            <p><strong>Descrição:</strong> ${produto.descricao}</p>
            <p><strong>Código de Barras:</strong> ${produto.codigo_barras || '-'}</p>
            <p><strong>Valor de Venda:</strong> R$ ${parseFloat(produto.valor_venda).toFixed(2)}</p>
            <p><strong>Peso Bruto:</strong> ${parseFloat(produto.peso_bruto).toFixed(3)} kg</p>
            <p><strong>Peso Líquido:</strong> ${parseFloat(produto.peso_liquido).toFixed(3)} kg</p>
        `;
        
        modal.style.display = 'block';
    } catch (error) {
        alert('Erro ao visualizar produto');
    }
}

function editProduto(id) {
    window.location.href = `produto-form.html?id=${id}`;
}

async function deleteProduto(id) {
    if (!confirm('Deseja realmente deletar este produto?')) return;
    
    try {
        await fetch(`${API_URL}/produtos/${id}`, { method: 'DELETE' });
        loadProdutos();
    } catch (error) {
        alert('Erro ao deletar produto');
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

loadProdutos();
