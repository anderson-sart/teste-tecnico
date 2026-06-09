<?php
session_start();

require __DIR__ . '/blade.php';
require __DIR__ . '/router.php';
require __DIR__ . '/database/DB.php';
require __DIR__ . '/app/Http/Request.php';

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
    
    // Load Models
    require_once __DIR__ . '/app/Models/Model.php';
    require_once __DIR__ . '/app/Models/User.php';
    require_once __DIR__ . '/app/Models/Produto.php';
    require_once __DIR__ . '/app/Models/Cliente.php';
    
    // Load Controllers
    require_once __DIR__ . '/app/Http/Controllers/AuthController.php';
    require_once __DIR__ . '/app/Http/Controllers/ProdutoController.php';
    require_once __DIR__ . '/app/Http/Controllers/ClienteController.php';
    
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
