<?php

namespace App\Http;

class Request {
    private static $data = null;
    
    public static function all() {
        if (self::$data === null) {
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            self::$data = self::sanitize($input);
        }
        return self::$data;
    }
    
    public static function input($key, $default = null) {
        $data = self::all();
        return $data[$key] ?? $default;
    }
    
    public static function only($keys) {
        $data = self::all();
        return array_intersect_key($data, array_flip($keys));
    }
    
    public static function except($keys) {
        $data = self::all();
        return array_diff_key($data, array_flip($keys));
    }
    
    public static function has($key) {
        $data = self::all();
        return isset($data[$key]);
    }
    
    /**
     * Get a query string parameter (?key=value)
     */
    public static function query($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    private static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return is_string($data) ? trim($data) : $data;
    }
}
