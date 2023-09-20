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
        if (Schema::hasTable('empresa')) {
            Schema::table('empresa', function (Blueprint $table) {
                // $table->foreign(['nao_aluno_utilizador_email'], 'empresa_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['pais_nome'], 'empresa_fk1')->references(['nome'])->on('pais');
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
        if (Schema::hasTable('empresa')) {
            Schema::table('empresa', function (Blueprint $table) {
                // $table->dropForeign('empresa_fk2');
                $table->dropForeign('empresa_fk1');
            });
        }
    }
};
