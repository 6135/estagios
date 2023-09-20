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
        if (!Schema::hasTable('visivel')) {
            Schema::create('visivel', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('data');
                $table->boolean('aluno')->default(false);
                $table->boolean('nao_aluno')->default(false);
                $table->string('visibilidade_tipo', 512);
                $table->bigInteger('edicao_estagio_id');

                $table->unique(['visibilidade_tipo', 'edicao_estagio_id'], 'visivel_visibilidade_tipo_edicao_estagio_id_key');
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
        Schema::dropIfExists('visivel');
    }
};
