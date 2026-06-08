## Scripts SQL - Ordem de Execução

Execute os scripts SQL na seguinte ordem:

1. **01-create-database.sql** - Cria o banco de dados, tabelas e dados iniciais
2. **02-procedures.sql** - Cria as stored procedures

### Informações do Banco

**Banco de Dados**: SoftlineDB

### Tabelas Criadas

- **Usuarios** - Armazena usuários do sistema
- **Produtos** - Armazena produtos cadastrados
- **Clientes** - Armazena clientes cadastrados

### Usuário Padrão

- **Usuário**: admin
- **Senha**: admin123

### Stored Procedures

**Produtos:**
- sp_ListarProdutos
- sp_ObterProduto
- sp_InserirProduto
- sp_AtualizarProduto
- sp_DeletarProduto

**Clientes:**
- sp_ListarClientes
- sp_ObterCliente
- sp_InserirCliente
- sp_AtualizarCliente
- sp_DeletarCliente

**Autenticação:**
- sp_ValidarLogin
