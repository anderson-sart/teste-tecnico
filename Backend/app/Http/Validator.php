<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class Validator {

    private static function factory(): Factory {
        $loader     = new FileLoader(new Filesystem, '');
        $translator = new Translator($loader, 'pt_BR');
        return new Factory($translator);
    }

    public static function validate(array $data, array $rules): void {
        $v = self::factory()->make($data, $rules, self::messages());

        if ($v->fails()) {
            http_response_code(422);
            echo json_encode(['errors' => $v->errors()->toArray()]);
            exit;
        }
    }

    private static function messages(): array {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute não pode ter mais de :max caracteres.',
            'min'      => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'string'   => 'O campo :attribute deve ser texto.',
            'regex'    => 'O campo :attribute possui formato inválido.',
        ];
    }

    // Mantém validações customizadas de CPF/CNPJ e código de barras
    public static function validarCPFCNPJ(string $doc): bool {
        $doc = preg_replace('/\D/', '', $doc);
        return strlen($doc) === 11 ? self::validarCPF($doc) : (strlen($doc) === 14 ? self::validarCNPJ($doc) : false);
    }

    private static function validarCPF(string $cpf): bool {
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }

    private static function validarCNPJ(string $cnpj): bool {
        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) $d += $cnpj[$c] * $b[$c + (13 - $t)];
            $d = ($d % 11 < 2) ? 0 : 11 - ($d % 11);
            if ($cnpj[$c] != $d) return false;
        }
        return true;
    }
}
