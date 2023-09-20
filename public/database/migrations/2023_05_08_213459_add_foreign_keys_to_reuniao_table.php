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
        if (Schema::hasTable('reuniao')) {
            Schema::table('reuniao', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'reuniao_fk1')->references(['id'])->on('proposta');
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
        if (Schema::hasTable('reuniao')) {
            Schema::table('reuniao', function (Blueprint $table) {
                $table->dropForeign('reuniao_fk1');
            });
        }
    }
};
