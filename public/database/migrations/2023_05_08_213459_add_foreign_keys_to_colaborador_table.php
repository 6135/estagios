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
        if (Schema::hasTable('colaborador')) {
            Schema::table('colaborador', function (Blueprint $table) {
                $table->foreign(['nao_aluno_utilizador_email'], 'colaborador_fk2')->references(['utilizador_email'])->on('nao_aluno');
                $table->foreign(['empresa_id'], 'colaborador_fk1')->references(['id'])->on('empresa');
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
        if (Schema::hasTable('colaborador')) {
            Schema::table('colaborador', function (Blueprint $table) {
                $table->dropForeign('colaborador_fk2');
                $table->dropForeign('colaborador_fk1');
            });
        }
    }
};
