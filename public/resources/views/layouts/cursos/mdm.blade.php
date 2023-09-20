@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')
    <div class="main-page row ">
        <div class="col-md-7 px-0" style="margin-bottom: 5rem">
            <div class="home_page">

                <p class="line-height-geral fwd-600">
                    {{-- {{ $curso->nome_completo }} ({{ $curso->titulo }}) --}}Mestrado em Design e Multimédia (MDM)
                </p><br>

                <p class="line-height-geral">O Mestrado em Design e Multimédia (MDM), forma profissionais especializados na conceção e desenvolvimento de produtos e serviços para os novos media. Para o efeito, alia as práticas do Design com as da Computação, fornecendo formação avançada em design para meios digitais. O MDM destina-se prioritariamente a alunos com uma formação anterior em Design, Informática e Artes.
                    O MDM diferencia-se pela adoção da Programação e pela sua aplicação a domínios como o Design de Comunicação, Design Generativo, Design de Interação, Design de Jogos, Design de Serviços, Design Web, Tipografia e Visualização. Deste modo, potencia-se a formação de profissionais capazes de aliar de forma inovadora a Computação com a prática do Design.</p>

                <p class="line-height-geral">No plano curricular do MDM, os alunos realizam uma Dissertação/Estágio correspondendo a um esforço de 42 ECTS.

                </p><br>

                <p class="line-height-geral fwd-600">Formato da unidade curricular</p><br>

                <ul>
                    <li>
                        <p class="line-height-geral">1º. Semestre –  O trabalho decorre na FCTUC e engloba trabalhos preparatórios da Dissertação. Estão previstas 6h de aulas semanais e mais 10h semanais de dedicação extra-aulas durante este período.</p>
                    </li>
                    <li>
                        <p class="line-height-geral">2º. Semestre –  O trabalho é realizado na FCTUC ou numa Empresa/Instituição, a tempo integral, correspondendo a 40 horas/semanais e um esforço de 30 ECTS, sob orientação de um Docente da FCTUC.  A realização do trabalho na Empresa requer a existência de um elemento habilitado da Empresa/Instituição que possa coadjuvar o Docente da FCTUC na orientação.</p>
                    </li>
                </ul><br>


                <p class="line-height-geral fwd-600">Objectivos da Unidade Curricular:</p><br>

                <p class="line-height-geral">Os alunos devem desenvolver um projecto com a contribuição de decisões conceptuais, técnicas e formais a partir de requisitos do programa por si formulado. Valorizam-se os aspectos de autoria e inovação, a pertinência das soluções metodológicas e a relevância social e cultural das propostas. O programa deverá sempre compreender a escrita de uma dissertação original.</p>
                <p class="line-height-geral">Vemos com o maior interesse a colaboração entre a Universidade e as Empresas/Instituições, pelo que teremos o maior prazer em considerar as vossas eventuais propostas de trabalhos de Dissertação/Estágio para os alunos em questão.</p><br>

                <p class="line-height-geral fwd-600"> Ano Letivo 2023/2024</p><br>

                <p class="line-height-geral">É da responsabilidade de cada aluno verificar se está em condições de se
                    inscrever na unidade curricular de Dissertação/Estágio do curso de 2º. ciclo num determinado ano letivo.
                    A atribuição de uma proposta pelo DEI não constitui por si só uma afirmação sobre a elegibilidade do
                    aluno para realizar essa unidade curricular nesse ano letivo.
                </p>
                <p class="line-height-geral">Todos os alunos em condições de frequentar a unidade curricular de Dissertação/Estágio têm de efectuar a
                    candidatura, aplicando-se também aos alunos já identificados nas propostas.
                </p><br>
                <p class="line-height-geral fwd-600">Regulamentos e Normas</p><br>
                <ul>
                    <li>Minuta do Protocolo de Colaboração entre a UC e a entidade de acolhimento: <a href="https://estagios.dei.uc.pt/site/assets/files/1166/im0427_protocolo_colab_estagios_curriculares_3.pdf">Português</a> | <a href="https://estagios.dei.uc.pt/site/assets/files/1166/im0427_protocolo_colab_estagios_curriculares_-_eng_6.pdf"> Inglês </a></li>
                    <li>Minuta do Acordo de Estágio Curricular: <a href="https://estagios.dei.uc.pt/site/assets/files/1298/acordo_estagio_dei_im0428_vuc_2022_2023.pdf">Português</a> | <a href="https://estagios.dei.uc.pt/site/assets/files/1298/im0428_en_acordo_de_estagio_2022_2023.pdf">Inglês</a></li>
                    <li><a href="https://estagios.dei.uc.pt/site/assets/files/1155/erros_frequentes_de_escrita_v4_2016-11.pdf">Resumo de erros frequentes de escrita</a> (jan2017)</li>
                    <li><a href="https://estagios.dei.uc.pt/site/assets/files/1298/reecomendacoes-estagio-v11_2022.pdf">Recomendações
                            de Funcionamento</a> (versão 11, setembro de 2022 – adaptado do documento elaborado por Edmundo
                        Monteiro)</li>
                </ul><br>
                <p class="line-height-geral fwd-600">Defesas Públicas</p><br>
                <ul> 
                    <li><p class="line-height-geral">Intermédia - jan/fev</p></li>
                    <li><p class="line-height-geral">Defesa Final julho (informação no Inforestudante)</p></li>
                    <li><p class="line-height-geral">Especial setembro (informação no Inforestudante)</p></li>
                </ul>
                <br>
                <p class="line-height-geral fwd-600">Estrutura e <a href="https://git.dei.uc.pt/cnl/thesis-template/repository/archive.zip">template</a></p><br>

                <p class="line-height-geral"><span class="fwd-600">Observações: </span>Para a submissão do relatório/dissertação final em Inforestudante é necessária a inserção do identificador ORCID (<a href="https://orcid.org">orcid.org</a>) | Não há entrega física dos documentos.</p>

            </div>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            @include('layouts.calendar.calendar')

        </div>
    </div>
    <div class="main-page">
        <p>
            {{-- Place table with the courses here for selection --}}
        </p>
        <p>
            {{-- Place table with courses here with students already --}}
        </p>
    </div>
@stop

@section('scripts')


@stop
