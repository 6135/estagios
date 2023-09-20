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
        if (!Schema::hasTable('defesaintermedia')) {
            Schema::create('defesaintermedia', function (Blueprint $table) {
                $table->string('relatorio', 256)->nullable();
                $table->string('anexo', 256)->nullable();
                $table->timestamp('data')->nullable();
                $table->string('comentarios', 512)->nullable();
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
                $table->bigInteger('proposta_id')->primary();
                $table->string('nao_aluno_utilizador_email', 256)->nullable();
                $table->string('classificacao_designacao', 32)->nullable();
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
        Schema::dropIfExists('defesaintermedia');
    }
};
