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
        if (Schema::hasTable('disciplina')) {
            Schema::table('disciplina', function (Blueprint $table) {
                $table->foreign(['curso_id'], 'disciplina_fk1')->references(['id'])->on('curso');
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
        if (Schema::hasTable('disciplina')) {
            Schema::table('disciplina', function (Blueprint $table) {
                $table->dropForeign('disciplina_fk1');
            });
        }
    }
};
