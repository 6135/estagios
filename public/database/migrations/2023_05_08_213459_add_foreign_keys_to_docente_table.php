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
        if (Schema::hasTable('docente')) {
            Schema::table('docente', function (Blueprint $table) {
                $table->foreign(['nao_aluno_utilizador_email'], 'docente_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['especializacao_nome'], 'docente_fk1')->references(['nome'])->on('especializacao');
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
        if (Schema::hasTable('docente')) {
            Schema::table('docente', function (Blueprint $table) {
                $table->dropForeign('docente_fk2');
                $table->dropForeign('docente_fk1');
            });
        }
    }
};
