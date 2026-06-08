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

4. Acesse:
   - Frontend: http://localhost:3000
   - Backend API: http://localhost:8000/api
   - Banco de dados: localhost:5432

## Credenciais de Acesso

- **Usuário**: admin
- **Senha**: admin123

## Instalação Manual (sem Docker)

### Backend (Laravel)

1. Entre na pasta do backend:
```bash
cd Backend
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o arquivo .env:
```bash
cp .env.example .env
# Edite o .env com suas configurações de banco
```

4. Gere a chave da aplicação:
```bash
php artisan key:generate
```

5. Execute as migrations:
```bash
php artisan migrate
```

6. Execute os seeders:
```bash
php artisan db:seed
```

7. Inicie o servidor:
```bash
php artisan serve
```

### Frontend

1. Entre na pasta do frontend:
```bash
cd Frontend
```

2. Inicie um servidor HTTP:
```bash
python3 -m http.server 3000
```

Ou simplesmente abra o arquivo `index.html` no navegador.

### Banco de Dados PostgreSQL

1. Crie o banco de dados:
```sql
CREATE DATABASE softline_db;
```

2. Execute os scripts SQL na pasta `Database/`:
```bash
psql -U seu_usuario -d softline_db -f Database/01-init-postgresql.sql
psql -U seu_usuario -d softline_db -f Database/02-functions-postgresql.sql
```

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
├── Backend/              # API Laravel
│   ├── app/
│   │   ├── Http/Controllers/
│   │   └── Models/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── routes/
├── Frontend/             # Interface web
│   ├── css/
│   ├── js/
│   └── *.html
├── Database/             # Scripts SQL
└── docker-compose.yml
```

## Troubleshooting

### Backend não conecta ao banco
- Verifique se o container do PostgreSQL está rodando: `docker ps`
- Verifique as credenciais no arquivo `.env`

### Frontend não conecta à API
- Verifique se o backend está rodando na porta 8000
- Verifique o CORS no arquivo `Backend/config/cors.php`

### Erro de permissão no Laravel
```bash
chmod -R 777 Backend/storage Backend/bootstrap/cache
```

## Suporte

Para problemas ou dúvidas, entre em contato ou abra uma issue no repositório.
