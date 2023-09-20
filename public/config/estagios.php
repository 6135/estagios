<?php
/*
 * Funciona
 * Para ler variável é necessário:
 *
 *      use Config;
 *
 *      echo config('estagios.url');
 *
 * no final de alterar este ficheiro, é necessáario:
 *
 *      php artisan config:cache
 *
 */

return [
    'debug' => true,
    'siteTitle' => 'Plataforma de Gestão de Estágios',
    'estado' => array(
        "10" => "Novo",
        "20" => "Aprovado",
        "25" => "Revisão Coord",
        "30" => "Em Revisão",
        "40" => "Revisto",
        "45" => "Rejeição Coord",
        "50" => "Rejeitado",
        "60" => "Cancelado"
    ),
    'curso' => array(
        'mdm'   => 'Mestrado em Design e Multimédia',
        'mei'   => 'Mestrado em Engenharia Informática (pré-2014)',
        'mei 20142000'  => 'Mestrado em Engenharia Informática',
        'mecd'  => 'Mestrado em Engenharia e Ciencia de Dados',
        'msi'  => 'Mestrado em Segurança Informática',
    ),
];