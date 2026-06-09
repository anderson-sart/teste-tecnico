<?php

// Auth Routes
$router->post('/login', function() {
    $controller = new AuthController();
    return $controller->login();
});

$router->post('/logout', function() {
    $controller = new AuthController();
    return $controller->logout();
});

// Produto Routes
$router->get('/produtos', function() {
    $controller = new ProdutoController();
    return $controller->index();
});

$router->get('/produtos/{id}', function($id) {
    $controller = new ProdutoController();
    return $controller->show($id);
});

$router->post('/produtos', function() {
    $controller = new ProdutoController();
    return $controller->store();
});

$router->put('/produtos/{id}', function($id) {
    $controller = new ProdutoController();
    return $controller->update($id);
});

$router->delete('/produtos/{id}', function($id) {
    $controller = new ProdutoController();
    return $controller->destroy($id);
});

// Cliente Routes
$router->get('/clientes', function() {
    $controller = new ClienteController();
    return $controller->index();
});

$router->get('/clientes/{id}', function($id) {
    $controller = new ClienteController();
    return $controller->show($id);
});

$router->post('/clientes', function() {
    $controller = new ClienteController();
    return $controller->store();
});

$router->put('/clientes/{id}', function($id) {
    $controller = new ClienteController();
    return $controller->update($id);
});

$router->delete('/clientes/{id}', function($id) {
    $controller = new ClienteController();
    return $controller->destroy($id);
});
