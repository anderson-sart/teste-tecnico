# Backend Laravel - Teste Técnico Soft-line

## Instalação

### Pré-requisitos
- PHP >= 8.1
- Composer
- SQL Server
- Extensão PHP para SQL Server (sqlsrv, pdo_sqlsrv)

### Passos

1. Instalar dependências:
```bash
composer install
```

2. Configurar arquivo .env:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar conexão com SQL Server no .env:
```
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=SoftlineDB
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

4. Executar o servidor:
```bash
php artisan serve
```

A API estará disponível em: http://localhost:8000

## Endpoints da API

### Autenticação
- POST `/api/login` - Fazer login

### Produtos
- GET `/api/produtos` - Listar todos
- GET `/api/produtos/{id}` - Obter um produto
- POST `/api/produtos` - Criar produto
- PUT `/api/produtos/{id}` - Atualizar produto
- DELETE `/api/produtos/{id}` - Deletar produto

### Clientes
- GET `/api/clientes` - Listar todos
- GET `/api/clientes/{id}` - Obter um cliente
- POST `/api/clientes` - Criar cliente
- PUT `/api/clientes/{id}` - Atualizar cliente
- DELETE `/api/clientes/{id}` - Deletar cliente
