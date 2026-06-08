<?php

$pdo->exec("
    CREATE TABLE IF NOT EXISTS clientes (
        codigo SERIAL PRIMARY KEY,
        nome VARCHAR(60) NOT NULL,
        fantasia VARCHAR(100),
        documento VARCHAR(18) NOT NULL,
        endereco TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
