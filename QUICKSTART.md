# 🚀 Quick Start - Teste Técnico Softline

## ⚡ Início Rápido (3 passos)

```bash
# 1. Clone o repositório
git clone git@github.com:anderson-sart/teste-tecnico.git
cd teste-tecnico

# 2. Inicie com Docker
docker-compose up -d

# 3. Acesse o sistema
# Frontend: http://localhost:3000
# Usuário: admin | Senha: admin123
```

## 🌐 URLs de Acesso

| Serviço | URL | Porta |
|---------|-----|-------|
| **Frontend** | http://localhost:3000 | 3000 |
| **Backend API** | http://localhost:8000/api | 8000 |
| **PostgreSQL** | localhost:5432 | 5432 |

## 🔐 Credenciais

### Sistema Web
```
Usuário: admin
Senha: admin123
```

### Banco de Dados PostgreSQL
```
Host: localhost (ou 'db' dentro do Docker)
Port: 5432
Database: softline_db
Username: softline_user
Password: softline_pass
```

## 📋 Checklist de Teste

### Login ✅
- [ ] Acessar http://localhost:3000
- [ ] Fazer login com admin/admin123
- [ ] Verificar redirecionamento para menu

### Produtos ✅
- [ ] Clicar em "Produtos"
- [ ] Ver lista de produtos (3 exemplos)
- [ ] Clicar em "Ver" para visualizar detalhes
- [ ] Clicar em "Novo Produto"
- [ ] Preencher formulário e salvar
- [ ] Editar um produto existente
- [ ] Deletar um produto

### Clientes ✅
- [ ] Voltar ao menu e clicar em "Clientes"
- [ ] Ver lista de clientes (2 exemplos)
- [ ] Clicar em "Ver" para visualizar detalhes
- [ ] Clicar em "Novo Cliente"
- [ ] Digitar CPF (11 dígitos) e ver máscara aplicada
- [ ] Digitar CNPJ (14 dígitos) e ver máscara aplicada
- [ ] Salvar cliente
- [ ] Editar um cliente existente
- [ ] Deletar um cliente

## 🧪 Testes da API (com curl)

### Autenticação
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"admin123"}'
```

### Listar Produtos
```bash
curl http://localhost:8000/api/produtos
```

### Criar Produto
```bash
curl -X POST http://localhost:8000/api/produtos \
  -H "Content-Type: application/json" \
  -d '{
    "descricao": "Mouse Gamer",
    "codigo_barras": "7891234567893",
    "valor_venda": 150.00,
    "peso_bruto": 0.200,
    "peso_liquido": 0.150
  }'
```

### Listar Clientes
```bash
curl http://localhost:8000/api/clientes
```

### Criar Cliente
```bash
curl -X POST http://localhost:8000/api/clientes \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Pedro Alves",
    "fantasia": "PA Comercio",
    "documento": "98765432100",
    "endereco": "Rua Exemplo, 456 - Rio de Janeiro/RJ"
  }'
```

## 🐳 Comandos Docker Úteis

```bash
# Ver logs em tempo real
docker-compose logs -f

# Ver logs apenas do backend
docker-compose logs -f backend

# Parar os containers
docker-compose down

# Reiniciar tudo (limpa o banco)
docker-compose down -v
docker-compose up -d

# Acessar o container do backend
docker exec -it softline_backend bash

# Acessar o PostgreSQL
docker exec -it softline_postgres psql -U softline_user -d softline_db
```

## 📊 Dados de Exemplo Pré-cadastrados

### Produtos
1. Notebook Dell Inspiron - R$ 3.500,00
2. Mouse Logitech MX Master - R$ 350,00
3. Teclado Mecânico RGB - R$ 450,00

### Clientes
1. João Silva Santos (CPF)
2. Maria Oliveira Ltda (CNPJ)

## ⚠️ Troubleshooting

### Porta já em uso
```bash
# Se a porta 3000, 8000 ou 5432 já estiver em uso, edite docker-compose.yml
# Exemplo: mudar "3000:80" para "3001:80"
```

### Backend não sobe
```bash
# Verificar logs
docker-compose logs backend

# Recriar container
docker-compose up -d --build backend
```

### Erro de permissão no Laravel
```bash
docker exec -it softline_backend chmod -R 777 storage bootstrap/cache
```

### Banco de dados vazio
```bash
# Rodar migrations e seeders manualmente
docker exec -it softline_backend php artisan migrate:fresh --seed
```

## 📱 Responsividade

O sistema é responsivo e funciona em:
- Desktop (1920x1080, 1366x768)
- Tablet (768x1024)
- Mobile (375x667)

## 🎯 Estrutura de Rotas

### Frontend
- `/` ou `/index.html` - Login
- `/menu.html` - Menu principal
- `/produtos.html` - Lista de produtos
- `/produto-form.html` - Formulário de produto
- `/clientes.html` - Lista de clientes
- `/cliente-form.html` - Formulário de cliente

### Backend API
- `POST /api/login` - Autenticação
- `GET /api/produtos` - Lista produtos
- `GET /api/produtos/{id}` - Busca produto
- `POST /api/produtos` - Cria produto
- `PUT /api/produtos/{id}` - Atualiza produto
- `DELETE /api/produtos/{id}` - Deleta produto
- `GET /api/clientes` - Lista clientes
- `GET /api/clientes/{id}` - Busca cliente
- `POST /api/clientes` - Cria cliente
- `PUT /api/clientes/{id}` - Atualiza cliente
- `DELETE /api/clientes/{id}` - Deleta cliente

## 📧 Contato

**Desenvolvedor**: Anderson Sartori  
**Repositório**: https://github.com/anderson-sart/teste-tecnico  
**Data**: 08/06/2026

---

**Boa sorte na avaliação! 🚀**
