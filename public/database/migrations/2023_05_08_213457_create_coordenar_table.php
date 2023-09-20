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
        if (!Schema::hasTable('coordenar')) {
            Schema::create('coordenar', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('data_inicio');
                $table->date('data_fim')->nullable();
                $table->bigInteger('curso_id');
                $table->string('coordenador_nao_aluno_utilizador_email', 256);

                $table->unique(['data_inicio', 'curso_id', 'coordenador_nao_aluno_utilizador_email'], 'coordenar_data_inicio_curso_id_coordenador_nao_aluno_utiliz_key');
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
        Schema::dropIfExists('coordenar');
    }
};
