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
        if (Schema::hasTable('defesaintermedia')) {
            Schema::table('defesaintermedia', function (Blueprint $table) {
                $table->foreign(['classificacao_designacao'], 'defesaintermedia_fk3')->references(['designacao'])->on('classificacao');
                $table->foreign(['nao_aluno_utilizador_email'], 'defesaintermedia_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['proposta_id'], 'defesaintermedia_fk1')->references(['id'])->on('proposta');
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
        if (Schema::hasTable('defesaintermedia')) {
            Schema::table('defesaintermedia', function (Blueprint $table) {
                $table->dropForeign('defesaintermedia_fk3');
                $table->dropForeign('defesaintermedia_fk2');
                $table->dropForeign('defesaintermedia_fk1');
            });
        }
    }
};
