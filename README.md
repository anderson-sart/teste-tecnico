# Teste Técnico - Soft-line Soluções em Sistemas

## Descrição
Sistema de cadastro de Produtos e Clientes com autenticação de usuário.

## 🚀 Quick Start

```bash
git clone git@github.com:anderson-sart/teste-tecnico.git
cd teste-tecnico
docker-compose up -d
```

Acesse: http://localhost:8000  
**Login**: admin | **Senha**: admin123

## 📚 Documentação

- **[QUICKSTART.md](QUICKSTART.md)** - Guia rápido de 3 passos
- **[INSTALL.md](INSTALL.md)** - Instalação detalhada (Docker e Manual)
- **[RESUMO.md](RESUMO.md)** - Resumo completo do projeto

## Tecnologias Utilizadas
- **Front-end**: Bootstrap 5, Alpine.js (recomendado oficialmente pelo Laravel)
- **Back-end**: PHP com Migrations Laravel-style
- **Banco de Dados**: PostgreSQL
- **Infraestrutura**: Docker & Docker Compose

### Por que Alpine.js?
Alpine.js é a escolha oficial recomendada pelo Laravel para interatividade no frontend. Suas vantagens:
- **Leve**: Apenas 15KB minificado
- **Declarativo**: Sintaxe HTML intuitiva (similar ao Vue.js)
- **Reativo**: Atualizações automáticas de UI
- **Sem build**: Funciona diretamente via CDN
- **Integração perfeita**: Trabalha nativamente com PHP/Blade

## Estrutura do Projeto
```
teste-tecnico-softline/
└── Backend/              # Aplicação PHP completa
    ├── resources/views/  # Views PHP (Bootstrap 5)
    ├── database/         # Migrations e Seeders
    ├── index.php         # Router + API
    └── artisan           # CLI para migrations
```

## Funcionalidades

### Páginas
1. **Login** - Autenticação de usuário
2. **Lista de Produtos** - Visualização, edição, exclusão com paginação e pesquisa
3. **Cadastro de Produtos** - Criação de novos produtos
4. **Lista de Clientes** - Visualização, edição, exclusão com paginação e pesquisa
5. **Cadastro de Clientes** - Criação de novos clientes

### Recursos Adicionais
- Paginação (10 registros por página)
- Pesquisa em tempo real (código, descrição, etc)
- Ordenação por colunas (ASC/DESC)
- Soft delete (exclusão lógica)
- 100 registros de exemplo (50 produtos + 50 clientes)

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
Acesse: http://localhost:8000

**Observação**: O banco de dados é inicializado automaticamente com migrations e seeders na primeira execução.

## Prazo de Entrega
14/06/2026 às 23:59

## Autor
Anderson Sartori

## Data de Criação
08/06/2026
