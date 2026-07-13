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
    blade('login');
});

$router->get('/login', function() {
    if (isAuthenticated()) {
        header('Location: /menu');
        exit;
    }
    blade('login');
});

// Protected Routes
$router->get('/menu', function() {
    requireAuth();
    blade('menu');
});

$router->get('/produtos', function() {
    requireAuth();
    blade('produtos.index');
});

$router->get('/produtos/create', function() {
    requireAuth();
    blade('produtos.form');
});

$router->get('/produtos/edit/{id}', function() {
    requireAuth();
    blade('produtos.form');
});

$router->get('/clientes', function() {
    requireAuth();
    blade('clientes.index');
});

$router->get('/clientes/create', function() {
    requireAuth();
    blade('clientes.form');
});

$router->get('/clientes/edit/{id}', function() {
    requireAuth();
    blade('clientes.form');
});

$router->get('/usuarios', function() {
    requireAuth();
    $user = currentUser();
    if (empty($user['is_admin'])) {
        header('Location: /menu');
        exit;
    }
    blade('usuarios.index');
});

$router->get('/usuarios/create', function() {
    requireAuth();
    $user = currentUser();
    if (empty($user['is_admin'])) {
        header('Location: /menu');
        exit;
    }
    blade('usuarios.form');
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
    blade('change-password');
});
