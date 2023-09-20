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
        //make field versao bigInteger instead of smallInteger
        Schema::table('proposta', function (Blueprint $table) {
            $table->bigInteger('versao')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //reverse
        Schema::table('proposta', function (Blueprint $table) {
            $table->smallInteger('versao')->change();
        });
    }
};
