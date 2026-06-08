<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['Usuario', 'Senha'];
    protected $hidden = ['Senha'];
}
