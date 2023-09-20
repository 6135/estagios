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
        if (!Schema::hasTable('utilizador')) {
            Schema::create('utilizador', function (Blueprint $table) {
                $table->string('email', 256)->primary();
                $table->string('nome', 256);
                $table->string('nome_curto', 128)->nullable();
                $table->boolean('ativo')->default(true);
                $table->string('password_hash', 512)->nullable();
                $table->string('confirmacao_hash', 512)->nullable();
                $table->boolean('confirmacao')->default(false);
                $table->string('ics', 256)->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('utilizador');
    }
};
