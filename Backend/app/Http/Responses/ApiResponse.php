<?php

namespace App\Http\Responses;

/**
 * Envelope padronizado para respostas JSON da API.
 *
 * Centraliza a serialização produzindo sempre uma resposta com estrutura
 * consistente e código HTTP explícito.
 *
 * Uso:
 *   return ApiResponse::ok($data);
 *   return ApiResponse::created($data);
 *   return ApiResponse::noContent();
 *   return ApiResponse::error('Mensagem', 400);
 *   return ApiResponse::paginated($paginatedResult);
 */
final class ApiResponse {
    
    private int $status;
    private mixed $data;
    private string $wrap = 'data';
    private array $additional = [];
    private bool $noWrap = false;
    
    private function __construct(mixed $data, int $status) {
        $this->data = $data;
        $this->status = $status;
    }
    
    // =========================================================================
    // Named constructors
    // =========================================================================
    
    /**
     * Resposta de sucesso (200)
     */
    public static function ok(mixed $data, int $status = 200): self {
        return new self($data, $status);
    }
    
    /**
     * Resposta de criação (201)
     */
    public static function created(mixed $data = null): self {
        return new self($data, 201);
    }
    
    /**
     * Resposta sem conteúdo (204)
     */
    public static function noContent(): array {
        http_response_code(204);
        return [];
    }
    
    /**
     * Resposta de erro
     */
    public static function error(string $message, int $status = 400, array $errors = []): self {
        $data = ['message' => $message];
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        $instance = new self($data, $status);
        $instance->noWrap = true;
        return $instance;
    }
    
    /**
     * Resposta não encontrada (404)
     */
    public static function notFound(string $message = 'Recurso não encontrado'): self {
        return self::error($message, 404);
    }
    
    /**
     * Resposta não autorizado (401)
     */
    public static function unauthorized(string $message = 'Não autorizado'): self {
        return self::error($message, 401);
    }
    
    /**
     * Resposta proibido (403)
     */
    public static function forbidden(string $message = 'Acesso negado'): self {
        return self::error($message, 403);
    }
    
    /**
     * Resposta paginada - preserva a estrutura data + meta
     */
    public static function paginated(array $paginatedResult): self {
        $meta = [
            'total' => $paginatedResult['total'] ?? 0,
            'page' => $paginatedResult['page'] ?? 1,
            'per_page' => $paginatedResult['per_page'] ?? 10,
            'last_page' => $paginatedResult['last_page'] ?? 1,
        ];
        
        $instance = new self($paginatedResult['data'] ?? [], 200);
        $instance->additional = ['meta' => $meta];
        return $instance;
    }
    
    // =========================================================================
    // Fluent modifiers
    // =========================================================================
    
    /**
     * Define a chave de envelope do payload
     */
    public function wrap(string $key = 'data'): self {
        $this->wrap = $key;
        return $this;
    }
    
    /**
     * Remove o envelope do payload
     */
    public function withoutWrap(): self {
        $this->noWrap = true;
        return $this;
    }
    
    /**
     * Adiciona dados extras na raiz do payload JSON
     */
    public function additional(array $additional): self {
        $this->additional = array_merge($this->additional, $additional);
        return $this;
    }
    
    // =========================================================================
    // Serialização
    // =========================================================================
    
    /**
     * Converte para array pronto para json_encode
     * Chamado automaticamente pelo sistema de rotas
     */
    public function toArray(): array {
        http_response_code($this->status);
        
        $payload = $this->resolveData();
        
        if ($this->noWrap) {
            return array_merge($payload, $this->additional);
        }
        
        $result = [$this->wrap => $payload];
        return array_merge($result, $this->additional);
    }
    
    /**
     * Resolve os dados para formato array
     */
    private function resolveData(): mixed {
        $data = $this->data;
        
        if ($data === null) {
            return null;
        }
        
        if (is_object($data) && method_exists($data, 'toArray')) {
            return $data->toArray();
        }
        
        if (is_array($data)) {
            return array_map(function($item) {
                if (is_object($item) && method_exists($item, 'toArray')) {
                    return $item->toArray();
                }
                return $item;
            }, $data);
        }
        
        return $data;
    }
}
