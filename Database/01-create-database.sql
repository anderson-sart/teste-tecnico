-- =============================================
-- Script de Criação do Banco de Dados
-- Teste Técnico Soft-line
-- =============================================

-- Criar banco de dados
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'SoftlineDB')
BEGIN
    CREATE DATABASE SoftlineDB;
END
GO

USE SoftlineDB;
GO

-- =============================================
-- Tabela de Usuários
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'Usuarios')
BEGIN
    CREATE TABLE Usuarios (
        Id INT PRIMARY KEY IDENTITY(1,1),
        Usuario VARCHAR(50) NOT NULL UNIQUE,
        Senha VARCHAR(255) NOT NULL,
        DataCriacao DATETIME DEFAULT GETDATE()
    );
END
GO

-- =============================================
-- Tabela de Produtos
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'Produtos')
BEGIN
    CREATE TABLE Produtos (
        Codigo INT PRIMARY KEY IDENTITY(1,1),
        Descricao VARCHAR(60) NOT NULL,
        CodigoBarras VARCHAR(14),
        ValorVenda DECIMAL(10, 2) NOT NULL,
        PesoBruto DECIMAL(10, 3) NOT NULL,
        PesoLiquido DECIMAL(10, 3) NOT NULL,
        DataCriacao DATETIME DEFAULT GETDATE(),
        DataAlteracao DATETIME NULL
    );
END
GO

-- =============================================
-- Tabela de Clientes
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'Clientes')
BEGIN
    CREATE TABLE Clientes (
        Codigo INT PRIMARY KEY IDENTITY(1,1),
        Nome VARCHAR(60) NOT NULL,
        Fantasia VARCHAR(100),
        Documento VARCHAR(18) NOT NULL,
        Endereco VARCHAR(MAX),
        DataCriacao DATETIME DEFAULT GETDATE(),
        DataAlteracao DATETIME NULL
    );
END
GO

-- =============================================
-- Dados Iniciais - Usuário padrão
-- =============================================
-- Senha: admin123 (em produção usar hash bcrypt)
IF NOT EXISTS (SELECT * FROM Usuarios WHERE Usuario = 'admin')
BEGIN
    INSERT INTO Usuarios (Usuario, Senha) 
    VALUES ('admin', 'admin123');
END
GO

-- =============================================
-- Dados de Exemplo - Produtos
-- =============================================
IF NOT EXISTS (SELECT * FROM Produtos)
BEGIN
    INSERT INTO Produtos (Descricao, CodigoBarras, ValorVenda, PesoBruto, PesoLiquido)
    VALUES 
        ('Notebook Dell Inspiron', '7891234567890', 3500.00, 2.500, 2.300),
        ('Mouse Logitech MX Master', '7891234567891', 350.00, 0.150, 0.120),
        ('Teclado Mecânico RGB', '7891234567892', 450.00, 1.200, 1.000);
END
GO

-- =============================================
-- Dados de Exemplo - Clientes
-- =============================================
IF NOT EXISTS (SELECT * FROM Clientes)
BEGIN
    INSERT INTO Clientes (Nome, Fantasia, Documento, Endereco)
    VALUES 
        ('João Silva Santos', 'JS Tecnologia', '12345678901', 'Rua das Flores, 123 - São Paulo/SP'),
        ('Maria Oliveira Ltda', 'Tech Solutions', '12345678000190', 'Av. Paulista, 1000 - São Paulo/SP');
END
GO

PRINT 'Banco de dados criado com sucesso!';
GO
