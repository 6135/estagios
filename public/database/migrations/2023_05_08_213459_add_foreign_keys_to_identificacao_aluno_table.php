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
        if (Schema::hasTable('identificacao_aluno')) {
            Schema::table('identificacao_aluno', function (Blueprint $table) {
                $table->foreign(['utilizador_email'], 'identificacao_aluno_fk4')->references(['email'])->on('utilizador');
                $table->foreign(['curso_id'], 'identificacao_aluno_fk3')->references(['id'])->on('curso');
                $table->foreign(['pais_nome'], 'identificacao_aluno_fk2')->references(['nome'])->on('pais');
                $table->foreign(['documento_tipo'], 'identificacao_aluno_fk1')->references(['tipo'])->on('documento');
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
        if (Schema::hasTable('identificacao_aluno')) {
            Schema::table('identificacao_aluno', function (Blueprint $table) {
                //drop foreign keys if exist
                $table->dropForeign('identificacao_aluno_fk4');
                $table->dropForeign('identificacao_aluno_fk3');
                $table->dropForeign('identificacao_aluno_fk2');
                $table->dropForeign('identificacao_aluno_fk1');
            });
        }
    }
};
