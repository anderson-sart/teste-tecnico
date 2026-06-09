<?php
session_start();

require __DIR__ . '/blade.php';
require __DIR__ . '/router.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Initialize Router
$router = new Router();

// Load Web Routes
if (!str_starts_with($path, '/api')) {
    require __DIR__ . '/routes/web.php';
    
    if ($router->dispatch($method, $path) !== false) {
        exit;
    }
}

// API ROUTES
if (str_starts_with($path, '/api')) {
    header('Content-Type: application/json');
    
    // Database connection
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

    // Load Controllers
    require_once __DIR__ . '/app/Http/Controllers/AuthController.php';
    require_once __DIR__ . '/app/Http/Controllers/ProdutoController.php';
    require_once __DIR__ . '/app/Http/Controllers/ClienteController.php';

    // Set PDO context for routes
    $router->setContext($pdo);
    
    // Load API Routes
    $apiPath = str_replace('/api', '', $path);
    require __DIR__ . '/routes/api.php';
    
    $result = $router->dispatch($method, $apiPath);
    
    if ($result !== false) {
        echo json_encode($result);
        exit;
    }
    
    echo json_encode(['error' => 'Route not found']);
    exit;
}
