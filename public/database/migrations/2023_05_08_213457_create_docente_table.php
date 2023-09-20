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
        if (!Schema::hasTable('docente')) {
            Schema::create('docente', function (Blueprint $table) {
                $table->string('numero_mecanografico', 512)->unique('docente_numero_mecanografico_key');
                $table->string('especializacao_nome', 256)->nullable();
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
        Schema::dropIfExists('docente');
    }
};
