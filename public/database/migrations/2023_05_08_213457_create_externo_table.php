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
        if (!Schema::hasTable('externo')) {
            Schema::create('externo', function (Blueprint $table) {
                $table->bigInteger('instituicao_nome');
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
        Schema::dropIfExists('externo');
    }
};
