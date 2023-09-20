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
        Schema::table('identificacao_aluno', function (Blueprint $table) {
            //remove aluno_idenficacao_id
            $table->dropColumn('aluno_identificacao_id');
            //delete aluno_validade
            $table->dropColumn('aluno_validade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identificacao_aluno', function (Blueprint $table) {
            //add aluno_idenficacao_id
            $table->string('aluno_identificacao_id')->nullable(false);
            //add aluno_validade
            $table->date('aluno_validade')->nullable(false);
        });
    }
};
