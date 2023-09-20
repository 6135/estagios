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
        if (Schema::hasTable('revisao')) {
            Schema::table('revisao', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'revisao_fk2')->references(['id'])->on('proposta');
                $table->foreign(['coordenador_nao_aluno_utilizador_email'], 'revisao_fk1')->references(['nao_aluno_utilizador_email'])->on('coordenador');
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
        if (Schema::hasTable('revisao')) {
            Schema::table('revisao', function (Blueprint $table) {
                $table->dropForeign('revisao_fk2');
                $table->dropForeign('revisao_fk1');
            });
        }
    }
};
