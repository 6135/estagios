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
        if (Schema::hasTable('mensagem')) {
            Schema::table('mensagem', function (Blueprint $table) {
                $table->foreign(['utilizador_email'], 'mensagem_fk1')->references(['email'])->on('utilizador');
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
        if (Schema::hasTable('mensagem')) {
            Schema::table('mensagem', function (Blueprint $table) {
                $table->dropForeign('mensagem_fk1');
            });
        }
    }
};
