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
        if (!Schema::hasTable('disciplina')) {
            Schema::create('disciplina', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nome', 512)->nullable();
                $table->date('data')->nullable();
                $table->bigInteger('curso_id');

                $table->unique(['data', 'curso_id'], 'disciplina_data_curso_id_key');
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
        Schema::dropIfExists('disciplina');
    }
};
