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
        if (!Schema::hasTable('colaborador')) {
            Schema::create('colaborador', function (Blueprint $table) {
                $table->string('cargo', 128);
                $table->string('telefone', 128);
                $table->boolean('formacao')->nullable();
                $table->integer('anosexperiencia')->nullable();
                $table->string('cv', 64);
                $table->bigInteger('empresa_id')->unsigned();
                $table->string('nao_aluno_utilizador_email', 256)->primary();
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
        Schema::dropIfExists('colaborador');
    }
};
