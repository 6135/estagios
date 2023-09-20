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
        if (!Schema::hasTable('proposta')) {
            Schema::create('proposta', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('titulo', 256);
                $table->string('enquadramento', 4096);
                $table->string('objetivos', 4096);
                $table->string('plano1', 4096);
                $table->string('plano2', 4096);
                $table->string('condicoes', 4096)->nullable();
                $table->string('observacoes', 4096)->nullable();
                $table->boolean('deseja_entrevistas');
                $table->timestamp('created_at');
                $table->string('utilizador_email', 256)->nullable();
                $table->string('nao_aluno_utilizador_email', 256);
                $table->string('representante_nao_aluno_utilizador_email', 256)->nullable();
                $table->string('identificacao_aluno_utilizador_email', 256)->nullable();
                $table->bigInteger('proposta_pai')->nullable();
                $table->bigInteger('edicao_estagio_id');
                $table->string('estado_nome', 64);
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
        Schema::dropIfExists('proposta');
    }
};
