<?php

class Request {
    private static $data = null;
    
    public static function all() {
        if (self::$data === null) {
            self::$data = json_decode(file_get_contents('php://input'), true) ?? [];
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
}
