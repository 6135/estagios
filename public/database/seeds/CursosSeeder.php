<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CursosSeeder extends Seeder
{
    const MEI = [
        'nome' => 'Mestrado em Engenharia Informática',
        'acronimo' => 'MEI',
        'ano_criacao' => 2014,
        'descricao' => '',
    ];
    const MDM = [
        'nome' => 'Mestrado em Design e Multimedia',
        'acronimo' => 'MDM',
        'ano_criacao' => 2000,
        'descricao' => ''
    ];
    const MECD = [
        'nome' => 'Mestrado em Engenharia e Ciência de Dados',
        'acronimo' => 'MECD',
        'ano_criacao' => 2000,
        'descricao' => ''
    ];
    const MSE = [
        'nome' => 'Mestrado em Segurança Informática',
        'acronimo' => 'MSE',
        'ano_criacao' => 2000,
        'descricao' => ''
    ];
    const AOR = [
        'nome' => 'Acertar o Rumo',
        'acronimo' => 'AoR',
        'ano_criacao' => 2013,
        'descricao' => ''
    ];
    const CURSOS = [self::MEI, self::MDM, self::MECD, self::MSE, self::AOR];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //check if database has table curso
        if (Schema::hasTable('curso')) {
            //add them to the database if they dont exist
            foreach (self::CURSOS as $curso) {
                if (!DB::table('curso')->where('nome', $curso['nome'])->where('ano_criacao', $curso['ano_criacao'])->exists()) {
                    DB::table('curso')->insert($curso);
                }
            }

        }
    }
}