<?php

namespace App\Http\Controllers;

use App\DataTables\UtilizadorDataTable;
use App\Helpers\DataTableApi;
use App\Models\Colaborador;
use App\Models\Gestor;
use App\Models\NaoAluno;
use App\Models\PapelUtilizador;
use App\Models\Representante;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GestorController extends Controller
{

    //create a clone of the navbar items array and activate the item with the given index
    public static function activate($index) : array
    {
        $nvbaritems = self::navbaritems();
        $nvbaritems[$index]['active'] = true;
        return $nvbaritems;
    }

    public static function activateByName($name) : array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['name'] == $name) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function activateByRoute($route) : array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['route'] == $route) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function navbaritems() : array
    {
        //check if user is logged in
        $nvbarItems = array(
            [
                'name' => 'Home',
                'route' => 'home',
                'active' => false
            ],
            [
                'name' => __('company.data.data'),
                'route' => 'empresa.dados',
                'active' => false
            ],
            [
                'name' => trans_choice('words.roles.EmpresaColaborador', 2),
                'route' => 'empresa.colaboradores',
                'active' => false
            ],
            [
                'name' => trans_choice('words.proposal',2),
                'route' => 'login',
                'active' => false
            ]
        );

        //append more items acording to user role
        //for docente
        return $nvbarItems;
    }

    //show dados empresa
    public function index()
    {
        return view('layouts.empresa.dados', array(
            'navbaritems' => self::activateByRoute('empresa.dados'),
            'empresa' => session()->get('user')->nao_aluno->gestor->empresa
        )
        );
    }

    public function confirmEmail(Request $request){
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'hash' => 'required|string|exists:utilizador,confirmacao_hash',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);
        $user = Utilizador::where('confirmacao_hash', $validated['hash'])->first();
        $user->password_hash = Hash::make($validated['password']);
        $user->confirmacao = true;
        $user->nome = $validated['nome'];
        $user->save();
        $nao_aluno = $user->nao_aluno;
        if($nao_aluno && !$nao_aluno->exists){
            $nao_aluno = NaoAluno::firstOrNew(
                [NaoAluno::UTILIZADOR_EMAIL => $user->email],
            );
            $nao_aluno->save();
        }
        $gestor = Gestor::firstOrNew(
            [Gestor::NAO_ALUNO_UTILIZADOR_EMAIL => $user->email],
        );
        if(!$gestor->exists){
            $gestor->cargo = $validated['cargo'];
            $gestor->nao_aluno()->associate($nao_aluno);
            $gestor->save();
        }
        $user->assignRole(PapelUtilizador::Gestor);
        return response()->json([
            'success' => true,
            'message' => 'Email confirmed',
            'redirect' => route('home')
        ]);
    }

    public function viewColaboradores(Request $request){
        return view('layouts.empresa.colaboradores', array(
            'navbaritems' => self::activateByRoute('empresa.colaboradores'),
            'empresa' => session()->get('user')->nao_aluno->gestor->empresa,
            'data' 
            )
        );
    }
    public  function viewColaboradoresJSON(Request $request){
        //append data from colaboradores,gestores and representantes

        $empresa = session()->get('user')->nao_aluno->gestor->empresa;
        //get all users that have nao_aluno and that nao_aluno has gestor/representante/colaborador and that colaborador/representante/gestor has empresa and that empresa is the same as the user's empresa
        $colaboradores = Utilizador::whereHas('nao_aluno', function($query) use ($empresa){
            $query->whereHas('colaborador', function($query) use ($empresa){
                $query->whereHas('empresa', function($query) use ($empresa){
                    $query->where('id', $empresa->id);
                });
            })->orWhereHas('representante', function($query) use ($empresa){
                $query->whereHas('empresa', function($query) use ($empresa){
                    $query->where('id', $empresa->id);
                });
            })->orWhereHas('gestor', function($query) use ($empresa){
                $query->whereHas('empresa', function($query) use ($empresa){
                    $query->where('id', $empresa->id);
                });
            });
        })->with([
                'nao_aluno' => [
                    'gestor',
                    'representante',
                    'colaborador' 
                ],
                'papeis'
            ])
        ->get();
        //For each object check if has nome_curto if so, replace with nome, if not, cut the name into a short name
        foreach ($colaboradores as $key => $value) {
            if($value->nome_curto == null){
                $colaboradores[$key]['nome_curto'] = $value->getShortName();
            }
            if($value->nao_aluno->gestor != null){
                $colaboradores[$key]['cargo'] = $value->nao_aluno->gestor->cargo;
                $colaboradores[$key]['telefone'] = '';

            }
            if($value->nao_aluno->representante != null){
                $colaboradores[$key]['cargo'] = $value->nao_aluno->representante->cargo;
                $colaboradores[$key]['telefone'] = $value->nao_aluno->representante->telefone;

            }
            if($value->nao_aluno->colaborador != null){
                $colaboradores[$key]['cargo'] = $value->nao_aluno->colaborador->cargo;
                $colaboradores[$key]['telefone'] = $value->nao_aluno->colaborador->telefone;
            }
            //for each papeis, check if is gestor, representante or colaborador and add to the object as readablename
            foreach ($value->papeis as $key => $papel){
                if($key < count($value->papeis) - 1)
                    $value['papels'] .= $papel->getSelfName(false,true) . ', ';
                else 
                    $value['papels'] .= $papel->getSelfName(false, true);
            }
            if($value['papels'] == null)
                $value['papels'] = '';
        }
        $colaboradores = $colaboradores->toArray();
        foreach ($colaboradores as $key => $value) {
            // unset($colaboradores[$key]['papeis']);
            unset($colaboradores[$key]['nao_aluno']);
        }
        //append data from colaboradores,gestores and representantes to data 
        // $data = json_decode($colaboradores, true);
        // $data = array_merge($data, json_decode($representantes, true));
        // $data = array_merge($data, json_decode($gestores, true));
        // dd($data);
        $datatableapi = new DataTableApi();
        return $datatableapi->inits($colaboradores,[
            'nome_curto',
            'email',
            'cargo',
            'telefone',
            'estado',
            'papels'
        ]);
    }

    /**
     * Deactivate a given colaborator, manager or legal. Must keep one active, must not deactivate themselves
     * @param Request $request
     * @param string $email
     * @param bool $state true to activate, false to deactivate
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeUserState(Request $request)
    {
        $email = $request->input('email');
        $state = $request->input('state');
        $state = $state == 'true' ? true : false;
        $user = Utilizador::where(Utilizador::EMAIL, $email)->first();
        $nao_aluno = NaoAluno::where(NaoAluno::UTILIZADOR_EMAIL, $email)->first();
        $colab = Colaborador::where(Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL, $email)->first();
        $gestor = Gestor::where(Gestor::NAO_ALUNO_UTILIZADOR_EMAIL, $email)->first();
        $rep = Representante::where(Representante::NAO_ALUNO_UTILIZADOR_EMAIL, $email)->first();
        $requestingUserEmail = session()->get('user')->email;
        $requestingUser = Utilizador::where(Utilizador::EMAIL, $requestingUserEmail)->firstOrFail();
        $requestingNaoAluno = NaoAluno::where(NaoAluno::UTILIZADOR_EMAIL, $requestingUserEmail)->firstOrFail();
        //check if user is the one deactivating
        if ($requestingUser && $user && $requestingUser->email == $user->email) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.deactivate.error.self'),
                'redirect' => false
            ]);
        }
        //get company id of user being whose state is being changed, if exists
        $companyId = null;
         if ($colab) {
            $companyId = $colab->empresa_id;
        } else if ($gestor) {
            $companyId = $gestor->empresa_id;
        } else if ($rep) {
            $companyId = $rep->empresa_id;
        }
        //check if requesting user is gestor and if is of same company as the user whose state is being changed
        if ($requestingNaoAluno->gestor && $requestingNaoAluno->gestor->empresa_id != $companyId) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.deactivate.error.not_same_company'),
                'redirect' => false
            ]);
        }
        if($user && $user->ativo == $state)
            return response()->json([
                'success' => false,
                'message' => __('company.messages.deactivate.error.same_state'),
                'redirect' => false
            ]);
            
        if($state == false) {
            //check if user is the last active gestor or legal rep
            if ($gestor && $gestor->ativo && $gestor->empresa_id == $requestingNaoAluno->gestor->empresa_id) {
                $gestores = Gestor::where(Gestor::EMPRESA_ID, $gestor->empresa_id)->whereHas('nao_aluno', function($query){
                    $query->whereHas('utilizador', function ($query) {
                        $query->where(Utilizador::ATIVO, true);
                    });
                })->get();

                if ($gestores->count() == 1) {
                    return response()->json([
                        'success' => false,
                        'message' => __('company.messages.deactivate.error.last_gestor'),
                        'redirect' => false
                    ]);
                }
            }
            if ($rep && $rep->ativo && $rep->empresa_id == $requestingNaoAluno->gestor->empresa_id) {
                $reps = Representante::where(Representante::EMPRESA_ID, $rep->empresa_id)->whereHas('nao_aluno', function($query){
                    $query->whereHas('utilizador', function ($query) {
                        $query->where(Utilizador::ATIVO, true);
                    });
                })->get();

                if ($reps->count() == 1) {
                    return response()->json([
                        'success' => false,
                        'message' => __('company.messages.deactivate.error.last_rep'),
                        'redirect' => false
                    ]);
                }
            }
        }
        
        //if nothing fails, deactive user and return success
        $user->ativo = $state;
        $user->save();
        $state = $state ? 'true' : 'false';
        return response()->json([
            'success' => true,
            'message' => __('company.messages.deactivate.success.'.$state),
            'redirect' => false
        ]);


    }

    /**
     * Function editUser to edit colaborator roles and permissions (gestor, representante, colaborador) in that company.
     * Conditions: 
     *  1) If user is not active or confirmed, cannot edit.
     *  2) If the requesting user is not Gestor, cannot edit.
     *  3) If user is the last active gestor or legal rep, cannot remove gestor or legal rep role from himself.
     *  4) If the edited user is a colaborator, no need to ask for more user details via email.
     *  5) If the edited user is a gestor or legal rep, need to ask for more user details via email.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUser(Request $request)
    {
        $email = $request->input('emailEdit');
        $cargos = $request->input('cargos');

        //$editedUser User being edited
        $editedUser = Utilizador::where(Utilizador::EMAIL, $email)->first();
        $requestingUserEmail = session()->get('user')->email;


        //$requestingUser User making the request
        $requestingUser = Utilizador::where(Utilizador::EMAIL, $requestingUserEmail)->firstOrFail();
        $requestingUserGestor = Gestor::where(Gestor::NAO_ALUNO_UTILIZADOR_EMAIL, $requestingUserEmail)->first();
        $requestingUserCompanyID = $requestingUserGestor->empresa_id;

        //check if user is the one editing
        if ($requestingUser && $editedUser && $requestingUser->email == $editedUser->email) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.edit.error.self'),
                'redirect' => false
            ]);
        }

        //check if user is active and confirmed
        if (!$editedUser->ativo || !$editedUser->confirmacao) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.edit.error.not_active'),
                'redirect' => false
            ]);
        }
        $gestor = $editedUser->nao_aluno->gestor;
        $rep = $editedUser->nao_aluno->representante;
        $colab = $editedUser->nao_aluno->colaborador;
        $companyId = null;
        if ($colab) {
           $companyId = $colab->empresa_id;
        } else if ($gestor) {
           $companyId = $gestor->empresa_id;
        } else if ($rep) {
            $companyId = $rep->empresa_id;
        }

        //check if requesting user is gestor and if is of same company as the user whose state is being changed
        if ($requestingUserGestor && $requestingUserGestor->empresa_id != $companyId) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.deactivate.error.not_same_company'),
                'redirect' => false
            ]);
        }

        //check if edited user is the last gestor or legal rep
        if ($gestor && $gestor->ativo && $gestor->empresa_id == $requestingUserGestor->empresa_id) {
            $gestores = Gestor::where(Gestor::EMPRESA_ID, $gestor->empresa_id)->whereHas('nao_aluno', function($query){
                $query->whereHas('utilizador', function ($query) {
                    $query->where(Utilizador::ATIVO, true);
                });
            })->get();

            if ($gestores->count() == 1) {
                return response()->json([
                    'success' => false,
                    'message' => __('company.messages.deactivate.error.last_gestor'),
                    'redirect' => false
                ]);
            }
        }

        if ($rep && $rep->ativo && $rep->empresa_id == $requestingUserGestor->empresa_id) {
            $reps = Representante::where(Representante::EMPRESA_ID, $rep->empresa_id)->whereHas('nao_aluno', function($query){
                $query->whereHas('utilizador', function ($query) {
                    $query->where(Utilizador::ATIVO, true);
                });
            })->get();

            if ($reps->count() == 1) {
                return response()->json([
                    'success' => false,
                    'message' => __('company.messages.deactivate.error.last_rep'),
                    'redirect' => false
                ]);
            }
        }

        //get edited users roles
        $roles = $editedUser->papeis->pluck('tipo')->toArray();
        //get the difference between edited users roles and the ones being edited
        $rolesToAdd = array_diff($cargos, $roles);
        $rolesToAdd = PapelUtilizador::whereIn(PapelUtilizador::TIPO, $rolesToAdd)->get();
        $rolesToAdd = $rolesToAdd->pluck(PapelUtilizador::TIPO)->toArray();
        
        $rolesToRemove = array_diff($roles, $cargos);
        $rolesToRemove = PapelUtilizador::whereIn(PapelUtilizador::TIPO, $rolesToRemove)->get();
        $rolesToRemove = $rolesToRemove->pluck(PapelUtilizador::TIPO)->toArray();
        //check if $roles contains PapelUtilizador::EmpresaColab
        $isColab = in_array(PapelUtilizador::EmpresaColab, $roles);
        $preExistingData = null;
        if($isColab && $colab){
            //and rolesToAdd has  PapelUtilizador::EmpresaColab, remove that
            if(in_array(PapelUtilizador::EmpresaColab, $rolesToAdd)){
                $rolesToAdd = array_diff($rolesToAdd, [PapelUtilizador::EmpresaColab]);
            }

            //get pre existing data
            $preExistingData['cargo'] = $colab->cargo;
            $preExistingData['telefone'] = $colab->gestor_id;

            //return success
            return response()->json([
                'success' => true,
                'message' => __('company.messages.edit.success'),
                'redirect' => false
            ]);

        }

        $isRep = in_array(PapelUtilizador::EmpresaRepLegal, $roles);
        if($isRep && $rep){
            //and rolesToAdd has  PapelUtilizador::EmpresaRepLegal, remove that
            if(in_array(PapelUtilizador::EmpresaRepLegal, $rolesToAdd)){
                $rolesToAdd = array_diff($rolesToAdd, [PapelUtilizador::EmpresaRepLegal]);
            }

            //get pre existing data
            $preExistingData['cargo'] = $rep->cargo;
            $preExistingData['telefone'] = $rep->telefone;
        }

        $isGestor = in_array(PapelUtilizador::EmpresaRepLegal, $roles);
        if($isGestor && $gestor){
            //and rolesToAdd has  PapelUtilizador::EmpresaRepLegal, remove that
            if(in_array(PapelUtilizador::EmpresaRepLegal, $rolesToAdd)){
                $rolesToAdd = array_diff($rolesToAdd, [PapelUtilizador::EmpresaRepLegal]);
            }

            //get pre existing data
            $preExistingData['cargo'] = $gestor->cargo;

        }


        $editedUser->papeis()->detach($rolesToRemove);
        //$aditionalDataTypes - string containing the profiles of the users that need additional data.

        $aditionalDataTypes = [];
        //foreach role to add, create corresponding object and save it. If colab, use existing colab data
        //cargo can be retrived from other object

        foreach ($rolesToAdd as $role) {

            // $editedUser->papeis()->attach($role);
            switch ($role) {
                case PapelUtilizador::EmpresaColab: 
                    //first or new colab
                    $colab = Colaborador::firstOrNew(
                        [Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL => $editedUser->email],
                    );
                    $colab->empresa_id = $requestingUserCompanyID;
                    $colab->nao_aluno_utilizador_email = $editedUser->email;
                    $colab->cargo = $preExistingData['cargo'] ?? '';
                    $colab->telefone = $preExistingData['telefone'] ?? '';
                    $colab->cv = $preExistingData['cv'] ?? '';
                    $colab->save();
                    $aditionalDataTypes[] = 'Colab';
                    break;
                case PapelUtilizador::EmpresaRepLegal:
                    //first or new rep
                    $rep = Representante::firstOrNew(
                        [Representante::NAO_ALUNO_UTILIZADOR_EMAIL => $editedUser->email],
                    );
                    $rep->empresa_id = $requestingUserCompanyID;
                    $rep->nao_aluno_utilizador_email = $editedUser->email;
                    $rep->cargo = $preExistingData['cargo'] ?? '';
                    $rep->telefone = $preExistingData['telefone'] ?? '';
                    if($rep->cargo == '' || $rep->telefone = '')
                        $aditionalDataTypes[] = 'RepLegal';
                    $rep->save();
                    break;
                case PapelUtilizador::Gestor:
                    //first or new gestor
                    $gestor = Gestor::firstOrNew(
                        [Gestor::NAO_ALUNO_UTILIZADOR_EMAIL => $editedUser->email],
                    );
                    $gestor->empresa_id = $requestingUserCompanyID;
                    $gestor->nao_aluno_utilizador_email = $editedUser->email;
                    $gestor->cargo = $preExistingData['cargo'] ?? '';
                    if($gestor->cargo == '')
                        $aditionalDataTypes[] = 'Gestor';
                    $gestor->save();
                    break;
            }

        }
        // dd($aditionalDataTypes, $preExistingData, $rolesToAdd, $rolesToRemove, $editedUser, $requestingUser, $requestingUserGestor, $requestingUserCompanyID, $gestor, $rep, $colab);
        if(count($aditionalDataTypes)>0){
            //send email to user to fill in the missing data
            $editedUser->sendEmailToFillInData($aditionalDataTypes, $editedUser);
            return response()->json([
                'success' => true,
                'message' => __('company.messages.edit.email_sent'),
                'redirect' => false
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => __('company.messages.edit.success'),
                'redirect' => false
            ]);
        }

    }

}
