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
        
        echo "✓ User seeded\n";
        
        // Produtos
        $pdo->exec("
            INSERT INTO produtos (descricao, codigo_barras, valor_venda, peso_bruto, peso_liquido) VALUES
            ('Mouse Gamer RGB LED', '7890123456001', 89.90, 0.150, 0.120),
            ('Teclado Mecânico Switch Blue', '7890123456002', 299.90, 1.200, 1.000),
            ('Monitor LED 24 Polegadas', '7890123456003', 899.00, 5.500, 5.200),
            ('Webcam Full HD 1080p', '7890123456004', 189.90, 0.300, 0.250),
            ('Headset Gamer 7.1', '7890123456005', 249.90, 0.450, 0.380),
            ('Mousepad Gamer XXL', '7890123456006', 79.90, 0.800, 0.750),
            ('Cadeira Gamer RGB', '7890123456007', 1299.00, 25.000, 23.500),
            ('SSD 480GB SATA III', '7890123456008', 299.00, 0.080, 0.060),
            ('Memória RAM 8GB DDR4', '7890123456009', 199.00, 0.050, 0.040),
            ('HD Externo 1TB USB 3.0', '7890123456010', 349.00, 0.250, 0.220),
            ('Placa de Vídeo GTX', '7890123456011', 2499.00, 1.200, 1.100),
            ('Processador Intel i5', '7890123456012', 1299.00, 0.100, 0.080),
            ('Gabinete Gamer RGB', '7890123456013', 399.00, 8.000, 7.500),
            ('Fonte 600W 80 Plus', '7890123456014', 349.00, 1.500, 1.400),
            ('Water Cooler RGB 240mm', '7890123456015', 499.00, 1.800, 1.600),
            ('Notebook Dell 15.6', '7890123456016', 3999.00, 2.300, 2.100),
            ('Tablet Samsung 10', '7890123456017', 1499.00, 0.600, 0.550),
            ('Smartphone Xiaomi', '7890123456018', 1899.00, 0.200, 0.180),
            ('Smartwatch Apple', '7890123456019', 2499.00, 0.150, 0.130),
            ('Fone Bluetooth JBL', '7890123456020', 399.00, 0.100, 0.080),
            ('Caixa de Som Portátil', '7890123456021', 299.00, 0.800, 0.700),
            ('Roteador WiFi 6', '7890123456022', 449.00, 0.600, 0.550),
            ('Switch 8 Portas Gigabit', '7890123456023', 249.00, 0.400, 0.350),
            ('Impressora Multifuncional', '7890123456024', 899.00, 8.500, 8.000),
            ('Scanner Mesa A4', '7890123456025', 699.00, 3.200, 3.000),
            ('Projetor Full HD', '7890123456026', 2299.00, 4.500, 4.200),
            ('Mesa Digitalizadora', '7890123456027', 599.00, 1.200, 1.100),
            ('Microfone Condensador USB', '7890123456028', 499.00, 0.600, 0.550),
            ('Interface de Áudio USB', '7890123456029', 899.00, 1.200, 1.100),
            ('Cabo HDMI 2.1 3m', '7890123456030', 79.90, 0.150, 0.120),
            ('Adaptador USB-C Hub', '7890123456031', 189.00, 0.100, 0.080),
            ('Carregador Rápido 65W', '7890123456032', 149.00, 0.200, 0.180),
            ('Bateria Externa 20000mAh', '7890123456033', 199.00, 0.450, 0.420),
            ('Suporte Monitor Articulado', '7890123456034', 299.00, 3.500, 3.200),
            ('Luminária LED Gamer', '7890123456035', 149.00, 1.200, 1.100),
            ('Webcam Ring Light', '7890123456036', 249.00, 0.800, 0.750),
            ('Filtro de Linha 8 Tomadas', '7890123456037', 89.90, 0.600, 0.550),
            ('Estabilizador 1000VA', '7890123456038', 299.00, 5.500, 5.200),
            ('No-break 1200VA', '7890123456039', 899.00, 12.000, 11.500),
            ('Cooler para Notebook', '7890123456040', 79.90, 0.600, 0.550),
            ('Hub USB 3.0 7 Portas', '7890123456041', 129.00, 0.200, 0.180),
            ('Leitor Biométrico USB', '7890123456042', 299.00, 0.150, 0.130),
            ('Pen Drive 64GB USB 3.0', '7890123456043', 49.90, 0.020, 0.015),
            ('Cartão Memória 128GB', '7890123456044', 89.90, 0.010, 0.008),
            ('Case HD Externo USB', '7890123456045', 59.90, 0.150, 0.130),
            ('Cooler Fan RGB 120mm', '7890123456046', 69.90, 0.200, 0.180),
            ('Pasta Térmica Premium', '7890123456047', 29.90, 0.050, 0.040),
            ('Kit Limpeza Eletrônicos', '7890123456048', 39.90, 0.300, 0.280),
            ('Organizador Cabos Mesa', '7890123456049', 49.90, 0.200, 0.180),
            ('Suporte Notebook Ergonômico', '7890123456050', 129.00, 0.800, 0.750)
            ON CONFLICT DO NOTHING
        ");
        
        echo "✓ Produtos seeded (50 records)\n";
        
        // Clientes
        $pdo->exec("
            INSERT INTO clientes (nome, fantasia, documento, endereco) VALUES
            ('João Silva Santos', 'JS Tech', '12345678901', 'Rua A, 100 - São Paulo/SP'),
            ('Maria Oliveira Costa', 'MC Informática', '98765432100', 'Av B, 200 - Rio/RJ'),
            ('Tech Solutions Ltda', 'Tech Solutions', '12345678000190', 'Rua C, 300 - BH/MG'),
            ('Informática Total ME', 'Info Total', '23456789000191', 'Av D, 400 - Curitiba/PR'),
            ('Pedro Alves Lima', 'PA Tecnologia', '11122233344', 'Rua E, 500 - Porto Alegre/RS'),
            ('Ana Paula Mendes', 'APM Digital', '22233344455', 'Av F, 600 - Salvador/BA'),
            ('Comercial Tech Ltda', 'Comercial Tech', '34567890000192', 'Rua G, 700 - Recife/PE'),
            ('Carlos Eduardo Silva', 'CE Sistemas', '33344455566', 'Av H, 800 - Fortaleza/CE'),
            ('Digital Store ME', 'Digital Store', '45678901000193', 'Rua I, 900 - Brasília/DF'),
            ('Fernanda Santos Costa', 'FS Computadores', '44455566677', 'Av J, 1000 - Manaus/AM'),
            ('Hardware Plus Ltda', 'Hardware Plus', '56789012000194', 'Rua K, 1100 - Belém/PA'),
            ('Roberto Carlos Souza', 'RC Tech', '55566677788', 'Av L, 1200 - Goiânia/GO'),
            ('TechStore Brasil ME', 'TechStore', '67890123000195', 'Rua M, 1300 - Vitória/ES'),
            ('Juliana Costa Lima', 'JC Digital', '66677788899', 'Av N, 1400 - Natal/RN'),
            ('Mega Informática Ltda', 'Mega Info', '78901234000196', 'Rua O, 1500 - Maceió/AL'),
            ('Lucas Martins Alves', 'LM Tech', '77788899900', 'Av P, 1600 - São Luis/MA'),
            ('PC World Comércio ME', 'PC World', '89012345000197', 'Rua Q, 1700 - Teresina/PI'),
            ('Patricia Silva Rocha', 'PS Informática', '88899900011', 'Av R, 1800 - João Pessoa/PB'),
            ('Global Tech Ltda', 'Global Tech', '90123456000198', 'Rua S, 1900 - Aracaju/SE'),
            ('Rafael Costa Santos', 'RC Computadores', '99900011122', 'Av T, 2000 - Cuiabá/MT'),
            ('Compunet Sistemas ME', 'Compunet', '01234567000199', 'Rua U, 2100 - Campo Grande/MS'),
            ('Camila Oliveira Lima', 'CO Tech', '10011122233', 'Av V, 2200 - Florianópolis/SC'),
            ('InfoTech Brasil Ltda', 'InfoTech', '12345678000200', 'Rua W, 2300 - Porto Velho/RO'),
            ('Bruno Santos Alves', 'BS Digital', '11122233355', 'Av X, 2400 - Boa Vista/RR'),
            ('Eletrônicos Top ME', 'Eletrônicos Top', '23456789000201', 'Rua Y, 2500 - Macapá/AP'),
            ('Daniela Costa Mendes', 'DC Sistemas', '12233344466', 'Av Z, 2600 - Palmas/TO'),
            ('Computadores Express Ltda', 'Comp Express', '34567890000202', 'Rua AA, 2700 - SP/SP'),
            ('Marcelo Silva Costa', 'MS Tech', '13344455577', 'Av BB, 2800 - RJ/RJ'),
            ('Tech House Brasil ME', 'Tech House', '45678901000203', 'Rua CC, 2900 - BH/MG'),
            ('Vanessa Lima Santos', 'VL Digital', '14455566688', 'Av DD, 3000 - Curitiba/PR'),
            ('Digital Point Ltda', 'Digital Point', '56789012000204', 'Rua EE, 3100 - POA/RS'),
            ('Rodrigo Alves Costa', 'RA Informática', '15566677799', 'Av FF, 3200 - Salvador/BA'),
            ('Master Tech Comércio ME', 'Master Tech', '67890123000205', 'Rua GG, 3300 - Recife/PE'),
            ('Gabriela Santos Lima', 'GS Tech', '16677788800', 'Av HH, 3400 - Fortaleza/CE'),
            ('Info Center Ltda', 'Info Center', '78901234000206', 'Rua II, 3500 - Brasília/DF'),
            ('Felipe Costa Souza', 'FC Digital', '17788899911', 'Av JJ, 3600 - Manaus/AM'),
            ('Tech Market Brasil ME', 'Tech Market', '89012345000207', 'Rua KK, 3700 - Belém/PA'),
            ('Amanda Lima Costa', 'AL Sistemas', '18899900022', 'Av LL, 3800 - Goiânia/GO'),
            ('Prime Tech Ltda', 'Prime Tech', '90123456000208', 'Rua MM, 3900 - Vitória/ES'),
            ('Thiago Santos Alves', 'TS Tech', '19900011133', 'Av NN, 4000 - Natal/RN'),
            ('Digital Wave ME', 'Digital Wave', '01234567000209', 'Rua OO, 4100 - Maceió/AL'),
            ('Carolina Costa Lima', 'CC Informática', '20011122244', 'Av PP, 4200 - São Luis/MA'),
            ('Cyber Tech Ltda', 'Cyber Tech', '12345678000210', 'Rua QQ, 4300 - Teresina/PI'),
            ('Gustavo Silva Santos', 'GS Digital', '21122233355', 'Av RR, 4400 - João Pessoa/PB'),
            ('Smart Tech Brasil ME', 'Smart Tech', '23456789000211', 'Rua SS, 4500 - Aracaju/SE'),
            ('Isabela Lima Costa', 'IL Tech', '22233344477', 'Av TT, 4600 - Cuiabá/MT'),
            ('Future Tech Ltda', 'Future Tech', '34567890000212', 'Rua UU, 4700 - Campo Grande/MS'),
            ('Leonardo Santos Lima', 'LS Sistemas', '23344455588', 'Av VV, 4800 - Florianópolis/SC'),
            ('Net Tech Brasil ME', 'Net Tech', '45678901000213', 'Rua WW, 4900 - Porto Velho/RO'),
            ('Mariana Costa Santos', 'MC Digital', '24455566699', 'Av XX, 5000 - Boa Vista/RR')
            ON CONFLICT DO NOTHING
        ");
        
        echo "✓ Clientes seeded (50 records)\n";
        echo "\n✅ Database seeding completed!\n";
    }
}
