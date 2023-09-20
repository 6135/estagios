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
        if (Schema::hasTable('especializacao')) {
            Schema::table('especializacao', function (Blueprint $table) {
                $table->foreign(['curso_id'], 'especializacao_fk1')->references(['id'])->on('curso');
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
        if (Schema::hasTable('especializacao')) {
            Schema::table('especializacao', function (Blueprint $table) {
                $table->dropForeign('especializacao_fk1');
            });
        }
    }
};
