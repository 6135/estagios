<?php

namespace App\Http\Controllers;

use Adldap\Adldap;
use App\AreaTecnologica;
use App\Curso;
use App\Docente;
use App\Empresa;
use App\Documento;
use App\EmpresaColaborador;
use App\EstagioAction;
use App\EstagioVersions;
use App\Helpers\Helper;
use App\Helpers\DataTableApi;
use App\Http\Requests\NovoEstagioRequest;
use App\Jobs\SendWelcomeEmail;
use App\Jobs\SendNotificationEmail;
use App\EstagioHasOpcaoTematica;
use App\OpcaoTematica;
use App\Role;
use App\Scopes\ColaboradorInternoScope;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\EstagioPeriodo;
use App\Estagio;
use Illuminate\Database\QueryException;
use App\UserAccessLog;
use Illuminate\Support\Facades\Log;
use DB;
use Config;
use function MongoDB\BSON\toJSON;
class EstagioController extends Controller
{

    public function showViewLista(Request $request)
    {
        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE lista de estagios';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        $categoryNames = array();
        $sidebarItems = array();
        switch (session()->get('profile')){
            case Role::Empresa:
                $categoryNames = Empresa::category();
                $sidebarItems = Empresa::items();
                break;
            case Role::EmpresaColaborador:
                $categoryNames = EmpresaColaborador::category();
                $sidebarItems = EmpresaColaborador::items();
                break;
            case Role::Docente:
                $categoryNames = Docente::category();
                $sidebarItems = Docente::items();
                break;
        }

        //dd($this->dbNormalize());
        $actions = EstagioAction::orderBy('created',"DESC")->take(7)->get();
        $userLogs = UserAccessLog::orderBy('created_at','DESC')->take(10)->get();
        $estados = $this->getEstado(0);
        return redirect('dashboard');

    }

    private function getEstado(int $idEstado) {
        return Estagio::getEstado($idEstado);
    }

    public function tabledataEstagios() {

        $estagios = array();
        $idEmpresa = 0;
        switch (session()->get('profile')) {
            case Role::Empresa:
                $idEmpresa=session()->get('id');
                $estagios = Estagio::with(['colaboradores' => function($query) {
                    $query->allColab()->select("titulo","nome");
                }, 'aluno' => function($query) {
                    $query->select('emailaluno','nomealuno');
                }] )
                    ->select(
                        'idestagio',
                        'tituloestagio',
                        'estadoestagio',
                        'data_defesaInt',
                        'alunoatribuido'
                    )
                    ->where('empresa_idempresa',$idEmpresa)->get();
                break;
            case Role::Docente:
                $docente = User::find(session()->get('id'))->docente;
                $estagios = $docente->estagios()->with(['docentes'=> function($query){
                    $query->select('nomedocente as nome');
                },'colaboradores' => function ($query){
                    $query->allColab()->select("titulo","nome");
                }, 'aluno'
                 => function ($query) {
                    $query->select('emailaluno','nomealuno');
                }
                ])
                    ->select(
                        'idestagio',
                        'tituloestagio',
                        'estadoestagio',
                        'data_defesaInt',
                        'alunoatribuido'
                    )
                    ->where('empresa_idempresa',1)->get();
                break;
            case Role::EmpresaColaborador:

                $colab = EmpresaColaborador::allColab()->where('email',(session()->get('login')))->first();
                $estagios = $colab->estagios()->with(['docentes'=> function($query){
                    $query->select('nomedocente as nome');
                },'colaboradores' => function ($query){
                    $query->allColab()->select("titulo","nome");
                }, 'aluno' => function ($query) {
                    $query->select('emailaluno','nomealuno');
                }])
                    ->select(
                        'idestagio',
                        'tituloestagio',
                        'estadoestagio',
                        'data_defesaInt',
                        'alunoatribuido'
                    )
                    ->where('empresa_idempresa',session()->get('id'))->get();
                Log::debug($estagios);
                break;
        }

        $data = [];
        foreach ($estagios as $estagio) {
            if(is_null($estagio->aluno))
                $estagio->nomealuno = "Sem aluno atribuido";
            else $estagio->nomealuno = $estagio->aluno->emailaluno . "@student.dei.uc.pt";
            $estagio->estadoestagiotext = Estagio::getEstado($estagio->estadoestagio)['text'];
            $estagio->estadoestagiobadge = Estagio::getEstado($estagio->estadoestagio)['badge'];
            $estagio->candidatosCount = count($estagio->alunos);
            $estagio->operationOID = $estagio->idestagio;
            //add all from estagio docentes to estagio colaboradores and concat all the nome in responsaveis to a string separated by comma
            $estagio->responsaveis = implode(", ",array_column(array_merge($estagio->colaboradores->toArray(),$estagio->docentes->toArray()),'nome'));

            $data[] = $estagio;
            
        }
        $dtb = new DataTableApi();
        return $dtb->inits($data);

    }

    public function compararVersoes(Request $request, $id, $idcomparar=null)
    {
        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE lista de estagios';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        $categoryNames = array();
        $sidebarItems = array();
        $idEmpresa = 0;

        switch (session()->get('profile')) {
            case Role::Empresa:
                $categoryNames = Empresa::category();
                $sidebarItems = Empresa::items();
                $idEmpresa = session()->get('id');
                break;
            case Role::EmpresaColaborador:
                $categoryNames = EmpresaColaborador::category();
                $sidebarItems = EmpresaColaborador::items();
                $idEmpresa = session()->get('id');
                break;
        }


        $actions = EstagioAction::all()->sortByDesc('created')->take(7);
        $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);

        $estados = Estagio::getEstado(0);
        if($idcomparar == null){
            $newEstagio = Estagio::with(['colaboradores','aluno'])
                ->where('empresa_idempresa',$idEmpresa)
                ->find($id);
            $oldEstagio = EstagioVersions::with(['colaboradores','aluno'])
                ->where('empresa_idempresa',$idEmpresa)
                ->orderBy('idestagio_versions','DESC')->first();
            if($oldEstagio)
                return view('metronicv815.layout.estagios.proposalShow', array(
                    'oldVersion' => $oldEstagio,
                    'newVersion' => $newEstagio,
                    'title' => 'Plataforma de Gestão de Estágios',
                    'actions' => $actions,
                    'logs' => $userLogs,
                    'estados' => $estados,
                    'categoryNames' => $categoryNames,
                    'sidebaritems' => $sidebarItems,
                ));
            else
                return view('metronicv815.layout.estagios.estagiosTable', array(
                    'compareAction' => route('compararVersoes', $id, ""),
                    'tableActionURL' => route('versionData', $id),
                    'title' => 'Plataforma de Gestão de Estágios',
                    'actions' => $actions,
                    'logs' => $userLogs,
                    'estados' => $estados,
                    'categoryNames' => $categoryNames,
                    'sidebaritems' => $sidebarItems,
                ));
        } else {
            $newEstagio = Estagio::with(['colaboradores','aluno'])
                ->where('empresa_idempresa',$idEmpresa)
                ->find($id);
            $oldEstagio = EstagioVersions::with(['colaboradores','aluno'])
                ->where('empresa_idempresa',$idEmpresa)
                ->find($idcomparar);
            return view('metronicv815.layout.estagios.proposalShow', array(
                'oldVersion' => $newEstagio,
                'newVersion' => $oldEstagio,
                'title' => 'Plataforma de Gestão de Estágios',
                'actions' => $actions,
                'logs' => $userLogs,
                'estados' => $estados,
                'categoryNames' => $categoryNames,
                'sidebaritems' => $sidebarItems,
            ));
        }
    }

    public function compararVersoesData($id){
        $estagios = array();
        if (session()->get('profile') == 2) {
            Log::debug(session()->get('id'));

            $estagios = Estagio::where('empresa_idempresa',session()->get('id'))
                ->find($id)->versoes()
                ->with('colaboradores')
                ->get();
        }

        $data = [];
        foreach ($estagios as $estagio) {
            if(is_null($estagio->aluno))
                $estagio->nomealuno = "TBD";
            Estagio::getEstado(1);
            $estagio->estadoestagiotext = Estagio::getEstado($estagio->estadoestagio)['text'];
            $estagio->estadoestagiocolour = Estagio::getEstado($estagio->estadoestagio)['colour'];
            $estagio->operationOID = $estagio->idestagio_versions;
            $data[] = $estagio;
        }
        $dtb = new DataTableApi();
        return $dtb->inits($data);
    }

    public function propostasNova(Request $request,$idEstagio = null)
    {

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE nova proposta de estagios';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();
        $displayColab2 = true;
        $displayColab3 = false;
        $empresa=false;
        $colab = null;
        switch (session()->get('profile')) {
            case Role::Empresa:
            case Role::EmpresaRepresentanteLegal:
                $idEmpresa = session()->get('id');
                $empresa = Empresa::findOrFail($idEmpresa);
                $estagioOrientadores = $empresa->empresaColaborador()->allColab()->get();
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = Empresa::category();
                $sidebaritems = Empresa::items();
                break;
            case Role::Docente:
                $empresa = Empresa::findOrFail(1);
                $idDocente = User::find(session()->get('id'))->docente->iddocente;
                $colab = User::find(session()->get('id'))->docente->nomedocente;
                $estagioOrientadores = Docente::where('iddocente','!=',$idDocente)
                    ->where('nomedocente','!=','')
                    ->orderBy('nomedocente','ASC')
                    ->get();
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = Docente::category();
                $sidebaritems = Docente::items();
                $displayColab2 = true;
                break;
            case Role::EmpresaColaborador:

                $empresa = Empresa::findOrFail(session()->get('id'));
                $colab = EmpresaColaborador::allColab()->where('email',session()->get('login'))->first()->nome;
                $estagioOrientadores = $empresa->empresaColaborador;
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = EmpresaColaborador::category();
                $sidebaritems = EmpresaColaborador::items();
                $displayColab2 = false;
                break;
            default:
                return redirect(route('CompanyDashboard'));
        }



        $mytimeAsString = Carbon::now()->toDateString();
        $periodosEstagio = EstagioPeriodo::where('datainicio','<=',$mytimeAsString)
                                         ->where('datafim','>=',$mytimeAsString)
                                         ->get();


        if($idEstagio!=null) {
            
            try {
                $estagio = Estagio::findOrFail($idEstagio);
                $loginTmp = session()->get('login');
                $profileTmp = session()->get('profile');
                //if $estagio->docentes()->get() is not empty and one of the logindocente == login$tmp
                
                if($profileTmp==Role::Docente &&
                    count($estagio->docentes()->get()->where('logindocente',$loginTmp)) != 1){

                        abort(404);
                }

                if($profileTmp==Role::EmpresaColaborador &&
                count($estagio->colaboradores()->allColab()->get()->where('email','cordeiro@onesource.pt')) != 1)
                        abort(404);
            } catch (\Exception $e) {
                // Log::debug($e);
                abort(400);
            }

            
        }
        else {
            $estagio = new Estagio();
            $estagio->desejaentrevistas = -1;
            $estagio->empresa_idempresa=$empresa->idempresa;
        }
        
        if(count($periodosEstagio)==0) {
            if($idEstagio==null)
                return view('message', array('message' => 'Não existem períodos de estágio abertos.'));

            return redirect(route('verDetalhes',$idEstagio));
        }
        if($estagio->opcaoTematica()->first()){
            $opcoeTematicaDesc = $estagio->opcaoTematica()->first()->descricao;
        }        else $opcoeTematicaDesc = null;
        
        // dd($empresaRepresentantes);

        return view('metronicv815.layout.estagios.proposal', array(
            'self' => $colab ?? null,
            'estagio' => $estagio,
            'empresa' => $empresa,
            'opcoeTematicaDesc' => $opcoeTematicaDesc,
            'periodosEstagio' => $periodosEstagio,
            'empresaColaboradores' => $estagioOrientadores,
            'empresaRepresentantes' => $empresaRepresentantes,
            'displayColab2' => $displayColab2,
            'displayColab3' => $displayColab3,
            'sidebaritems' => $sidebaritems,
            'categoryNames' => $categoryNames,
            'title' => config('estagios.siteTitle'))
        );

    }

    public function getOpcaoTematica($curso){

        return Curso::query()->where('titulo',$curso)->first()->areas ?? null;

    }

    public function sumbitEstagio(NovoEstagioRequest $request){

        try {
            $mytimeAsString = Carbon::now()->toDateString();
            EstagioPeriodo::where('datainicio','<=',$mytimeAsString)
                ->where('datafim','>=',$mytimeAsString)
                ->findOrFail($request->periodo_estagios);
            
        } catch (Exception $e){
            return view('message', array('message' => 'Não existem períodos de estágio abertos.'));
        }

        $profile_type = session()->get('profile');

        Log::debug("function submitEstagio: " . json_encode($request)."---------------");
        $data = $request; // request is already converted and validated using FormRequest class

        switch (session()->get('profile')) {
            case Role::Empresa:
                $idAutor = session()->get('id');
                $empresa = Empresa::query()->find($idAutor);
                break;
            case Role::Docente:
                $empresa = Empresa::query()->find(1);
                $docente = User::find(session()->get('id'))->docente;
                $data->legal_rep = 0;
                break;
            case Role::EmpresaColaborador:
                $empresa = Empresa::findOrFail(session()->get('id'));
                $colab = EmpresaColaborador::where('email',session()->get('login'))->first();
                break;

            default:
                dd("err");
                break;
        }



        $periodoAssoc = EstagioPeriodo::find($request->periodo_estagios);

        if ($data->estagioID != null) {
            $estagio = Estagio::findOrFail($data->estagioID);
            $oldestagio = new EstagioVersions();
            $oldestagio->saveFromEstagio($estagio);

        } else { $estagio = new Estagio();}


        $estagio->empresa_idempresa = $empresa->idempresa;
        $estagio->periodo_estagio_idperiodo_estagio = $periodoAssoc->idperiodo_estagio;
        $estagio->tituloestagio = $data->titEstagio;
        $estagio->empresa_representantelegal = $data->legal_rep;
        $estagio->empresaestagio = $empresa->nomeempresa;
        $estagio->enquadramento = $data->TextareaEnquandramento;
        $estagio->objectivoestagio = $data->TextareaObjetivos;
        $estagio->ptrabalhosestagio = $data->TextareaPlano1Semestre;
        $estagio->ptrabalhosestagio2 = $data->TextareaPlano2Semestre;
        $estagio->condicoesestagios = $data->TextareaCondicoes;
        $estagio->observacoesestagio = $data->TextareaElementosAdicionais;

        if($data->radioCheckEntrevistas==2){
            $estagio->desejaentrevistas = 1;
        } elseif($data->radioCheckEntrevistas==1) {$estagio->desejaentrevistas = 0;}

        $estagio->localestagio = $data->floatingInputLocal;
        $estagio->emailaluno = $data->inputEmailAluno;
        $estagio->save();

        /**
         * Adicionar areas
         */

        if ($data->floatingSelectAE != null) {
            optional(optional($estagio->opcaoTematica)[0])->delete();
            optional(optional($estagio->opcaoTematica)[1])->delete();

            $areaEspeciladeObrigatoria = new EstagioHasOpcaoTematica();
            $areaEspeciladeObrigatoria->opcaotematica_idopcaotematica = $data->floatingSelectAE;

            $areaEspeciladeObrigatoria->ordem = 1;
            $ocap = OpcaoTematica::find($data->floatingSelectAE);
            if ($ocap->fillField) {
                $areaEspeciladeObrigatoria->descricao = $data->TextareaOpcaoTematica;
            } else {$areaEspeciladeObrigatoria->descricao = null;}

            $estagio->opcaoTematica()->save($areaEspeciladeObrigatoria);
            
            if ($data->floatingSelectAE2 != null && is_null($data->TextareaOpcaoTematica)){

                $areaEspeciladeOpcional = new EstagioHasOpcaoTematica();
                $areaEspeciladeOpcional->opcaotematica_idopcaotematica = $data->floatingSelectAE2;
                $areaEspeciladeOpcional->ordem = 2;

                $estagio->opcaoTematica()->save($areaEspeciladeOpcional);
            }
        }


        /**
         * Adicionar Orientadores externos
         */
        Log::debug("------------Profiles type----------------");
        Log::debug($profile_type);
        switch ($profile_type){
            case Role::Empresa:
                $estagio->colaboradores()->detach();
                $estagio->colaboradores()->attach($data->colab1, ['ordem' => 1]);
                if ($data->colab2 != -1 && $data->colab2 > 0 ){
                    $estagio->colaboradores()->attach($data->colab2, ['ordem' => 2]);
                }
                if ($data->colab3 != -2 && $data->colab3 > 0){
                    $estagio->colaboradores()->attach($data->colab3, ['ordem' => 3]);
                }
                break;
            case Role::Docente:
                $estagio->docentes()->detach();

                $estagio->docentes()->attach($docente->logindocente, ['docentedisponivel' => 0]);
                Log::debug($data->colab1);
                if ($data->colab1 != $docente->logindocente && $data->colab1 != null && $data->colab1 != '-1'){
                    $estagio->docentes()->attach($data->colab1, ['docentedisponivel' => 1]);
                }
                if ($data->colab2 != -1 && $data->colab2 != null && $data->colab2 != '-2'){
                    $estagio->docentes()->attach($data->colab2, ['docentedisponivel' => 2]);
                }
                break;
            case Role::EmpresaColaborador:
                $estagio->colaboradores()->detach();
                $estagio->colaboradores()->attach($colab->id, ['ordem' => 0]);
                if ($data->colab1 != $colab->id && $data->colab1 != null ){
                    $estagio->colaboradores()->attach($data->colab1, ['ordem' => 1]);
                }
                break;
            default: dd("err"); break;
        }

        return redirect()->route('CompanyDashboard');
    }

    public function propostasDetalhes(Request $request, $idEstagio)
    {

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE ver proposta de estagios';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();
        $displayColab2 = true;
        $displayColab3 = false;
        $empresa=false;
        $colab = null;
        switch (session()->get('profile')) {
            case Role::Empresa:
            case Role::EmpresaRepresentanteLegal:
                $idEmpresa = session()->get('id');
                $empresa = Empresa::findOrFail($idEmpresa);
                $estagioOrientadores = $empresa->empresaColaborador()->allColab()->get();
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = Empresa::category();
                $sidebaritems = Empresa::items();
                break;
            case Role::Docente:
                $empresa = Empresa::findOrFail(1);
                $idDocente = User::find(session()->get('id'))->docente->iddocente;
                $colab = User::find(session()->get('id'))->docente->nomedocente;
                $estagioOrientadores = Docente::where('iddocente','!=',$idDocente)
                    ->where('nomedocente','!=','')
                    ->orderBy('nomedocente','ASC')
                    ->get();
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = Docente::category();
                $sidebaritems = Docente::items();
                $displayColab2 = true;
                break;
            case Role::EmpresaColaborador:

                $empresa = Empresa::findOrFail(session()->get('id'));
                $colab = EmpresaColaborador::allColab()->where('email',session()->get('login'))->first()->nome;
                $estagioOrientadores = $empresa->empresaColaborador;
                $empresaRepresentantes = $empresa->empresaRepresentante;
                $categoryNames = EmpresaColaborador::category();
                $sidebaritems = EmpresaColaborador::items();
                $displayColab2 = false;
                break;
            default:
                return redirect(route('CompanyDashboard'));
                break;
        }


        if($idEstagio!=null) {
            $estagio = Estagio::findOrFail($idEstagio);
            try {
                $loginTmp = session()->get('login');
                $profileTmp = session()->get('profile');

                //Check if is Docente and if is the same as the one in the estagio
                if($profileTmp==Role::Docente &&
                count($estagio->docentes()->get()->where('logindocente',$loginTmp)) != 1)
                        abort(404);

                //Check if is EmpresaColaborador and if is the same as the one in the estagio
                if($profileTmp==Role::EmpresaColaborador &&
                count($estagio->colaboradores()->allColab()->get()->where('email',$loginTmp)) != 1)
                        abort(404);

                //Check if is EmpresaRepresentanteLegal and if is the same as the one in the estagio
                if($profileTmp==Role::EmpresaRepresentanteLegal &&
                count($estagio->empresa()->get()->where('emailrepresentantelegal',$loginTmp)) != 1)
                        abort(404);
                
                //Check if is Empresa and if is the same as the one in the estagio
                if($profileTmp==Role::Empresa &&
                count($estagio->empresa()->get()->where('emailempresa',$loginTmp)) != 1)
                        abort(404);
                
            } catch (\Exception $e) {
                Log::debug($e);
                abort(400);
            }
                $periodosEstagio = $estagio->periodoEstagio()->get();
            
        }
        
        return view('metronicv815.layout.estagios.proposal', array(
            'self' => $colab ?? null,
            'estagio' => $estagio,
            'empresa' => $empresa,
            'opcoeTematicaDesc' => optional($estagio->opcaoTematica)[0]['descricao'],
            'periodosEstagio' => $periodosEstagio,
            'empresaColaboradores' => $estagioOrientadores,
            'empresaRepresentantes' => $empresaRepresentantes,
            'displayColab2' => $displayColab2,
            'displayColab3' => $displayColab3,
            'sidebaritems' => $sidebaritems,
            'categoryNames' => $categoryNames,
            'title' => config('estagios.siteTitle'),
            'viewMode' => true
            )
        );

    }

    public function verDetalheCandidatos($id){
        $estagios = array();
        $idEmpresa = 0;
        switch (session()->get('profile')) {
            case Role::Empresa:
                $idEmpresa=session()->get('id');
                $estagio = Estagio::where('idestagio',$id)->where('empresa_idempresa',$idEmpresa)->get()->first();
                break;
            case Role::Docente:
                $docente = User::find(session()->get('id'))->docente;
                $estagio = $docente->estagios()->where('idestagio',$id)->where('empresa_idempresa',1)->get()->first();
                // $estagio = $estagio->first();
                break;
            case Role::EmpresaColaborador:
                Log::debug('EmpresaColaborador');
                $colab = EmpresaColaborador::where('email',(session()->get('login')))->first();
                Log::debug('EmpresaColaborador 2');
                $estagio = $colab->estagios()->where('idestagio',$id)->where('empresa_idempresa',session()->get('id'))->get()->first();
                Log::debug('EmpresaColaborador 3');
                // $estagio = $estagio->first();
                break;
        }

        $data = [];
        //sum 1 +1

        //get estagios many to many from aluno with two pivot num_escolha and perfiladequado
        //sum 1 + 1
        Log::debug($estagio);
        $alunos = $estagio->alunos()->withPivot('num_escolha','perfiladequado')->select(
            'aluno.idaluno',
            'aluno.nomealuno',
            'aluno.emailaluno',
            'medialicenciatura',
            'cvaluno'
        )->get();
        //utf8 encode nomealuno in alunos.
        
        

        $alunos = $alunos->map(function($aluno){
            // $aluno->nomealuno = utf8_encode($aluno->nomealuno);
            $aluno->nomealuno = utf8_decode($aluno->nomealuno);
            $aluno->cvaluno = utf8_decode($aluno->cvaluno);
            return $aluno;
        });


        
        foreach ($alunos as $aluno) {
            //alunoData new object
            $alunoData = $aluno;
            

            if($aluno->pivot->perfiladequado == 1){
                $alunoData->perfiladequado = $aluno->pivot->perfiladequado;
            } elseif($aluno->pivot->perfiladequado == null) {
                $alunoData->perfiladequado = 'null';
            }
            else {
                $alunoData->perfiladequado = 2;
            }
            $alunoData->num_escolha = $aluno->pivot->num_escolha;
            $alunoData->operationOID =$aluno->idaluno;
            unset($alunoData->idaluno);
            $data[] = $alunoData;

        }
        //log to debug $data

        // dd($data);
        $dtb = new DataTableApi();
        return $dtb->inits($data);
    }

    public function verDetalheCandidatosTable(Request $request , $id = null) {
        $theView= 'metronicv815.layout.estagios.estagiosCandidatesTable';
        $categoryNames = array();
        $sidebarItems = array();
        $profileAction = "";

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE candidates table';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();

        if(session()->has('profile')) {
            switch (session()->get('profile')) {
                case Role::Empresa:
                    $idEmpresa=session()->get('id');
                    $estagio = Estagio::where('empresa_idempresa',$idEmpresa)->where('idestagio',$id)->get();
                    $estagio = $estagio->first();
                    $categoryNames = Empresa::category();
                    $sidebarItems = Empresa::items();
                    break;
                case Role::Docente:
                    $docente = User::find(session()->get('id'))->docente;
                    $estagio = $docente->estagios()->where('idestagio',$id)->where('empresa_idempresa',1)->get();
                    $estagio = $estagio->first();
                    $categoryNames = Docente::category();
                    $sidebarItems = Docente::items();

                    break;
                case Role::EmpresaColaborador:
                    $colab = EmpresaColaborador::where('email',(session()->get('login')))->first();
                    $estagio = $colab->estagios()->where('idestagio',$id)->where('empresa_idempresa',session()->get('id'))->get();
                    $estagio = $estagio->first();
                    $categoryNames = EmpresaColaborador::category();
                    $sidebarItems = EmpresaColaborador::items();
                    break;
                default:
                    $estagio = null;
                    die();
                    break;
            }
        }

        return view($theView, array('title' => 'Plataforma de Gestão de Estágios',
            'estagio' => $estagio,
            'compareAction' => route('gerirCandidato'),
            'tableActionURL' => route('estagiosCandidatesJSON'),
            'categoryNames' => $categoryNames,
            'sidebaritems' => $sidebarItems,
        ));
    }

    public function gerirCandidato(Request $request , $idEstagio = null, $idCandidato = null, $apply = null) {
        $theView= 'metronicv815.layout.estagios.estagiosCandidatesTable';
        $categoryNames = array();
        $sidebarItems = array();
        $profileAction = "";

        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE candidates table';
        $ual->status = 'OK';
        $ual->ipAddress = $request->ip();
        $ual->save();
        //TODO: Must check if estagio is within candidatura time or selection time.
        if(session()->has('profile')) {
            switch (session()->get('profile')) {
                case Role::Empresa:
                    $idEmpresa=session()->get('id');
                    $estagio = Estagio::where('empresa_idempresa',$idEmpresa)->where('idestagio',$idEstagio)->get();
                    $estagio = $estagio->first();
                    break;
                case Role::Docente:
                    $docente = User::find(session()->get('id'))->docente;
                    $estagio = $docente->estagios()->where('idestagio',$idEstagio)->where('empresa_idempresa',1)->get();
                    $estagio = $estagio->first();
                    break;
                case Role::EmpresaColaborador:
                    $colab = EmpresaColaborador::where('email',(session()->get('login')))->first();
                    $estagio = $colab->estagios()->where('idestagio',$idEstagio)->where('empresa_idempresa',session()->get('id'))->get();
                    $estagio = $estagio->first();
                    break;
                default:
                    $estagio = null;
                    die();
                    break;
            }
        }
        //get estagio alunos, find one with idaluno = $idCandidato and pivot perfiladequado = to apply if apply,idCandidado and $idEstagio not default
        if($idEstagio != null && $idCandidato != null && $apply != null){
            $estagio->alunos()->updateExistingPivot($idCandidato, ['perfiladequado' => $apply]);
        }
        
        return redirect(route('estagiosCandidates', ['id' => $idEstagio]));
    }
}
