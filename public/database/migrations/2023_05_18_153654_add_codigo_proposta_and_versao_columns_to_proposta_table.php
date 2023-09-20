<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proposta', function (Blueprint $table) {
            //add codigo_proposta
            $table->bigInteger('codigo_proposta')->nullable(true)->unique()->default(null);
            //add versao
            $table->smallInteger('versao')->nullable(false)->default(0);
            //versao de is a foreign key to another proposal

            //drop table versao_proposta
            Schema::dropIfExists('versao_proposta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposta', function (Blueprint $table) {
            //remove codigo_proposta
            $table->dropColumn('codigo_proposta');
            //remove versao
            $table->dropColumn('versao');
            //remove unique constraint

            //create table versao_proposta
            if (!Schema::hasTable('versao_proposta')) {
                Schema::create('versao_proposta', function (Blueprint $table) {
                    $table->increments('versao');
                    $table->bigInteger('proposta_original');
                    $table->bigInteger('versao_id');

                    $table->unique(['versao', 'versao_id'], 'versao_proposta_versao_versao_id_key');
                });
            }
        });
    }
};