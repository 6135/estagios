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
        if (Schema::hasTable('nao_aluno_proposta')) {
            Schema::table('nao_aluno_proposta', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'nao_aluno_proposta_fk2')->references(['id'])->on('proposta');
                $table->foreign(['nao_aluno_utilizador_email'], 'nao_aluno_proposta_fk1')->references(['utilizador_email'])->on('nao_aluno');
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
        if (Schema::hasTable('nao_aluno_proposta')) {
            Schema::table('nao_aluno_proposta', function (Blueprint $table) {
                $table->dropForeign('nao_aluno_proposta_fk2');
                $table->dropForeign('nao_aluno_proposta_fk1');
            });
        }
    }
};
