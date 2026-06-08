# Teste Técnico - Soft-line Soluções em Sistemas

## Descrição
Sistema de cadastro de Produtos e Clientes com autenticação de usuário.

## Tecnologias Utilizadas
- **Front-end**: HTML, CSS, JavaScript (Vanilla JS / jQuery)
- **Back-end**: C# (ASP.NET Core)
- **Banco de Dados**: SQL Server

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

### Banco de Dados
1. Execute os scripts na pasta `Database/` no SQL Server

### Backend
1. Navegue até a pasta `Backend/`
2. Execute `dotnet restore`
3. Execute `dotnet run`

### Frontend
1. Abra o arquivo `Frontend/index.html` no navegador
   ou configure um servidor web local

## Prazo de Entrega
14/06/2026 às 23:59

## Autor
Anderson Sartori

## Data de Criação
08/06/2026
