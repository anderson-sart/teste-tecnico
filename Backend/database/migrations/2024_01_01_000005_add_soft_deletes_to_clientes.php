<?php

$pdo->exec("ALTER TABLE clientes ADD COLUMN IF NOT EXISTS deleted_at TIMESTAMP NULL");
