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
        //drop foreign key in duracao table
        Schema::table('duracao', function (Blueprint $table) {
            $table->dropColumn('evento_tipo');
        });


        Schema::table('evento', function (Blueprint $table) {
            //change tipo column to varchar 512, primary key
            $table->dropPrimary('tipo');
            $table->string('tipo', 512)->primary()->change();

        });

        //re add foreign key in duracao table
        Schema::table('duracao', function (Blueprint $table) {
            $table->string('evento_tipo', 512)->nullable(false);
            $table->foreign('evento_tipo','duracao_fk2')->references('tipo')->on('evento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop foreign key in duracao table
        Schema::table('duracao', function (Blueprint $table) {
            $table->dropColumn('evento_tipo');
        });

        //drop table evento
        Schema::dropIfExists('evento');
        if (!Schema::hasTable('evento')) {
            Schema::create('evento', function (Blueprint $table) {
                $table->bigInteger('tipo')->primary();
            });
        }

        //re add foreign key in duracao table
        Schema::table('duracao', function (Blueprint $table) {
            $table->bigInteger('evento_tipo')->nullable(false);
            $table->foreign('evento_tipo','duracao_fk2')->references('tipo')->on('evento')->onDelete('cascade');
        });
    }
};
