<?php

namespace App\Http\Controllers;

use App\Mail\MailQueuer;
use App\Role;
use Adldap\Auth\BindException;
use App\Aluno;
use App\Http\Controllers\Auth\Authentication;
use App\Empresa;
use App\Scopes\ColaboradorInternoScope;
use Carbon\Carbon;
use App\Docente;
use App\EmpresaColaborador;
use App\EmpresaPedidoRegisto;
use App\EmpresaRepresentante;
use App\Estagio;
use App\EstagioAction;
use App\Helpers\Helper;
use App\User;
use App\UserAccessLog;
use Illuminate\Http\Request;
use App\Virtualmachine;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\View\View;
use Psr\Log\NullLogger;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Log;
use App\EstagioPeriodo;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Image;



class HomeController extends Controller
{
    // public function main() {
    //     //return "main page";
    //     //return view('metronicv460.master');
    //     return view('metronicv460.pages.pageOne');
    //     //return view::make('metronicv460.pages.pageOne');
    // }

    // //https://estagiosadminv2.dei.uc.pt/logo_123.png
    // public function imagetracker(Request $request, $token) {
    //     //Log::debug(array($request, $token));

    //     Log::debug(array($token));
    //     Log::debug(storage_path('logos'));

    //     //return redirect()->to(config('app.url') . '/logos/uc_dei_logo.png')->send();
    //     return Image::make(storage_path('/logos/uc_dei_logo.png'))->response();
    // }

    public function dashboard(Request $request) {
        $theView= 'metronicv510.pages.dashboard';
        $categoryNames = array();
        $sidebarItems = array();
        $profileAction = "";

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE dashboard';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        if(session()->has('profile')) {
            switch (session()->get('profile')) {
                case Role::Empresa:
                    $theView = 'metronicv815.layout.profiles.profile_empresa_dashboard';
                    $categoryNames = Empresa::category();
                    $sidebarItems = Empresa::items();
                    $idEmpresa = session()->get('id');
                    $ultimosEstagiosNovos = Estagio::where('empresa_idempresa', $idEmpresa)->orderBy('created','DESC')->take(20)->get();

                    break;
                case Role::Docente:
                    $theView = 'metronicv815.layout.profiles.profile_docente_dashboard';
                    $categoryNames = Docente::category();
                    $sidebarItems = Docente::items();
                    $idEmpresa = 1;
                    $docente = User::find(session()->get('id'))->docente;
                    $ultimosEstagiosNovos = $docente->estagios()->get()->take(10);
//                dd($ultimosEstagiosNovos);
                    break;
                case Role::Aluno:
                    dd("aluno");
 ;                   $theView = 'metronicv815.layout.profiles.profile_docente_dashboard';
                    $categoryNames = Docente::category();
                    $sidebarItems = Docente::items();
                    break;
                case Role::EmpresaColaborador:
                    $theView = 'metronicv815.layout.profiles.profile_empresa_dashboard';
                    $categoryNames = EmpresaColaborador::category();
                    $sidebarItems = EmpresaColaborador::items();
                    $idEmpresa = session()->get('id');
                    $colab = EmpresaColaborador::allColab()->where('email',session()->get('login'))->first();
                    $ultimosEstagiosNovos = $colab->estagios()->get()->take(10);
                    break;
                default:
                    dd("err");

            }
        }


//        if(session()->has('login')) {
//            $userLogs = null;//UserAccessLog::all()->where('username', session()->get('login'))->take(10);
//
//            foreach ($ultimosEstagiosNovos as $ultimoEstagio) {
//                if (isset($ultimoEstagio['estadoestagio'])) {
//                    $ultimoEstagio['estado'] = Estagio::getEstado($ultimoEstagio['estadoestagio']);
//                } else {
//                    $ultimoEstagio['estado'] = Estagio::getEstado(15);
//                }
//            }
//        }

//        $actions = EstagioAction::orderBy('created','DESC')->take(7)->get();
//        return redirect('estagios/lista');

        $actionName = "Editar";
        $mytimeAsString = Carbon::now()->toDateString();
        $periodosEstagio = EstagioPeriodo::where('datainicio','<=',$mytimeAsString)
                                         ->where('datafim','>=',$mytimeAsString)
                                         ->get();
        if(count($periodosEstagio) == 0)
            $actionName = "Ver";
        
        $estados = Estagio::getEstado(0);
        return view($theView, array('title' => 'Plataforma de Gestão de Estágios',
//            'actions'=>$actions,
//            'logs' => $userLogs,
            'compareAction' => route('compararVersoes',""),
            'tableActionURL' => route('estagiosJSON'),
            'title' => 'Plataforma de Gestão de Estágios',
            'estados' => $estados,
            'actionName' => $actionName,
//           'ultimosestagiosnovos' => $ultimosEstagiosNovos,
            'categoryNames' => $categoryNames,
            'sidebaritems' => $sidebarItems,
        ));
    }

    public function usersTable() {
        $actions = EstagioAction::all()->sortByDesc('created')->take(7);
        $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
        return view('metronicv510.pages.tableUsers', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
    }

    public function empresaslista() {
        $actions = EstagioAction::all()->sortByDesc('created')->take(7);
        $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
        $estagiosPeriodos = EstagioPeriodo::all()->sortByDesc('descricao');
        return view('metronicv510.pages.empresasLista', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs, 'estagiosPeriodos' => $estagiosPeriodos));
    }

    //lista temporaria de empresas repetidas
    public function empresaslistaB() {
        $actions = EstagioAction::all()->sortByDesc('created')->take(7);
        $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
        //return view('metronicv510.pages.empresasListaRepetidas', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
        return view('metronicv510.pages.empresasListaMoradas', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
    }

    public function mv51forms($id) {
        //return view('metronicv510.pages.defaultForms');
        $empresa = Empresa::where('idempresa', $id)->firstOrFail();

        $empresa->aceitadeclaracao = false;

        if($empresa->datadeclaracao!=null && $empresa->datadeclaracao!='') {
            $empresa->aceitadeclaracao = true;
        }

        $empresa->datadeclaracao = date('m/d/Y', strtotime($empresa->datadeclaracao));

        return view('metronicv510.pages.companyForm', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'empresa' => $empresa));
    }

    public function messagecheckmail() {
        return view('message', array('message' => 'Please check your mailbox'));
    }

    public function showViewDadosEmpresa(Request $request) {
        //return view('metronicv510.pages.defaultForms');
        $idEmpresa = session()->get('id');

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE dados empresa';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        $categoryNames = $navbarItems = array();
        switch (session()->get('profile')){
            case Role::Empresa or Role::EmpresaRepresentanteLegal:
                $categoryNames = Empresa::category();
                $navbarItems = Empresa::items();
                break;
            default:
                abort(404);
                break;
        }

//        Log::debug(array('idEmpresa', $idEmpresa));

        if($idEmpresa==null){
            $idEmpresa = 1;
        }
        //$empresa = Empresa::where('idempresa', $idEmpresa)->firstOrFail();
        $empresa = Empresa::where('idempresa', $idEmpresa)->firstOrFail()->toArray();



//        $empresa['aceitadeclaracao'] = false;
//
//        if($empresa['datadeclaracao']!=null && $empresa['datadeclaracao']!='') {
//            $empresa['aceitadeclaracao'] = true;
//        }

//        $empresa['datadeclaracao'] = date('m/d/Y', strtotime($empresa['datadeclaracao']));


        //$empresa = self::array_utf8_encode($empresa);

        $empresa['aceitadeclaracao'] = false;

        if($empresa['aceitadeclaracao']!=null && $empresa['aceitadeclaracao']!='') {
            $empresa['aceitadeclaracao'] = true;
        }

        $empresa['datadeclaracao'] = date('m/d/Y', strtotime($empresa['datadeclaracao']));


        $dbData = Empresa::where('pcolectivaempresa',$empresa['pcolectivaempresa'])->get();

        foreach ($dbData as $ddat) {
            $empresa['semelhantes'][] = self::array_utf8_encode((array)$ddat);
        }

        $dbData = EmpresaRepresentante::where('empresa',$empresa['idempresa'])->get();

        $empresa['representantes'] = array();
        foreach ($dbData as $ddat) {
            $representanteDaEmpresa = $ddat;

            if($representanteDaEmpresa['deleted_at']!=null) {
                $representanteDaEmpresa['activo'] = false;
            } else {
                $representanteDaEmpresa['activo'] = true;
            }


            if($representanteDaEmpresa['accountConfirmed']==1) {
                if($representanteDaEmpresa['deleted_at']!=null) {
                    $representanteDaEmpresa['estado'] = 'Desactivado em ' . $representanteDaEmpresa['deleted_at'];
                } else {
                    $representanteDaEmpresa['estado'] = 'Activo';
                }
            } else {
                $representanteDaEmpresa['estado'] = 'Por confirmar';
            }

            $empresa['representantes'][] = $representanteDaEmpresa;
        }

        $dbData = EmpresaColaborador::where('empresa',$empresa['idempresa'])->get();

        $empresa['colaboradores'] = array();
        foreach ($dbData as $ddat) {
            $colaboradorDaEmpresa = $ddat;

            if($colaboradorDaEmpresa['deleted_at']!=null) {
                Log::debug('deleted_at not NULL');
                $colaboradorDaEmpresa['activo'] = false;
            } else {
                Log::debug('deleted_at is NULL');
                $colaboradorDaEmpresa['activo'] = true;
            }

            if($colaboradorDaEmpresa['accountConfirmed']==1) {
                if($colaboradorDaEmpresa['deleted_at']!=null) {
                    $colaboradorDaEmpresa['estado'] = 'Desactivado em ' . $colaboradorDaEmpresa['deleted_at'];
                } else {
                    $colaboradorDaEmpresa['estado'] = 'Activo';
                }
            } else {
                $colaboradorDaEmpresa['estado'] = 'Por confirmar';
            }


            $empresa['colaboradores'][] = $colaboradorDaEmpresa;
        }
        
        $view = 'metronicv815.layout.empresa.dadosEmpresa';
//        $view = 'metronicv510.pages.dadosEmpresa';
        return view(
            $view,
            array(
                'title' => 'Plataforma de Gestão de Estágios : Empresa',
                'empresa' => $empresa,
                'categoryNames' => $categoryNames,
                'sidebaritems' => $navbarItems
            ));

        /*echo "<pre>";
        print_r(session()->all());
        echo "</pre>";*/
    }

    //https://estagiosadminv2.dei.uc.pt/dadosempresa/save
    public function dadosEmpresaSave(Request $request) {
        //$idEmpresa = $request->id;
        $idEmpresa = session()->get('id');

        //$idEmpresa = 1;

        if($idEmpresa == null) {
            $data = array(
                'result' => false,
                'message' => 'empresa não definida'
            );
        } else {
            Log::debug($idEmpresa);

            $formData = (array)$request->json()->all();
            Log::debug($formData);

            $data = array(
                'data' => $formData,
                'message' => 'the message'
            );

            //$empZ = Empresa::where('idempresa', '1')->first();

            $emp = Empresa::where('idempresa', $idEmpresa)->firstOrFail();
            $empresa = self::array_utf8_encode((array)$emp->getOriginal());


            if($emp==null) {
                Log::debug('empresa null');
            } else {
                Log::debug($emp);
                Log::debug($formData['actividade']);
                $emp->nomeempresa = $formData['nome'];
                $emp->moradaempresa = $formData['sede'];
                $emp->acronimoempresa = $formData['acronimo'];
                $emp->actividadeempresa = $formData['actividade'];
                $emp->urlempresa = $formData['url'];
                $emp->telefoneempresa = $formData['telefone'];
                $emp->datadeclaracao = date("Y/m/d G:i:s");
                Log::debug($emp->save());

            }

            $data['empresa'] = $empresa;
        }

        echo json_encode($data);
    }

    private static function array_utf8_encode($dat){
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = self::array_utf8_encode($d);
        return $ret;
    }

    private static function arrayCastRecursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = arrayCastRecursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return arrayCastRecursive((array)$array);
        }
        return $array;
    }

    public function showViewEmpresasdetalhes($id) {
        $empresa = Empresa::where('idempresa', $id)->firstOrFail()->toArray();

        //$empresa = self::array_utf8_encode($empresa);

        $empresa['aceitadeclaracao'] = false;

        if($empresa['aceitadeclaracao']!=null && $empresa['aceitadeclaracao']!='') {
            $empresa['aceitadeclaracao'] = true;
        }

        $empresa['datadeclaracao'] = date('m/d/Y', strtotime($empresa['datadeclaracao']));

        $dbData = DB::select("select * from empresa where pcolectivaempresa='" . $empresa['pcolectivaempresa'] . "'");

        $empresa['semelhantes'] = array();

        foreach ($dbData as $ddat) {
            $empresa['semelhantes'][] = self::array_utf8_encode((array)$ddat);
        }

        $dbData = DB::select("select * from empresa_representantes where empresa='" . $empresa['idempresa'] . "'");

        $empresa['representantes'] = array();
        foreach ($dbData as $ddat) {
            $empresa['representantes'][] = self::array_utf8_encode((array)$ddat);
        }

        $dbData = DB::select("select * from empresa_colaboradores where empresa='" . $empresa['idempresa'] . "'");

        $empresa['colaboradores'] = array();
        foreach ($dbData as $ddat) {
            $empresa['colaboradores'][] = self::array_utf8_encode((array)$ddat);
        }

        //dd($empresa);

        return view('metronicv510.pages.empresaDetalhes2', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'empresa' => $empresa));
    }


    public function endSession(Request $request){
        session()->flush();
        return redirect(route('login'));
    }

    public function loginpage($token = '', Request $request) {
        //session()->flush();
        session()->put('login','');
        $login='';
        $password='';

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE : login page';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();

        if($token=='anonymous') {
            $login='diogo.goncalo@gmail.com';
            $password='esquecer';
        }

        return view('metronicv510.pages.login', array('title' => 'Plataforma de Gestão de Estágios : Login', 'login'=>$login, 'password'=>$password));
        //return view('metronicv510.pages.login', array('title' => config('app.title')));
    }

    public function loginrecover(Request $request) {
        //diogo.goncalo@gmail.com
        Log::debug($request);

        $emailAddress = $request->input('email');

        $ual = new UserAccessLog();
        $ual->username = $emailAddress;
        $ual->details = 'ACCESS PAGE : login : recover';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();
        if(!Helper::validEmail($emailAddress)) {
            $ual->status = 'INVALID EMAIL';
            $ual->save();

            return json_encode(array(
                'result' => false,
                'message' => 'Verifique o endereço de email',
            ));
        }

        $seed = 'Zeichaebu2ahfongahro';
        $hash = sha1(uniqid($seed . mt_rand(), true));

        //VERIFICAR O TIPO DE UTILIZADOR

        $tipoUtilizador = 0;

        $auxA = EmpresaColaborador::where('email', $emailAddress)->where('accountConfirmed', '1')->get();
        $auxB = EmpresaRepresentante::where('email', $emailAddress)->where('accountConfirmed', '1')->get();
        $auxC = Empresa::where('emailempresa', $emailAddress)->where('estadoempresa', '1')->get();

        if(count($auxA)==1) {
            $ec = $auxA[0];
            $tipoUtilizador = 1;
            $ec->accountConfirmHash = $hash;
            $ec->accountConfirmed = 0;
            $ec->save();

            $ual->status = 'EmpresaColaborador';
            $ual->save();
        } elseif (count($auxB)==1) {
            $er = $auxB[0];
            $tipoUtilizador = 2;
            $er->accountConfirmHash = $hash;
            $er->accountConfirmed = 0;
            $er->save();

            $ual->status = 'EmpresaRepresentante';
            $ual->save();
        } elseif (count($auxC)==1) {
            $er = $auxC[0];
            $tipoUtilizador = 3;
            $er->accountConfirmHash = $hash;
            $er->accountConfirmation = 0;
            $er->save();

            $ual->status = 'Empresa';
            $ual->save();
            Log::debug($er);
        }

        $mailData = array(
            'actiontype' => 'empsetpass',
            'nomedestino' => 'nome',
            'emailAddress' => $emailAddress,
            'targeturl' => '',
            'mensagem' => ''
        );

        switch($tipoUtilizador) {
            case 1:
                $mailData['targeturl'] = env('APP_URL') . '/colaborador/definirpassword/' . $hash;
                $mailData['mensagem'] = 'Foi adicionado como colaborador de uma empresa na plataforma de estágios do DEI @ FCTUC';
                $mailData['subject'] = 'Confirmar registo como colaborador';
                break;
            case 2:
                $mailData['targeturl'] = env('APP_URL') . '/representante/definirpassword/' . $hash;
                $mailData['mensagem'] = 'Foi adicionado como representante legal de uma empresa na plataforma de estágios do DEI @ FCTUC';
                $mailData['subject'] = 'Confirmar registo como representante';
                break;
            case 3:
                $mailData['targeturl'] = env('APP_URL') . '/empresa/definirpassword/' . $hash;
                $mailData['mensagem'] = 'Foi solicitada a recuperação de password de empresa na plataforma de estágios do DEI @ FCTUC';
                $mailData['subject'] = 'Solicitação de recuperação de password';
                break;
            default:
                break;
        }

        if($tipoUtilizador>0) {
            $mailData['view'] = 'emails.mail-1';
            Mail::queue(new MailQueuer($mailData));

        } else {
            return json_encode(
                array(
                    'status'=>'false',
                    'mensagem' => 'A recuperação de senha está apenas disponível para contas externas ao DEI'
                )
            );
        }

        return json_encode(array('t'=>'r'));

    }

    public function mv51() {
        return view('metronicv510.pages.pageOne');
    }

    public function login(Request $request) {
        //dd("login");
        //$ld = LdapauthController();

        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

        $auth = new Authentication();
        return $auth->checklogin($username, $password);

        //return \Redirect::route('LdapauthController@login');

        //return view('metronicv460.pages.login');
    }



//     public function tabledata() {
// //        echo "hello";

// //        $virtualMachines = App\Virtualmachine::all();
//         $virtualMachines = Virtualmachine::all();

//         $iDisplayLength = 100;
//         $iDisplayStart = 0;
//         $sEcho = 0;

//         $iTotalRecords = 178;

//         if(isset($_REQUEST['length'])) {
//             $iDisplayLength = intval($_REQUEST['length']);
//         }

//         $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

//         if(isset($_REQUEST['start'])) {
//             $iDisplayStart = intval($_REQUEST['start']);
//         }

//         if(isset($_REQUEST['draw'])) {
//             $sEcho = intval($_REQUEST['draw']);
//         }

//         $records = array();
//         $records["data"] = array();

//         $end = $iDisplayStart + $iDisplayLength;
//         $end = $end > $iTotalRecords ? $iTotalRecords : $end;

//         $status_list = array(
//             array("success" => "Pending"),
//             array("info" => "Closed"),
//             array("danger" => "On Hold"),
//             array("warning" => "Fraud")
//         );

//         $i=0;

//         foreach ($virtualMachines as $virtualMachine) {
// //            echo $virtualMachine->projectName;

//             $status = $status_list[rand(0, 2)];
//             $id = ($i + 1);

//             $tickets = explode(',', $virtualMachine->rtTicket);
//             $ticketLink = "";

//             $auxUserList = "";
//             $auxUsers = explode(',', $virtualMachine->users) ;

//             foreach ($tickets as $ticket) {
//                 $ticketLink .= '<a href="https://sic.dei.uc.pt/rt4/Ticket/Display.html?id=' . $ticket . '" target="_blank">' . $ticket . '</a><br/>';
//             }

//             foreach ($auxUsers as $auxUser) {
//                 $auxUserList .= $auxUser .  '<br/>';
//             }

//             $records["data"][] = array(
//                 '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$id.'"/><span></span></label>',
//                 $id,
//                 $virtualMachine->projectName,
//                 '???',
// //                $virtualMachine->users,
//                 $auxUserList,
//                 $virtualMachine->userType,
//                 $virtualMachine->associatedProject,
//                 $virtualMachine->associatedProfessor,
//                 $virtualMachine->notes,
// //                '<a href="https://sic.dei.uc.pt/rt4/Ticket/Display.html?id=' . $virtualMachine->rtTicket . '" target="_blank">' . $virtualMachine->rtTicket . '</a>',
//                 $ticketLink,
//                 '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>',
//                 '<a href="javascript:;" class="btn btn-sm btn-outline grey-salsa"><i class="fa fa-search"></i> View</a>',
//             );
//             $i++;
//         }

// //        for($i = $iDisplayStart; $i < $end; $i++) {
// //        }

//         if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
//             $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
//             $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
//         }

//         $records["draw"] = $sEcho;
//         $records["recordsTotal"] = $iTotalRecords;
//         $records["recordsFiltered"] = $iTotalRecords;

//         echo json_encode($records);


// //        foreach ($virtualMachines as $virtualMachine) {
// //            echo $virtualMachine->projectName;
// //        }
//     }

    // public function tabledata2() {
    //     $iDisplayLength = 10;
    //     $iDisplayStart = 0;
    //     $sEcho = 0;

    //     $iTotalRecords = 178;

    //     if(isset($_REQUEST['length'])) {
    //         $iDisplayLength = intval($_REQUEST['length']);
    //     }

    //     $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

    //     if(isset($_REQUEST['start'])) {
    //         $iDisplayStart = intval($_REQUEST['start']);
    //     }

    //     if(isset($_REQUEST['draw'])) {
    //         $sEcho = intval($_REQUEST['draw']);
    //     }

    //     $records = array();
    //     $records["data"] = array();

    //     $end = $iDisplayStart + $iDisplayLength;
    //     $end = $end > $iTotalRecords ? $iTotalRecords : $end;

    //     $status_list = array(
    //         array("success" => "Pending"),
    //         array("info" => "Closed"),
    //         array("danger" => "On Hold"),
    //         array("warning" => "Fraud")
    //     );

    //     for($i = $iDisplayStart; $i < $end; $i++) {
    //         $status = $status_list[rand(0, 2)];
    //         $id = ($i + 1);
    //         $records["data"][] = array(
    //             '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$id.'"/><span></span></label>',
    //             $id,
    //             '12/09/2013',
    //             'Jhon Doe',
    //             'Jhon Doe',
    //             'Jhon Doe',
    //             'Jhon Doe',
    //             'Jhon Doe',
    //             '450.60$',
    //             rand(1, 10),
    //             '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>',
    //             '<a href="javascript:;" class="btn btn-sm btn-outline grey-salsa"><i class="fa fa-search"></i> View</a>',
    //         );
    //     }

    //     if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
    //         $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
    //         $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
    //     }

    //     $records["draw"] = $sEcho;
    //     $records["recordsTotal"] = $iTotalRecords;
    //     $records["recordsFiltered"] = $iTotalRecords;

    //     echo json_encode($records);
    // }

    // public function getEvents() {
    //     if(false) {
    //         header('Content-Type: application/json; charset=utf-8');
    //         header('Access-Control-Allow-Origin: *');
    //         header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    //         header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    //     }

    //     $eventos = array();

    //     $estagios = Estagio::whereNotNull('data_defesaFinal')->take(1000)->get(['idestagio', 'data_defesaInt', 'data_defesaFinal', 'tituloestagio']);
    //     //dd($estagios);

    //     foreach ($estagios as $estagio) {
    //         $estagio = self::array_utf8_encode($estagio);
    //         //dd(substr($estagio->tituloestagio, 0, 25));
    //         //$titulo = $estagio->tituloestagio;

    //         //$titulo = mb_convert_encoding($titulo, 'UTF-8', 'UTF-16LE');
    //         //$titulo = substr($titulo, 0, 15);

    //         //dump($titulo);

    //         $classNames = array(
    //             'm-fc-event--primary',
    //             'm-fc-event--accent'
    //         );

    //         $eventos[] = array(
    //             'id' => $estagio->idestagio,
    //             'title' => 'Defesa Intermédia ' . $estagio->idestagio,
    //             'start' => $estagio->data_defesaInt,
    //             'end' => $estagio->data_defesaInt,
    //             'allDay' => false,
    //             'description' => '',
    //             'className' => $classNames[0],
    //             'url' => '/estagios/propostas/detalhes/' . $estagio->idestagio,
    //         );

    //         $eventos[] = array(
    //             'id' => $estagio->idestagio,
    //             'title' => 'Defesa Final ' . $estagio->idestagio,
    //             'start' => $estagio->data_defesaFinal,
    //             'end' => $estagio->data_defesaFinal,
    //             'allDay' => false,
    //             'description' => '',
    //             'className' => $classNames[1],
    //             'url' => '/estagios/propostas/detalhes/' . $estagio->idestagio,
    //         );
    //     }

    //     //dd($eventos);

    //     echo json_encode($eventos);
    //     die();

    //     $data = array(
    //         array(
    //             'id' => 1,
    //             'title' => 'Meeting',
    //             'start' => '2018/04/30',
    //             'end' => '2018/04/30',
    //             'allDay' => true,
    //             'description' => 'Lorem ipsum dolor sit incid idunt ut',
    //             'className' => 'm-fc-event--light m-fc-event--solid-warning',
    //         ),
    //         array(
    //             'id' => 2,
    //             'title' => 'Meeting',
    //             'start' => '2018/04/29',
    //             'end' => '2018/04/29',
    //             'allDay' => true,
    //             'description' => 'Lorem ipsum dolor sit incid idunt ut',
    //             'className' => 'm-fc-event--light  m-fc-event--solid-danger',
    //         ),
    //         array(
    //             'id' => 3,
    //             'title' => 'Meeting',
    //             'start' => '2018/04/28',
    //             'end' => '2018/04/28',
    //             'allDay' => true,
    //             'description' => 'Lorem ipsum dolor sit incid idunt ut',
    //             'className' => 'm-fc-event--danger m-fc-event--solid-focus',
    //         ),
    //     );

    //     if(true) {
    //         echo json_encode($data);
    //     }else {
    //         echo '[
    //             {
    //                 title: \'Meeting\',
    //                 start: \'2017-08-28\',
    //                 description: \'Lorem ipsum dolor sit incid idunt ut\',
    //                 className: "m-fc-event--light m-fc-event--solid-warning"
    //             },
    //             {
    //                 title: \'Conference\',
    //                 description: \'Lorem ipsum dolor incid idunt ut labore\',
    //                 start: \'2017-08-29T13:30:00\',
    //                 end: \'2017-08-29T17:30:00\',
    //                 className: "m-fc-event--accent"
    //             },
    //             {
    //                 title: \'Dinner\',
    //                 start: \'2017-08-30\',
    //                 description: \'Lorem ipsum dolor sit tempor incid\',
    //                 className: "m-fc-event--light  m-fc-event--solid-danger"
    //             },
    //             {
    //                 title: \'All Day Event\',
    //                 start: \'2017-09-01\',
    //                 description: \'Lorem ipsum dolor sit incid idunt ut\',
    //                 className: "m-fc-event--danger m-fc-event--solid-focus"
    //             },
    //             {
    //                 title: \'Reporting\',
    //                 description: \'Lorem ipsum dolor incid idunt ut labore\',
    //                 start: \'2017-09-03T13:30:00\',
    //                 end: \'2017-09-04T17:30:00\',
    //                 className: "m-fc-event--accent"
    //             },
    //             {
    //                 title: \'Company Trip\',
    //                 start: \'2017-09-05\',
    //                 end: \'2017-09-07\',
    //                 description: \'Lorem ipsum dolor sit tempor incid\',
    //                 className: "m-fc-event--primary"
    //             },
    //             {
    //                 title: \'ICT Expo 2017 - Product Release\',
    //                 start: \'2017-09-09\',
    //                 description: \'Lorem ipsum dolor sit tempor inci\',
    //                 className: "m-fc-event--light m-fc-event--solid-primary"
    //             },
    //             {
    //                 title: \'Dinner\',
    //                 start: \'2017-09-12\',
    //                 description: \'Lorem ipsum dolor sit amet, conse ctetur\'
    //             },
    //             {
    //                 id: 999,
    //                 title: \'Repeating Event\',
    //                 start: \'2017-09-15T16:00:00\',
    //                 description: \'Lorem ipsum dolor sit ncididunt ut labore\',
    //                 className: "m-fc-event--danger"
    //             },
    //             {
    //                 id: 1000,
    //                 title: \'Repeating Event\',
    //                 description: \'Lorem ipsum dolor sit amet, labore\',
    //                 start: \'2017-09-18T19:00:00\',
    //             },
    //             {
    //                 title: \'Conference\',
    //                 start: \'2017-09-20T13:00:00\',
    //                 end: \'2017-09-21T19:00:00\',
    //                 description: \'Lorem ipsum dolor eius mod tempor labore\',
    //                 className: "m-fc-event--accent"
    //             },
    //             {
    //                 title: \'Meeting\',
    //                 start: \'2017-09-11\',
    //                 description: \'Lorem ipsum dolor eiu idunt ut labore\'
    //             },
    //             {
    //                 title: \'Lunch\',
    //                 start: \'2017-09-18\',
    //                 className: "m-fc-event--info m-fc-event--solid-accent",
    //                 description: \'Lorem ipsum dolor sit amet, ut labore\'
    //             },
    //             {
    //                 title: \'Meeting\',
    //                 start: \'2017-09-24\',
    //                 className: "m-fc-event--warning",
    //                 description: \'Lorem ipsum conse ctetur adipi scing\'
    //             },
    //             {
    //                 title: \'Happy Hour\',
    //                 start: \'2017-09-24\',
    //                 className: "m-fc-event--light m-fc-event--solid-focus",
    //                 description: \'Lorem ipsum dolor sit amet, conse ctetur\'
    //             },
    //             {
    //                 title: \'Dinner\',
    //                 start: \'2017-09-24\',
    //                 className: "m-fc-event--solid-focus m-fc-event--light",
    //                 description: \'Lorem ipsum dolor sit ctetur adipi scing\'
    //             },
    //             {
    //                 title: \'Birthday Party\',
    //                 start: \'2017-09-24\',
    //                 className: "m-fc-event--primary",
    //                 description: \'Lorem ipsum dolor sit amet, scing\'
    //             },
    //             {
    //                 title: \'Company Event\',
    //                 start: \'2017-09-24\',
    //                 className: "m-fc-event--danger",
    //                 description: \'Lorem ipsum dolor sit amet, scing\'
    //             },
    //             {
    //                 title: \'Click for Google\',
    //                 url: \'http://google.com/\',
    //                 start: \'2017-09-26\',
    //                 className: "m-fc-event--solid-info m-fc-event--light",
    //                 description: \'Lorem ipsum dolor sit amet, labore\'
    //             }
    //         ]';
    //     }
    // }

    // public function logout() {
    //     session()->put('login', '');

    //     echo "<pre>";
    //     //print_r(session()->all());
    //     print_r(session()->get('login'));
    //     echo "</pre>";
    // }

    public function indevelopment() {
        return view('indevelopment');
    }

    // public function search(Request $request) {
    //     Log::debug(session()->all());

    //     $titulo = $request->input('query');
    //     //dd($titulo);

    //     $estagios = array();
    //     $alunos = array();

    //     if (session()->get('profile') == 2) {
    //         Log::debug(session()->get('id'));

    //         $dbQuery = "select idestagio, tituloestagio from estagio where empresa_idempresa=" . session()->get('id') . " and tituloestagio like '%" . $titulo . "%' order by idestagio asc limit 5";
    //         $dbData = DB::select($dbQuery);

    //         foreach ($dbData as $dbD) {
    //             $estagios[] = self::array_utf8_encode((array)$dbD);
    //         }

    //         $dbQuery = "select idestagio, alunoatribuido, tituloestagio from estagio where empresa_idempresa=" . session()->get('id') . " and alunoatribuido like '%" . $titulo . "%' order by idestagio asc limit 5";
    //         $dbData = DB::select($dbQuery);

    //         foreach ($dbData as $dbD) {
    //             $alunos[] = self::array_utf8_encode((array)$dbD);
    //         }

    //         Log::debug($alunos);

    //     }


    //     return view('search.results', array('estagios' => $estagios, 'alunos' => $alunos));
    //     //return view($theView, array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
    // }

    // //config('estagios.curso.msi')
    // public function cursoTitulo($acronimo) {
    //     if(is_numeric($acronimo)) {
    //         $lista = DB::select("select curso from periodo_estagio where idperiodo_estagio='" . $acronimo . "'");
    //         $acronimo = $lista[0]->curso;

    //         return json_encode(array('titulo' => Helper::tituloCurso($acronimo)));
    //     } else {
    //         return json_encode(array('titulo' => config('estagios.curso.' . strtolower($acronimo))));
    //     }
    // }

    // public function m_aside_left_minimize_toggle() {
    //     if(empty(session()->get('leftmenuminimized'))) {
    //         session()->put('leftmenuminimized', 0);
    //     }

    //     if(session()->get('leftmenuminimized')==0) {
    //         session()->put('leftmenuminimized', 1);
    //     } else {
    //         session()->put('leftmenuminimized', 0);
    //     }
    // }

    // public function pdf(Fpdf $fpdf) {
    //     $filename = "AppName_Day_1_gen_".date("Y-m-d_H-i").".pdf";

    //     header("Content-Type: application/pdf");
    //     header("Pragma: public");
    //     header("Expires: 0");
    //     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //     header("Content-Type: application/force-download");
    //     header("Content-Type: application/octet-stream");
    //     header("Content-Type: application/download");
    //     header('Content-Disposition: attachment; filename="'.$filename.'"');
    //     header("Content-Transfer-Encoding: binary ");

    //     $pdf = new FPDF();
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial','B',16);
    //     $pdf->Cell(40,10,'Hello World!');
    //     $pdf->Output();

    //     exit();
    //     die();
    // }

    // public function map() {
    //     $theView= 'metronicv510.pages.map';

    //     if(session()->has('profile')) {
    //         if(session()->get('profile')==2) {

    //         }
    //     }

    //     $actions = EstagioAction::all()->sortByDesc('created')->take(7);
    //     $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
    //     return view($theView, array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
    // }
}
