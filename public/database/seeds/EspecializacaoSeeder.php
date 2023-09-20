<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EspecializacaoSeeder extends Seeder
{
    const CURSOS = CursosSeeder::CURSOS;
    const ESPECIAL_MEI = [
        [
            'nome' => 'Engenharia de Software',
            'descricaocurta' => 'O programa de Mestrado em Engenharia Informática com especialização em Engenharia de Software fornece conhecimento avançado e competências metodológicas sobre um largo conjunto de áreas e técnicas na interseção entre Engenharia de Software e Ciências da Computação.',
            'descricao' => 'O programa de Mestrado em Engenharia Informática com especialização em Engenharia de Software fornece conhecimento avançado e competências metodológicas sobre um largo conjunto de áreas e técnicas na interseção entre Engenharia de Software e Ciências da Computação.
                            A especialização concentra-se nas competências para gestão eficaz de pessoas, projetos e processos, e para arquitetura, desenho, e construção de sistemas de software de larga escala, com atributos de qualidade estritos.'
        ],
        [
            'nome' => 'Comunicações, serviços e infraestruturas',
            'descricaocurta' => 'O programa de Mestrado em Engenharia Informática com especialização em Comunicações, Serviços e Infraestruturas fornece conhecimento avançado e competências metodológicas sobre um largo conjunto de áreas envolvendo comunicações e serviços de Tecnologias de Informação.',
            'descricao' => 'O programa de Mestrado em Engenharia Informática com especialização em Comunicações, Serviços e Infraestruturas fornece conhecimento avançado e competências metodológicas sobre um largo conjunto de áreas envolvendo comunicações e serviços de Tecnologias de Informação.
            A especialização concentra-se nas competências para o planeamento, concepção, operação e gestão de infraestruturas e serviços de Tecnologias de Informação, onde estão incluídos os sistemas de comunicação, as infraestruturas de computação (data centres) e os serviços telemáticos, assentando sobre arquiteturas interoperáveis, seguras, fiáveis e escaláveis.'
        ],
        [
            'nome' => 'Sistemas Inteligentes',
            'descricaocurta' => 'O programa de Mestrado em Engenharia Informática com especialização em Sistemas Inteligentes fornece conhecimento e competências práticas sobre um largo conjunto de áreas e técnicas dentro da Inteligência Artificial e Ciências da Computação.
            As competências essenciais adquiridas abrangem técnicas e conceitos fundamentais em Inteligência Artificial, incluindo um largo conjunto de tópicos, tais como:',
            'descricao' => 'O programa de Mestrado em Engenharia Informática com especialização em Sistemas Inteligentes fornece conhecimento e competências práticas sobre um largo conjunto de áreas e técnicas dentro da Inteligência Artificial e Ciências da Computação.
            As competências essenciais adquiridas abrangem técnicas e conceitos fundamentais em Inteligência Artificial.'
        ],
        [
            'nome' => 'Sistemas de Informação',
            'descricaocurta' => 'O programa de Mestrado em Engenharia Informática com especialização em Sistemas de Informação fornece competências metodológicas bem fundamentadas na interseção entre ciências da computação, computação em nuvem, modelação empresarial, e negócio.
            O programa concentra-se nas competências em modelação, análise, implementação e gestão de sistemas de informação.',
            'descricao' => 'O programa de Mestrado em Engenharia Informática com especialização em Sistemas de Informação fornece competências metodológicas bem fundamentadas na interseção entre ciências da computação, computação em nuvem, modelação empresarial, e negócio.
            O programa concentra-se nas competências em modelação, análise, implementação e gestão de sistemas de informação.'
        ]
    ];

    const ESPECIAL_MDM = [
        [
            'nome' => 'Design Comuputacional',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Design de Interação',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Design Gráfico',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Web Design',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Visualização de Informação',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Design de Som',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Design de Jogos',
            'descricao' => 'Placeholder'
        ],
        [
            'nome' => 'Media Art',
            'descricao' => 'Placeholder'
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Schema::hasTable('especializacao')) {
            //add them to the database if they dont exist
            $mei = DB::table('curso')->where('acronimo', CursosSeeder::MEI['acronimo'])->where('ano_criacao', CursosSeeder::MEI['ano_criacao'])->first();
            $mdm = DB::table('curso')->where('acronimo', CursosSeeder::MDM['acronimo'])->where('ano_criacao', CursosSeeder::MDM['ano_criacao'])->first();

            foreach (self::ESPECIAL_MEI as $especializacao) {
                if (!DB::table('especializacao')->where('nome', $especializacao['nome'])->where('curso_id', $mei->id)->exists()) {
                    DB::table('especializacao')->insert([
                        'nome' => $especializacao['nome'],
                        'descricaocurta' => $especializacao['descricaocurta'],
                        'descricao' => $especializacao['descricao'],
                        'curso_id' => $mei->id
                    ]);
                }
            }
            foreach (self::ESPECIAL_MDM as $especializacao) {
                if (!DB::table('especializacao')->where('nome', $especializacao['nome'])->where('curso_id', $mdm->id)->exists()) {
                    DB::table('especializacao')->insert([
                        'nome' => $especializacao['nome'],
                        'descricao' => $especializacao['descricao'],
                        'curso_id' => $mdm->id
                    ]);
                }
            }

        }
    }
}