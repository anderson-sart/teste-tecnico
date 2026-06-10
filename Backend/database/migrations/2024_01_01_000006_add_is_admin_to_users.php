<?php

$pdo->exec("
    ALTER TABLE users 
    ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE
");

// Tornar o usuário admin como admin
$pdo->exec("
    UPDATE users 
    SET is_admin = TRUE 
    WHERE username = 'admin'
");
