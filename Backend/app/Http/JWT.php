<?php

class JWT {
    
    private static function getSecret(): string {
        return env('JWT_SECRET', 'default-secret-change-in-production-k8s');
    }
    
    private static function base64UrlEncode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    private static function base64UrlDecode(string $data): string {
        return base64_decode(strtr($data, '-_', '+/'));
    }
    
    /**
     * Generate a JWT token
     */
    public static function encode(array $payload): string {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        // Add expiration if not set (24 hours)
        if (!isset($payload['exp'])) {
            $payload['exp'] = time() + (int)env('JWT_EXPIRATION', 86400);
        }
        
        $payload['iat'] = time();
        
        $headerEncoded = self::base64UrlEncode($header);
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        
        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::getSecret(), true);
        $signatureEncoded = self::base64UrlEncode($signature);
        
        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }
    
    /**
     * Decode and validate a JWT token
     * Returns payload array or null if invalid/expired
     */
    public static function decode(string $token): ?array {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return null;
        }
        
        [$headerEncoded, $payloadEncoded, $signatureEncoded] = $parts;
        
        // Verify signature
        $expectedSignature = self::base64UrlEncode(
            hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::getSecret(), true)
        );
        
        if (!hash_equals($expectedSignature, $signatureEncoded)) {
            return null;
        }
        
        $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);
        
        if (!$payload) {
            return null;
        }
        
        // Check expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null;
        }
        
        return $payload;
    }
    
    /**
     * Get token from request (Authorization header or cookie)
     */
    public static function getTokenFromRequest(): ?string {
        // Check Authorization header
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        
        if (preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
            return $matches[1];
        }
        
        // Check cookie
        if (isset($_COOKIE['auth_token'])) {
            return $_COOKIE['auth_token'];
        }
        
        return null;
    }
    
    /**
     * Get authenticated user from token
     */
    public static function getUser(): ?array {
        $token = self::getTokenFromRequest();
        
        if (!$token) {
            return null;
        }
        
        $payload = self::decode($token);
        
        if (!$payload) {
            return null;
        }
        
        return [
            'id' => $payload['user_id'] ?? null,
            'username' => $payload['username'] ?? null,
            'is_admin' => $payload['is_admin'] ?? false,
        ];
    }
}
