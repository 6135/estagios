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
        if (Schema::hasTable('especializacao_proposta')) {
            Schema::table('especializacao_proposta', function (Blueprint $table) {
                $table->foreign(['proposta_id'], 'especializacao_proposta_fk2')->references(['id'])->on('proposta');
                $table->foreign(['especializacao_nome'], 'especializacao_proposta_fk1')->references(['nome'])->on('especializacao');
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
        if (Schema::hasTable('especializacao_proposta')) {
            Schema::table('especializacao_proposta', function (Blueprint $table) {
                $table->dropForeign('especializacao_proposta_fk2');
                $table->dropForeign('especializacao_proposta_fk1');
            });
        }
    }
};
