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
        if (!Schema::hasTable('especializacao')) {
            Schema::create('especializacao', function (Blueprint $table) {
                $table->string('nome', 256)->primary();
                $table->string('descricaocurta', 256)->nullable();
                $table->string('descricao', 512);
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
        Schema::dropIfExists('especializacao');
    }
};
