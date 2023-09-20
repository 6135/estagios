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
        if (Schema::hasTable('coordenar')) {
            Schema::table('coordenar', function (Blueprint $table) {
                $table->foreign(['coordenador_nao_aluno_utilizador_email'], 'coordenar_fk2')->references(['nao_aluno_utilizador_email'])->on('coordenador');
                $table->foreign(['curso_id'], 'coordenar_fk1')->references(['id'])->on('curso');
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
        if (Schema::hasTable('coordenar')) {
            Schema::table('coordenar', function (Blueprint $table) {
                $table->dropForeign('coordenar_fk2');
                $table->dropForeign('coordenar_fk1');
            });
        }
    }
};
