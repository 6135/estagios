<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class EstatisticasController extends Controller
{
    public function __construct()
    {
    }

    public static function estagiosPorCurso($ano='') {
        $listaEmpresas = DB::select("select estagio.periodo_estagio_idperiodo_estagio idpe, periodo_estagio.curso, count(*) qtd from estagio, periodo_estagio where estagio.periodo_estagio_idperiodo_estagio=periodo_estagio.idperiodo_estagio and estagio.idestagio>4472 group by estagio.periodo_estagio_idperiodo_estagio;");

        return $listaEmpresas;
    }

    public static function estagiosPorAno($ano) {
        $estagiosAno = DB::select("select year(created) ano, count(*) qtd from estagio where year(created) in (" . $ano . ") group by year(created)");

        return $estagiosAno;
    }
}
