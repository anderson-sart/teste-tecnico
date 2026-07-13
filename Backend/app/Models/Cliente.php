<?php

class Cliente extends Model {
    protected $table = 'clientes';
    protected $primaryKey = 'codigo';
    protected $fillable = ['nome', 'fantasia', 'documento', 'endereco'];
    protected $searchable = ['nome', 'fantasia', 'documento', 'codigo'];
}
