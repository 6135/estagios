<?php

// namespace App\Http\Controllers;

// use App\EstagioAction;
// use App\EstagioPeriodo;
// use App\Helpers\Helper;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;
// use Illuminate\Database\QueryException;
// use App\UserAccessLog;
// use DB;

// class QueriesController extends Controller
// {
//     public function index() {
//         //echo json_encode(['hi' => 'ok']);
//         $actions = EstagioAction::all()->sortByDesc('created')->take(7);
//         $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
//         $estagiosPeriodos = EstagioPeriodo::all()->sortByDesc('descricao');
//         return view('metronicv510.pages.queriesEstagiosRelatorios', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs, 'estagiosPeriodos' => $estagiosPeriodos));
//     }

//     public function dashboard() {
//         /*$actions = EstagioAction::all()->sortByDesc('created')->take(7);
//         $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
//         return view('metronicv510.pages.queriesDashboard', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));*/


//         //Baseado em:
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/widgets/general.html

//         $actions = EstagioAction::all()->sortByDesc('created')->take(7);
//         $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
//         return view('metronicv510.pages.queriesDashboard2', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
//     }

//     public function lastinserted() {
//         //echo json_encode(['hi' => 'lastinserted']);
//         //echo json_encode(echo json_encode(DB::select("select di.created, a.numaluno, a.nomealuno, e.empresaestagio, e.idestagio, e.tituloestagio, pe.curso from aluno a, defesa_intermedia di, estagio e, periodo_estagio pe where e.alunoatribuido=a.emailaluno and di.estagio_idestagio=e.idestagio and pe.idperiodo_estagio=e.periodo_estagio_idperiodo_estagio and di.created>'2021-01-01' and pe.curso like '%MSI%' order by di.iddefesa_intermedia desc"));
//         //echo json_encode(DB::select("select * from aluno limit 5"));
//         //echo json_encode(DB::select("desc aluno"));

//         $alunos = DB::select("select idaluno, nomealuno, numaluno from aluno limit 5");
//         //$alunosEncoded = self::utf8_converter($alunos); //array_map("utf8_decode", $alunos );

//         /*foreach ($alunos as $key => $value) {
//             $value = utf8_encode($value);
//         }*/

//         $res = json_encode($alunos);

//         return $res;
//     }

//     public function dashboardInfo() {
//         $nAlunos = DB::select("select count(*) as counter from aluno");
//         $nRelatoriosProgresso = DB::select("select count(*) as counter from relatorios_progresso");
//         $nReunioesMes = DB::select("select DATE_FORMAT(data, '%Y-%m') as mes, count(*) as qtd from reunioes group by 1 order by 1 desc limit 3");
//         $nEstagiosCurso = DB::select("select pe.idperiodo_estagio, pe.curso, DATE_FORMAT(pe.datainicio, '%Y') as anoinicio, pe.datainicio, pe.datafim, count(*) as counter from periodo_estagio pe, estagio e where pe.idperiodo_estagio=e.periodo_estagio_idperiodo_estagio group by 1 order by 1 desc limit 4");

//         //select pe.idperiodo_estagio, pe.curso, DATE_FORMAT(pe.datainicio, '%Y') as anoinicio, pe.datainicio from periodo_estagio pe where pe.datafim>now();

//         $total = 0;

//         foreach ($nEstagiosCurso as $ec) {
//             $aux = explode(' ', $ec->curso);

//             if(sizeof($aux)==1) {
//                 $ec->curso = $ec->curso . ' ' . $ec->anoinicio . '/' . (intval($ec->anoinicio) + 1);
//             } elseif(sizeof($aux)>1) {
//                 $ec->curso = $aux[0] . ' ' . $ec->anoinicio . '/' . (intval($ec->anoinicio) + 1);
//             }

//             $total = $total + $ec->counter;
//         }

//         foreach ($nEstagiosCurso as $ec) {
//             $ec->percentagem = round($ec->counter/$total*100, 0, PHP_ROUND_HALF_UP);
//         }

//         $res = json_encode(
//             array(
//                 'nalunos' => $nAlunos[0]->counter,
//                 'nrelatoriosp' => $nRelatoriosProgresso[0]->counter,
//                 'nreunioesmes' => $nReunioesMes,
//                 'nestagioscurso' => $nEstagiosCurso,
//             )
//         );

//         return $res;
//     }

//     public function downloadRelatorioProgresso() {
//         $file = public_path() . '/data/esp32_datasheet_en.pdf';

//         //print_r($file);

//         if (file_exists($file)) {
//             header('Content-Description: File Transfer');
//             header('Content-Type: application/octet-stream');
//             header('Content-Disposition: attachment; filename="'.basename($file).'"');
//             header('Expires: 0');
//             header('Cache-Control: must-revalidate');
//             header('Pragma: public');
//             header('Content-Length: ' . filesize($file));
//             readfile($file);
//             exit;
//         }
//     }

//     public function relatoriosProgressoUltimos() {
//         $alunos = DB::select("select * from relatorios_progresso order by created desc limit 20");
//         echo json_encode($alunos);
//     }

//     /*public function quantidadeReunioesUltimosMeses() {
//         $info = DB::select("select DATE_FORMAT(data, '%Y-%m') as mes, count(*) as qtd from reunioes group by 1 order by 1 desc limit 3");
//         echo json_encode($info);
//     }*/

//     public function relatoriosProgressoUltimosComAnexo() {
//         //$alunos = DB::select("select * from relatorios_progresso where anexo<>'' order by created desc limit 10");
//         $alunos = DB::select("select e.alunoatribuido, e.tituloestagio, e.orientadorDEI, rp.* from relatorios_progresso rp, estagio e where e.idestagio=rp.estagio_idestagio and rp.anexo<>'' order by rp.created desc limit 10");
//         echo json_encode($alunos);
//     }

//     public function ultimasReunioes() {
//         //header('Access-Control-Allow-Origin: *');
//         //header("Content-type: application/json; charset=utf8");

//         $reunioes = DB::select("select * from reunioes r, estagio e where e.idestagio=r.estagio_idestagio order by idreuniao desc limit 10");

//         //echo mb_detect_encoding(json_encode($reunioes[0]->participantes));
//         //echo mb_detect_encoding($reunioes[0]->participantes);
//         //echo mb_convert_encoding($reunioes[0]->participantes, "UTF-8", "auto");
//         for($i=0; $i<10; $i++) {
//             //$reunioes[$i]->tituloestagio = mb_convert_encoding($reunioes[$i]->tituloestagio, "ISO-8859-1", "UTF-8");
//             //$reunioes[$i]->tituloestagio = utf8_encode ($reunioes[$i]->tituloestagio);
//         }
//         echo json_encode($reunioes);
//     }

//     /*private static function mySubstring($string) {
//         $aux = '';

//         for($i=0; $i<10; $i++) {
//             $aux .= $string[$i];
//         }
//         //return "234234234";
//         return $aux;
//     }*/

//     public function numeroReunioesPorEstagio() {
//         try {
//             //create view nreunioesporestagio as select estagio.idestagio, periodo_estagio.curso, estagio.tituloestagio, count(*) as nreunioes from estagio, reunioes, periodo_estagio where estagio.idestagio=reunioes.estagio_idestagio and estagio.periodo_estagio_idperiodo_estagio=periodo_estagio.idperiodo_estagio group by reunioes.estagio_idestagio;

//             //$reunioes = DB::select("select estagio.idestagio, periodo_estagio.curso, estagio.tituloestagio, count(*) as nreunioes from estagio, reunioes, periodo_estagio where estagio.idestagio=reunioes.estagio_idestagio and estagio.periodo_estagio_idperiodo_estagio=periodo_estagio.idperiodo_estagio and reunioes.data>'2020-09-01' group by reunioes.estagio_idestagio");

//             //$reunioes = DB::select("select * from nreunioesporestagio");

//             $reunioes = DB::select("select estagio.idestagio, periodo_estagio.curso, estagio.tituloestagio, count(*) as nreunioes from estagio, reunioes, periodo_estagio where estagio.idestagio=reunioes.estagio_idestagio and estagio.periodo_estagio_idperiodo_estagio=periodo_estagio.idperiodo_estagio and estagio.idestagio not in(3362, 3835) and reunioes.data>DATE_SUB(NOW(),INTERVAL 2 YEAR) group by estagio.idestagio, periodo_estagio.curso, estagio.tituloestagio order by 2, 4 desc");

//             for($i=0; $i<sizeof($reunioes); $i++) {
//                 $max = 64;
//                 if(strlen($reunioes[$i]->tituloestagio)>$max) {
//                     $reunioes[$i]->tituloestagio = substr($reunioes[$i]->tituloestagio, 0, $max) . "...";
//                 }
//             }

//             /*
//              * select estagio.idestagio, periodo_estagio.curso, estagio.tituloestagio, count(*) as nreunioes
//              * from estagio, reunioes, periodo_estagio
//              * where estagio.idestagio=reunioes.estagio_idestagio and estagio.periodo_estagio_idperiodo_estagio=periodo_estagio.idperiodo_estagio
//              * group by reunioes.estagio_idestagio
//              */
//             echo json_encode($reunioes);
//         } catch(QueryException $ex){
//             dd($ex->getMessage());
//         }
//     }

//     public function common() {
//         //ver tabelas:
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/base/tables.html

//         //accordions para as queries mais comuns
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/base/accordions.html

//         //ver gridnav para dashboard principal
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/base/navs.html

//         //forms
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/forms/layouts/multi-column-forms.html

//         //download de docs
//         //http://estagiosadminv2.dei.uc.pt/metronicv510/components/widgets/general.html



//     }

//     private static function utf8_converter($array){
//         array_walk_recursive($array, function(&$item, $key){
//             if(!mb_detect_encoding($item, 'utf-8', true)){
//                 $item = utf8_encode($item);
//             }
//         });
//         return $array;
//     }

//     public function empresasComEstagioNoAno($ano=0) {
//         $periodosEstagioAno = DB::select("select * from periodo_estagio where datainicio like '%" . $ano . "%' or datafim like '%" . $ano . "%'");
//         $dados=array();

//         foreach ($periodosEstagioAno as $pea) {
//             $empresasPeriodo = DB::select("select distinct empresa_idempresa from estagio where periodo_estagio_idperiodo_estagio=" . $pea->idperiodo_estagio);
//             $empresas = array();

//             foreach ($empresasPeriodo as $ep) {

//                 $emailsEmpresaDB = DB::select("select emailempresa email from empresa where idempresa=" . $ep->empresa_idempresa . " union select email from empresa_colaboradores where empresa=" . $ep->empresa_idempresa);

//                 $emailsEmpresa = array();

//                 foreach ($emailsEmpresaDB as $ee) {
//                     $emailsEmpresa[] = $ee->email;
//                 }

//                 $empresas[] = array(
//                     'id' => $ep->empresa_idempresa,
//                     'emails' => $emailsEmpresa,
//                     'emailss' => implode(",", $emailsEmpresa)
//                 );
//             }

//             $dados[] = array(
//                 'idperiodo_estagio' => $pea->idperiodo_estagio,
//                 'descricao' => $pea->descricao,
//                 'empresas' => $empresas,
//             );
//         }

//         //dd($dados);

//         if($ano!=0) {
//             return view('metronicv510.pages.queries.empresas.listaEmailsEmpresas', array('dados' => $dados));
//         }
//     }
// }
