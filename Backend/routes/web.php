<?php

// Helper function to check authentication via JWT cookie
function isAuthenticated() {
    return JWT::getUser() !== null;
}

// Helper to get current user from JWT
function currentUser() {
    return JWT::getUser();
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

$router->get('/usuarios', function() {
    requireAuth();
    $user = currentUser();
    if (empty($user['is_admin'])) {
        header('Location: /menu');
        exit;
    }
    render('usuarios/index');
});

$router->get('/usuarios/create', function() {
    requireAuth();
    $user = currentUser();
    if (empty($user['is_admin'])) {
        header('Location: /menu');
        exit;
    }
    render('usuarios/form');
});

// Logout
$router->get('/logout', function() {
    setcookie('auth_token', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    header('Location: /');
    exit;
});

$router->get('/change-password', function() {
    requireAuth();
    render('change-password');
});
