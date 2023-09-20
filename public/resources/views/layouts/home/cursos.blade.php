@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')
    <div class="main-page row ">
        <div class="col-md-6 px-0" style="margin-bottom: 5rem">
            <div class="home_page">

                <p class="line-height-geral mb-4 fwd-600">
                    <a class="link" href="{{ route('curso', 'mei') }}">Mestrado em Engenharia Informática (MEI)</a><br>
                </p>
                <p class="line-height-geral mb-4">O Mestrado em Engenharia Informática (MEI) garante formação avançada nas
                    diferentes áreas da Engenharia Informática, preparando os graduados para a liderança, concepção e
                    desenvolvimento de projetos de grande dimensão. Os objetivos do MEI passam por fornecer competências de
                    excelência aos seus alunos em quatro áreas principais de especialização: Comunicações, Serviços e
                    Infraestruturas; Sistemas Inteligentes; Sistemas de Informação; e Engenharia de Software.</p>

                <p class="line-height-geral mb-4 fwd-600">
                    <a class="link" href="{{ route('curso', 'mdm') }}">Mestrado em Design e Multimédia (MDM)</a><br>
                </p>
                <p class="line-height-geral mb-4">O Mestrado em Design e Multimédia (MDM), forma profissionais
                    especializados na conceção e desenvolvimento de produtos e serviços para os novos media. Para o efeito,
                    alia as práticas do Design com as da Computação, fornecendo formação avançada em design para meios
                    digitais. O MDM destina-se prioritariamente a alunos com uma formação anterior em Design, Informática e
                    Artes.</p>

                <p class="line-height-geral mb-4 fwd-600">
                    <a class="link" href="{{ route('curso', 'mecd') }}">Mestrado em Engenharia e Ciência de Dados (MECD)</a><br>

                </p>
                <p class="line-height-geral mb-4">O Mestrado em Ciência de Dados forma profissionais na área da
                    informática/inteligência artificial/aprendizagem computacional com competências específicas para
                    analisar, projetar e implementar serviços e soluções avançadas para a colheita, modelação,
                    armazenamento, gestão e análise de dados (massivos) como recurso relevante para a tomada de decisões
                    baseadas em dados. Cobre necessidades crescentes e transversais nas sociedades modernas, abrangendo
                    setores tão diversos como o comércio eletrónico, a saúde, os transportes, a gestão energética e a
                    indústria.</p>

                <p class="line-height-geral mb-4 fwd-600">
                    <a class="link" href="{{ route('curso', 'msi') }}">Mestrado em Segurança Informática (MSI)</a><br>
                </p>
                <p class="line-height-geral mb-4">O Mestrado em Segurança Informática (MSI) visa dar resposta à procura de
                    profissionais na área de Cibersegurança e às necessidades criadas pelas diretivas europeias e pelos
                    desafios societais relacionados com a segurança e privacidade de empresas e cidadãos. O curso
                    proporciona competências em diversas vertentes relacionadas com esta temática, tais como criptografia,
                    privacidade, comunicações e infraestruturas seguras, segurança de software e aspetos legais de
                    privacidade e cibersegurança.</p>


                <p class="line-height-geral mb-4 fwd-600">
                    <a class="link" href="{{ route('curso', 'aor') }}">Acertar o Rumo (AoR)</a><br>
                </p>
                <p class="line-height-geral mb-4">O Curso de Formação “Acertar o Rumo – Programação em Java” desenvolve
                    competências técnicas de programação em Java com uma abordagem que engloba formação teórica de base e
                    forte componente prática em técnicas de programação.</p>

            </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            <div class="col-sm px-0 " style="margin-bottom: 5rem">
                @include('layouts.home.contacts')
            </div>

        </div>
    </div>
@stop

@section('scripts')


@stop
