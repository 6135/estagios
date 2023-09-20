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
        if (Schema::hasTable('gestor_plataforma')) {
            Schema::table('gestor_plataforma', function (Blueprint $table) {
                $table->foreign(['nao_aluno_utilizador_email'], 'gestor_plataforma_fk1')->references(['utilizador_email'])->on('nao_aluno');
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
        if (Schema::hasTable('gestor_plataforma')) {
            Schema::table('gestor_plataforma', function (Blueprint $table) {
                $table->dropForeign('gestor_plataforma_fk1');
            });
        }
    }
};
