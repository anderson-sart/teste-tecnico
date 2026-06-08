# Resumo do Projeto - Teste Técnico Softline

## ✅ Status: Implementado

Projeto completo de sistema de cadastro de Produtos e Clientes usando Laravel + PostgreSQL + Docker.

## 🎯 Requisitos Atendidos

### Páginas (5/5)
- ✅ Login com validação
- ✅ Lista de Produtos
- ✅ Cadastro de Produtos
- ✅ Lista de Clientes
- ✅ Cadastro de Clientes

### Funcionalidades
- ✅ CRUD completo de Produtos
- ✅ CRUD completo de Clientes
- ✅ Autenticação de usuário
- ✅ Validação de campos
- ✅ Máscaras para CPF/CNPJ
- ✅ Campos com limitação de caracteres

### Campos - Produtos
- ✅ Código (inteiro, auto-incremento)
- ✅ Descrição (texto, 60 caracteres)
- ✅ Código de Barras (texto, 14 caracteres)
- ✅ Valor de Venda (numérico, 2 casas decimais)
- ✅ Peso Bruto (numérico, 3 casas decimais)
- ✅ Peso Líquido (numérico, 3 casas decimais)

### Campos - Clientes
- ✅ Código (inteiro, auto-incremento)
- ✅ Nome (texto, 60 caracteres)
- ✅ Fantasia (texto, 100 caracteres)
- ✅ Documento (CPF ou CNPJ com máscara)
- ✅ Endereço (texto livre)

## 🛠️ Tecnologias Utilizadas

### Backend
- **Framework**: Laravel 10
- **Linguagem**: PHP 8.2
- **Banco de Dados**: PostgreSQL 15

### Frontend
- **HTML5** - Estrutura das páginas
- **CSS3** - Estilização e design responsivo
- **JavaScript Vanilla** - Lógica e interação com API
- **Fetch API** - Requisições HTTP

### Infraestrutura
- **Docker** - Containerização
- **Docker Compose** - Orquestração de containers
- **Nginx** - Servidor web para frontend

## 📁 Estrutura do Projeto

```
teste-tecnico-softline/
├── Backend/                    # API Laravel
│   ├── app/
│   │   ├── Http/Controllers/  # AuthController, ProdutoController, ClienteController
│   │   └── Models/            # Usuario, Produto, Cliente
│   ├── database/
│   │   ├── migrations/        # Estrutura das tabelas
│   │   └── seeders/           # Dados iniciais
│   ├── routes/api.php         # Rotas da API
│   └── Dockerfile
├── Frontend/                   # Interface Web
│   ├── css/style.css          # Estilos
│   ├── js/                    # Scripts JavaScript
│   ├── index.html             # Login
│   ├── menu.html              # Menu principal
│   ├── produtos.html          # Lista de produtos
│   ├── produto-form.html      # Formulário de produto
│   ├── clientes.html          # Lista de clientes
│   └── cliente-form.html      # Formulário de cliente
├── Database/                   # Scripts SQL
│   ├── 01-init-postgresql.sql
│   └── 02-functions-postgresql.sql
├── docker-compose.yml          # Configuração Docker
├── README.md                   # Documentação principal
└── INSTALL.md                  # Guia de instalação
```

## 🚀 Como Executar

### Opção 1: Docker (Recomendado)
```bash
docker-compose up -d
```
Acesse: http://localhost:3000

### Opção 2: Manual
Ver instruções detalhadas em `INSTALL.md`

## 🔐 Credenciais

**Usuário**: admin  
**Senha**: admin123

## 📊 Endpoints da API

### Autenticação
- `POST /api/login` - Login

### Produtos
- `GET /api/produtos` - Listar todos
- `GET /api/produtos/{id}` - Buscar por ID
- `POST /api/produtos` - Criar
- `PUT /api/produtos/{id}` - Atualizar
- `DELETE /api/produtos/{id}` - Deletar

### Clientes
- `GET /api/clientes` - Listar todos
- `GET /api/clientes/{id}` - Buscar por ID
- `POST /api/clientes` - Criar
- `PUT /api/clientes/{id}` - Atualizar
- `DELETE /api/clientes/{id}` - Deletar

## 🎨 Features Implementadas

### Frontend
- Design responsivo e moderno
- Validação de formulários
- Máscaras automáticas para CPF/CNPJ
- Modal para visualização de detalhes
- Feedback visual para ações
- Navegação intuitiva

### Backend
- API RESTful
- Validação de dados
- Autenticação com hash de senha
- Migrations e Seeders
- CORS configurado
- Relacionamentos no Eloquent

### Banco de Dados
- Normalização de dados
- Triggers para updated_at
- Dados de exemplo
- Scripts de inicialização

## 📦 Diferenciais

1. **Docker Compose** completo com 3 serviços
2. **Migrations** do Laravel + Scripts SQL
3. **Seeders** para dados iniciais
4. **Frontend** 100% JavaScript Vanilla (sem frameworks)
5. **Máscaras** automáticas para documentos
6. **Validações** no frontend e backend
7. **CORS** configurado
8. **Documentação** completa

## 🗓️ Prazo

**Data de Entrega**: 14/06/2026 às 23:59  
**Status**: ✅ Entregue em 08/06/2026

## 📝 Observações

- Senha do usuário padrão usa bcrypt hash
- Banco de dados PostgreSQL para melhor performance
- Frontend sem dependências externas
- Código limpo e bem estruturado
- Pronto para produção com ajustes mínimos

## 👤 Autor

**Anderson Sartori**  
Data de Criação: 08/06/2026

## 🔗 Repositório

https://github.com/anderson-sart/teste-tecnico

---

**Soft-line Soluções em Sistemas - Teste Técnico DEV**
