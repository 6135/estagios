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
        if (!Schema::hasTable('empresa')) {
            Schema::create('empresa', function (Blueprint $table) {
                $table->string('nomeempresa', 512);
                $table->string('acronimo', 128)->nullable();
                $table->string('nif', 64)->unique('empresa_nif_key');
                $table->string('morada', 512);
                $table->string('telefone', 64);
                $table->string('url', 128)->nullable()->default('NULL');
                $table->string('atividade', 1024);
                $table->string('pais_nome', 64);
                $table->id();
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
        Schema::dropIfExists('empresa');
    }
};
