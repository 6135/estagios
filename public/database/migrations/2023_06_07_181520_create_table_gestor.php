<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gestor', function (Blueprint $table) {
            //empresa_id foreign key not null
            $table->bigInteger('empresa_id')->unsigned()->nullable(false);
            $table->string('nao_aluno_utilizador_email', 256)->primary();
            $table->foreign(['nao_aluno_utilizador_email'], 'gestor_fk1')->references(['utilizador_email'])->on('nao_aluno');
            $table->foreign(['empresa_id'], 'gestor_fk2')->references(['id'])->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestor');
    }
};
