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
        if (!Schema::hasTable('identificacao_aluno')) {
            Schema::create('identificacao_aluno', function (Blueprint $table) {
                $table->string('documento_id', 512);
                $table->date('validade');
                $table->bigInteger('aluno_numaluno')->nullable()->unique('identificacao_aluno_aluno_numaluno_key');
                $table->smallInteger('aluno_medialicenciatura');
                $table->decimal('aluno_mediamestrado', 5, 3);
                $table->string('aluno_cv', 256);
                $table->string('aluno_telefone', 512);
                $table->string('aluno_morada', 1024);
                $table->string('aluno_identificacao_id', 128);
                $table->date('aluno_validade');
                $table->string('documento_tipo', 128);
                $table->string('pais_nome', 64);
                $table->bigInteger('curso_id');
                $table->string('utilizador_email', 256)->primary();

                $table->unique(['documento_id', 'validade'], 'identificacao_aluno_documento_id_validade_key');
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
        Schema::dropIfExists('identificacao_aluno');
    }
};
