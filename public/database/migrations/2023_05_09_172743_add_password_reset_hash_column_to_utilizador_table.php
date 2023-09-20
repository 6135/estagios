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
            if(!Schema::hasColumn('utilizador', 'password_reset_hash'))
                $table->string('password_reset_hash')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilizador', function (Blueprint $table) {
            if(Schema::hasColumn('utilizador', 'password_reset_hash'))
                $table->dropColumn('password_reset_hash');
        });
    }
};
