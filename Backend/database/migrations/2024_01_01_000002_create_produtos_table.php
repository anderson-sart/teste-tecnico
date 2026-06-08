<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('codigo');
            $table->string('descricao', 60);
            $table->string('codigo_barras', 14);
            $table->decimal('valor_venda', 10, 2);
            $table->decimal('peso_bruto', 10, 3);
            $table->decimal('peso_liquido', 10, 3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
