# Scripts do Banco de Dados - PostgreSQL

## Descrição
Scripts SQL para criação e gerenciamento do banco de dados PostgreSQL.

## Arquivos

### PostgreSQL (Utilizados no projeto)

1. **01-init-postgresql.sql** - Script de inicialização do banco de dados
   - Cria tabelas: users, produtos, clientes
   - Insere dados iniciais e de exemplo
   
2. **02-functions-postgresql.sql** - Functions e triggers
   - Trigger para atualização automática do campo updated_at

### SQL Server (Referência)

- **01-create-database.sql** - Script original para SQL Server
- **02-procedures.sql** - Procedures originais para SQL Server

## Execução Automática (Docker)

Os scripts são executados automaticamente ao iniciar o Docker Compose:

```bash
docker-compose up -d
```

## Execução Manual

Se desejar executar os scripts manualmente no PostgreSQL:

```bash
psql -U softline_user -d softline_db -f 01-init-postgresql.sql
psql -U softline_user -d softline_db -f 02-functions-postgresql.sql
```

## Informações do Banco

**Banco de Dados**: softline_db
**Usuário**: softline_user
**Senha**: softline_pass
**Porta**: 5432

## Tabelas Criadas

- **users** - Usuários do sistema (login)
- **produtos** - Produtos cadastrados
- **clientes** - Clientes cadastrados

## Usuário Padrão

- **Usuário**: admin
- **Senha**: admin123

## Observações

- O Laravel também possui migrations que criam as mesmas tabelas
- Os dados são persistidos no volume Docker `postgres_data`
- Utilize pgAdmin ou DBeaver para gerenciar o banco graficamente
