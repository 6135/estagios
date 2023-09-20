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
        if (Schema::hasTable('duracao')) {
            Schema::table('duracao', function (Blueprint $table) {
                $table->foreign(['evento_tipo'], 'duracao_fk2')->references(['tipo'])->on('evento');
                $table->foreign(['edicao_estagio_id'], 'duracao_fk1')->references(['id'])->on('edicao_estagio');
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
        if (Schema::hasTable('duracao')) {
            Schema::table('duracao', function (Blueprint $table) {
                $table->dropForeign('duracao_fk2');
                $table->dropForeign('duracao_fk1');
            });
        }
    }
};
