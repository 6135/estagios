<?php

namespace App\Http\Controllers;

use App\EmpresaColaborador;
use App\EmpresaPedidoRegisto;
use App\EmpresaRepresentante;
use App\Estagio;
use App\Mail\MailQueuer;
use App\Role;
use App\User;
use App\UserAccessLog;
use Illuminate\Http\Request;
use App\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class EmpresaController extends Controller
{


    /**
     * This function validEmail() is used to validate an email address. It takes a string as an argument and returns either TRUE or FALSE depending on whether the string is a valid email address or not. The regular expression used in the function checks if the string contains a valid combination of characters, including lowercase letters, numbers, plus signs, underscores and hyphens. It also checks for an '@' symbol and a valid domain name with at least two characters after the last period.
     * @param $str string to be validated
     * @return bool true if valid, false if not
     */
    private static function validEmail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    /**
     * Displays the register page for companies
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function registoPublico(Request $request) {
        $empresa = array();

        $username = '';

        if(session()->has('login')) {
            $username = session()->get('login');
        }

        $ual = new UserAccessLog();
        $ual->username = $username;
        $ual->details = 'ACCESS PAGE : empresa : registopublico';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();

        return view('metronicv510.pages.empresaRegistoPublico', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'empresa' => $empresa));
    }

    /**
     * Handles the incoming register request and validates the data, also sends email to confirm request
     * @param Request $request
     * @return false|string
     */
    public function novoregisto(Request $request) {
        $message = '';
        $result = true;
        $formData = (array)$request->json()->all();

        if($formData['password1']!=$formData['password2']) {
            $message = 'Verifique as passwords';
            $result = false;

            return json_encode(array('result'=>$result, 'message'=>$message));
        }

        if(!self::validEmail($formData['email'])) {
            $message = 'Verifique o endereço de email';
            $result = false;

            return json_encode(array('result'=>$result, 'message'=>$message));
        }

        $empresa = Empresa::where('pcolectivaempresa', $formData['nif'])->get();

        if(count($empresa)>0) {
            $message = 'Ja existe uma empresa registada com esse NIF';
            //TODO: Add to translation file
            $result = false;

            return json_encode(array('result'=>$result, 'message'=>$message));
        }

        $empresa = Empresa::where('emailempresa',$formData['email'])->get();

        if(count($empresa)>0) {
            $message = 'O endereço de email já existe, tente recuperar a password';
            //TODO: Add to translation file
            $result = false;

            return json_encode(array('result'=>$result, 'message'=>$message));
        }

        if($result) {
            $seed = 'Zeichaebu2ahfongahro';
            $hash = sha1(uniqid($seed . mt_rand(), true));

            $empresaPedidoRegisto = new EmpresaPedidoRegisto();
            $empresaPedidoRegisto->email = $formData['email'];
            $empresaPedidoRegisto->password = $formData['password1'];
            $empresaPedidoRegisto->nif = $formData['nif'];
            $empresaPedidoRegisto->ipAddressReg = $request->ip();
            $empresaPedidoRegisto->accountConfirmHash = $hash;
            $empresaPedidoRegisto->accountConfirmation = 0;

            $empresaPedidoRegisto->save();

            $message = 'Registo criado com sucesso, verifique o seu endereço de email';

            $targeturl = config('app.url') . '/empresa/registopublico-fase2/' . $hash;
            Log::debug($targeturl);

            $mailData = array(
                'actiontype' => 'created',
                'nomedestino' => 'nome',
                'targeturl' => $targeturl,
                'emailAddress' => $formData['email'],
                'subject' => 'Registo de empresa na plataforma de estágios',
                'view' => 'emails.mail-1',
            );


            Mail::queue(new MailQueuer($mailData));


        }


        $ual = new UserAccessLog();
        $ual->username = session()->get('login');
        $ual->details = 'ACCESS PAGE : empresa : registopublico : save';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();


        return json_encode(array('result'=>$result, 'message'=>$message));
        //return json_encode(array('result'=>$result, 'message'=>$message, 'request' => $formData));
    }
    /**
     * Displays the register page after confirming request, asks for more data
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|void
     */
    public function registoPublicoFase2($id) {
        //dd($id);
        $opcoesFormulario = array();

        $registo = array();
        //$registo['request'] = $request;
        $registo['id'] = $id;

        //$registo['db'] = DB::select("select * from empresa where accountConfirmHash='" . $id . "'");

        //QUANDO HASH NAO EXISTE, MOSTRA ERRO "Sorry, the page you are looking for could not be found."
        $registo['db2'] = EmpresaPedidoRegisto::where([['accountConfirmHash','=',$id], ['accountConfirmation','=','0']])->firstOrFail()->getOriginal();
        //dd($registo);
        unset($registo['db2']['password']);

        //dd($registo);

        $registo['nif'] = EmpresaPedidoRegisto::where([['accountConfirmHash',$id], ['accountConfirmation','=','0']])->firstOrFail()->nif;

        $registo['db'] = DB::select("select * from empresa where pcolectivaempresa='" . $registo['nif'] . "'");


        if(sizeof($registo['db'])==0) {
            //NAO EXISTE EMPRESA COM O NIF INDICADO -> REGISTAR NOVA
            $opcoesFormulario['tipo'] = 'nova-empresa';
            $opcoesFormulario['token'] = $id;

            return view('metronicv510.pages.empresaRegistoPublicoFase2nova', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'dados' => array('token' => $id, 'opcoes' => $opcoesFormulario, 'registo' => $registo['db2'], 'session' => session()->all())));

        } else if(sizeof($registo['db'])==1) {
            //EXISTE 1 EMPRESA COM O NIF INDICADO -> REGISTAR COMO COLABORADOR

            //dd($registo['db2']['email']);

            //VERIFICA SE TOKEN JÁ UTILIZADO E COLABORADOR JÁ REGISTADO
            $ec = EmpresaColaborador::where('email', $registo['db2']['email'])->get();
            if(sizeof($ec)>0) {
                return view('message', array('message' => 'Invalid token'));
            }

            $opcoesFormulario['tipo'] = '1-empresa-encontrada';
            $empresa = array('nome' => $registo['db'][0]->nomeempresa);

            return view('metronicv510.pages.empresaRegistoPublicoFase2colaborador', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'dados' => array('token' => $id, 'opcoes' => $opcoesFormulario, 'registo' => $registo['db2'], 'session' => session()->all(), 'empresa' => $empresa)));

        }else if(sizeof($registo['db'])>=1) {
            //EXISTE MAIS QUE 1 EMPRESA COM O NIF INDICADO -> SOLICITAR EMPRESA DA LISTA
            session()->put('nif', $registo['nif']);
            //Log::debug($registo['db2']['accountConfirmHash']);
            session()->put('accountConfirmHash', $registo['db2']['accountConfirmHash']);
            $opcoesFormulario['tipo'] = 'varias-empresas-encontradas';

            return view('metronicv510.pages.empresaRegistoPublicoFase2multiplas', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'dados' => array('token' => $id, 'opcoes' => $opcoesFormulario, 'registo' => $registo['db2'], 'session' => session()->all())));
        }

        //dd($registo);
    }

    /**
     * This exists to save data from old companies, such that they dont have to renter everything again.
     * @param Request $request
     * @return false|string
     */
    public function registoPublicoFase22Save(Request $request) {
        $formData = $request->json()->all();
        //return json_encode($formData);

        if(isset($formData['cbdeclaracao'])) {
            if($formData['cbdeclaracao']!='on') {
                return json_encode(array('result' => false, 'message' => 'Verifique a checkbox de declaração de veracidade dos dados'));
            }
        } else {
            return json_encode(array('result' => false, 'message' => 'Verifique a checkbox de declaração de veracidade dos dados'));
        }

        $epr = EmpresaPedidoRegisto::where([['accountConfirmHash','=',$formData['token']], ['accountConfirmation','=','0']])->get();
        Log::debug('save-company');
        $formData['eprsize'] = sizeof($epr);
        $formData['epr'] = $epr;
        $formData['eprnif'] = $epr[0]['nif'];

        if(sizeof($epr) == 1) {
            $nif = $epr[0]['nif'];
            //$nif = '510510515';
            //$formData['emprexxxxxaxx'] = $nif;
            $empresa = Empresa::where('pcolectivaempresa',$nif)->get();
            $formData['emprexxxxxa'] = $empresa[0]->idempresa;

            //return json_encode($formData);

            //VERIFICAR SE JÁ EXISTE ANTES DE REGISTAR NOVO

            $ec = EmpresaColaborador::where('email', $formData['email'])->get();

            if(sizeof($ec) > 0) {
                return json_encode(array('result' => false, 'message' => 'Colaborador já existe, tente recuperação da password ou contacte-nos via helpdesk@dei.uc.pt'));
            }

            $empC = new EmpresaColaborador();
            $empC->titulo = $formData['titulo'];
            $empC->nome = $formData['nome'];
            $empC->cargo = $formData['cargo'];
            $empC->email = $formData['email'];
            $empC->telefone = $formData['telefone'];
            $empC->empresa = $empresa[0]->idempresa;
            $empC->accountConfirmHash = '';
            $empC->accountConfirmation = 0;
            $empC->accountConfirmed = 0;
            $empC->password = '';
            dd("end of test");
            if($empC->save()) {
                return json_encode(array('result' => true, 'message' => 'Colaborador registado com sucesso'));
            } else {
                return json_encode(array('result' => false, 'message' => 'Erro ao registar novo colaborador, contacte-nos via helpdesk@dei.uc.pt'));
            }
        }

        return json_encode(array('result' => false, 'message' => 'Erro ao registar novo colaborador, contacte-nos via helpdesk@dei.uc.pt'));
    }

    /**
     * Saves all the remaining company data
     * @param Request $request
     * @return false|string|void
     */
    public function registoPublicoFase2Save(Request $request) {
        //$formData = (array)$request->json()->all();
        $formData = $request->json()->all();
        $formData['accountConfirmHash'] = session()->get('accountConfirmHash');
        //$registo['db2'] = EmpresaPedidoRegisto::where('accountConfirmHash',$id)->firstOrFail()->getOriginal();

        /*echo "ok [";
        print_r($formData['accountConfirmHash']);
        echo "]";
        die();*/

        Log::debug('----------------AKI 1----------------');

        $epr = EmpresaPedidoRegisto::where([['accountConfirmHash','=',$formData['token']], ['accountConfirmation','=','0']])->firstOrFail();

        $empresa = Empresa::where('pcolectivaempresa',$epr->nif)->get();
        // $empresa = DB::select("select * from empresa where pcolectivaempresa='" . $epr->nif . "'");
        //select * from empresa where pcolectivaempresa='226814360';

        //VERIFICAR SE EMPRESA EXISTE
        if(sizeof($empresa)==0) {
            //CASO NÃO EXISTA, CRIAR
            //$formData['nome']
            //$epr->nif

            //Log::debug('NIF:');
            Log::debug(array('NIF', $epr->nif));
            Log::debug(array('formData',$formData));

            //$formData['actividade'], $formData['sede'], $formData['url'], $formData['telefone'], $formData['rlnome'], $formData['rlcargo'], $formData['rltitulo']
            //if($formData['nome']!='' || $formData['actividade']!='' || $formData['telefone']!='') {
            if($formData['nome']!='' &&
                $formData['actividade']!='' &&
                $formData['telefone']!='' &&
                $formData['rlnome']!='' &&
                $formData['rlcargo']!='' &&
                $formData['rlemail']!='') {
                    
                if(!Helper::validEmail($formData['rlemail'])) {
                    return json_encode(array('message' => 'O endereço de email incorrecto, verifique os dados introduzidos', 'result'=> false));
                }

                $password = sha1($epr->password);
                //TODO: Change this to eloquent
                Log::debug("INSERT COMPANY");
                Log::debug( [$epr->nif, $formData['nome'], $epr->email, $password, $formData['acronimo'] ?? null, $formData['actividade'], $formData['sede'], $formData['url'] ?? null, $formData['telefone'], $formData['rlnome'], $formData['rlcargo'], $formData['rltitulo'] ?? null, 1, now(), now(), now()]);
                $dbInsertResult = DB::insert('insert into empresa (pcolectivaempresa, nomeempresa, emailempresa, password, acronimoempresa, actividadeempresa, moradaempresa, urlempresa, telefoneempresa, responsavelempresa, cresponsavelempresa, tresponsavelempresa, accountConfirmation, created, datadeclaracao, lastlogin) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$epr->nif, $formData['nome'], $epr->email, $password, $formData['acronimo'] ?? null, $formData['actividade'], $formData['sede'], $formData['url'] ?? null, $formData['telefone'], $formData['rlnome'], $formData['rlcargo'], $formData['rltitulo'] ?? null, 1, now(), now(), now()]);
                $empresaObj = Empresa::where('pcolectivaempresa',$epr->nif)->get()->first();
                //assign it a user 
                $user = User::userFromCompany($empresaObj);
                Log::debug(array('dbInsertResult', $dbInsertResult));
                $idEmpresa = DB::getPdo()->lastInsertId();
                //insert into empresa (pcolectivaempresa, nomeempresa, created) values ('226814360','dgl',now());

                if ($dbInsertResult) {
                    $epr->accountConfirmation = 1;
                    $epr->dataconfirm = now();
                    $epr->ipAddressConf = $request->ip();
                    $epr->save();
                    Log::debug(array('lastInsertId', $idEmpresa));
                    //TODO: Change this to eloquent
                    $dbInsertResult = DB::insert('insert into empresa_representantes (empresa, titulo, nome, cargo, email, created_at, accountConfirmHash, accountConfirmation, accountConfirmed, password) values (?,?,?,?,?,?,?,?,?,?)', [$empresaObj->idempresa, $formData['rltitulo'] ?? null, $formData['rlnome'], $formData['rlcargo'], $formData['rlemail'], now(), '', '0', '0','']);
                    $rl = EmpresaRepresentante::where('email',$formData['rlemail'])->first();
                    //if company and rl were created, dont send rl email
    
                    if($formData['rlemail'] ==  $user->email){
                        $user->assignRoleByName('EmpresaRepresentanteLegal');
                        $rl->accountConfirmation = 1;
                        $rl->accountConfirmed = 1;
                        $rl->save();
                    }
                    else {
                        $rl->registerEmail();
                    }
                    return json_encode(array('message' => 'Empresa registada com sucesso, pode efectuar login', 'result'=> true));
                }
            }else {
                return json_encode(array('message' => 'Verifique os campos obrigatórios', 'result'=> false));
            }

            //OBTER LASTINSERTID PARA REGISTAR NOVO REPRESENTANTE LEGALG
            //rltitulo
            //rlnome
            //rlcargo
        } else {
            $message = 'empresa existe';
            //$result = false;
            return json_encode(array('message' => 'A empresa já existe, contacte suporte helpdesk@dei.uc.pt', 'result'=> false));
        }

        /*
                $epr->accountConfirmation=1;
                $epr->save();*/

        /*        echo "ok";
                die();*/

        Log::debug('----------------AKI 2----------------');
        Log::debug($epr);



        echo json_encode(array('message' => 'Dados atualizados com sucesso, já pode efectuar login. Será redirecionado em segundos...', 'result'=> true, 'form'=>$formData, 'info'=>array(1,2,3)));
    }


    public function colaboradorSetNewPassView($hash) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)
        //TODO: Check Hash
        //echo $hash;

        return view('metronicv510.pages.colaboradorSetNewPassword', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'hash' => $hash));
    }

    public function empresaSetNewPassView($hash, Request $request) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)
        //TODO: Check Hash
        //echo $hash;

        $ual = new UserAccessLog();
        $ual->username = $hash;
        $ual->details = 'ACCESS PAGE : empresa : definirpassword';
        $ual->status = '--';
        $ual->ipAddress = $request->ip();
        $ual->save();

        return view('metronicv510.pages.empresaSetNewPassword', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'hash' => $hash));
    }

    public function representanteSetNewPassView($hash) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)
        //TODO: Check Hash

        //echo $hash;

        return view('metronicv510.pages.representanteSetNewPassword', array('title' => 'Plataforma de Gestão de Estágios : Empresa', 'hash' => $hash));
    }

    public function colaboradorSetNewPassService(Request $request) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();
        Log::debug(array('formData' => $formData));

        if($formData['password1'] == $formData['password2'] && $formData['password1'] != '') {
            //$rl = new EmpresaColaborador();
            $rl = EmpresaColaborador::where('accountConfirmHash', $formData['hash'])->where('accountConfirmed', 0)->orderBy('id', 'desc')->first();
            //$rl = EmpresaColaborador::where('accountConfirmHash', 'b7928c794f5ad2c18670fb7dc7260b815e39be9e')->orderBy('id', 'desc')->first();
            //$empresas = Empresa::where('estadoempresa',1)->take(10)->get();

            Log::debug('--------------------------------------------------');
            Log::debug(array('EmpresaColaborador' => $rl));
            Log::debug('--------------------------------------------------');

            if($rl!=null) {
                $rl->password=sha1($formData['password1']);
                $rl->accountConfirmed=1;
                $rl->save();
                //Log::debug(array('EmpresaColaborador' => $rl));
                if(count($rl->user()->get())==1){
                    $user = $rl->user()->first();
                    //$user->password=sha1($formData['password1']);
                    $user->accountConfirmed=1;
                    $user->accountConfirmation=1;
                    $user->save();
                    //Assign role
                    $user->assignRoleByName(Role::getProfileName(Role::EmpresaColaborador));
                } else {
                    User::userFromColaborador($rl);
                }
                $data['result'] = true;
                $data['message'] = 'Password definida com sucesso';
            } else {
                $data['result'] = false;
                $data['message'] = 'Token inválido';
            }
        } else {
            $data['result'] = false;
            $data['message'] = 'Passwords diferem';
        }

        if($formData['password1'] == '' || $formData['password2'] == '') {
            $data['result'] = false;
            $data['message'] = 'Verifique as passwords';
        }

        echo json_encode($data);
    }

    public function representanteSetNewPassService(Request $request) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();
        Log::debug(array('formData' => $formData));

        if($formData['password1'] == $formData['password2'] && $formData['password1'] != '') {
            //$rl = new EmpresaColaborador();
            $rl = EmpresaRepresentante::where('accountConfirmHash', $formData['hash'])->where('accountConfirmed', 0)->orderBy('id', 'desc')->first();
            //$rl = EmpresaColaborador::where('accountConfirmHash', 'b7928c794f5ad2c18670fb7dc7260b815e39be9e')->orderBy('id', 'desc')->first();
            //$empresas = Empresa::where('estadoempresa',1)->take(10)->get();

            Log::debug('--------------------------------------------------');
            Log::debug(array('EmpresaRepresentante' => $rl));
            Log::debug('--------------------------------------------------');

            if($rl!=null) {
                $rl->password=sha1($formData['password1']);
                $rl->accountConfirmed=1;
                $rl->save();
                //Log::debug(array('EmpresaColaborador' => $rl));
                //check if it has a user associated
                if(count($rl->user()->get())== 1) {
                    $user = $rl->user()->get()->first();
                    $user->password=sha1($formData['password1']);
                    $user->accountConfirmed=1;
                    $user->accountConfirmation=1;
                    $user->save();
                    $user->assignRoleByName(Role::getProfileName(Role::EmpresaRepresentanteLegal));
                } else {
                    Log::debug($user = User::userFromRepresentanteLegal($rl));
                    Log::debug($user->roles()->get());
                }
                $data['result'] = true;
                $data['message'] = 'Password definida com sucesso';
            } else {
                $data['result'] = false;
                $data['message'] = 'Token inválido';
            }
        } else {
            $data['result'] = false;
            $data['message'] = 'Passwords diferem';
        }

        if($formData['password1'] == '' || $formData['password2'] == '') {
            $data['result'] = false;
            $data['message'] = 'Verifique as passwords';
        }

        echo json_encode($data);
    }

    public function empresaSetNewPassService(Request $request) {
        //VERIFICAR SE HASH VÁLIDA... (SE CONSTA EM BD E SE JÁ FOI UTILIZADA)

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();
        Log::debug(array('formData' => $formData));

        if($formData['password1'] == $formData['password2'] && $formData['password1'] != '') {
            $rl = Empresa::where('accountConfirmHash', $formData['hash'])->where('accountConfirmation', 0)->orderBy('idempresa', 'desc')->get();


            //return json_encode(sizeof($rl));
            //return json_encode($rl);
            //return json_encode($data);
            //return json_encode($formData);
            //return json_encode(sha1($formData['password1']));

            //Log::debug('--------------------------------------------------');
            //Log::debug(array('EmpresaRepresentante' => $rl));
            //Log::debug('--------------------------------------------------');

            //die();

            if($rl) {
                if(count($rl) == 1) {
                    $rl=$rl->first();
                    $rl->password = sha1($formData['password1']);
                    $rl->accountConfirmation = 1;
                    $rl->save();
                    if(count($rl->user()->get())==1){
                        $user = $rl->user()->get()[0];
                        $user->password=sha1($formData['password1']);
                        $user->accountConfirmed=1;
                        $user->accountConfirmation=1;
                        $user->save();
                        $user->assignRoleByName(Role::getProfileName(Role::Empresa));
                    } else {
                        User::userFromCompany($rl);
                    }
                    $data['result'] = true;
                    $data['message'] = 'Password definida com sucesso';


                    //enviar email a indicar que a pass foi alterada
                } else {
                    $data['result'] = false;
                    $data['message'] = 'Empresa não existe';
                }
            } else {
                $data['result'] = false;
                $data['message'] = 'Token inválido';
            }
        } else {
            $data['result'] = false;
            $data['message'] = 'Passwords diferem';
        }

        if($formData['password1'] == '' || $formData['password2'] == '') {
            $data['result'] = false;
            $data['message'] = 'Verifique as passwords';
        }

        echo json_encode($data);
    }

    public function colaboradorActivacaoService(Request $request) {
        //CONFIRMAR EMPRESA, LOGIN/SESSÃO

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();

        $rl = EmpresaColaborador::where('id', $formData['id'])->orderBy('id', 'asc')->first();

        if($rl!=null) {
            if($formData['activa']==0){
                $rl->deleted_at=DB::raw('now()');
            }else{
                $rl->deleted_at=DB::raw('null');
            }
            $rl->save();
            //check if rl has user object
            
            $data['result'] = true;
            $data['message'] = 'Colaborador desactivado';
            $data['title'] = 'Colaboradores';
        } else {
            $data['result'] = false;
            $data['message'] = 'Erro ao desactivar colaborador';
            $data['title'] = 'Colaboradores';
        }

        echo json_encode($data);
    }

    public function colaboradorRecuperacaoPasswordService(Request $request) {
        //CONFIRMAR EMPRESA, LOGIN/SESSÃO

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();

        $rl = EmpresaColaborador::where('id', $formData['id'])->orderBy('id', 'asc')->first();
        if($rl->recuperaPassword()){
            $data['result'] = true;
            $data['message'] = 'Verifique o seu email';
            $data['title'] = 'Recuperação de password';
        };

        echo json_encode($data);
    }


    /**
     * Creates new colaborators from modal
     * @param Request $request
     * @return false|string|void
     */
    public function empresaNovoColaborador(Request $request) {
        if(session()->get('profile') != Role::Empresa && session()->get('profile') != Role::EmpresaRepresentanteLegal)
            return json_encode(array(
                'result' => false,
                'message' => 'Nao tem permissões para efetuar esta ação',
            ));

        $formData = $request;

        if($formData['nome'] == '' || $formData['cargo'] == '' || $formData['email'] == '') {
            return json_encode(array(
                'result' => false,
                'message' => 'Ocorreu erro, verifique os campos do formulário ou contacte helpdesk@dei.uc.pt',
            ));
        }

        if(!Helper::validEmail($formData['email'])) {
            return json_encode(array(
                'result' => false,
                'message' => 'Verifique o endereço de email',
            ));
        }

        $data = array(
            'result' => true,
            'data' => $formData,
            'message' => 'Colaborador adicionado com sucesso',
            'titulo' => $formData['titulo'] ?? null
        );

        $seed = 'Zeichaebu2ahfongahro';
        $hash = sha1(uniqid($seed . mt_rand(), true));

        $rlCheck = count(EmpresaColaborador::where('email', $formData['email'])->orderBy('id', 'desc')->get());

        if($rlCheck>0) {
            $data['result']=false;
            $data['message']='Colaborador já existe';
        } else {
            $someForm = 0;
            $rl = new EmpresaColaborador();
            $rl->titulo = $formData['titulo'] ?? null;
            $rl->nome = $formData['nome'];
            $rl->cargo = $formData['cargo'];
            $rl->email = $formData['email'];
            $rl->telefone = $formData['telefone'];
            if(isset($formData['checkFormacao'])) {
                $rl->formacao = $formData['checkFormacao'];
                $someForm++;
            }
            if(isset($formData['checkExperienciaRelevante'])) {
                if (isset($formData['anos'])) {
                    $rl->anosexperiencia = $formData['anos'];
                    $someForm++;
                }
                else {
                    $rl->anosexperiencia = 0;
                    return json_encode(array(
                        'result' => false,
                        'message' => 'Ocorreu erro, verifique os campos do formulário ou contacte helpdesk@dei.uc.pt',
                    ));
                }
            }
            if($someForm == 0){
                return json_encode(array(
                    'result' => false,
                    'message' => 'Deve Introduzir pelo menos um tipo de formação.',
                ));
            }

            $rl->accountConfirmation = '';
            $rl->accountConfirmed = 0;
            $rl->password = '';
            $rl->accountConfirmHash = $hash;
            $userAlreadyExists = false;


            if ($formData['idempresa'] == null) {

                $empresa = session()->get('id');
                $rl->empresa = $empresa;
            } else {
                $rl->empresa = $formData['idempresa'];
            }
            if(!$formData['filename']){
                return json_encode(array(
                    'result' => false,
                    'message' => 'Tem de submeter o CV',
                ));
            } else {
                $filename = $formData['filename'].".pdf";
                $file = Storage::disk('temporary')->get($filename);
                $store = Storage::disk('public')->put($filename,$file);
                if($store)
                     Storage::disk('temporary')->delete($filename);
                else return json_encode(array(
                    'result' => false,
                    'message' => 'O ficheiro nao foi guardado com sucesso'
                ));
                $rl->cv_colab=$filename;
                $rl->save();
                if(count($rl->user()->get())==1){
                    $user = $rl->user()->get()->first();
                    $user->assignRoleByName('EmpresaColaborador');
                    $user->save();
                    // Log::debug($rl->user()->get()->first());
                    // Log::debug(User::where('email',$formData['email'])->get());
                    $userAlreadyExists = true;
                }
            }


            //----------------------------ENVIO DE EMAIL----
            $mailData = array(
                'actiontype' => 'newcolabsetpass',
                'nomedestino' => 'nome',
                'targeturl' => env('APP_URL') . '/colaborador/definirpassword/' . $hash,
                'emailAddress' => $formData['email'],
                'mensagem' => 'Foi adicionado como colaborador de uma empresa na plataforma de estágios do DEI @ FCTUC',
                'subject' => 'Confirmar registo como colaborador',
                'view' => 'emails.mail-1',
            );
            if($userAlreadyExists == false)
                Mail::queue(new MailQueuer($mailData));

            //----------------------------------------------
        }

        echo json_encode($data);
    }

    /**
     * Creates new external colaborators ext from modal for external colaborator
     * @param Request $request
     * @return false|string|void
     */
    public function empresaNovoColaboradorExterno(Request $request) {
        if(session()->get('profile') != Role::Empresa && session()->get('profile') != Role::EmpresaRepresentanteLegal)
            return json_encode(array(
                'result' => false,
                'message' => 'Nao tem permissões para efetuar esta ação',
            ));

        $formData = $request;

        if($formData['nome'] == '' or $formData['email'] == '') {
            return json_encode(array(
                'result' => false,
                'message' => 'Ocorreu erro, verifique os campos do formulário ou contacte helpdesk@dei.uc.pt',
            ));
        } else if(!Helper::validEmail($formData['email'])) {
            return json_encode(array(
                'result' => false,
                'message' => 'Verifique o endereço de email',
            ));
        }

        $data = array(
            'result' => true,
            'data' => $formData,
            'message' => 'Colaborador adicionado com sucesso',
            'titulo' => $formData['titulo'] ?? null
        );

        $seed = 'Zeichaebu2ahfongahro';
        $hash = sha1(uniqid($seed . mt_rand(), true));
        //TODO: Add check if colab that exists belongs to same company
        $rlCheck = count(EmpresaColaborador::allColab()->where('email', $formData['email'])->orderBy('id', 'desc')->get());
        if($rlCheck>0) {
            $data['result']=false;
            $data['message']='Colaborador já existe';
            
        } else {
            $someForm = 0;
            $rl = new EmpresaColaborador();
            $rl->externo = 1;
            $rl->titulo = $formData['titulo'] ?? null;
            $rl->nome = $formData['nome'];
            $rl->cargo = $formData['cargo'] ?? null;
            $rl->email = $formData['email'];
            $rl->telefone = $formData['telefone'] ?? null;
            // if(isset($formData['checkFormacao'])) {
            //     $rl->formacao = $formData['checkFormacao'];
            //     $someForm++;
            // }
            // if(isset($formData['checkExperienciaRelevante'])) {
            //     if (isset($formData['anos'])) {
            //         $rl->anosexperiencia = $formData['anos'];
            //         $someForm++;
            //     }
            //     else {
            //         $rl->anosexperiencia = 0;
            //         return json_encode(array(
            //             'result' => false,
            //             'message' => 'Ocorreu erro, verifique os campos do formulário ou contacte helpdesk@dei.uc.pt',
            //         ));
            //     }
            // }
            // if($someForm == 0){
            //     return json_encode(array(
            //         'result' => false,
            //         'message' => 'Deve Introduzir pelo menos um tipo de formação.',
            //     ));
            // }

            // $rl->accountConfirmation = '';
            // $rl->accountConfirmed = 0;
            // $rl->password = '';
            // $rl->accountConfirmHash = $hash;

            if ($formData['idempresa'] == null) {

                $empresa = session()->get('id');
                $rl->empresa = $empresa;
            } else {
                $rl->empresa = $formData['idempresa'];
            }
            // if(!$formData['filename']){
            //     return json_encode(array(
            //         'result' => false,
            //         'message' => 'Tem de submeter o CV',
            //     ));
            // } else {
            //     $filename = $formData['filename'].".pdf";
            //     $file = Storage::disk('temporary')->get($filename);
            //     $store = Storage::disk('public')->put($filename,$file);
            //     if($store)
            //          Storage::disk('temporary')->delete($filename);
            //     else return json_encode(array(
            //         'result' => false,
            //         'message' => 'O ficheiro nao foi guardado com sucesso'
            //     ));
            //     $rl->cv_colab=$filename;
                
            // }

            $rl->save();
            $data['colabExt'] = array(
                'nome' => $rl->nome,
                'email' => $rl->email,
                'id' => $rl->id
            );
            //----------------------------ENVIO DE EMAIL----
            // $mailData = array(
            //     'actiontype' => 'newcolabsetpass',
            //     'nomedestino' => 'nome',
            //     'targeturl' => env('APP_URL') . '/colaborador/definirpassword/' . $hash,
            //     'emailAddress' => $formData['email'],
            //     'mensagem' => 'Foi adicionado como colaborador de uma empresa na plataforma de estágios do DEI @ FCTUC',
            //     'subject' => 'Confirmar registo como colaborador',
            //     'view' => 'emails.mail-1',
            // );
            // Mail::queue(new MailQueuer($mailData));

            //----------------------------------------------
        }

        echo json_encode($data);
    }

    /**
     * Upload CV
     * @param Request $request - file to upload
     * @return string - filename
     */
    public function colaboradorcv(Request $request){
        if(session()->get('profile') == Role::Empresa || session()->get('profile') == Role::EmpresaRepresentanteLegal) {
            $file = $request->validate([
                'file' => 'required|mimes:pdf|max:100000',
            ]);
            if (!$file) {
                return json_encode(array(
                    'result' => false,
                    'message' => 'Erro ao submeter o CV',
                ));
            } else {
                $path = $request->file('file')->store('', 'temporary');
                $filename = pathinfo($path, PATHINFO_FILENAME);


            }

            return json_encode(['filename' => $filename]);
        } else {
            return json_encode(['filename' => ""]);
        }
    }

    /**
     * Update CV, delete old one and store new one
     * @param Request $request - file to upload
     * @return string - filename
     */
    public function colaboradorUpdateCV(Request $request){
        if(session()->get('profile') != Role::Empresa && session()->get('profile') != Role::EmpresaRepresentanteLegal)
            return json_encode(array(
                'result' => false,
                'message' => 'Nao tem permissões para efetuar esta ação',
            ));
        $colab = EmpresaColaborador::query()->findOrFail($request['colabID']);
        $newFileName = $request['filename'].".pdf";
        $currentFileName = $colab->cv_colab;
        $file = Storage::disk('temporary')->get($newFileName);
        $store = Storage::disk('public')->put($newFileName,$file);
        if($store) {
            Storage::disk('temporary')->delete($newFileName);
            Storage::disk('public')->delete($currentFileName);
            $colab->cv_colab = $newFileName;
        }
        $colab->save();

        return json_encode(array(
            'result' => true,
            'message' => 'CV Alterado com sucesso'
        ));
    }

    /**
     * Criar novo representante legal a partir do modal
     * @param Request $request
     * @return false|string|void
     */
    public function novorepresentantelegal(Request $request)
    {
        $formData = (array)$request->json()->all();

        if($formData['nome'] == '' || $formData['cargo'] == '' || $formData['email'] == '') {
            return json_encode(array(
                'result' => false,
                'message' => 'Ocorreu erro, verifique os campos do formulário ou contacte helpdesk@dei.uc.pt',
            ));
        }

        if(!Helper::validEmail($formData['email'])) {
            return json_encode(array(
                'result' => false,
                'message' => 'Verifique o endereço de email',
            ));
        }

        $data = array(
            'data' => $formData,
            'result' => 0,
            'message' => 'the message',
            'titulo' => $formData['titulo'] ?? null
        );

        $seed = 'Zeichaebu2ahfongahro';
        $hash = sha1(uniqid($seed . mt_rand(), true));

        //VERIFICACOES ANTES DE ADICIONAR
        $zemail = $formData['email'];
        $rlCheck = count(EmpresaRepresentante::where('email', $zemail)->orderBy('id', 'desc')->get());

        //Log::debug(array('counter', $rlCheck));

        if ($rlCheck > 0) {
            $data['result'] = false;
            $data['message'] = 'Representante legal já existe, se tem dificuldades em aceder, tente recuperar password ou contactar helpdesk@dei.uc.pt';
        } else {
            $rl = new EmpresaRepresentante();
            $rl->titulo = $formData['titulo'] ?? null;
            $rl->nome = $formData['nome'];
            $rl->cargo = $formData['cargo'];
            $rl->email = $formData['email'];
            $rl->telefone = $formData['telefone'];

            if ($formData['idempresa'] == null) {
                $empresa = session()->get('id');
                $rl->empresa = $empresa;
            } else {
                $rl->empresa = $formData['idempresa'];
            }

            $saveRes = $rl->save();
            $rl->registerEmail();
            if ($saveRes == 1) {
                $data['result'] = 1;
                $data['message'] = "Novo representante legal registado com sucesso";
            } else {
                $data['result'] = 0;
                $data['message'] = "Ocorreu um erro ao registar o novo representante legal";
            }
        }
        echo json_encode($data);
    }

    public function representanteActivacaoService(Request $request) {
        //CONFIRMAR EMPRESA, LOGIN/SESSÃO

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();

        $rl = EmpresaRepresentante::where('id', $formData['id'])->orderBy('id', 'asc')->first();

        if($rl!=null) {
            if($formData['activa']==0){
                $rl->deleted_at=DB::raw('now()');
            }else{
                $rl->deleted_at=DB::raw('null');
            }
            $rl->save();

            $data['result'] = true;
            $data['message'] = 'Representante desactivado';
            $data['title'] = 'Representantes';
        } else {
            $data['result'] = false;
            $data['message'] = 'Erro ao desactivar representante';
            $data['title'] = 'Representantes';
        }

        echo json_encode($data);
    }

    public function representanteRecuperacaoPasswordService(Request $request) {
        //CONFIRMAR EMPRESA, LOGIN/SESSÃO

        $data = array(
            'result' => false,
            'message' => ''
        );

        $formData = $request->json()->all();
        /*echo json_encode($formData['id']);
        die();*/

        //$rl = EmpresaRepresentante::where('id', 1);
        //echo json_encode($formData['id']);
        //$rl = EmpresaRepresentante::where('id', $formData['id'])->orderBy('id', 'asc')->first();
        //die();

        $rl = EmpresaRepresentante::where('id', $formData['id'])->orderBy('id', 'asc')->first();

        if($rl->recuperaPassword()){
            $data['result'] = true;
            $data['message'] = 'Verifique o seu email';
            $data['title'] = 'Recuperação de password';
        };

        echo json_encode($data);
    }
}
