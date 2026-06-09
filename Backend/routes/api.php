<?php

// Auth Routes
$router->post('/login', function($pdo) {
    $controller = new AuthController($pdo);
    return $controller->login();
});

$router->post('/logout', function($pdo) {
    $controller = new AuthController($pdo);
    return $controller->logout();
});

// Produto Routes
$router->get('/produtos', function($pdo) {
    $controller = new ProdutoController($pdo);
    return $controller->index();
});

$router->get('/produtos/{id}', function($pdo, $id) {
    $controller = new ProdutoController($pdo);
    return $controller->show($id);
});

$router->post('/produtos', function($pdo) {
    $controller = new ProdutoController($pdo);
    return $controller->store();
});

$router->put('/produtos/{id}', function($pdo, $id) {
    $controller = new ProdutoController($pdo);
    return $controller->update($id);
});

$router->delete('/produtos/{id}', function($pdo, $id) {
    $controller = new ProdutoController($pdo);
    return $controller->destroy($id);
});

// Cliente Routes
$router->get('/clientes', function($pdo) {
    $controller = new ClienteController($pdo);
    return $controller->index();
});

$router->get('/clientes/{id}', function($pdo, $id) {
    $controller = new ClienteController($pdo);
    return $controller->show($id);
});

$router->post('/clientes', function($pdo) {
    $controller = new ClienteController($pdo);
    return $controller->store();
});

$router->put('/clientes/{id}', function($pdo, $id) {
    $controller = new ClienteController($pdo);
    return $controller->update($id);
});

$router->delete('/clientes/{id}', function($pdo, $id) {
    $controller = new ClienteController($pdo);
    return $controller->destroy($id);
});
