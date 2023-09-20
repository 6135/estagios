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
        if (!Schema::hasTable('representante')) {
            Schema::create('representante', function (Blueprint $table) {
                $table->string('cargo', 512);
                $table->string('telefone', 512);
                $table->bigInteger('empresa_id')->unsigned();
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
        Schema::dropIfExists('representante');
    }
};
