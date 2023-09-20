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
        if (!Schema::hasTable('identificacao_aluno_cadeira')) {
            Schema::create('identificacao_aluno_cadeira', function (Blueprint $table) {
                $table->string('identificacao_aluno_utilizador_email', 256);
                $table->string('cadeira_designacao', 64);

                $table->primary(['identificacao_aluno_utilizador_email', 'cadeira_designacao']);
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
        Schema::dropIfExists('identificacao_aluno_cadeira');
    }
};
