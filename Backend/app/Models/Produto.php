<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'Produtos';
    protected $primaryKey = 'Codigo';
    public $timestamps = false;

    protected $fillable = [
        'Descricao',
        'CodigoBarras',
        'ValorVenda',
        'PesoBruto',
        'PesoLiquido'
    ];

    protected $casts = [
        'ValorVenda' => 'decimal:2',
        'PesoBruto' => 'decimal:3',
        'PesoLiquido' => 'decimal:3',
    ];
}
