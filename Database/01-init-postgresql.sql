-- =============================================
-- Script de Criação do Banco de Dados PostgreSQL
-- Teste Técnico Soft-line
-- =============================================

-- Criar tabela de usuários
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criar tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    codigo SERIAL PRIMARY KEY,
    descricao VARCHAR(60) NOT NULL,
    codigo_barras VARCHAR(14),
    valor_venda DECIMAL(10, 2) NOT NULL,
    peso_bruto DECIMAL(10, 3) NOT NULL,
    peso_liquido DECIMAL(10, 3) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criar tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
    codigo SERIAL PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    fantasia VARCHAR(100),
    documento VARCHAR(18) NOT NULL,
    endereco TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir usuário padrão
-- Senha: admin123 (hash bcrypt)
INSERT INTO users (username, password) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON CONFLICT (username) DO NOTHING;

-- Dados de exemplo - Produtos
INSERT INTO produtos (descricao, codigo_barras, valor_venda, peso_bruto, peso_liquido) VALUES
('Notebook Dell Inspiron', '7891234567890', 3500.00, 2.500, 2.300),
('Mouse Logitech MX Master', '7891234567891', 350.00, 0.150, 0.120),
('Teclado Mecânico RGB', '7891234567892', 450.00, 1.200, 1.000);

-- Dados de exemplo - Clientes
INSERT INTO clientes (nome, fantasia, documento, endereco) VALUES
('João Silva Santos', 'JS Tecnologia', '12345678901', 'Rua das Flores, 123 - São Paulo/SP'),
('Maria Oliveira Ltda', 'Tech Solutions', '12345678000190', 'Av. Paulista, 1000 - São Paulo/SP');
