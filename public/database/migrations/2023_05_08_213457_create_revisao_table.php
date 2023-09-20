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
        if (!Schema::hasTable('revisao')) {
            Schema::create('revisao', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('motivo', 4096)->nullable();
                $table->timestamp('data')->nullable();
                $table->string('coordenador_nao_aluno_utilizador_email', 256);
                $table->bigInteger('proposta_id');

                $table->unique(['data', 'coordenador_nao_aluno_utilizador_email', 'proposta_id'], 'revisao_data_coordenador_nao_aluno_utilizador_email_propost_key');
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
        Schema::dropIfExists('revisao');
    }
};
