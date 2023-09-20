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
        if (Schema::hasTable('visivel')) {
            Schema::table('visivel', function (Blueprint $table) {
                $table->foreign(['edicao_estagio_id'], 'visivel_fk2')->references(['id'])->on('edicao_estagio');
                $table->foreign(['visibilidade_tipo'], 'visivel_fk1')->references(['tipo'])->on('visibilidade');
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
        if (Schema::hasTable('visivel')) {
            Schema::table('visivel', function (Blueprint $table) {
                $table->dropForeign('visivel_fk2');
                $table->dropForeign('visivel_fk1');
            });
        }
    }
};
