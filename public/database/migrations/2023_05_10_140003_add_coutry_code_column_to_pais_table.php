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
        //remove pais_nome foreign key from empresa e aluno
        Schema::table('empresa', function (Blueprint $table) {
            if(Schema::hasColumn('empresa', 'pais_nome'))
                $table->dropColumn('pais_nome');
        });

        Schema::table('identificacao_aluno', function (Blueprint $table) {
            if(Schema::hasColumn('identificacao_aluno', 'pais_nome'))
                $table->dropColumn('pais_nome');
        });

        Schema::table('pais', function (Blueprint $table) {
            //remove nome col
            if(Schema::hasColumn('pais', 'nome'))
                $table->dropColumn('nome');
            //add coutry code col as primary key
            if(!Schema::hasColumn('pais', 'codigo_iso'))
                $table->string('codigo_iso', 16)->primary();
            if(!Schema::hasColumn('pais', 'codigo_iso'))
                $table->string('codigo_tel', 16)->after('codigo_iso');

        });

        //re add foreign keys but with country_iso
        Schema::table('empresa', function (Blueprint $table) {
            if(!Schema::hasColumn('empresa', 'pais_codigo_iso')){
                $table->string('pais_codigo_iso', 16)->nullable(false);
                $table->foreign('pais_codigo_iso','empresa_fk1')->references('codigo_iso')->on('pais');}
        });

        Schema::table('identificacao_aluno', function (Blueprint $table) {
            if(!Schema::hasColumn('identificacao_aluno', 'pais_codigo_iso')){
                $table->string('pais_codigo_iso', 16)->nullable(false);
                $table->foreign('pais_codigo_iso', 'identificacao_aluno_fk2')->references('codigo_iso')->on('pais');}
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //remove pais_codigo_iso foreign key from empresa e aluno
        Schema::table('empresa', function (Blueprint $table) {
            if(Schema::hasColumn('empresa', 'pais_codigo_iso'))
                $table->dropColumn('pais_codigo_iso');
        });

        Schema::table('identificacao_aluno', function (Blueprint $table) {
            if(Schema::hasColumn('identificacao_aluno', 'pais_codigo_iso'))
                $table->dropColumn('pais_codigo_iso');
        });

        Schema::table('pais', function (Blueprint $table) {
            //add nome col
            if(!Schema::hasColumn('pais', 'nome'))
                $table->string('nome', 64)->primary();
            if(Schema::hasColumn('pais', 'codigo_tel'))
                $table->dropColumn('codigo_tel');
            //rem coutry code col
            if(Schema::hasColumn('pais', 'codigo_iso'))
                $table->dropColumn('codigo_iso');
        });

        //re add foreign keys but with pais_nome
        Schema::table('empresa', function (Blueprint $table) {
            if(!Schema::hasColumn('empresa', 'pais_nome')){
                $table->string('pais_nome', 64)->nullable(false);
                $table->foreign('pais_nome','empresa_fk1')->references('nome')->on('pais');}
        });

        Schema::table('identificacao_aluno', function (Blueprint $table) {
            if(!Schema::hasColumn('identificacao_aluno', 'pais_nome')){
                $table->string('pais_nome', 64)->nullable(false);
                $table->foreign('pais_nome','identificacao_aluno_fk2')->references('nome')->on('pais');}
        });

    }
};
