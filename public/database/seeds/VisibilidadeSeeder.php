<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class VisibilidadeSeeder extends Seeder
{
    /**
     * showjury
     * show_data_defesa_intermedia_alunos
     * show_data_defesa_final_alunos
     * show_atrib_orientadores_alunos
     * show_estagio_atrib_alunos => this one already exists as the date for the publishing of the final and provisional list of students allocation to internships
     * show_data_defesa_intermedia_docentes
     * show_data_defesa_final_docentes
     * show_atrib_orientadores_docentes
     * show_estagio_atrib_docentes
     * 
     */
    const visbilidade_tipo = [
        'showjury',
        'show_data_defesa_intermedia_alunos',
        'show_data_defesa_final_alunos',
        'show_atrib_orientadores_alunos',
        // 'show_estagio_atrib_alunos',
        'show_data_defesa_intermedia_docentes',
        'show_data_defesa_final_docentes',
        'show_atrib_orientadores_docentes',
        'show_estagio_atrib_docentes'


    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add the fields above to the database, events table, if they don't exist
        if(Schema::hasTable('visibilidade')){
            foreach (self::visbilidade_tipo as $visibilidade) {
                if(!DB::table('visibilidade')->where('tipo', $visibilidade)->exists()){
                    DB::table('visibilidade')->insert([
                        'tipo' => $visibilidade
                    ]);
                }
            }
        }
    }
}
