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
        if (Schema::hasTable('coordenador')) {
            Schema::table('coordenador', function (Blueprint $table) {
                $table->foreign(['nao_aluno_utilizador_email'], 'coordenador_fk1')->references(['utilizador_email'])->on('nao_aluno');
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
        if (Schema::hasTable('coordenador')) {
            Schema::table('coordenador', function (Blueprint $table) {
                $table->dropForeign('coordenador_fk1');
            });
        }
    }
};
