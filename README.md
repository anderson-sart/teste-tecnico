# Teste Técnico - Soft-line Soluções em Sistemas

## Descrição
Sistema de cadastro de Produtos e Clientes com autenticação de usuário.

## 🚀 Quick Start

```bash
git clone git@github.com:anderson-sart/teste-tecnico.git
cd teste-tecnico
docker-compose up -d
```

Acesse: http://localhost:3000  
**Login**: admin | **Senha**: admin123

## 📚 Documentação

- **[QUICKSTART.md](QUICKSTART.md)** - Guia rápido de 3 passos
- **[INSTALL.md](INSTALL.md)** - Instalação detalhada (Docker e Manual)
- **[RESUMO.md](RESUMO.md)** - Resumo completo do projeto
- **[Database/README-POSTGRESQL.md](Database/README-POSTGRESQL.md)** - Informações do banco

## Tecnologias Utilizadas
- **Front-end**: HTML, CSS, JavaScript (Vanilla JS / jQuery)
- **Back-end**: PHP (Laravel)
- **Banco de Dados**: PostgreSQL
- **Infraestrutura**: Docker & Docker Compose

## Estrutura do Projeto
```
teste-tecnico-softline/
├── Backend/          # API em C# (ASP.NET Core)
├── Frontend/         # Interface web (HTML, CSS, JS)
└── Database/         # Scripts SQL
```

## Funcionalidades

### Páginas
1. **Login** - Autenticação de usuário
2. **Lista de Produtos** - Visualização, edição, exclusão de produtos
3. **Cadastro de Produtos** - Criação de novos produtos
4. **Lista de Clientes** - Visualização, edição, exclusão de clientes
5. **Cadastro de Clientes** - Criação de novos clientes

### Campos - Produtos
- Código (inteiro)
- Descrição (texto, 60 caracteres)
- Código de Barras (texto, 14 caracteres)
- Valor de Venda (numérico, 2 casas decimais)
- Peso Bruto (numérico, 3 casas decimais)
- Peso Líquido (numérico, 3 casas decimais)

### Campos - Clientes
- Código (inteiro)
- Nome (texto, 60 caracteres)
- Fantasia (texto, 100 caracteres)
- Documento (CPF ou CNPJ com máscara)
- Endereço (texto livre)

## Como Executar

### Usando Docker (Recomendado)
```bash
docker-compose up -d
```
Acesse o backend em: http://localhost:8000
Acesse o frontend em: http://localhost:3000

### Manualmente

#### Banco de Dados
1. Execute os scripts na pasta `Database/` no PostgreSQL

#### Backend
1. Instale o Composer: https://getcomposer.org/
2. Navegue até a pasta `Backend/`
3. Execute `composer install`
4. Configure o `.env` com a conexão do PostgreSQL
5. Execute `php artisan migrate`
6. Execute `php artisan serve`

#### Frontend
1. Abra o arquivo `Frontend/index.html` no navegador
   ou use: `python3 -m http.server 3000`

## Prazo de Entrega
14/06/2026 às 23:59

## Autor
Anderson Sartori

## Data de Criação
08/06/2026
