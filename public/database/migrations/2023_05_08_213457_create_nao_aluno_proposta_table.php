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
        if (!Schema::hasTable('nao_aluno_proposta')) {
            Schema::create('nao_aluno_proposta', function (Blueprint $table) {
                $table->string('nao_aluno_utilizador_email', 256);
                $table->bigInteger('proposta_id');

                $table->primary(['nao_aluno_utilizador_email', 'proposta_id']);
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
        Schema::dropIfExists('nao_aluno_proposta');
    }
};
