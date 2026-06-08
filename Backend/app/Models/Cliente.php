<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Clientes';
    protected $primaryKey = 'Codigo';
    public $timestamps = false;

    protected $fillable = [
        'Nome',
        'Fantasia',
        'Documento',
        'Endereco'
    ];
}
