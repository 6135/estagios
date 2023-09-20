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
        if (Schema::hasTable('externo')) {
            Schema::table('externo', function (Blueprint $table) {
                $table->foreign(['nao_aluno_utilizador_email'], 'externo_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['instituicao_nome'], 'externo_fk1')->references(['nome'])->on('instituicao');
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
        if (Schema::hasTable('externo')) {
            Schema::table('externo', function (Blueprint $table) {
                $table->dropForeign('externo_fk2');
                $table->dropForeign('externo_fk1');
            });
        }
    }
};
