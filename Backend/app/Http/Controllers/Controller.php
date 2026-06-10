<?php

abstract class Controller {
    
    protected function json($data, $status = 200) {
        http_response_code($status);
        return $data;
    }
    
    protected function success($data = [], $message = null) {
        $response = ['success' => true];
        if ($message) $response['message'] = $message;
        if (!empty($data)) $response['data'] = $data;
        return $response;
    }
    
    protected function error($message, $status = 400, $errors = []) {
        http_response_code($status);
        $response = ['error' => $message];
        if (!empty($errors)) $response['errors'] = $errors;
        return $response;
    }
    
    protected function notFound($message = 'Recurso não encontrado') {
        return $this->error($message, 404);
    }
    
    protected function unauthorized($message = 'Não autorizado') {
        return $this->error($message, 401);
    }
    
    protected function validateExists($model, $id, $message = 'Recurso não encontrado') {
        $resource = $model::find($id);
        if (!$resource) {
            echo json_encode($this->notFound($message));
            exit;
        }
        return $resource;
    }
}
