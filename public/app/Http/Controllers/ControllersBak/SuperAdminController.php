<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Estagio;
use App\UserAccessLog;
use App\EventsSent;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\EmpresaPedidoRegisto;
use DB;

class SuperAdminController extends Controller
{
//     public function __construct()
//     {
//     }

//     //     /su/listaempresasnovas
//     public function listaEmpresasNovas() {
//         $aux = EstatisticasController::estagiosPorCurso();

//         //dd($aux);

//         $listaEmpresasArray = array();

//         $listaEmpresas =  Empresa::all()->where('idempresa', '>', 740)->sortByDesc('idempresa')->toArray();

//         foreach ($listaEmpresas as $empresaDaLista) {
//             $listaEmpresas = DB::select("select count(*) quantidade from estagio where empresa_idempresa=" . $empresaDaLista['idempresa']);

//             $empresaDaLista['zzzzzzzzz'] = 99;
//             $empresaDaLista['numestagios'] = $listaEmpresas[0]->quantidade;
//             $listaEmpresasArray[] = $empresaDaLista;
//         }

//         $listaEmpresas = $listaEmpresasArray;


//         //grafico
//         $estatisticasEsteAno = DB::select("select date(created) dia, count(*) qtd from estagio where created like '2022%' group by dia;");
//         $estatisticasAnoAnterior = DB::select("select date(created) dia, count(*) qtd from estagio where created like '2021%' group by dia;");


//         $begin = new \DateTime( "2021-01-01" );
//         $end   = new \DateTime( "2021-12-31" );

//         $estatisticas = array();

//         for($i = $begin; $i <= $end; $i->modify('+1 day')){
//             //dia a dia
//             $qtdA=0;
//             $qtdB=0;

//             foreach ($estatisticasEsteAno as $eea) {
//                 if(str_contains($eea->dia, $i->format("-m-d"))) {
//                     $qtdA = $eea->qtd;
//                 }
//             }

//             foreach ($estatisticasAnoAnterior as $eaa) {
//                 if(str_contains($eaa->dia, $i->format("-m-d"))) {
//                     $qtdB = $eaa->qtd;
//                 }
//             }

//             if($qtdA!=0 || $qtdB!=0) {
//                 $estatisticas[] = array(
//                     'dia' => $i->format("m-d"),
//                     'anoactual' => $qtdA,
//                     'anoanteior' => $qtdB
//                 );
//             }
//         }

//         //$estatisticas

//         //dd($estatisticas);

//         $dados = array(
//             'dados' => print_r(Empresa::all()->where('idempresa', '>', 740), true),
//             'empresas' => $listaEmpresas,
//             'empresaspr' => EmpresaPedidoRegisto::all()->where('created_at', '>=', '2022-04-28')->toArray(),
//             'estatisticas' => $estatisticas
//         );

//         return view('metronicv510.pages.superadmin.empresas.lista', $dados);
//     }

//     //stats
//     //     /su/stats
//     public function stats() {
//         $aux = EstatisticasController::estagiosPorCurso();

//         $estagiosEsteAno=0;
//         $estagiosAnoAnterior=0;

//         $estagiosEsteAnoAux = EstatisticasController::estagiosPorAno(2022);
//         $estagiosAnoAnteriorAux = EstatisticasController::estagiosPorAno(2021);
//         $estagiosPorCurso = EstatisticasController::estagiosPorCurso(2022);

//         if(sizeof($estagiosEsteAnoAux)==1) {
//             $estagiosEsteAno =$estagiosEsteAnoAux[0]->qtd;
//         }

//         if(sizeof($estagiosAnoAnteriorAux)==1) {
//             $estagiosAnoAnterior =$estagiosAnoAnteriorAux[0]->qtd;
//         }

//         //dd(array($estagiosAnoAnterior,$estagiosEsteAno));

//         //grafico
//         $estatisticasEsteAno = DB::select("select date(created) dia, count(*) qtd from estagio where created like '2022%' group by dia;");
//         $estatisticasAnoAnterior = DB::select("select date(created) dia, count(*) qtd from estagio where created like '2021%' group by dia;");

//         $begin = new \DateTime( "2021-01-01" );
//         $end   = new \DateTime( "2021-12-31" );

//         $estatisticas = array();

//         for($i = $begin; $i <= $end; $i->modify('+1 day')){
//             //dia a dia
//             $qtdA=0;
//             $qtdB=0;

//             foreach ($estatisticasEsteAno as $eea) {
//                 if(str_contains($eea->dia, $i->format("-m-d"))) {
//                     $qtdA = $eea->qtd;
//                 }
//             }

//             foreach ($estatisticasAnoAnterior as $eaa) {
//                 if(str_contains($eaa->dia, $i->format("-m-d"))) {
//                     $qtdB = $eaa->qtd;
//                 }
//             }

//             if($qtdA!=0 || $qtdB!=0) {
//                 $estatisticas[] = array(
//                     'dia' => $i->format("m-d"),
//                     'anoactual' => $qtdA,
//                     'anoanteior' => $qtdB
//                 );
//             }
//         }

//         //$estatisticas

//         //dd($estatisticas);

//         $dados = array(
//             'estatisticas' => $estatisticas,
//             'estagiosanoactual' => $estagiosEsteAno,
//             'estagiosanoanteior' => $estagiosAnoAnterior,
//             'estagiosporcurso' => $estagiosPorCurso,
//         );

//         return view('metronicv510.pages.superadmin.stats', $dados);
//     }

//     public function listaEstagiosEmpresaDetalhe($tipo = 0, $idEmpresa = 0) {
//         if($idEmpresa==0) {
//             //$estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->where('estadoestagio', '<>', '60')->where('estadoestagio', '<>', '20')->get()->sortByDesc('idestagio');//getEstagioEstado
//             if($tipo!=0) {
//                 if($tipo==-1) {
//                     $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->where('cvorientadorempresa', '=', '')->where('estadoestagio', '<>', '60')->where('empresa_idempresa', '<>', '1')->get()->sortByDesc('idestagio');//getEstagioEstado
//                 } else {
//                     $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->where('estadoestagio', '=', $tipo)->get()->sortByDesc('idestagio');//getEstagioEstado
//                 }
//             } else {
//                 $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->get()->sortByDesc('idestagio');//getEstagioEstado
//             }
//         } else {
//             $estagios = Estagio::with('empresa')->where([['empresa_idempresa', '=', $idEmpresa],['idestagio', '>', '4472']])->get()->sortByDesc('idestagio');//getEstagioEstado
//         }

//         if(str_contains($tipo, 'error')) {
//             $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->where('periodo_estagio_idperiodo_estagio', '=', '43')->where('empresa_idempresa', '<>', '1')->get()->sortByDesc('idestagio');//getEstagioEstado
//         }

//         /*foreach ($estagios as $estagio) {
//             echo "<pre>";
//             print_r($estagio->toArray());
//             echo "</pre>";

//             //$estagio->empresaestagio = utf8_encode($estagio->empresaestagio);
//             //$estagio->empresaestagio = utf8_decode($estagio->empresaestagio);
//         }

//         dd();*/

//         //dd($estagios->toArray());
//         //dd($estagios[0]['empresa']);
//         //dd($estagios[0]['empresa']);

//         $estagiosArray = array();

//         $contadores = array(
//             'sem_cv' => 0,
//             'por_submeter' => 0,
//             'aguarda_aprovacao_coordenador' => 0,
//             'aprovado' => 0,
//             'aguarda_revisao_coordenador' => 0,
//             'em_revisao' => 0,
//             'revisto' => 0,
//             'aguarda_rejeicao_coordenador' => 0,
//             'rejeitado' => 0,
//             'cancelado' => 0,
//         );

//         foreach ($estagios as $estagio) {
//             $estagio['estadotext'] = $estagio->estadoestagio . " : " . Helper::getEstagioEstado($estagio->estadoestagio)['text'];

//             $estagio['tituloestagio'] = substr($estagio['tituloestagio'],0, 30);
//             $estagio['empresa']['nomeempresa'] = substr($estagio['empresa']['nomeempresa'],0, 30);
//             $estagio['ptrabalhosestagio'] = substr($estagio['ptrabalhosestagio'],0, 100);
//             $estagio['ptrabalhosestagio2'] = substr($estagio['ptrabalhosestagio2'],0, 100);

//             if($estagio['cvorientadorempresa']=='') {
//                 if($estagio['empresa']['idempresa']==1) {
//                     $estagio['cvorientadorempresa']='--------------';
//                 } else {
//                     $contadores['sem_cv']++;
//                 }
//             }

//             if($estagio->estadoestagio == 10) {
//                 $contadores['por_submeter']++;
//             }
//             if($estagio->estadoestagio == 15) {
//                 $contadores['aguarda_aprovacao_coordenador']++;
//             }
//             if($estagio->estadoestagio == 20) {
//                 $contadores['aprovado']++;
//             }
//             if($estagio->estadoestagio == 25) {
//                 $contadores['aguarda_revisao_coordenador']++;
//             }
//             if($estagio->estadoestagio == 30) {
//                 $contadores['em_revisao']++;
//             }
//             if($estagio->estadoestagio == 40) {
//                 $contadores['revisto']++;
//             }
//             if($estagio->estadoestagio == 45) {
//                 $contadores['aguarda_rejeicao_coordenador']++;
//             }
//             if($estagio->estadoestagio == 50) {
//                 $contadores['rejeitado']++;
//             }
//             if($estagio->estadoestagio == 60) {
//                 $contadores['cancelado']++;
//             }

//             if(str_contains($tipo, 'error')) {
//                 if(sizeof($estagio['opcaoTematica'])==0) {
//                     $estagiosArray[] = $estagio;
//                 }
//             }
//             else {
//                 $estagiosArray[] = $estagio;
//             }

//             //$estagio['empresa']['nomeempresa'] = $estagio['empresa']['nomeempresa'];

//             if($estagio['empresa']['idempresa'] == 144) {
//                 Log::debug($estagio['empresa']['idempresa'] . " " . $estagio['empresa']['nomeempresa']);
//             }
//         }

//         //dd($estagiosArray[0]);

//         $estagios = $estagiosArray;

//         $dados = array(
//             'dados' => print_r(Estagio::all()->where('empresa_idempresa', '=', $idEmpresa), true),
//             'estagios' => $estagios,
//             'contadores' => $contadores
//         );

//         //dd($dados);

//         return view('metronicv510.pages.superadmin.empresas.listaEstagiosDetalhe', $dados);
//     }

//     public function listaEstagiosEmpresaDestaque() {
//         return $this->listaEstagiosEmpresa(0, true);
//     }

//     public function listaEstagiosEmpresa($idEmpresa = 0, $destaque=false) {

//         //dd($idEmpresa);
//         //dd($request->all());

//         Log::debug($idEmpresa);

//         if($idEmpresa==0) {
//             $estagios = Estagio::with('empresa')->where('idestagio', '>', '4472')->get()->sortByDesc('idestagio');//getEstagioEstado
//             //$estagios = Estagio::with('empresa')->get();
//             //$estagios = Estagio::all()->where('idestagio', '>', '4472')->sortByDesc('idestagio');//getEstagioEstado
//         } else {
//             //$estagios = Estagio::all()->where('empresa_idempresa', '=', $idEmpresa)->sortByDesc('idestagio');//getEstagioEstado
//             //$estagios = Estagio::with('empresa')->where('empresa_idempresa', '=', $idEmpresa)->get()->sortByDesc('idestagio');//getEstagioEstado
//             $estagios = Estagio::with('empresa')->where([['empresa_idempresa', '=', $idEmpresa],['idestagio', '>', '4472']])->get()->sortByDesc('idestagio');//getEstagioEstado
//         }

//         if($destaque) {
//             //MEI
//             $estagios = Estagio::with('empresa')->where([['idestagio', '>', '4472'], ['empresa_idempresa', '<>', '1'], ['periodo_estagio_idperiodo_estagio', '=', '43']])->whereIn('estadoestagio', ['10', '15'])->get()->sortByDesc('idestagio');

//             //TODOS
//             //$estagios = Estagio::with('empresa')->where([['idestagio', '>', '4472'], ['empresa_idempresa', '<>', '1']])->whereIn('estadoestagio', ['10', '15'])->get()->sortByDesc('idestagio');
//         }

//         /*$zzz = array();
//         foreach ($estagios as $estagio) {
//             $zzz[] = array(
//                 'idestagio' => $estagio['idestagio'],
//                 'estadoestagio' => $estagio['estadoestagio'],
//             );
//         }

//         dd($zzz);*/
//         //dd($estagios->toArray());

//         $estagiosArray = array();

//         //dd($estagios->toArray());

//         //echo "<pre>";
//         foreach ($estagios as $estagio) {
//             $estagio['estadotext'] = Helper::getEstagioEstado($estagio->estadoestagio)['text'];
//             $estagiosArray[] = $estagio;
//             //print_r($estagio);
//         }
//         //echo "</pre>";

//         //die();
//         $estagios = $estagiosArray;

//         //dd($estagiosArray);

//         $dados = array(
//             'dados' => print_r(Estagio::all()->where('empresa_idempresa', '=', $idEmpresa), true),
//             'estagios' => $estagios,
//         );

//         if($destaque) {
//             //dd($estagios);
//             return view('metronicv510.pages.superadmin.empresas.listaEstagiosDestaque', $dados);
//         }

//         return view('metronicv510.pages.superadmin.empresas.listaEstagios', $dados);
//     }

//     public function logsaccess() {
//         $useraccesslogs = UserAccessLog::all()->sortByDesc('id')->take(100)->toArray();

//         //dd($logs);

//         $dados = array(
//             'dados' => array(),
//             'estagios' => array(),
//             'empresas' => array(),
//             'useraccesslogs' => $useraccesslogs,
//         );

//         return view('metronicv510.pages.superadmin.logs.access', $dados);
//     }

//     public function chartpr() {
//         return '[{
//                 "country": "Lithuania",
//                 "litres": 50
//             }, {
//                 "country": "Czech Republic",
//                 "litres": 50
//             }]';
//     }

//     //grafico pedidos registos por mes
//     public function chartprmm() {
//         return '[{"year":"2019-01-01","income": 9,"expenses": 5}, {"year": "2020-01-01", "income": 1, "expenses": 7}, {"year": "2022-03-21", "income": 18, "expenses": 7}]';
//         //return response()->json(['name' => 'Abigail', 'state' => 'CA']);

//         $data = array (array (
//             'year' => 'Janeiro',
//             'income' => 23.5,
//             'expenses' => 21.1,
//         ),
//             array (
//                 'year' => 'Fevereiro',
//                 'income' => 26.2,
//                 'expenses' => 30.5,
//             ),
//             array (
//                 'year' => 'Março',
//                 'income' => 30.1,
//                 'expenses' => 34.9,
//             ),
//             array (
//                 'year' => 'Abril',
//                 'income' => 29.5,
//                 'expenses' => 31.1,
//             ),
//             array (
//                 'year' => 'Maio',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Junho',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Julho',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Agosto',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Setembro',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Outubro',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//             ),
//             array (
//                 'year' => 'Novembro',
//                 'income' => 30.6,
//                 'expenses' => 28.2,
//                 'dashLengthLine' => 5,
//             ),
//             array (
//                 'year' => 'Dezembro',
//                 'income' => 34.1,
//                 'expenses' => 32.9,
//                 'dashLengthColumn' => 5,
//                 'alpha' => 0.2,
//                 'additional' => '(projection)',
//             ),
//         );
//         return json_encode($data);
//         //return print_r(json_encode($data), true);
//     }


//     public function eventsGet(Request $request) {
//         /*
//          *
// {
//   "id": 9,
//   "username": "234",
//   "ipAddress": "10.5.0.165",
//   "status": "KO",
//   "details": "",
//   "remember_token": null,
//   "created_at": "2022-01-21 12:23:22",
//   "updated_at": "2022-01-21 12:23:22"
// }
//          *
//          * */

//         if(session()->has('login')) {
//             //Obter id do último enviado
//             $login = session()->get('login');

//             $lastEventId = -1;

//             $event = EventsSent::where('username', $login)->first();

//             if(sizeof($event)==1) {
//                 $lastEventId = $event->lastlogid;
//             } else {
//                 $event = new EventsSent();

//                 //No caso de não existir registo, tem de criar novo
//                 $event->username = $login;
//                 $event->save();
//             }

//             //Obter todos os eventos mais recentes que o último recebido
//             $lastLog = UserAccessLog::where('id', '>', $lastEventId)->first();

//             if(sizeof($lastLog)==1) {
//                 $event->lastlogid = $lastLog->id;
//                 $event->save();

//                 return json_encode(array(
//                     'result' => true,
//                     'message' => 'Username : ' . $lastLog->username . ' Status : ' . $lastLog->details,
//                     'description' => 'Data : ' . $lastLog->created_at . ' IP : ' . $lastLog->ipAddress
//                 ));
//             }

//             return json_encode(array(
//                 'result' => false,
//                 'message' => 'erro desconhecido',
//                 'description' => 'erro desconhecido'
//             ));
//         } else {
//             return json_encode(array(
//                 'result' => false,
//                 'message' => 'sessão inválida',
//                 'description' => 'sessão inválida'
//             ));
//         }
//     }

//     public function listaAlunosCandidatos() {
//         $periodos = DB::select("select * from periodo_estagio where datainicio like '2022%'");

//         foreach ($periodos as $periodo) {
//             $estagios = DB::select("select * from estagio where periodo_estagio_idperiodo_estagio=" . $periodo->idperiodo_estagio);

//             foreach ($estagios as $estagio) {
//                 $candidatos = DB::select("select * from estagio_has_aluno where estagio_idestagio=" . $estagio->idestagio);
//                 $estagio->candidatos = $candidatos;
//             }

//             $periodo->estagios = $estagios;
//         }

//         //dd($periodos);//listaCandidatosAEstagio.blade.php
//         return view('metronicv510.pages.queries.candidaturas.listaCandidatosAEstagio', array('periodos' => $periodos));
//     }

//     public function listaAlunosCandidatosDadosAjax() {
//         header('Content-Type: application/json');
//         header('Access-Control-Allow-Origin: *');
//         header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//         header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

//         //$estagios = DB::select("select idestagio, empresa_idempresa, tituloestagio from estagio where periodo_estagio_idperiodo_estagio in (select idperiodo_estagio from periodo_estagio where datainicio like '2022%' and dev_test=0)");

//         $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->get()->sortByDesc('idestagio');//getEstagioEstado

//         //print_r($estagios->toArray());

//         $records = array();

//         foreach ($estagios as $estagio) {
//             $records[] = array(
//                 "idestagio" => $estagio['idestagio'],
//                 "title" => $estagio['tituloestagio'],
//                 "company" => $estagio['empresa']['nomeempresa'],
//                 "email" => $estagio['empresa']['emailempresa'],
//                 "phone" => $estagio['empresa']['telefoneempresa'],
//             );
//         }

//         $records[] = array(
//             "RecordID" => 1, "FirstName" => "BBBBB", "Satou", "Accountant", "Tokyo", "28th Nov 08", "$162,700"
//         );

//         $data = array(
//             'draw' => 1,
//             'recordsTotal' => 3,
//             'recordsFiltered' => 3,
//             'data' => $records,
//         );

//         return json_encode($data);
//     }

//     public function listaAlunosCandidatoDetalhe() {
//         header('Content-Type: application/json');
//         header('Access-Control-Allow-Origin: *');
//         header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//         header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

//         //$estagios = DB::select("select idestagio, empresa_idempresa, tituloestagio from estagio where periodo_estagio_idperiodo_estagio in (select idperiodo_estagio from periodo_estagio where datainicio like '2022%' and dev_test=0)");

//         $estagios = Estagio::with(['empresa', 'opcaoTematica'])->where('idestagio', '>', '4472')->get()->sortByDesc('idestagio');//getEstagioEstado

//         //print_r($estagios->toArray());

//         $records = array();

//         foreach ($estagios as $estagio) {
//             $records[] = array(
//                 "idestagio" => $estagio['idestagio'],
//                 "title" => $estagio['tituloestagio'],
//                 "company" => $estagio['empresa']['nomeempresa'],
//                 "email" => $estagio['empresa']['emailempresa'],
//                 "phone" => $estagio['empresa']['telefoneempresa'],
//             );
//         }

//         /*$records[] = array(
//             "RecordID" => 1, "FirstName" => "BBBBB", "Satou", "Accountant", "Tokyo", "28th Nov 08", "$162,700"
//         );*/

//         //$data = $records;

//         $data = array(
//             'draw' => 1,
//             'recordsTotal' => 3,
//             'recordsFiltered' => 3,
//             'data' => $records,
//         );

//         //return '{"RecordID":97,"FirstName":"Zeke","LastName":"Woodall","Company":"Wikizz","Email":"zwoodall2o@trellian.com","Phone":"706-661-5835","Status":1,"Type":1,"Orders":[{"OrderID":"55150-117","ShipCountry":"GE","ShipAddress":"3 Jenna Pass","ShipName":"Auer, Towne and Cremin","OrderDate":"6/25/2016","TotalPayment":"$295291.68","Status":4,"Type":3},{"OrderID":"68786-212","ShipCountry":"FR","ShipAddress":"59 Shasta Way","ShipName":"Quigley, Stoltenberg and Hermiston","OrderDate":"10/9/2017","TotalPayment":"$34719.10","Status":5,"Type":1},{"OrderID":"50436-6578","ShipCountry":"MX","ShipAddress":"993 Anzinger Pass","ShipName":"Bruen LLC","OrderDate":"8/16/2017","TotalPayment":"$195900.25","Status":1,"Type":1},{"OrderID":"10578-037","ShipCountry":"MX","ShipAddress":"522 Burning Wood Court","ShipName":"Ondricka, Leffler and Gusikowski","OrderDate":"8/12/2016","TotalPayment":"$1191897.61","Status":4,"Type":1},{"OrderID":"68026-501","ShipCountry":"ID","ShipAddress":"730 Barnett Street","ShipName":"Powlowski and Sons","OrderDate":"9/6/2016","TotalPayment":"$649539.60","Status":1,"Type":1},{"OrderID":"0781-5311","ShipCountry":"PH","ShipAddress":"2476 Scofield Street","ShipName":"Bartoletti Group","OrderDate":"11/23/2017","TotalPayment":"$75470.34","Status":2,"Type":1}]}';
//         return '{"Orders":[{"OrderID":"55150-117","ShipCountry":"GE","ShipAddress":"3 Jenna Pass","ShipName":"Auer, Towne and Cremin","OrderDate":"6/25/2016","TotalPayment":"$295291.68","Status":4,"Type":3},{"OrderID":"68786-212","ShipCountry":"FR","ShipAddress":"59 Shasta Way","ShipName":"Quigley, Stoltenberg and Hermiston","OrderDate":"10/9/2017","TotalPayment":"$34719.10","Status":5,"Type":1},{"OrderID":"50436-6578","ShipCountry":"MX","ShipAddress":"993 Anzinger Pass","ShipName":"Bruen LLC","OrderDate":"8/16/2017","TotalPayment":"$195900.25","Status":1,"Type":1},{"OrderID":"10578-037","ShipCountry":"MX","ShipAddress":"522 Burning Wood Court","ShipName":"Ondricka, Leffler and Gusikowski","OrderDate":"8/12/2016","TotalPayment":"$1191897.61","Status":4,"Type":1},{"OrderID":"68026-501","ShipCountry":"ID","ShipAddress":"730 Barnett Street","ShipName":"Powlowski and Sons","OrderDate":"9/6/2016","TotalPayment":"$649539.60","Status":1,"Type":1},{"OrderID":"0781-5311","ShipCountry":"PH","ShipAddress":"2476 Scofield Street","ShipName":"Bartoletti Group","OrderDate":"11/23/2017","TotalPayment":"$75470.34","Status":2,"Type":1}]}';
//         //return '[{"OrderID":"55150-117","ShipCountry":"GE","ShipAddress":"3 Jenna Pass","ShipName":"Auer, Towne and Cremin","OrderDate":"6/25/2016","TotalPayment":"$295291.68","Status":4,"Type":3},{"OrderID":"68786-212","ShipCountry":"FR","ShipAddress":"59 Shasta Way","ShipName":"Quigley, Stoltenberg and Hermiston","OrderDate":"10/9/2017","TotalPayment":"$34719.10","Status":5,"Type":1},{"OrderID":"50436-6578","ShipCountry":"MX","ShipAddress":"993 Anzinger Pass","ShipName":"Bruen LLC","OrderDate":"8/16/2017","TotalPayment":"$195900.25","Status":1,"Type":1},{"OrderID":"10578-037","ShipCountry":"MX","ShipAddress":"522 Burning Wood Court","ShipName":"Ondricka, Leffler and Gusikowski","OrderDate":"8/12/2016","TotalPayment":"$1191897.61","Status":4,"Type":1},{"OrderID":"68026-501","ShipCountry":"ID","ShipAddress":"730 Barnett Street","ShipName":"Powlowski and Sons","OrderDate":"9/6/2016","TotalPayment":"$649539.60","Status":1,"Type":1},{"OrderID":"0781-5311","ShipCountry":"PH","ShipAddress":"2476 Scofield Street","ShipName":"Bartoletti Group","OrderDate":"11/23/2017","TotalPayment":"$75470.34","Status":2,"Type":1}]';

//         //return json_encode($data);

//         /*return '
//     [{
//       "idestagio": "1",
//       "title": "Tiger Nixon",
//       "company": "System Architect",
//       "email": "$320,800",
//       "phone": "2011/04/25",
//       "Status": "Edinburgh",
//       "Type": "5421"
// }]';

//         return '{
//   "data": [
//     {
//       "idestagio": "1",
//       "title": "Tiger Nixon",
//       "company": "System Architect",
//       "email": "$320,800",
//       "phone": "2011/04/25",
//       "Status": "Edinburgh",
//       "Type": "5421"
//     }
// 	]
// }';*/




//     }
}
