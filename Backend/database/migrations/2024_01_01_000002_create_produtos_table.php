<?php

$pdo->exec("
    CREATE TABLE IF NOT EXISTS produtos (
        codigo SERIAL PRIMARY KEY,
        descricao VARCHAR(60) NOT NULL,
        codigo_barras VARCHAR(14),
        valor_venda DECIMAL(10, 2) NOT NULL,
        peso_bruto DECIMAL(10, 3) NOT NULL,
        peso_liquido DECIMAL(10, 3) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
