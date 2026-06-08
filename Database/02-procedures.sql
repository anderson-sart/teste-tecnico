-- =============================================
-- Procedures para Produtos
-- =============================================

USE SoftlineDB;
GO

-- Listar Produtos
CREATE OR ALTER PROCEDURE sp_ListarProdutos
AS
BEGIN
    SELECT Codigo, Descricao, CodigoBarras, ValorVenda, PesoBruto, PesoLiquido, DataCriacao, DataAlteracao
    FROM Produtos
    ORDER BY Codigo DESC;
END
GO

-- Obter Produto por Código
CREATE OR ALTER PROCEDURE sp_ObterProduto
    @Codigo INT
AS
BEGIN
    SELECT Codigo, Descricao, CodigoBarras, ValorVenda, PesoBruto, PesoLiquido, DataCriacao, DataAlteracao
    FROM Produtos
    WHERE Codigo = @Codigo;
END
GO

-- Inserir Produto
CREATE OR ALTER PROCEDURE sp_InserirProduto
    @Descricao VARCHAR(60),
    @CodigoBarras VARCHAR(14),
    @ValorVenda DECIMAL(10, 2),
    @PesoBruto DECIMAL(10, 3),
    @PesoLiquido DECIMAL(10, 3)
AS
BEGIN
    INSERT INTO Produtos (Descricao, CodigoBarras, ValorVenda, PesoBruto, PesoLiquido)
    VALUES (@Descricao, @CodigoBarras, @ValorVenda, @PesoBruto, @PesoLiquido);
    
    SELECT SCOPE_IDENTITY() AS Codigo;
END
GO

-- Atualizar Produto
CREATE OR ALTER PROCEDURE sp_AtualizarProduto
    @Codigo INT,
    @Descricao VARCHAR(60),
    @CodigoBarras VARCHAR(14),
    @ValorVenda DECIMAL(10, 2),
    @PesoBruto DECIMAL(10, 3),
    @PesoLiquido DECIMAL(10, 3)
AS
BEGIN
    UPDATE Produtos
    SET Descricao = @Descricao,
        CodigoBarras = @CodigoBarras,
        ValorVenda = @ValorVenda,
        PesoBruto = @PesoBruto,
        PesoLiquido = @PesoLiquido,
        DataAlteracao = GETDATE()
    WHERE Codigo = @Codigo;
END
GO

-- Deletar Produto
CREATE OR ALTER PROCEDURE sp_DeletarProduto
    @Codigo INT
AS
BEGIN
    DELETE FROM Produtos WHERE Codigo = @Codigo;
END
GO

-- =============================================
-- Procedures para Clientes
-- =============================================

-- Listar Clientes
CREATE OR ALTER PROCEDURE sp_ListarClientes
AS
BEGIN
    SELECT Codigo, Nome, Fantasia, Documento, Endereco, DataCriacao, DataAlteracao
    FROM Clientes
    ORDER BY Codigo DESC;
END
GO

-- Obter Cliente por Código
CREATE OR ALTER PROCEDURE sp_ObterCliente
    @Codigo INT
AS
BEGIN
    SELECT Codigo, Nome, Fantasia, Documento, Endereco, DataCriacao, DataAlteracao
    FROM Clientes
    WHERE Codigo = @Codigo;
END
GO

-- Inserir Cliente
CREATE OR ALTER PROCEDURE sp_InserirCliente
    @Nome VARCHAR(60),
    @Fantasia VARCHAR(100),
    @Documento VARCHAR(18),
    @Endereco VARCHAR(MAX)
AS
BEGIN
    INSERT INTO Clientes (Nome, Fantasia, Documento, Endereco)
    VALUES (@Nome, @Fantasia, @Documento, @Endereco);
    
    SELECT SCOPE_IDENTITY() AS Codigo;
END
GO

-- Atualizar Cliente
CREATE OR ALTER PROCEDURE sp_AtualizarCliente
    @Codigo INT,
    @Nome VARCHAR(60),
    @Fantasia VARCHAR(100),
    @Documento VARCHAR(18),
    @Endereco VARCHAR(MAX)
AS
BEGIN
    UPDATE Clientes
    SET Nome = @Nome,
        Fantasia = @Fantasia,
        Documento = @Documento,
        Endereco = @Endereco,
        DataAlteracao = GETDATE()
    WHERE Codigo = @Codigo;
END
GO

-- Deletar Cliente
CREATE OR ALTER PROCEDURE sp_DeletarCliente
    @Codigo INT
AS
BEGIN
    DELETE FROM Clientes WHERE Codigo = @Codigo;
END
GO

-- =============================================
-- Procedure para Login
-- =============================================

CREATE OR ALTER PROCEDURE sp_ValidarLogin
    @Usuario VARCHAR(50),
    @Senha VARCHAR(255)
AS
BEGIN
    SELECT Id, Usuario
    FROM Usuarios
    WHERE Usuario = @Usuario AND Senha = @Senha;
END
GO

PRINT 'Procedures criadas com sucesso!';
GO
