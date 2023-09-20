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
        if (!Schema::hasTable('candidatura')) {
            Schema::create('candidatura', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('ordem');
                $table->smallInteger('perfil_adequado')->nullable();
                $table->timestamp('data');
                $table->string('identificacao_aluno_utilizador_email', 256);
                $table->bigInteger('proposta_id');

                $table->unique(['identificacao_aluno_utilizador_email', 'proposta_id'], 'candidatura_identificacao_aluno_utilizador_email_proposta_i_key');
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
        Schema::dropIfExists('candidatura');
    }
};
