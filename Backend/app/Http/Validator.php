<?php

class Validator {
    
    public static function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $ruleList = explode('|', $rule);
            
            foreach ($ruleList as $r) {
                // Required
                if ($r === 'required') {
                    if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
                        $errors[$field][] = "O campo $field é obrigatório";
                    }
                }
                
                // Max length
                if (str_starts_with($r, 'max:')) {
                    $max = (int) substr($r, 4);
                    if (isset($data[$field])) {
                        if (is_numeric($data[$field]) && (float)$data[$field] > (float)$max) {
                            $errors[$field][] = "O campo $field não pode ser maior que $max";
                        } elseif (is_string($data[$field]) && strlen($data[$field]) > $max) {
                            $errors[$field][] = "O campo $field não pode ter mais de $max caracteres";
                        }
                    }
                }
                
                // Numeric
                if ($r === 'numeric' && isset($data[$field]) && !is_numeric($data[$field])) {
                    $errors[$field][] = "O campo $field deve ser numérico";
                }
                
                // Barcode (EAN-8, EAN-13, GTIN)
                if ($r === 'barcode' && isset($data[$field]) && !empty($data[$field])) {
                    $barcode = preg_replace('/[^0-9]/', '', $data[$field]);
                    $len = strlen($barcode);
                    if (!in_array($len, [8, 12, 13, 14]) || !preg_match('/^[0-9]+$/', $barcode)) {
                        $errors[$field][] = "O campo $field deve ser um código de barras válido (8, 12, 13 ou 14 dígitos)";
                    }
                }
                
                // CPF/CNPJ
                if ($r === 'cpf_cnpj' && isset($data[$field]) && !empty($data[$field])) {
                    $doc = preg_replace('/[^0-9]/', '', $data[$field]);
                    $len = strlen($doc);
                    
                    if ($len === 11) {
                        // Validar CPF
                        if (!self::validarCPF($doc)) {
                            $errors[$field][] = "O CPF informado é inválido";
                        }
                    } elseif ($len === 14) {
                        // Validar CNPJ
                        if (!self::validarCNPJ($doc)) {
                            $errors[$field][] = "O CNPJ informado é inválido";
                        }
                    } else {
                        $errors[$field][] = "O documento deve ser um CPF (11 dígitos) ou CNPJ (14 dígitos)";
                    }
                }
            }
        }
        
        if (!empty($errors)) {
            http_response_code(422);
            echo json_encode(['errors' => $errors]);
            exit;
        }
    }
    
    private static function validarCPF($cpf) {
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;
        
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }
    
    private static function validarCNPJ($cnpj) {
        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;
        
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $b[$c + (13 - $t)];
            }
            $d = ($d % 11 < 2) ? 0 : 11 - ($d % 11);
            if ($cnpj[$c] != $d) return false;
        }
        return true;
    }
}
