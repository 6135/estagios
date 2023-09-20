@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')
    <div class="main-page row ">
        <div class="col-md-7 px-0" style="margin-bottom: 5rem">
            <div class="home_page">

                <p class="line-height-geral fwd-600">
                    Acertar o Rumo (AoR)</p><br>

                <p class="line-height-geral">O Curso de Formação “Acertar o Rumo – Programação em Java” desenvolve
                    competências técnicas de programação em Java com uma abordagem que engloba formação teórica de base e
                    forte componente prática em técnicas de programação.

                    <br><br>O Curso é um programa formativo que inclui: <br>
                <ul>
                    <li>Uma fase letiva em contexto de sala que decorre no Departamento de Engenharia Informática (DEI) da
                        Universidade de Coimbra;</li>

                    <li>Um Estágio remunerado em contexto de trabalho numa das empresas parceiras para alunos com média da
                        fase letiva igual ou superior a 14 valores e que sejam aceites pelas mesmas ou um estágio não
                        remunerado a realizar no DEI nos outros casos.</li>
                </ul>
                </p><br>
                <p class="line-height-geral">O estágio é anual e pode ser realizado numa empresa, sendo este orientado pelos
                    responsáveis da entidade acolhedora, com acompanhamento de um professor do lado da Universidade de
                    Coimbra, ou na UC, onde também terá acompanhamento por um professor da UC.
                <p>

                <p class="line-height-geral">Os alunos com média de 14 valores, ou superior, no primeiro ano, podem ter
                    acesso a um estágio
                    remunerado em empresa, exceto se não forem aceites pela empresa ou não houver oferta suficiente de
                    estágios por parte das empresas aderentes. Os alunos também podem encontrar por si um estágio numa
                    empresa, a aprovar pela coordenação do curso, ou frequentar o estágio na UC.</p>

                <p class="line-height-geral">Os alunos com média inferior a 14 valores apenas têm acesso a um estágio
                    remunerado se houver lugares
                    sobrantes, podendo sempre seguir também uma das últimas duas alternativas.</p>

                <p class="line-height-geral">As empresas parceiras do programa ou o DEI integram os formandos nas suas
                    equipas para treino e formação
                    on-the-job, em projetos reais, por 12 meses.</p>

                <p class="line-height-geral">O Júri é nomeado pela coordenação do curso. A classificação é quantitativa na
                    escala de 0 a 20.</p>
                </p><br>



                <p class="line-height-geral fwd-600">Objectivos da Unidade Curricular:</p><br>

                <p class="line-height-geral">Os estágios deverão visar o exercício de:
                </p>

                <ul>
                    <li>
                        <p class="line-height-geral">Aplicar os conceitos aprendidos nas restantes unidades curriculares no
                            contexto particular de trabalho numa empresa de software ou na Universidade.</p>
                    </li>
                    <li>
                        <p class="line-height-geral">Escrita de um documento final com os resultados obtidos durante o
                            período de esstágio.</p>
                    </li>
                    <li>
                        <p class="line-height-geral">Apresentação e discussão do trabalho efetuado.</p>
                    </li>
                    <li>
                        <p class="line-height-geral">Como competências genéricas realçam-se: capacidade de análise, síntese;
                            organização e planificação; resolução de problemas; aprendizagem autónoma; adaptabilidade a
                            novas situações; criatividade; preocupação com a qualidade e com desenvolvimento sustentado.</p>
                    </li>


                </ul><br>

                <p class="line-height-geral">Vemos com o maior interesse a colaboração entre a Universidade e as Empresas ou
                    outras Instituições, pelo que teremos o maior prazer em considerar as vossas eventuais propostas de
                    trabalhos de Dissertação/Estágio para os alunos em questão.</p><br>

                <p class="line-height-geral fwd-600"> Ano Letivo 2023/2024</p><br>

                <p class="line-height-geral fwd-600">Regulamentos e Normas</p><br>
                <ul>
                    <li>Minuta do Protocolo de Colaboração entre a UC e a entidade de acolhimento: <a href="#">Português</a></li>
                    <li>Minuta do Acordo de Estágio Curricular: <a href="#">Português</a></li>
                </ul><br>
                <p class="line-height-geral fwd-600">Defesas Públicas</p><br>
                <ul>
                    <li>
                        <p class="line-height-geral">Intermédia - jan/fev</p>
                    </li>
                    <li>
                        <p class="line-height-geral">Defesa Final julho (informação no Inforestudante)</p>
                    </li>
                </ul>
                <br>
                <p class="line-height-geral fwd-600">Estrutura e <a
                        href="https://www.uc.pt/identidadevisual/">template</a></p><br>

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
