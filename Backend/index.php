<?php
// No session needed - using JWT tokens for stateless auth

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
require __DIR__ . '/app/Http/JWT.php';

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
    
    // Load ApiResponse
    require_once __DIR__ . '/app/Http/Responses/ApiResponse.php';
    
    // Load Data classes
    require_once __DIR__ . '/app/Data/Pagination/PaginationInputData.php';
    require_once __DIR__ . '/app/Data/Produto/Input/ProdutoInputData.php';
    require_once __DIR__ . '/app/Data/Produto/Output/ProdutoOutputData.php';
    require_once __DIR__ . '/app/Data/Cliente/Input/ClienteInputData.php';
    require_once __DIR__ . '/app/Data/Cliente/Output/ClienteOutputData.php';
    
    // Load Models
    require_once __DIR__ . '/app/Models/Model.php';
    require_once __DIR__ . '/app/Models/User.php';
    require_once __DIR__ . '/app/Models/Produto.php';
    require_once __DIR__ . '/app/Models/Cliente.php';
    
    // Load UseCases
    require_once __DIR__ . '/app/UseCases/Produto/ListarProdutosUseCase.php';
    require_once __DIR__ . '/app/UseCases/Produto/ShowProdutoUseCase.php';
    require_once __DIR__ . '/app/UseCases/Produto/StoreProdutoUseCase.php';
    require_once __DIR__ . '/app/UseCases/Produto/UpdateProdutoUseCase.php';
    require_once __DIR__ . '/app/UseCases/Produto/DeleteProdutoUseCase.php';
    require_once __DIR__ . '/app/UseCases/Cliente/ListarClientesUseCase.php';
    require_once __DIR__ . '/app/UseCases/Cliente/ShowClienteUseCase.php';
    require_once __DIR__ . '/app/UseCases/Cliente/StoreClienteUseCase.php';
    require_once __DIR__ . '/app/UseCases/Cliente/UpdateClienteUseCase.php';
    require_once __DIR__ . '/app/UseCases/Cliente/DeleteClienteUseCase.php';
    require_once __DIR__ . '/app/UseCases/Stats/GetStatsUseCase.php';
    
    // Load Controllers
    require_once __DIR__ . '/app/Http/Controllers/Controller.php';
    require_once __DIR__ . '/app/Http/Controllers/AuthController.php';
    require_once __DIR__ . '/app/Http/Controllers/ProdutoController.php';
    require_once __DIR__ . '/app/Http/Controllers/ClienteController.php';
    require_once __DIR__ . '/app/Http/Controllers/UserController.php';
    
    // Load Middleware & Validator
    require_once __DIR__ . '/app/Http/Middleware.php';
    require_once __DIR__ . '/app/Http/Validator.php';
    
    // Load API Routes
    $apiPath = str_replace('/api', '', $path);
    require __DIR__ . '/routes/api.php';
    
    $result = $router->dispatch($method, $apiPath);
    
    if ($result !== false) {
        // Handle ApiResponse objects
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
