const API_URL = 'http://localhost:8000/api';
const urlParams = new URLSearchParams(window.location.search);
const produtoId = urlParams.get('id');

if (produtoId) {
    document.getElementById('formTitle').textContent = 'Editar Produto';
    loadProduto();
}

async function loadProduto() {
    try {
        const response = await fetch(`${API_URL}/produtos/${produtoId}`);
        const produto = await response.json();
        
        document.getElementById('descricao').value = produto.descricao;
        document.getElementById('codigo_barras').value = produto.codigo_barras || '';
        document.getElementById('valor_venda').value = produto.valor_venda;
        document.getElementById('peso_bruto').value = produto.peso_bruto;
        document.getElementById('peso_liquido').value = produto.peso_liquido;
    } catch (error) {
        alert('Erro ao carregar produto');
    }
}

document.getElementById('produtoForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const data = {
        descricao: document.getElementById('descricao').value,
        codigo_barras: document.getElementById('codigo_barras').value,
        valor_venda: document.getElementById('valor_venda').value,
        peso_bruto: document.getElementById('peso_bruto').value,
        peso_liquido: document.getElementById('peso_liquido').value
    };
    
    const messageDiv = document.getElementById('message');
    
    try {
        const url = produtoId ? `${API_URL}/produtos/${produtoId}` : `${API_URL}/produtos`;
        const method = produtoId ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            messageDiv.className = 'success';
            messageDiv.textContent = 'Produto salvo com sucesso!';
            setTimeout(() => window.location.href = 'produtos.html', 1500);
        } else {
            messageDiv.className = 'error';
            messageDiv.textContent = 'Erro ao salvar produto';
        }
    } catch (error) {
        messageDiv.className = 'error';
        messageDiv.textContent = 'Erro ao conectar com o servidor';
    }
});
