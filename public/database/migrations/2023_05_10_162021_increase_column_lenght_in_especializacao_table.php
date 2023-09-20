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
        Schema::table('especializacao', function (Blueprint $table) {
            $table->string('descricao', 1024)->nullable()->change();
            $table->string('descricaocurta', 1024)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('especializacao', function (Blueprint $table) {
            $table->string('descricao', 256)->nullable()->change();
            $table->string('descricaocurta', 512)->nullable()->change();
        });
    }
};
