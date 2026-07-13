<?php

/**
 * Get environment variable with fallback
 */
function env($key, $default = null) {
    $value = getenv($key);
    
    if ($value === false) {
        return $default;
    }
    
    // Convert string boolean values
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'null':
        case '(null)':
            return null;
    }
    
    return $value;
}

/**
 * Render a view
 */
function render($view, $data = []) {
    extract($data);
    $viewPath = __DIR__ . "/../resources/views/{$view}.php";
    include $viewPath;
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}

/**
 * Get current authenticated user
 */
function auth() {
    return JWT::getUser();
}
