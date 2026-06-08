<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'descricao',
        'codigo_barras',
        'valor_venda',
        'peso_bruto',
        'peso_liquido'
    ];

    protected $casts = [
        'valor_venda' => 'decimal:2',
        'peso_bruto' => 'decimal:3',
        'peso_liquido' => 'decimal:3',
    ];
}
