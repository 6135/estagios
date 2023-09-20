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
        if (!Schema::hasTable('reuniao')) {
            Schema::create('reuniao', function (Blueprint $table) {
                $table->date('data')->primary();
                $table->string('participantes', 512);
                $table->string('comentarios', 2048);
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
                $table->bigInteger('proposta_id');
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
        Schema::dropIfExists('reuniao');
    }
};
