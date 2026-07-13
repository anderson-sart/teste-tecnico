<?php

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends EloquentModel {
    use SoftDeletes;

    protected $table      = 'produtos';
    protected $primaryKey = 'codigo';
    protected $fillable   = ['descricao', 'codigo_barras', 'valor_venda', 'peso_bruto', 'peso_liquido'];
    public $timestamps    = true;

    public static array $searchable = ['descricao', 'codigo_barras', 'codigo'];
}
