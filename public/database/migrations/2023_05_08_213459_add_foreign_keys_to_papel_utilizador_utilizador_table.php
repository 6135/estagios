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
        if (Schema::hasTable('papel_utilizador_utilizador')) {
            Schema::table('papel_utilizador_utilizador', function (Blueprint $table) {
                $table->foreign(['utilizador_email'], 'papel_utilizador_utilizador_fk2')->references(['email'])->on('utilizador');
                $table->foreign(['papel_utilizador_tipo'], 'papel_utilizador_utilizador_fk1')->references(['tipo'])->on('papel_utilizador');
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
        if (Schema::hasTable('papel_utilizador_utilizador')) {
            Schema::table('papel_utilizador_utilizador', function (Blueprint $table) {
                $table->dropForeign('papel_utilizador_utilizador_fk2');
                $table->dropForeign('papel_utilizador_utilizador_fk1');
            });
        }
    }
};
