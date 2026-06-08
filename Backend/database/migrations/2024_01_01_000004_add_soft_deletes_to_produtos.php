<?php

$pdo->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS deleted_at TIMESTAMP NULL");
