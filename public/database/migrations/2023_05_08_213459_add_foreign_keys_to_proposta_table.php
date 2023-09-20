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
        if (Schema::hasTable('proposta')) {
            Schema::table('proposta', function (Blueprint $table) {
                $table->foreign(['estado_nome'], 'proposta_fk7')->references(['nome'])->on('estado');
                $table->foreign(['edicao_estagio_id'], 'proposta_fk6')->references(['id'])->on('edicao_estagio');
                $table->foreign(['proposta_pai'], 'proposta_fk5')->references(['id'])->on('proposta');
                $table->foreign(['identificacao_aluno_utilizador_email'], 'proposta_fk4')->references(['utilizador_email'])->on('identificacao_aluno');
                $table->foreign(['representante_nao_aluno_utilizador_email'], 'proposta_fk3')->references(['nao_aluno_utilizador_email'])->on('representante');
                $table->foreign(['nao_aluno_utilizador_email'], 'proposta_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['utilizador_email'], 'proposta_fk1')->references(['email'])->on('utilizador');
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
        if (Schema::hasTable('proposta')) {
            Schema::table('proposta', function (Blueprint $table) {
                $table->dropForeign('proposta_fk7');
                $table->dropForeign('proposta_fk6');
                $table->dropForeign('proposta_fk5');
                $table->dropForeign('proposta_fk4');
                $table->dropForeign('proposta_fk3');
                $table->dropForeign('proposta_fk2');
                $table->dropForeign('proposta_fk1');
            });
        }
    }
};
