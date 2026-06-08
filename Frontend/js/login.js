const API_URL = 'http://localhost:8000/api';

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('error-message');
    
    try {
        const response = await fetch(`${API_URL}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            localStorage.setItem('username', data.username);
            window.location.href = 'menu.html';
        } else {
            errorDiv.textContent = data.message;
        }
    } catch (error) {
        errorDiv.textContent = 'Erro ao conectar com o servidor';
    }
});
