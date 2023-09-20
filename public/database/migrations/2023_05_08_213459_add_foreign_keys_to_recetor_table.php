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
        if (Schema::hasTable('recetor')) {
            Schema::table('recetor', function (Blueprint $table) {
                $table->foreign(['utilizador_email'], 'recetor_fk2')->references(['email'])->on('utilizador');
                $table->foreign(['mensagem_id'], 'recetor_fk1')->references(['id'])->on('mensagem');
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
        if (Schema::hasTable('recetor')) {
            Schema::table('recetor', function (Blueprint $table) {
                $table->dropForeign('recetor_fk2');
                $table->dropForeign('recetor_fk1');
            });
        }
    }
};
