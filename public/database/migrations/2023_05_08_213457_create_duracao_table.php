<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('duracao')) {
            Schema::create('duracao', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('inicio');
                $table->date('fim');
                $table->bigInteger('edicao_estagio_id');
                $table->bigInteger('evento_tipo');

                $table->unique(['edicao_estagio_id', 'evento_tipo'], 'duracao_edicao_estagio_id_evento_tipo_key');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duracao');
    }
};
