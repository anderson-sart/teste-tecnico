# Guia de Instalação e Execução

## Pré-requisitos

- Docker e Docker Compose instalados
- Git instalado

## Instalação Rápida com Docker

1. Clone o repositório:
```bash
git clone git@github.com:anderson-sart/teste-tecnico.git
cd teste-tecnico
```

2. Inicie os containers:
```bash
docker-compose up -d
```

3. Aguarde alguns segundos para os serviços iniciarem

4. Acesse: http://localhost:8000

## Credenciais de Acesso

- **Usuário**: admin
- **Senha**: admin123

## Instalação Manual (sem Docker)

### 1. Backend PHP

1. Entre na pasta do backend:
```bash
cd Backend
```

2. Configure o arquivo .env:
```bash
cp .env.example .env
# Edite o .env com suas configurações de banco
```

3. Execute as migrations e seeders:
```bash
./artisan migrate
./artisan seed
```

4. Inicie o servidor:
```bash
php -S localhost:8000 index.php
```

### 2. Banco de Dados PostgreSQL

1. Crie o banco de dados:
```sql
CREATE DATABASE softline_db;
CREATE USER softline_user WITH PASSWORD 'softline_pass';
GRANT ALL PRIVILEGES ON DATABASE softline_db TO softline_user;
```

2. Configure o .env com as credenciais do banco

## Testando a API

### Login
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
    "descricao": "Produto Teste",
    "codigo_barras": "1234567890123",
    "valor_venda": 100.00,
    "peso_bruto": 1.500,
    "peso_liquido": 1.200
  }'
```

## Comandos Docker Úteis

```bash
# Ver logs dos containers
docker-compose logs -f

# Parar os containers
docker-compose down

# Remover volumes (apaga dados do banco)
docker-compose down -v

# Reiniciar um serviço específico
docker-compose restart backend
```

## Estrutura do Projeto

```
teste-tecnico-softline/
└── Backend/                    # Aplicação PHP completa
    ├── resources/views/        # Views PHP com Bootstrap 5
    │   ├── layout.php          # Layout base
    │   ├── login.php           # Tela de login
    │   ├── produtos/           # Views de produtos
    │   │   ├── index.php       # Listagem
    │   │   ├── create.php      # Cadastro
    │   │   └── edit.php        # Edição
    │   └── clientes/           # Views de clientes
    │       ├── index.php       # Listagem
    │       ├── create.php      # Cadastro
    │       └── edit.php        # Edição
    ├── database/
    │   ├── migrations/         # Estrutura das tabelas
    │   └── seeders/            # Dados iniciais (100 registros)
    ├── index.php               # Router + API
    ├── artisan                 # CLI para migrations
    └── Dockerfile
```

## Troubleshooting

### Backend não conecta ao banco
- Verifique se o container do PostgreSQL está rodando: `docker ps`
- Verifique as credenciais no arquivo `.env`
- Execute manualmente: `docker exec -it softline_backend ./artisan migrate`

### Migrations não executam
```bash
# Execute manualmente dentro do container
docker exec -it softline_backend ./artisan migrate
docker exec -it softline_backend ./artisan seed
```

### Erro de permissão
```bash
chmod -R 755 Backend/storage Backend/bootstrap/cache
```

## Suporte

Para problemas ou dúvidas, entre em contato ou abra uma issue no repositório.
