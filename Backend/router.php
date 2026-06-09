<?php

class Router {
    private $routes = [];
    private $context = null;
    
    public function setContext($context) {
        $this->context = $context;
    }
    
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
    }
    
    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
    }
    
    public function dispatch($method, $path) {
        // Exact match
        if (isset($this->routes[$method][$path])) {
            $params = $this->context ? [$this->context] : [];
            return call_user_func_array($this->routes[$method][$path], $params);
        }
        
        // Pattern match (para rotas com parâmetros)
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            $pattern = preg_replace('/\{[a-z]+\}/', '(\d+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                if ($this->context) {
                    array_unshift($matches, $this->context);
                }
                return call_user_func_array($callback, $matches);
            }
        }
        
        return false;
    }
}
