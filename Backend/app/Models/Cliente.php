<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'nome',
        'fantasia',
        'documento',
        'endereco'
    ];
}
