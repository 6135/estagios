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
        if (Schema::hasTable('edicao_estagio')) {
            Schema::table('edicao_estagio', function (Blueprint $table) {
                $table->foreign(['curso_id'], 'edicao_estagio_fk1')->references(['id'])->on('curso');
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
        if (Schema::hasTable('edicao_estagio')) {
            Schema::table('edicao_estagio', function (Blueprint $table) {
                $table->dropForeign('edicao_estagio_fk1');
            });
        }
    }
};
