<?php

class Middleware {
    
    public static function auth() {
        $user = JWT::getUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autorizado', 'message' => 'Faça login para acessar este recurso']);
            exit;
        }
    }
    
    public static function guest() {
        $user = JWT::getUser();
        if ($user) {
            http_response_code(403);
            echo json_encode(['error' => 'Já está autenticado']);
            exit;
        }
    }
}
