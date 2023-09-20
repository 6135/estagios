<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Add theses roles to PapelUtilizador if they dont exist
     */
    const ROLES = [
        "Undefined",
        "Admin",
        "Gestor",
        "EmpresaColaborador",
        "EmpresaRepresentanteLegal",
        "Aluno",
        "Docente",
        "Coordenador",
        "GestorPlataforma"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //check if table exists
        if (\Schema::hasTable('papel_utilizador'))
            foreach (self::ROLES as $role)
                if (!\DB::table('papel_utilizador')->where('tipo', $role)->exists())
                    \DB::table('papel_utilizador')->insert([
                        'tipo' => $role,
                    ]);

    }
}