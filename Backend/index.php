<?php
session_start();

// Error handling
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function($e) {
    http_response_code(500);
    
    if (str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Erro interno do servidor',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    } else {
        echo '<h1>Erro 500</h1>';
        echo '<p>Ocorreu um erro interno.</p>';
        echo '<pre>' . $e->getMessage() . '</pre>';
        echo '<pre>' . $e->getFile() . ':' . $e->getLine() . '</pre>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
    exit;
});

require __DIR__ . '/app/helpers.php';
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
    require_once __DIR__ . '/app/Http/Controllers/Controller.php';
    require_once __DIR__ . '/app/Http/Controllers/AuthController.php';
    require_once __DIR__ . '/app/Http/Controllers/ProdutoController.php';
    require_once __DIR__ . '/app/Http/Controllers/ClienteController.php';
    
    // Load Middleware & Validator
    require_once __DIR__ . '/app/Http/Middleware.php';
    require_once __DIR__ . '/app/Http/Validator.php';
    
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
