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
        if (!Schema::hasTable('especializacao_proposta')) {
            Schema::create('especializacao_proposta', function (Blueprint $table) {
                $table->string('especializacao_nome', 256);
                $table->bigInteger('proposta_id');

                $table->primary(['especializacao_nome', 'proposta_id']);
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
        Schema::dropIfExists('especializacao_proposta');
    }
};
