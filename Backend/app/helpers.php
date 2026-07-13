<?php

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($value === false || $value === null) return $default;
        switch (strtolower($value)) {
            case 'true': case '(true)': return true;
            case 'false': case '(false)': return false;
            case 'null': case '(null)': return null;
        }
        return $value;
    }
}

if (!function_exists('render')) {
    function render($view, $data = []) {
        extract($data);
        include __DIR__ . "/../resources/views/{$view}.php";
    }
}

if (!function_exists('blade')) {
    function blade($view, $data = []) {
        static $factory = null;
        if ($factory === null) {
            $views    = __DIR__ . '/../resources/views';
            $cache    = __DIR__ . '/../storage/framework/views';
            $files    = new \Illuminate\Filesystem\Filesystem;
            $events   = new \Illuminate\Events\Dispatcher;
            $resolver = new \Illuminate\View\Engines\EngineResolver;
            $compiler = new \Illuminate\View\Compilers\BladeCompiler($files, $cache);
            $resolver->register('blade', fn() => new \Illuminate\View\Engines\CompilerEngine($compiler, $files));
            $resolver->register('php', fn() => new \Illuminate\View\Engines\PhpEngine($files));
            $finder   = new \Illuminate\View\FileViewFinder($files, [$views]);
            $factory  = new \Illuminate\View\Factory($resolver, $finder, $events);
        }
        echo $factory->make($view, $data)->render();
    }
}

if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}

if (!function_exists('auth')) {
    function auth() {
        return \App\Http\JWT::getUser();
    }
}
