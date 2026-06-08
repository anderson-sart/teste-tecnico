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
- **Linguagem**: PHP 8.2
- **Framework**: Migrations Laravel-style (sem framework completo)
- **Banco de Dados**: PostgreSQL 15

### Frontend
- **HTML5 + PHP Views** - Templates integrados
- **Bootstrap 5** - Framework CSS responsivo
- **JavaScript Vanilla** - Lógica client-side (pesquisa, ordenação, paginação)

### Infraestrutura
- **Docker** - Containerização
- **Docker Compose** - Orquestração de containers

## 📁 Estrutura do Projeto

```
teste-tecnico-softline/
└── Backend/                    # Aplicação PHP completa
    ├── resources/views/        # Views PHP com Bootstrap 5
    │   ├── layout.php          # Layout base
    │   ├── login.php           # Tela de login
    │   ├── produtos/           # Views de produtos
    │   │   ├── index.php       # Lista + pesquisa + ordenação
    │   │   ├── create.php      # Formulário de cadastro
    │   │   └── edit.php        # Formulário de edição
    │   └── clientes/           # Views de clientes
    │       ├── index.php       # Lista + pesquisa + ordenação
    │       ├── create.php      # Formulário de cadastro
    │       └── edit.php        # Formulário de edição
    ├── database/
    │   ├── migrations/         # Create tables + soft delete
    │   └── seeders/            # DatabaseSeeder (100 registros)
    ├── index.php               # Router + API endpoints
    ├── artisan                 # CLI migrations simplificado
    ├── docker-entrypoint.sh    # Auto-execução de migrations
    └── Dockerfile
```

## 🚀 Como Executar

### Opção 1: Docker (Recomendado)
```bash
git clone git@github.com:anderson-sart/teste-tecnico.git
cd teste-tecnico
docker-compose up -d
```
Acesse: http://localhost:8000

**Observação**: Migrations e seeders executam automaticamente na primeira inicialização.

## 🔐 Credenciais

**Usuário**: admin  
**Senha**: admin123

## 📊 Endpoints da API

### Autenticação
- `POST /api/login` - Login

### Produtos
- `GET /api/produtos` - Listar todos (com soft delete)
- `GET /api/produtos/{id}` - Buscar por ID
- `POST /api/produtos` - Criar
- `PUT /api/produtos/{id}` - Atualizar
- `DELETE /api/produtos/{id}` - Deletar (soft delete)

### Clientes
- `GET /api/clientes` - Listar todos (com soft delete)
- `GET /api/clientes/{id}` - Buscar por ID
- `POST /api/clientes` - Criar
- `PUT /api/clientes/{id}` - Atualizar
- `DELETE /api/clientes/{id}` - Deletar (soft delete)

## 🎨 Features Implementadas

### Frontend
- Design responsivo com Bootstrap 5
- Validação de formulários
- Máscaras automáticas para CPF/CNPJ
- Paginação client-side (10 registros/página)
- Pesquisa em tempo real (filtragem sem reload)
- Ordenação por colunas (ASC/DESC toggle)
- Feedback visual para ações
- Navegação intuitiva

### Backend
- Router personalizado em index.php
- API RESTful com JSON responses
- Validação de dados
- Autenticação com bcrypt
- Migrations Laravel-style simplificadas
- Seeder com 100 registros (50 produtos + 50 clientes)
- Soft delete (deleted_at)
- Views PHP com Bootstrap integrado

### Banco de Dados
- PostgreSQL com migrations automáticas
- Soft delete em todas as tabelas
- Dados de exemplo para testes
- Inicialização automática via Docker

## 📦 Diferenciais

1. **Arquitetura Simplificada** - Views PHP + API em único Backend
2. **Migrations Customizadas** - Sistema Laravel-style sem framework completo
3. **Seeder Rico** - 100 registros de exemplo para testes realistas
4. **Pesquisa + Ordenação + Paginação** - Client-side para performance
5. **Soft Delete** - Exclusão lógica preservando dados
6. **Docker Auto-Init** - Migrations executam automaticamente no startup
7. **Validações Duplas** - Frontend (UX) + Backend (segurança)
8. **Documentação Completa** - README, QUICKSTART, INSTALL, RESUMO

## 🗓️ Prazo

**Data de Entrega**: 14/06/2026 às 23:59  
**Status**: ✅ Entregue em 08/06/2026

## 📝 Observações

- Sistema 100% funcional com Docker
- Senha do usuário usa bcrypt hash
- PostgreSQL com soft delete nativo
- Views PHP com Bootstrap 5
- Pesquisa, ordenação e paginação client-side
- 100 registros de exemplo (50 produtos + 50 clientes)
- Código limpo e bem estruturado
- Pronto para uso

## 👤 Autor

**Anderson Sartori**  
Data de Criação: 08/06/2026

## 🔗 Repositório

https://github.com/anderson-sart/teste-tecnico

---

**Soft-line Soluções em Sistemas - Teste Técnico DEV**
