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
        if (!Schema::hasTable('mensagem')) {
            Schema::create('mensagem', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('assunto', 256);
                $table->string('mensagem', 4096);
                $table->timestamp('enviada');
                $table->string('utilizador_email', 256)->nullable(true);
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
        Schema::dropIfExists('mensagem');
    }
};
