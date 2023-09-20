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
        if (!Schema::hasTable('juri')) {
            Schema::create('juri', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nao_aluno_utilizador_email', 256);
                $table->string('papel_juri_funcao', 512);
                $table->bigInteger('proposta_id');

                $table->unique(['nao_aluno_utilizador_email', 'papel_juri_funcao', 'proposta_id'], 'juri_nao_aluno_utilizador_email_papel_juri_funcao_proposta__key');
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
        Schema::dropIfExists('juri');
    }
};
