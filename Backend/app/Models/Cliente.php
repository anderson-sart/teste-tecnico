<?php

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends EloquentModel {
    use SoftDeletes;

    protected $table      = 'clientes';
    protected $primaryKey = 'codigo';
    protected $fillable   = ['nome', 'fantasia', 'documento', 'endereco'];
    public $timestamps    = true;

    public static array $searchable = ['nome', 'fantasia', 'documento', 'codigo'];
}
