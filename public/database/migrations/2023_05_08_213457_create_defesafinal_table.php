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
        if (!Schema::hasTable('defesafinal')) {
            Schema::create('defesafinal', function (Blueprint $table) {
                $table->string('relatorio', 256)->nullable();
                $table->string('anexos', 256)->nullable();
                $table->timestamp('data')->nullable();
                $table->smallInteger('avaliacao')->nullable();
                $table->string('comentarios', 4096)->nullable();
                $table->timestamps();
                $table->bigInteger('proposta_id')->primary();
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
        Schema::dropIfExists('defesafinal');
    }
};
