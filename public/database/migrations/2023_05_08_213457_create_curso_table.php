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
        if (!Schema::hasTable('curso')) {
            Schema::create('curso', function (Blueprint $table) {
                //add auto increment pk, big integer
                $table->bigIncrements('id');
                $table->string('acronimo', 8);
                $table->smallInteger('ano_criacao');
                $table->string('nome', 128);
                $table->string('descricao', 1024);

                $table->unique(['acronimo', 'ano_criacao'], 'curso_acronimo_ano_criacao_key');
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
        Schema::dropIfExists('curso');
    }
};
