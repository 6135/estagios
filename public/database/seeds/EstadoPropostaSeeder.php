<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoPropostaSeeder extends Seeder
{
    
	const ESTADOS = [
		"1" => array(
			'text' => "Novo",
			'colour' => '#666666',
			'badge' => 'secondary'
		),
		"2" => array(
			'text' => "Aguarda revisão da coordenação de curso",
			'colour' => '#ffc700',
			'badge' => 'warning'
		),
		"3" => array(
			'text' => "Aprovado",
			'colour' => 'green',
			'badge' => 'success'
		),
		"4" => array(
			'text' => "Revisto",
			'colour' => '#35a7e0',
			'badge' => 'success'
		),
		"5" => array(
			'text' => "Rejeitado",
			'colour' => 'red',
			'badge' => 'danger'
		),
		"6" => array(
			'text' => "Cancelado",
			'colour' => '#333333',
			'badge' => 'danger'
		)
	];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ESTADOS as $id => $estado) {
			if(!\App\Models\Estado::where('nome', $estado['text'])->exists()){
				\App\Models\Estado::create([
					'nome' => $estado['text'],
					'descricao' => $estado['text'],
					'cor' => $estado['colour'],
				]);
			}
        }
    }
}
