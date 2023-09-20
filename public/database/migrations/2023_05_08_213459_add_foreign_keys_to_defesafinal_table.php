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
        if (Schema::hasTable('defesafinal')) {
            Schema::table('defesafinal', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'defesafinal_fk1')->references(['id'])->on('proposta');
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
        if (Schema::hasTable('defesafinal')) {
            Schema::table('defesafinal', function (Blueprint $table) {
                $table->dropForeign('defesafinal_fk1');
            });
        }
    }
};
