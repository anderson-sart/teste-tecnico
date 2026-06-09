<?php

class Produto extends Model {
    protected $table = 'produtos';
    protected $primaryKey = 'codigo';
    protected $fillable = ['descricao', 'codigo_barras', 'valor_venda', 'peso_bruto', 'peso_liquido'];
}
