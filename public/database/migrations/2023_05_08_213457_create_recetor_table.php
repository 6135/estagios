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
        if (!Schema::hasTable('recetor')) {
            Schema::create('recetor', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamp('lida')->nullable();
                $table->bigInteger('mensagem_id');
                $table->string('utilizador_email', 256);
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
        Schema::dropIfExists('recetor');
    }
};
