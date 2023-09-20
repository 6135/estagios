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
        Schema::table('utilizador', function (Blueprint $table) {
            $table->string('dados_adicionais_hash', 512)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilizador', function (Blueprint $table) {
            $table->dropColumn('dados_adicionais_hash');
        });
    }
};
