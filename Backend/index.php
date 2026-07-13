<?php
// No session needed - using JWT tokens for stateless auth

// Error handling
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function($e) {
    http_response_code(500);
    $debug = env('APP_DEBUG', false);

    if (str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
        header('Content-Type: application/json');
        $payload = ['error' => 'Erro interno do servidor'];
        if ($debug) {
            $payload['message'] = $e->getMessage();
            $payload['file']    = $e->getFile();
            $payload['line']    = $e->getLine();
        }
        echo json_encode($payload);
    } else {
        echo '<h1>Erro 500</h1><p>Ocorreu um erro interno.</p>';
        if ($debug) {
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
            echo '<pre>' . htmlspecialchars($e->getFile() . ':' . $e->getLine()) . '</pre>';
            echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        }
    }
    exit;
});

require __DIR__ . '/app/helpers.php';
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/router.php';
require __DIR__ . '/database/DB.php';
require __DIR__ . '/app/Http/Request.php';
require __DIR__ . '/app/Http/JWT.php';

// Boot Eloquent
DB::boot();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

    // Load API Routes
    $apiPath = str_replace('/api', '', $path);
    require __DIR__ . '/routes/api.php';
    
    $result = $router->dispatch($method, $apiPath);
    
    if ($result !== false) {
        if ($result instanceof ApiResponse) {
            echo json_encode($result->toArray());
        } else {
            echo json_encode($result);
        }
        exit;
    }
    
    echo json_encode(['error' => 'Route not found']);
    exit;
}
