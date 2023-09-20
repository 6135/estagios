<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const Undef = "Undefined";
    const Admin = "Admin";
    const Gestor = "Gestor";
    const EmpresaColab = "EmpresaColaborador";
    const EmpresaRepLegal = "EmpresaRepresentanteLegal";
    const Aluno = "Aluno";
    const Docente = "Docente";
    const Coordenador = "Coordenador";               

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('papel_utilizador', function (Blueprint $table) {
            //add these items to table if table exists, otherwise do nothing.
            if (Schema::hasTable('papel_utilizador')) {
                DB::table('papel_utilizador')->insert([
                    ['tipo' => self::Undef],
                    ['tipo' => self::Admin],
                    ['tipo' => self::EmpresaColab],
                    ['tipo' => self::EmpresaRepLegal],
                    ['tipo' => self::Aluno],
                    ['tipo' => self::Docente],
                    ['tipo' => self::Coordenador],
                    ['typo' => self::Gestor]
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('papel_utilizador', function (Blueprint $table) {
            //remove these items
            DB::table('papel_utilizador')->whereIn('tipo', [
                self::Undef,
                self::Admin,
                self::EmpresaColab,
                self::EmpresaRepLegal,
                self::Aluno,
                self::Docente,
                self::Coordenador,
            ])->delete();
        });
    }
};
