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
        if (Schema::hasTable('candidatura')) {
            Schema::table('candidatura', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'candidatura_fk2')->references(['id'])->on('proposta');
                $table->foreign(['identificacao_aluno_utilizador_email'], 'candidatura_fk1')->references(['utilizador_email'])->on('identificacao_aluno');
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
        if (Schema::hasTable('candidatura')) {
            Schema::table('candidatura', function (Blueprint $table) {
                $table->dropForeign('candidatura_fk2');
                $table->dropForeign('candidatura_fk1');
            });
        }
    }
};
