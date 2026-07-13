<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produto;
use App\Models\Cliente;

class DatabaseSeeder
{
    public function run()
    {
        // Criar usuário admin
        User::updateOrCreate(
            ['username' => 'admin'],
            ['password' => '$2y$10$qG9.p.QqaA0nB0roaaQSVO6lKaQhR/eH7CRi9CGgiojgPN6256VBi', 'is_admin' => true]
        );

        echo "✓ User seeded\n";

        // Produtos
        $produtos = [
            ['descricao' => 'Mouse Gamer RGB LED', 'codigo_barras' => '7890123456001', 'valor_venda' => 89.90, 'peso_bruto' => 0.150, 'peso_liquido' => 0.120],
            ['descricao' => 'Teclado Mecânico Switch Blue', 'codigo_barras' => '7890123456002', 'valor_venda' => 299.90, 'peso_bruto' => 1.200, 'peso_liquido' => 1.000],
            ['descricao' => 'Monitor LED 24 Polegadas', 'codigo_barras' => '7890123456003', 'valor_venda' => 899.00, 'peso_bruto' => 5.500, 'peso_liquido' => 5.200],
            ['descricao' => 'Webcam Full HD 1080p', 'codigo_barras' => '7890123456004', 'valor_venda' => 189.90, 'peso_bruto' => 0.300, 'peso_liquido' => 0.250],
            ['descricao' => 'Headset Gamer 7.1', 'codigo_barras' => '7890123456005', 'valor_venda' => 249.90, 'peso_bruto' => 0.450, 'peso_liquido' => 0.380],
            ['descricao' => 'Mousepad Gamer XXL', 'codigo_barras' => '7890123456006', 'valor_venda' => 79.90, 'peso_bruto' => 0.800, 'peso_liquido' => 0.750],
            ['descricao' => 'Cadeira Gamer RGB', 'codigo_barras' => '7890123456007', 'valor_venda' => 1299.00, 'peso_bruto' => 25.000, 'peso_liquido' => 23.500],
            ['descricao' => 'SSD 480GB SATA III', 'codigo_barras' => '7890123456008', 'valor_venda' => 299.00, 'peso_bruto' => 0.080, 'peso_liquido' => 0.060],
            ['descricao' => 'Memória RAM 8GB DDR4', 'codigo_barras' => '7890123456009', 'valor_venda' => 199.00, 'peso_bruto' => 0.050, 'peso_liquido' => 0.040],
            ['descricao' => 'HD Externo 1TB USB 3.0', 'codigo_barras' => '7890123456010', 'valor_venda' => 349.00, 'peso_bruto' => 0.250, 'peso_liquido' => 0.220],
            ['descricao' => 'Placa de Vídeo GTX', 'codigo_barras' => '7890123456011', 'valor_venda' => 2499.00, 'peso_bruto' => 1.200, 'peso_liquido' => 1.100],
            ['descricao' => 'Processador Intel i5', 'codigo_barras' => '7890123456012', 'valor_venda' => 1299.00, 'peso_bruto' => 0.100, 'peso_liquido' => 0.080],
            ['descricao' => 'Gabinete Gamer RGB', 'codigo_barras' => '7890123456013', 'valor_venda' => 399.00, 'peso_bruto' => 8.000, 'peso_liquido' => 7.500],
            ['descricao' => 'Fonte 600W 80 Plus', 'codigo_barras' => '7890123456014', 'valor_venda' => 349.00, 'peso_bruto' => 1.500, 'peso_liquido' => 1.400],
            ['descricao' => 'Water Cooler RGB 240mm', 'codigo_barras' => '7890123456015', 'valor_venda' => 499.00, 'peso_bruto' => 1.800, 'peso_liquido' => 1.600],
            ['descricao' => 'Notebook Dell 15.6', 'codigo_barras' => '7890123456016', 'valor_venda' => 3999.00, 'peso_bruto' => 2.300, 'peso_liquido' => 2.100],
            ['descricao' => 'Tablet Samsung 10', 'codigo_barras' => '7890123456017', 'valor_venda' => 1499.00, 'peso_bruto' => 0.600, 'peso_liquido' => 0.550],
            ['descricao' => 'Smartphone Xiaomi', 'codigo_barras' => '7890123456018', 'valor_venda' => 1899.00, 'peso_bruto' => 0.200, 'peso_liquido' => 0.180],
            ['descricao' => 'Smartwatch Apple', 'codigo_barras' => '7890123456019', 'valor_venda' => 2499.00, 'peso_bruto' => 0.150, 'peso_liquido' => 0.130],
            ['descricao' => 'Fone Bluetooth JBL', 'codigo_barras' => '7890123456020', 'valor_venda' => 399.00, 'peso_bruto' => 0.100, 'peso_liquido' => 0.080],
            ['descricao' => 'Caixa de Som Portátil', 'codigo_barras' => '7890123456021', 'valor_venda' => 299.00, 'peso_bruto' => 0.800, 'peso_liquido' => 0.700],
            ['descricao' => 'Roteador WiFi 6', 'codigo_barras' => '7890123456022', 'valor_venda' => 449.00, 'peso_bruto' => 0.600, 'peso_liquido' => 0.550],
            ['descricao' => 'Switch 8 Portas Gigabit', 'codigo_barras' => '7890123456023', 'valor_venda' => 249.00, 'peso_bruto' => 0.400, 'peso_liquido' => 0.350],
            ['descricao' => 'Impressora Multifuncional', 'codigo_barras' => '7890123456024', 'valor_venda' => 899.00, 'peso_bruto' => 8.500, 'peso_liquido' => 8.000],
            ['descricao' => 'Scanner Mesa A4', 'codigo_barras' => '7890123456025', 'valor_venda' => 699.00, 'peso_bruto' => 3.200, 'peso_liquido' => 3.000],
            ['descricao' => 'Projetor Full HD', 'codigo_barras' => '7890123456026', 'valor_venda' => 2299.00, 'peso_bruto' => 4.500, 'peso_liquido' => 4.200],
            ['descricao' => 'Mesa Digitalizadora', 'codigo_barras' => '7890123456027', 'valor_venda' => 599.00, 'peso_bruto' => 1.200, 'peso_liquido' => 1.100],
            ['descricao' => 'Microfone Condensador USB', 'codigo_barras' => '7890123456028', 'valor_venda' => 499.00, 'peso_bruto' => 0.600, 'peso_liquido' => 0.550],
            ['descricao' => 'Interface de Áudio USB', 'codigo_barras' => '7890123456029', 'valor_venda' => 899.00, 'peso_bruto' => 1.200, 'peso_liquido' => 1.100],
            ['descricao' => 'Cabo HDMI 2.1 3m', 'codigo_barras' => '7890123456030', 'valor_venda' => 79.90, 'peso_bruto' => 0.150, 'peso_liquido' => 0.120],
            ['descricao' => 'Adaptador USB-C Hub', 'codigo_barras' => '7890123456031', 'valor_venda' => 189.00, 'peso_bruto' => 0.100, 'peso_liquido' => 0.080],
            ['descricao' => 'Carregador Rápido 65W', 'codigo_barras' => '7890123456032', 'valor_venda' => 149.00, 'peso_bruto' => 0.200, 'peso_liquido' => 0.180],
            ['descricao' => 'Bateria Externa 20000mAh', 'codigo_barras' => '7890123456033', 'valor_venda' => 199.00, 'peso_bruto' => 0.450, 'peso_liquido' => 0.420],
            ['descricao' => 'Suporte Monitor Articulado', 'codigo_barras' => '7890123456034', 'valor_venda' => 299.00, 'peso_bruto' => 3.500, 'peso_liquido' => 3.200],
            ['descricao' => 'Luminária LED Gamer', 'codigo_barras' => '7890123456035', 'valor_venda' => 149.00, 'peso_bruto' => 1.200, 'peso_liquido' => 1.100],
            ['descricao' => 'Webcam Ring Light', 'codigo_barras' => '7890123456036', 'valor_venda' => 249.00, 'peso_bruto' => 0.800, 'peso_liquido' => 0.750],
            ['descricao' => 'Filtro de Linha 8 Tomadas', 'codigo_barras' => '7890123456037', 'valor_venda' => 89.90, 'peso_bruto' => 0.600, 'peso_liquido' => 0.550],
            ['descricao' => 'Estabilizador 1000VA', 'codigo_barras' => '7890123456038', 'valor_venda' => 299.00, 'peso_bruto' => 5.500, 'peso_liquido' => 5.200],
            ['descricao' => 'No-break 1200VA', 'codigo_barras' => '7890123456039', 'valor_venda' => 899.00, 'peso_bruto' => 12.000, 'peso_liquido' => 11.500],
            ['descricao' => 'Cooler para Notebook', 'codigo_barras' => '7890123456040', 'valor_venda' => 79.90, 'peso_bruto' => 0.600, 'peso_liquido' => 0.550],
            ['descricao' => 'Hub USB 3.0 7 Portas', 'codigo_barras' => '7890123456041', 'valor_venda' => 129.00, 'peso_bruto' => 0.200, 'peso_liquido' => 0.180],
            ['descricao' => 'Leitor Biométrico USB', 'codigo_barras' => '7890123456042', 'valor_venda' => 299.00, 'peso_bruto' => 0.150, 'peso_liquido' => 0.130],
            ['descricao' => 'Pen Drive 64GB USB 3.0', 'codigo_barras' => '7890123456043', 'valor_venda' => 49.90, 'peso_bruto' => 0.020, 'peso_liquido' => 0.015],
            ['descricao' => 'Cartão Memória 128GB', 'codigo_barras' => '7890123456044', 'valor_venda' => 89.90, 'peso_bruto' => 0.010, 'peso_liquido' => 0.008],
            ['descricao' => 'Case HD Externo USB', 'codigo_barras' => '7890123456045', 'valor_venda' => 59.90, 'peso_bruto' => 0.150, 'peso_liquido' => 0.130],
            ['descricao' => 'Cooler Fan RGB 120mm', 'codigo_barras' => '7890123456046', 'valor_venda' => 69.90, 'peso_bruto' => 0.200, 'peso_liquido' => 0.180],
            ['descricao' => 'Pasta Térmica Premium', 'codigo_barras' => '7890123456047', 'valor_venda' => 29.90, 'peso_bruto' => 0.050, 'peso_liquido' => 0.040],
            ['descricao' => 'Kit Limpeza Eletrônicos', 'codigo_barras' => '7890123456048', 'valor_venda' => 39.90, 'peso_bruto' => 0.300, 'peso_liquido' => 0.280],
            ['descricao' => 'Organizador Cabos Mesa', 'codigo_barras' => '7890123456049', 'valor_venda' => 49.90, 'peso_bruto' => 0.200, 'peso_liquido' => 0.180],
            ['descricao' => 'Suporte Notebook Ergonômico', 'codigo_barras' => '7890123456050', 'valor_venda' => 129.00, 'peso_bruto' => 0.800, 'peso_liquido' => 0.750],
        ];

        foreach ($produtos as $data) {
            Produto::firstOrCreate(['codigo_barras' => $data['codigo_barras']], $data);
        }

        echo "✓ Produtos seeded (50 records)\n";

        // Clientes
        $clientes = [
            ['nome' => 'João Silva Santos', 'fantasia' => 'JS Tech', 'documento' => '12345678901', 'endereco' => 'Rua A, 100 - São Paulo/SP'],
            ['nome' => 'Maria Oliveira Costa', 'fantasia' => 'MC Informática', 'documento' => '98765432100', 'endereco' => 'Av B, 200 - Rio/RJ'],
            ['nome' => 'Tech Solutions Ltda', 'fantasia' => 'Tech Solutions', 'documento' => '12345678000190', 'endereco' => 'Rua C, 300 - BH/MG'],
            ['nome' => 'Informática Total ME', 'fantasia' => 'Info Total', 'documento' => '23456789000191', 'endereco' => 'Av D, 400 - Curitiba/PR'],
            ['nome' => 'Pedro Alves Lima', 'fantasia' => 'PA Tecnologia', 'documento' => '11122233344', 'endereco' => 'Rua E, 500 - Porto Alegre/RS'],
            ['nome' => 'Ana Paula Mendes', 'fantasia' => 'APM Digital', 'documento' => '22233344455', 'endereco' => 'Av F, 600 - Salvador/BA'],
            ['nome' => 'Comercial Tech Ltda', 'fantasia' => 'Comercial Tech', 'documento' => '34567890000192', 'endereco' => 'Rua G, 700 - Recife/PE'],
            ['nome' => 'Carlos Eduardo Silva', 'fantasia' => 'CE Sistemas', 'documento' => '33344455566', 'endereco' => 'Av H, 800 - Fortaleza/CE'],
            ['nome' => 'Digital Store ME', 'fantasia' => 'Digital Store', 'documento' => '45678901000193', 'endereco' => 'Rua I, 900 - Brasília/DF'],
            ['nome' => 'Fernanda Santos Costa', 'fantasia' => 'FS Computadores', 'documento' => '44455566677', 'endereco' => 'Av J, 1000 - Manaus/AM'],
            ['nome' => 'Hardware Plus Ltda', 'fantasia' => 'Hardware Plus', 'documento' => '56789012000194', 'endereco' => 'Rua K, 1100 - Belém/PA'],
            ['nome' => 'Roberto Carlos Souza', 'fantasia' => 'RC Tech', 'documento' => '55566677788', 'endereco' => 'Av L, 1200 - Goiânia/GO'],
            ['nome' => 'TechStore Brasil ME', 'fantasia' => 'TechStore', 'documento' => '67890123000195', 'endereco' => 'Rua M, 1300 - Vitória/ES'],
            ['nome' => 'Juliana Costa Lima', 'fantasia' => 'JC Digital', 'documento' => '66677788899', 'endereco' => 'Av N, 1400 - Natal/RN'],
            ['nome' => 'Mega Informática Ltda', 'fantasia' => 'Mega Info', 'documento' => '78901234000196', 'endereco' => 'Rua O, 1500 - Maceió/AL'],
            ['nome' => 'Lucas Martins Alves', 'fantasia' => 'LM Tech', 'documento' => '77788899900', 'endereco' => 'Av P, 1600 - São Luis/MA'],
            ['nome' => 'PC World Comércio ME', 'fantasia' => 'PC World', 'documento' => '89012345000197', 'endereco' => 'Rua Q, 1700 - Teresina/PI'],
            ['nome' => 'Patricia Silva Rocha', 'fantasia' => 'PS Informática', 'documento' => '88899900011', 'endereco' => 'Av R, 1800 - João Pessoa/PB'],
            ['nome' => 'Global Tech Ltda', 'fantasia' => 'Global Tech', 'documento' => '90123456000198', 'endereco' => 'Rua S, 1900 - Aracaju/SE'],
            ['nome' => 'Rafael Costa Santos', 'fantasia' => 'RC Computadores', 'documento' => '99900011122', 'endereco' => 'Av T, 2000 - Cuiabá/MT'],
            ['nome' => 'Compunet Sistemas ME', 'fantasia' => 'Compunet', 'documento' => '01234567000199', 'endereco' => 'Rua U, 2100 - Campo Grande/MS'],
            ['nome' => 'Camila Oliveira Lima', 'fantasia' => 'CO Tech', 'documento' => '10011122233', 'endereco' => 'Av V, 2200 - Florianópolis/SC'],
            ['nome' => 'InfoTech Brasil Ltda', 'fantasia' => 'InfoTech', 'documento' => '12345678000200', 'endereco' => 'Rua W, 2300 - Porto Velho/RO'],
            ['nome' => 'Bruno Santos Alves', 'fantasia' => 'BS Digital', 'documento' => '11122233355', 'endereco' => 'Av X, 2400 - Boa Vista/RR'],
            ['nome' => 'Eletrônicos Top ME', 'fantasia' => 'Eletrônicos Top', 'documento' => '23456789000201', 'endereco' => 'Rua Y, 2500 - Macapá/AP'],
            ['nome' => 'Daniela Costa Mendes', 'fantasia' => 'DC Sistemas', 'documento' => '12233344466', 'endereco' => 'Av Z, 2600 - Palmas/TO'],
            ['nome' => 'Computadores Express Ltda', 'fantasia' => 'Comp Express', 'documento' => '34567890000202', 'endereco' => 'Rua AA, 2700 - SP/SP'],
            ['nome' => 'Marcelo Silva Costa', 'fantasia' => 'MS Tech', 'documento' => '13344455577', 'endereco' => 'Av BB, 2800 - RJ/RJ'],
            ['nome' => 'Tech House Brasil ME', 'fantasia' => 'Tech House', 'documento' => '45678901000203', 'endereco' => 'Rua CC, 2900 - BH/MG'],
            ['nome' => 'Vanessa Lima Santos', 'fantasia' => 'VL Digital', 'documento' => '14455566688', 'endereco' => 'Av DD, 3000 - Curitiba/PR'],
            ['nome' => 'Digital Point Ltda', 'fantasia' => 'Digital Point', 'documento' => '56789012000204', 'endereco' => 'Rua EE, 3100 - POA/RS'],
            ['nome' => 'Rodrigo Alves Costa', 'fantasia' => 'RA Informática', 'documento' => '15566677799', 'endereco' => 'Av FF, 3200 - Salvador/BA'],
            ['nome' => 'Master Tech Comércio ME', 'fantasia' => 'Master Tech', 'documento' => '67890123000205', 'endereco' => 'Rua GG, 3300 - Recife/PE'],
            ['nome' => 'Gabriela Santos Lima', 'fantasia' => 'GS Tech', 'documento' => '16677788800', 'endereco' => 'Av HH, 3400 - Fortaleza/CE'],
            ['nome' => 'Info Center Ltda', 'fantasia' => 'Info Center', 'documento' => '78901234000206', 'endereco' => 'Rua II, 3500 - Brasília/DF'],
            ['nome' => 'Felipe Costa Souza', 'fantasia' => 'FC Digital', 'documento' => '17788899911', 'endereco' => 'Av JJ, 3600 - Manaus/AM'],
            ['nome' => 'Tech Market Brasil ME', 'fantasia' => 'Tech Market', 'documento' => '89012345000207', 'endereco' => 'Rua KK, 3700 - Belém/PA'],
            ['nome' => 'Amanda Lima Costa', 'fantasia' => 'AL Sistemas', 'documento' => '18899900022', 'endereco' => 'Av LL, 3800 - Goiânia/GO'],
            ['nome' => 'Prime Tech Ltda', 'fantasia' => 'Prime Tech', 'documento' => '90123456000208', 'endereco' => 'Rua MM, 3900 - Vitória/ES'],
            ['nome' => 'Thiago Santos Alves', 'fantasia' => 'TS Tech', 'documento' => '19900011133', 'endereco' => 'Av NN, 4000 - Natal/RN'],
            ['nome' => 'Digital Wave ME', 'fantasia' => 'Digital Wave', 'documento' => '01234567000209', 'endereco' => 'Rua OO, 4100 - Maceió/AL'],
            ['nome' => 'Carolina Costa Lima', 'fantasia' => 'CC Informática', 'documento' => '20011122244', 'endereco' => 'Av PP, 4200 - São Luis/MA'],
            ['nome' => 'Cyber Tech Ltda', 'fantasia' => 'Cyber Tech', 'documento' => '12345678000210', 'endereco' => 'Rua QQ, 4300 - Teresina/PI'],
            ['nome' => 'Gustavo Silva Santos', 'fantasia' => 'GS Digital', 'documento' => '21122233355', 'endereco' => 'Av RR, 4400 - João Pessoa/PB'],
            ['nome' => 'Smart Tech Brasil ME', 'fantasia' => 'Smart Tech', 'documento' => '23456789000211', 'endereco' => 'Rua SS, 4500 - Aracaju/SE'],
            ['nome' => 'Isabela Lima Costa', 'fantasia' => 'IL Tech', 'documento' => '22233344477', 'endereco' => 'Av TT, 4600 - Cuiabá/MT'],
            ['nome' => 'Future Tech Ltda', 'fantasia' => 'Future Tech', 'documento' => '34567890000212', 'endereco' => 'Rua UU, 4700 - Campo Grande/MS'],
            ['nome' => 'Leonardo Santos Lima', 'fantasia' => 'LS Sistemas', 'documento' => '23344455588', 'endereco' => 'Av VV, 4800 - Florianópolis/SC'],
            ['nome' => 'Net Tech Brasil ME', 'fantasia' => 'Net Tech', 'documento' => '45678901000213', 'endereco' => 'Rua WW, 4900 - Porto Velho/RO'],
            ['nome' => 'Mariana Costa Santos', 'fantasia' => 'MC Digital', 'documento' => '24455566699', 'endereco' => 'Av XX, 5000 - Boa Vista/RR'],
        ];

        foreach ($clientes as $data) {
            Cliente::firstOrCreate(['documento' => $data['documento']], $data);
        }

        echo "✓ Clientes seeded (50 records)\n";
        echo "\n✅ Database seeding completed!\n";
    }
}
