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
        if (!Schema::hasTable('edicao_estagio')) {
            Schema::create('edicao_estagio', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('disciplina', 128);
                $table->date('inicio_estagio')->nullable();
                $table->date('fim_estagio')->nullable();
                $table->boolean('ativo')->default(true);
                $table->bigInteger('curso_id');
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
        Schema::dropIfExists('edicao_estagio');
    }
};
