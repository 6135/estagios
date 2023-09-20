<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EdicaoEstagioEvents extends Seeder
{
    /**
     * inicio submissao
     * fim submissao
     * inicio avaliacao
     * fim avaliacao
     * inicio revisao
     * fim revisao
     * publicacao propostas
     * dia estagios
     * inicio candidatura
     * fim candidatura
     * inicio consultacv
     * fim consultacv   
     * inicio atribuicao propostas
     * fim atribuicao propostas
     * divulgacao lista provisoria
     * incio reclamacao
     * fim reclamacao
     * divulgacao lista final
     * entrega intermedia
     * entrega final
     * incio estagio
     * fim estagio
     * 
     */
    const event_types = [
        'inicio submissao',
        'fim submissao',
        'inicio avaliacao',
        'fim avaliacao',
        'inicio revisao',
        'fim revisao',
        'publicacao propostas',
        'dia estagios',
        'inicio candidatura',
        'fim candidatura',
        'inicio consultacv',
        'fim consultacv',
        'inicio atribuicao propostas',
        'fim atribuicao propostas',
        'divulgacao lista provisoria',
        'incio reclamacao',
        'fim reclamacao',
        'divulgacao lista final',
        'entrega intermedia',
        'entrega final',
        'incio estagio',
        'fim estagio'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add the fields above to the database, events table, if they don't exist
        if(Schema::hasTable('evento')){
            //add if they dont exist
            foreach(self::event_types as $event){
                if(!DB::table('evento')->where('tipo', $event)->exists()){
                    DB::table('evento')->insert(['tipo' => $event]);
                }
            }
        }

    }
}
