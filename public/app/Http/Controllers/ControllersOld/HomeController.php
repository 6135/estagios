<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use Illuminate\Support\Facades\App;

use App\Curso;
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
use App\Helpers\Event;


class HomeController extends Controller
{
    private $nvbarItems = array(
        [
            'name' => 'Home',
            'route' => 'home',
            'active' => false
        ],
        [
            'name' => 'Cursos',
            'route' => 'cursos',
            'active' => false
        ],
    );
    //create a clone of the navbar items array and activate the item with the given index
    private function activate($index)
    {
        $nvbaritems = $this->nvbarItems;
        $nvbaritems[$index]['active'] = true;
        return $nvbaritems;
    }
    private function navbaritems()
    {
        return $this->nvbarItems;
    }
    /**
     * Application home page, mostly static
     */
    public function index()
    {
        $navbaritems = $this->activate(0);
        return view(
            'layouts.home.home',
            array(
                'navbaritems' => $navbaritems
            )
        );
    }

    /**
     * Application cursos page. mostly static
     */
    public function cursos()
    {
        $navbaritems = $this->activate(1);
        return view(
            'layouts.home.cursos',
            array(
                'navbaritems' => $navbaritems
            )
        );
    }

    /**
     * Application curso page with calendar for current periodo de estagio
     * @param Request $request
     * @param $curso string curso title
     * @return View
     * 
     */
    public function curso(Request $request, $curso)
    {
        //convert $curso to uppercase to match database
        $curso = strtoupper($curso);
        //get curso from database
        $curso = Curso::where('titulo', $curso)->first();
        if(!$curso){
            abort(404);
        } else 
        $periodoEstagio = $curso->estagioPeriodos()->current()->first();
        // dd($curso->estagioPeriodos()->where('datainicio', '<=', date('Y-m-d'))->get());
        // $date = Carbon::now();
        // $isoFormatForDates = 'D [de] MMMM';
        // if (App::getLocale() == 'en') {
        //     $isoFormatForDates = 'MMMM Do';
        // }
        // dd(
        //     $date->locale(),            // fr_FR
        //     $date->diffForHumans(),     // il y a 1 seconde
        //     $date->monthName,          // décembre
        //     $date->isoFormat('ll'),   // samedi 31 décembre 2022 15:56
        //     //Long date format without year
        //     $date->isoFormat($isoFormatForDates), // samedi 31 décembre 15:56
        //     App::getLocale()

        // );
        $view = 'layouts.home.curso';
        $cursoTitle = strtolower($curso->titulo);
        //get view from curso title
        if (view()->exists('layouts.cursos.' . $cursoTitle)) {
            $view = 'layouts.cursos.' . $cursoTitle;
        } else {
            $view = 'layouts.home.curso';
        }

        //if $periodoEstagio is not null, create calendar, else set calendar to null
        $calendar = null;
        if($periodoEstagio){
            $calendar = new CalendarBuilder(
                title: __('words.calendar'),
                subtitle: $periodoEstagio->descricao,
                description: '',
                events: CalendarBuilder::buildEventsFromPeriodoEstagio($periodoEstagio),
                columnThreshold: 1,
                doubleColumn: 1,
            );
        }


        return view($view, array(
            'curso' => $curso,
            'periodoEstagio' => $periodoEstagio,
            'navbaritems' => $this->navbaritems(),
            'calendar' => $calendar,
        )
        );
    }

    /**
     * Show the application dashboard to the user. Responsible for the main page of the application
     * @param Request $request
     * @return View|string
     * 
     */
    public function dashboard(Request $request)
    {
        $theView = 'metronicv510.pages.dashboard';
        $categoryNames = array();
        $sidebarItems = array();
        $profileAction = "";

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE dashboard';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        if (session()->has('profile')) {
            switch (session()->get('profile')) {
                case Role::EmpresaRepresentanteLegal:
                    $theView = 'metronicv815.layout.profiles.profile_empresa_dashboard';
                    $categoryNames = Empresa::category();
                    $sidebarItems = Empresa::items();
                    $idEmpresa = User::find(session()->get('userID'))->getCompanyIDActive();
                    $ultimosEstagiosNovos = Estagio::where('empresa_idempresa', $idEmpresa)->orderBy('created', 'DESC')->take(20)->get();
                case Role::Empresa:
                   
                    $theView = 'metronicv815.layout.profiles.profile_empresa_dashboard';
                    $categoryNames = Empresa::category();
                    $sidebarItems = Empresa::items();
                    $idEmpresa = User::find(session()->get('userID'))->getCompanyIDActive();
                    
                    $ultimosEstagiosNovos = Estagio::where('empresa_idempresa', $idEmpresa)->orderBy('created', 'DESC')->take(20)->get();

                    break;
                case Role::Docente:
                    $theView = 'metronicv815.layout.profiles.profile_docente_dashboard';
                    $categoryNames = Docente::category();
                    $sidebarItems = Docente::items();
                    $idEmpresa = User::find(session()->get('userID'))->getCompanyIDActive();;
                    $docente = User::find(session()->get('userID'))->docente;
                    $ultimosEstagiosNovos = $docente->estagios()->get()->take(10);
                    break;
                case Role::Aluno:
                    return redirect()->route('alunoDados');
                case Role::EmpresaColaborador:
                    $theView = 'metronicv815.layout.profiles.profile_empresa_dashboard';
                    $categoryNames = EmpresaColaborador::category();
                    $sidebarItems = EmpresaColaborador::items();
                    // dd(User::find(session()->get('userID'))->empresaColaborador->empresaObj->idempresa);
                    $idEmpresa = User::find(session()->get('userID'))->getCompanyIDActive();
                    $colab = EmpresaColaborador::allColab()->where('email', session()->get('login'))->first();
                    $ultimosEstagiosNovos = $colab->estagios()->get()->take(10);
                    break;
                default:
                    return "Admin page in development <a href='/switchrole/8'>Switch to docente</a>";

            }
        }

        $actionName = "Editar";
        $mytimeAsString = Carbon::now()->toDateString();
        $periodosEstagio = EstagioPeriodo::where('datainicio', '<=', $mytimeAsString)
            ->where('datafim', '>=', $mytimeAsString)
            ->get();
        if (count($periodosEstagio) == 0)
            $actionName = "Ver";

        $estados = Estagio::getEstado(0);
        return view($theView, array(
            'title' => 'Plataforma de Gestão de Estágios',
            //            'actions'=>$actions,
            //            'logs' => $userLogs,
            'compareAction' => route('compararVersoes', ""),
            'tableActionURL' => route('estagiosJSON'),
            'estados' => $estados,
            'actionName' => $actionName,
            //           'ultimosestagiosnovos' => $ultimosEstagiosNovos,
            'categoryNames' => $categoryNames,
            'sidebaritems' => $sidebarItems,
        )
        );
    }


    public function messagecheckmail()
    {
        return view('message', array('message' => 'Please check your mailbox'));
    }

    public function showViewDadosEmpresa(Request $request)
    {
        //return view('metronicv510.pages.defaultForms');
        $idEmpresa = User::find(session()->get('userID'))->getCompanyIDActive();

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE dados empresa';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        $categoryNames = $navbarItems = array();
        switch (session()->get('profile')) {
            case Role::Empresa or Role::EmpresaRepresentanteLegal:
                $categoryNames = Empresa::category();
                $navbarItems = Empresa::items();
                break;
            default:
                abort(404);
                break;
        }

        //        Log::debug(array('idEmpresa', $idEmpresa));

        if ($idEmpresa == null) {
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


        //$empresa = Helper::array_utf8_encode($empresa);

        $empresa['aceitadeclaracao'] = false;

        if ($empresa['aceitadeclaracao'] != null && $empresa['aceitadeclaracao'] != '') {
            $empresa['aceitadeclaracao'] = true;
        }

        $empresa['datadeclaracao'] = date('m/d/Y', strtotime($empresa['datadeclaracao']));


        $dbData = Empresa::where('pcolectivaempresa', $empresa['pcolectivaempresa'])->get();

        foreach ($dbData as $ddat) {
            $empresa['semelhantes'][] = Helper::array_utf8_encode((array) $ddat);
        }

        $dbData = EmpresaRepresentante::where('empresa', $empresa['idempresa'])->get();

        $empresa['representantes'] = array();
        foreach ($dbData as $ddat) {
            $representanteDaEmpresa = $ddat;

            if ($representanteDaEmpresa['deleted_at'] != null) {
                $representanteDaEmpresa['activo'] = false;
            } else {
                $representanteDaEmpresa['activo'] = true;
            }


            if ($representanteDaEmpresa['accountConfirmed'] == 1) {
                if ($representanteDaEmpresa['deleted_at'] != null) {
                    $representanteDaEmpresa['estado'] = 'Desactivado em ' . $representanteDaEmpresa['deleted_at'];
                } else {
                    $representanteDaEmpresa['estado'] = 'Activo';
                }
            } else {
                $representanteDaEmpresa['estado'] = 'Por confirmar';
            }

            $empresa['representantes'][] = $representanteDaEmpresa;
        }

        $dbData = EmpresaColaborador::where('empresa', $empresa['idempresa'])->get();

        $empresa['colaboradores'] = array();
        foreach ($dbData as $ddat) {
            $colaboradorDaEmpresa = $ddat;

            if ($colaboradorDaEmpresa['deleted_at'] != null) {
                Log::debug('deleted_at not NULL');
                $colaboradorDaEmpresa['activo'] = false;
            } else {
                Log::debug('deleted_at is NULL');
                $colaboradorDaEmpresa['activo'] = true;
            }

            if ($colaboradorDaEmpresa['accountConfirmed'] == 1) {
                if ($colaboradorDaEmpresa['deleted_at'] != null) {
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
            )
        );

        /*echo "<pre>";
        print_r(session()->all());
        echo "</pre>";*/
    }

    //https://estagiosadminv2.dei.uc.pt/dadosempresa/save
    public function dadosEmpresaSave(Request $request)
    {
        //$idEmpresa = $request->id;
        $idEmpresa = session()->get('id');

        //$idEmpresa = 1;

        if ($idEmpresa == null) {
            $data = array(
                'result' => false,
                'message' => 'empresa não definida'
            );
        } else {
            Log::debug($idEmpresa);

            $formData = (array) $request->json()->all();
            Log::debug($formData);

            $data = array(
                'data' => $formData,
                'message' => 'the message'
            );

            //$empZ = Empresa::where('idempresa', '1')->first();

            $emp = Empresa::where('idempresa', $idEmpresa)->firstOrFail();
            $empresa = Helper::array_utf8_encode((array) $emp->getOriginal());


            if ($emp == null) {
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

    public function showViewEmpresasdetalhes($id)
    {
        $empresa = Empresa::where('idempresa', $id)->firstOrFail()->toArray();

        //$empresa = Helper::array_utf8_encode($empresa);

        $empresa['aceitadeclaracao'] = false;

        if ($empresa['aceitadeclaracao'] != null && $empresa['aceitadeclaracao'] != '') {
            $empresa['aceitadeclaracao'] = true;
        }

        $empresa['datadeclaracao'] = date('m/d/Y', strtotime($empresa['datadeclaracao']));

        $dbData = DB::select("select * from empresa where pcolectivaempresa='" . $empresa['pcolectivaempresa'] . "'");

        $empresa['semelhantes'] = array();

        foreach ($dbData as $ddat) {
            $empresa['semelhantes'][] = Helper::array_utf8_encode((array) $ddat);
        }

        $dbData = DB::select("select * from empresa_representantes where empresa='" . $empresa['idempresa'] . "'");

        $empresa['representantes'] = array();
        foreach ($dbData as $ddat) {
            $empresa['representantes'][] = Helper::array_utf8_encode((array) $ddat);
        }

        $dbData = DB::select("select * from empresa_colaboradores where empresa='" . $empresa['idempresa'] . "'");

        $empresa['colaboradores'] = array();
        foreach ($dbData as $ddat) {
            $empresa['colaboradores'][] = Helper::array_utf8_encode((array) $ddat);
        }

        //dd($empresa);

        return view('metronicv510.pages.empresaDetalhes2', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'empresa' => $empresa));
    }

    /**
     * This function is end session and redirect to login page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function endSession(Request $request)
    {
        session()->flush();
        return redirect(route('login'));
    }

    public function loginpage(Request $request, $token = '')
    {
        //session()->flush();
        session()->put('login', '');
        $login = '';
        $password = '';

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE : login page';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();

        if ($token == 'anonymous') {
            $login = 'diogo.goncalo@gmail.com';
            $password = 'esquecer';
        }

        return view('metronicv510.pages.login', array('title' => 'Plataforma de Gestão de Estágios : Login', 'login' => $login, 'password' => $password));
        //return view('metronicv510.pages.login', array('title' => config('app.title')));
    }

    public function loginrecover(Request $request)
    {
        //diogo.goncalo@gmail.com
        // Log::debug($request);
        // Log::debug("--------------------------------------------");

        $emailAddress = $request->input('email');

        $ual = new UserAccessLog();
        $ual->username = $emailAddress;
        $ual->details = 'ACCESS PAGE : login : recover';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();
        if (!Helper::validEmail($emailAddress)) {
            $ual->status = 'INVALID EMAIL';
            $ual->save();

            return json_encode(
                array(
                    'result' => false,
                    'message' => 'Verifique o endereço de email',
                )
            );
        }

        $seed = 'Zeichaebu2ahfongahro';
        $hash = sha1(uniqid($seed . mt_rand(), true));

        //VERIFICAR O TIPO DE UTILIZADOR

        $tipoUtilizador = 0;

        $auxA = EmpresaColaborador::where('email', $emailAddress)->where('accountConfirmed', '1')->get();
        $auxB = EmpresaRepresentante::where('email', $emailAddress)->where('accountConfirmed', '1')->get();
        $auxC = Empresa::where('emailempresa', $emailAddress)->where('estadoempresa', '1')->get();

        if (count($auxA) == 1) {
            $ec = $auxA[0];
            $tipoUtilizador = 1;
            $ec->accountConfirmHash = $hash;
            $ec->accountConfirmed = 0;
            $ec->save();
            $user = $auxA->first()->user()->first();
            $user->accountConfirmHash = $hash;
            $user->accountConfirmed = 0;
            $user->accountConfirmation = 0;
            $user->save();
            $ual->status = 'EmpresaColaborador';
            $ual->save();
        } elseif (count($auxB) == 1) {
            $er = $auxB[0];
            $tipoUtilizador = 2;
            $er->accountConfirmHash = $hash;
            $er->accountConfirmed = 0;
            $er->save();
            $user = $auxB->first()->user()->first();
            $user->accountConfirmHash = $hash;
            $user->accountConfirmed = 0;
            $user->accountConfirmation = 0;
            $user->save();
            $ual->status = 'EmpresaRepresentante';
            $ual->save();
        } elseif (count($auxC) == 1) {
            $er = $auxC[0];
            $tipoUtilizador = 3;
            $er->accountConfirmHash = $hash;
            $er->accountConfirmation = 0;
            $er->save();
            $user = $auxC->first()->user()->first();
            $user->accountConfirmHash = $hash;
            $user->accountConfirmed = 0;
            $user->accountConfirmation = 0;
            $user->save();
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

        switch ($tipoUtilizador) {
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
        Log::debug($tipoUtilizador);
        if ($tipoUtilizador > 0) {
            $mailData['view'] = 'emails.mail-1';
            Mail::queue(new MailQueuer($mailData));

        } else {
            return json_encode(
                array(
                    'status' => 'false',
                    'mensagem' => 'A recuperação de senha está apenas disponível para contas externas ao DEI'
                )
            );
        }

        return json_encode(array('t' => 'r'));

    }

    public function login(Request $request)
    {
        //dd("login");
        //$ld = LdapauthController();

        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

        $auth = new Authentication();
        return $auth->checklogin($username, $password);

        //return \Redirect::route('LdapauthController@login');

        //return view('metronicv460.pages.login');
    }


    public function indevelopment()
    {
        return view('indevelopment');
    }

    /*view that recieves a two numbers and sums them
    */
    public function sum($a, $b)
    {
        return $a + $b;
    }

}

    // //view to test event class
    // public function testEvents(){
    //     $date = Carbon::now();
    //     $isoFormatForDates = 'D [de] MMMM';
    //     if (App::getLocale() == 'en') {
    //         $isoFormatForDates = 'MMMM Do';
    //     }
    //     /*dd(
    //         $date->locale(),            // fr_FR
    //         $date->diffForHumans(),     // il y a 1 seconde
    //         $date->monthName,          // décembre
    //         $date->isoFormat('ll'),   // samedi 31 décembre 2022 15:56
    //         //Long date format without year
    //         $date->isoFormat($isoFormatForDates), // samedi 31 décembre 15:56
    //         App::getLocale()

    //     );*/
    //     $event = new Event(
    //         startDate: '2023-9-01',
    //         endDate: '2023-9-10',
    //         title: 'Test Event',
    //         subtitle: 'Test Event Subtitle',
    //         description: 'same year same month',
    //         link: 'https://www.google.com',
    //     ); // same year same month
    //     $event2 = new Event(
    //         startDate: '2023-9-01',
    //         endDate: '2024-9-10',
    //         title: 'Test Event 2',
    //         subtitle: 'Test Event Subtitle 2',
    //         description: 'same month different year',
    //         link: 'https://www.google.com',
    //     ); // same month different year
    //     $event3 = new Event(
    //         startDate: '2023-9-01',
    //         endDate: '2023-10-10',
    //         title: 'Test Event 3',
    //         subtitle: 'Test Event Subtitle 3',
    //         description: 'same year different month',
    //         link: 'https://www.google.com',
    //     ); // same year different month
    //     $event4 = new Event(
    //         startDate: '2023-9-01',
    //         endDate: '2024-10-10',
    //         title: 'Test Event 4',
    //         subtitle: 'Test Event Subtitle 4',
    //         description: 'different year different month',
    //         link: 'https://www.google.com',
    //     ); // different year different month
    //     $event5 = new Event(
    //         startDate: '2024-9-01',
    //         endDate: '2025-10-10',
    //         title: 'Test Event 5',
    //         subtitle: 'Test Event Subtitle 5',
    //         description: 'startDate different year from current, end and start different month and year',
    //         link: 'https://www.google.com',
    //     ); // different year from current, and end different month
    //     $event6 = new Event(
    //         // startDate: '2024-9-01',
    //         endDate: '2025-10-10',
    //         title: 'Test Event 6',
    //         subtitle: 'Test Event Subtitle 6',
    //         description: 'no start date end date with different year than current',
    //         link: 'https://www.google.com',
    //     ); // no start date
    //     $event6_2 = new Event(
    //         // startDate: '2024-9-01',
    //         endDate: '2023-10-10',
    //         title: 'Test Event 6',
    //         subtitle: 'Test Event Subtitle 6',
    //         description: 'no start date end date with current year',
    //         link: 'https://www.google.com',
    //     ); // no start date
    //     $event7 = new Event(
    //         startDate: '2024-9-01',
    //         // endDate: '2025-10-10',
    //         title: 'Test Event 7',
    //         subtitle: 'Test Event Subtitle 7',
    //         description: 'no end date, start date with different year than current',
    //         link: 'https://www.google.com',
    //     ); // no end date
    //     $event8 = new Event(
    //         startDate: '2023-10-01',
    //         // endDate: '2023-10-01',
    //         title: 'Test Event 8',
    //         subtitle: 'Test Event Subtitle 8',
    //         description: 'no end date and start date with current year',
    //         link: 'https://www.google.com',
    //     ); // no end date
    //     $event9 = new Event(
    //         startDate: '2023-09-01',
    //         endDate: '2023-09-01',
    //         title: 'Test Event 9',
    //         subtitle: 'Test Event Subtitle 9',
    //         description: 'same start date and end date with current year',
    //         link: 'https://www.google.com',
    //     ); // no end date
    //     $event10 = new Event(
    //         startDate: '2024-9-01',
    //         endDate: '2024-9-10',
    //         title: 'Test Event 10',
    //         subtitle: 'Test Event Subtitle 10',
    //         description: 'same year same month, different year from current',
    //         link: 'https://www.google.com',
    //     ); // same year same month
    //     $event11 = new Event(
    //         startDate: '2024-9-01',
    //         endDate: '2025-9-10',
    //         title: 'Test Event 11',
    //         subtitle: 'Test Event Subtitle 11',
    //         description: 'same month different year, different year from current',
    //         link: 'https://www.google.com',
    //     ); // same month different year
    //     $event12 = new Event(
    //         startDate: '2024-9-01',
    //         endDate: '2025-10-10',
    //         title: 'Test Event 12',
    //         subtitle: 'Test Event Subtitle 12',
    //         description: 'same year different month, different year from current',
    //         link: 'https://www.google.com',
    //     ); // same year different month
    //     $event13 = new Event(
    //         startDate: '2025-9-01',
    //         endDate: '2026-10-10',
    //         title: 'Test Event 13',
    //         subtitle: 'Test Event Subtitle 13',
    //         description: 'different year different month, different year from current',
    //         link: 'https://www.google.com',
    //     ); // different year different month17
    //     $event17 = new Event(
    //         startDate: '2025-9-01',
    //         endDate: '2025-9-01',
    //         title: 'Test Event 17',
    //         subtitle: 'Test Event Subtitle 17',
    //         description: 'same day same dates',
    //         link: 'https://www.google.com',
    //     ); // different year different month
    //     //error events (should not be created) eg. end date before start date
    //     $event14 = new Event(
    //         startDate: '2025-9-01',
    //         endDate: '2024-10-10',
    //         title: 'Test Event 14',
    //         subtitle: 'Test Event Subtitle 14',
    //         description: 'start date after end date',
    //         link: 'https://www.google.com',
    //     ); // dates are wrong
    //     $event15 = new Event(
    //         startDate: '2024-10-01',
    //         endDate: '2024-09-10',
    //         title: 'Test Event 15',
    //         subtitle: 'Test Event Subtitle 15',
    //         description: 'start date after end date',
    //         link: 'https://www.google.com',
    //     ); // dates are wrong
    //     $event16 = new Event(
    //         startDate: '2024-09-10',
    //         endDate: '2024-09-01',
    //         title: 'Test Event 15',
    //         subtitle: 'Test Event Subtitle 16',
    //         description: 'start date after end date',
    //         link: 'https://www.google.com',
    //     ); // dates are wrong
    //     dd(
    //         $event->event(),
    //         $event2->event(),
    //         $event3->event(),
    //         $event4->event(),
    //         $event5->event(),
    //         $event6->event(),
    //         $event6_2->event(),
    //         $event7->event(),
    //         $event8->event(),
    //         $event9->event(),
    //         $event10->event(),
    //         $event11->event(),
    //         $event12->event(),
    //         $event13->event(),
    //         $event14->event(),
    //         $event15->event(),
    //         $event16->event(),
    //         $event17->event(),
    //         $date->locale(),           
    //         $date->diffForHumans(),
    //         $date->monthName,
    //         $date->isoFormat('ll'),
    //         $date->isoFormat($isoFormatForDates),
    //     );
    // }