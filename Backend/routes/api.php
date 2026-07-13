<?php

// Middleware de autenticação
function requireAuth() {
    Middleware::auth();
}

// Health Check (para Kubernetes liveness/readiness probes)
$router->get('/health', function() {
    try {
        $pdo = DB::connection();
        $pdo->query('SELECT 1');
        return ApiResponse::ok([
            'status' => 'healthy',
            'database' => 'connected',
            'timestamp' => date('c'),
        ])->withoutWrap();
    } catch (Exception $e) {
        http_response_code(503);
        return ['status' => 'unhealthy', 'database' => 'disconnected'];
    }
});

// Auth Routes
$router->post('/login', function() {
    $controller = new AuthController();
    return $controller->login();
});

$router->post('/logout', function() {
    requireAuth();
    $controller = new AuthController();
    return $controller->logout();
});

$router->post('/change-password', function() {
    requireAuth();
    $controller = new AuthController();
    return $controller->changePassword();
});

// Produto Routes (Protegidas)
$router->get('/produtos', function() {
    requireAuth();
    $controller = new ProdutoController();
    return $controller->index();
});

$router->get('/produtos/{id}', function($id) {
    requireAuth();
    $controller = new ProdutoController();
    return $controller->show($id);
});

$router->post('/produtos', function() {
    requireAuth();
    $controller = new ProdutoController();
    return $controller->store();
});

$router->put('/produtos/{id}', function($id) {
    requireAuth();
    $controller = new ProdutoController();
    return $controller->update($id);
});

$router->delete('/produtos/{id}', function($id) {
    requireAuth();
    $controller = new ProdutoController();
    return $controller->destroy($id);
});

// Cliente Routes (Protegidas)
$router->get('/clientes', function() {
    requireAuth();
    $controller = new ClienteController();
    return $controller->index();
});

$router->get('/clientes/{id}', function($id) {
    requireAuth();
    $controller = new ClienteController();
    return $controller->show($id);
});

$router->post('/clientes', function() {
    requireAuth();
    $controller = new ClienteController();
    return $controller->store();
});

$router->put('/clientes/{id}', function($id) {
    requireAuth();
    $controller = new ClienteController();
    return $controller->update($id);
});

$router->delete('/clientes/{id}', function($id) {
    requireAuth();
    $controller = new ClienteController();
    return $controller->destroy($id);
});

// User Routes (Protegidas)
$router->get('/users', function() {
    requireAuth();
    $controller = new UserController();
    return $controller->index();
});

$router->post('/users', function() {
    requireAuth();
    $controller = new UserController();
    return $controller->store();
});

$router->delete('/users/{id}', function($id) {
    requireAuth();
    $controller = new UserController();
    return $controller->destroy($id);
});

// Stats Route (Dashboard)
$router->get('/stats', function() {
    requireAuth();
    $useCase = new GetStatsUseCase();
    return ApiResponse::ok($useCase->execute())->withoutWrap();
});
