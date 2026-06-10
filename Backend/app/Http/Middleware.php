<?php

class Middleware {
    
    public static function auth() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autorizado', 'message' => 'Faça login para acessar este recurso']);
            exit;
        }
    }
    
    public static function guest() {
        if (isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Já está autenticado']);
            exit;
        }
    }
}
