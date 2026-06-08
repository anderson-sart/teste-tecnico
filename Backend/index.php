<?php
require __DIR__ . '/blade.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// VIEW ROUTES
if ($path === '/' || $path === '/login') { render('login'); exit; }
if ($path === '/menu') { render('menu'); exit; }
if ($path === '/produtos') { render('produtos/index'); exit; }
if ($path === '/produtos/create') { render('produtos/form'); exit; }
if (preg_match('#^/produtos/edit/(\d+)$#', $path)) { render('produtos/form'); exit; }
if ($path === '/clientes') { render('clientes/index'); exit; }
if ($path === '/clientes/create') { render('clientes/form'); exit; }
if (preg_match('#^/clientes/edit/(\d+)$#', $path)) { render('clientes/form'); exit; }

// API ROUTES
if (str_starts_with($path, '/api')) {
    header('Content-Type: application/json');
    
    $db_host = getenv('DB_HOST') ?: 'db';
    $db_name = getenv('DB_DATABASE') ?: 'softline_db';
    $db_user = getenv('DB_USERNAME') ?: 'softline_user';
    $db_pass = getenv('DB_PASSWORD') ?: 'softline_pass';

    try {
        $pdo = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }

    $method = $_SERVER['REQUEST_METHOD'];
    $path = str_replace('/api', '', $path);

    // LOGIN
    if ($path === '/login' && $method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$data['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($data['password'], $user['password'])) {
            echo json_encode(['success' => true, 'username' => $user['username']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuário ou senha inválidos']);
        }
        exit;
    }

    // PRODUTOS
    if (preg_match('#^/produtos(/(\d+))?$#', $path, $matches)) {
        $id = $matches[2] ?? null;
        
        if ($method === 'GET' && !$id) {
            $stmt = $pdo->query('SELECT * FROM produtos WHERE deleted_at IS NULL ORDER BY codigo DESC');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        elseif ($method === 'GET' && $id) {
            $stmt = $pdo->prepare('SELECT * FROM produtos WHERE codigo = ? AND deleted_at IS NULL');
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
        elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('INSERT INTO produtos (descricao, codigo_barras, valor_venda, peso_bruto, peso_liquido) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$data['descricao'], $data['codigo_barras'], $data['valor_venda'], $data['peso_bruto'], $data['peso_liquido']]);
            echo json_encode(['codigo' => $pdo->lastInsertId()]);
        }
        elseif ($method === 'PUT' && $id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('UPDATE produtos SET descricao=?, codigo_barras=?, valor_venda=?, peso_bruto=?, peso_liquido=?, updated_at=NOW() WHERE codigo=? AND deleted_at IS NULL');
            $stmt->execute([$data['descricao'], $data['codigo_barras'], $data['valor_venda'], $data['peso_bruto'], $data['peso_liquido'], $id]);
            echo json_encode(['success' => true]);
        }
        elseif ($method === 'DELETE' && $id) {
            $stmt = $pdo->prepare('UPDATE produtos SET deleted_at = NOW() WHERE codigo = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        exit;
    }

    // CLIENTES
    if (preg_match('#^/clientes(/(\d+))?$#', $path, $matches)) {
        $id = $matches[2] ?? null;
        
        if ($method === 'GET' && !$id) {
            $stmt = $pdo->query('SELECT * FROM clientes WHERE deleted_at IS NULL ORDER BY codigo DESC');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        elseif ($method === 'GET' && $id) {
            $stmt = $pdo->prepare('SELECT * FROM clientes WHERE codigo = ? AND deleted_at IS NULL');
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
        elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('INSERT INTO clientes (nome, fantasia, documento, endereco) VALUES (?, ?, ?, ?)');
            $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco']]);
            echo json_encode(['codigo' => $pdo->lastInsertId()]);
        }
        elseif ($method === 'PUT' && $id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('UPDATE clientes SET nome=?, fantasia=?, documento=?, endereco=?, updated_at=NOW() WHERE codigo=? AND deleted_at IS NULL');
            $stmt->execute([$data['nome'], $data['fantasia'], $data['documento'], $data['endereco'], $id]);
            echo json_encode(['success' => true]);
        }
        elseif ($method === 'DELETE' && $id) {
            $stmt = $pdo->prepare('UPDATE clientes SET deleted_at = NOW() WHERE codigo = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        exit;
    }

    echo json_encode(['error' => 'Route not found']);
}
