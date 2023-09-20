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
        if (Schema::hasTable('identificacao_aluno_cadeira')) {
            Schema::table('identificacao_aluno_cadeira', function (Blueprint $table) {
                $table->foreign(['cadeira_designacao'], 'identificacao_aluno_cadeira_fk2')->references(['designacao'])->on('cadeira');
                $table->foreign(['identificacao_aluno_utilizador_email'], 'identificacao_aluno_cadeira_fk1')->references(['utilizador_email'])->on('identificacao_aluno');
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
        if (Schema::hasTable('identificacao_aluno_cadeira')) {
            Schema::table('identificacao_aluno_cadeira', function (Blueprint $table) {
                $table->dropForeign('identificacao_aluno_cadeira_fk2');
                $table->dropForeign('identificacao_aluno_cadeira_fk1');
            });
        }
    }
};
