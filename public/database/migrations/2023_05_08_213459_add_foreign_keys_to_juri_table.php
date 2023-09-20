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
        if (Schema::hasTable('juri')) {
            Schema::table('juri', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'juri_fk3')->references(['id'])->on('proposta');
                $table->foreign(['papel_juri_funcao'], 'juri_fk2')->references(['funcao'])->on('papel_juri');
                $table->foreign(['nao_aluno_utilizador_email'], 'juri_fk1')->references(['utilizador_email'])->on('nao_aluno');
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
        if (Schema::hasTable('juri')) {
            Schema::table('juri', function (Blueprint $table) {
                $table->dropForeign('juri_fk3');
                $table->dropForeign('juri_fk2');
                $table->dropForeign('juri_fk1');
            });
        }
    }
};
