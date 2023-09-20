<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DocumentSeeder extends Seeder
{
    const TIPOS_DOCUMENTO = [
        [
            'tipo' => 'CC'
        ],
        [
            'tipo' => 'BI'
        ],
        [
            'tipo' => 'Passaporte'
        ]

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //if has table
        if (Schema::hasTable('documento')) {
            //add them to the database if they dont exist
            foreach (self::TIPOS_DOCUMENTO as $tipo) {
                if (!DB::table('documento')->where('tipo', $tipo['tipo'])->exists()) {
                    DB::table('documento')->insert($tipo);
                }
            }
        }
    }
}
