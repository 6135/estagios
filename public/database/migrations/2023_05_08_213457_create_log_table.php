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
        if (!Schema::hasTable('log')) {
            Schema::create('log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ipaddr', 1024)->nullable();
                $table->string('status', 512);
                $table->string('acao', 512);
                $table->text('detalhes')->nullable();
                $table->timestamp('data');
                $table->string('utilizador_email', 256)->nullable();
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
        Schema::dropIfExists('log');
    }
};
