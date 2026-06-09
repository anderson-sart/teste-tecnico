<?php

// Helper function to check authentication
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// Helper function to require authentication
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: /');
        exit;
    }
}

// Public Routes
$router->get('/', function() {
    if (isAuthenticated()) {
        header('Location: /menu');
        exit;
    }
    render('login');
});

$router->get('/login', function() {
    if (isAuthenticated()) {
        header('Location: /menu');
        exit;
    }
    render('login');
});

// Protected Routes
$router->get('/menu', function() {
    requireAuth();
    render('menu');
});

$router->get('/produtos', function() {
    requireAuth();
    render('produtos/index');
});

$router->get('/produtos/create', function() {
    requireAuth();
    render('produtos/form');
});

$router->get('/produtos/edit/{id}', function() {
    requireAuth();
    render('produtos/form');
});

$router->get('/clientes', function() {
    requireAuth();
    render('clientes/index');
});

$router->get('/clientes/create', function() {
    requireAuth();
    render('clientes/form');
});

$router->get('/clientes/edit/{id}', function() {
    requireAuth();
    render('clientes/form');
});

// Logout
$router->get('/logout', function() {
    session_destroy();
    header('Location: /');
});
