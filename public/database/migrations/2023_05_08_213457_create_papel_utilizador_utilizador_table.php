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
        if (!Schema::hasTable('papel_utilizador_utilizador')) {
            Schema::create('papel_utilizador_utilizador', function (Blueprint $table) {
                $table->string('papel_utilizador_tipo', 512);
                $table->string('utilizador_email', 256);

                $table->primary(['papel_utilizador_tipo', 'utilizador_email']);
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
        Schema::dropIfExists('papel_utilizador_utilizador');
    }
};
