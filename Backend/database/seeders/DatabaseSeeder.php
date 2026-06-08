<?php

namespace Database\Seeders;

class DatabaseSeeder
{
    public function run()
    {
        global $pdo;
        
        // Criar usuário admin
        $pdo->exec("
            INSERT INTO users (username, password) 
            VALUES ('admin', '\$2y\$10\$qG9.p.QqaA0nB0roaaQSVO6lKaQhR/eH7CRi9CGgiojgPN6256VBi')
            ON CONFLICT (username) DO NOTHING
        ");
        
        echo "User seeded\n";
    }
}
