<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Authentication;
use App\Http\Requests\CompanyDetailsRequest;
use App\Models\Colaborador;
use App\Models\Empresa;
use App\Models\Gestor;
use App\Models\Representante;
use App\Models\NaoAluno;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use App\Http\Requests\ConfirmCompanyEmailRequest;
use App\Models\PapelUtilizador;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Function to store company data from confirm email form
     */
    public function confirmEmail(ConfirmCompanyEmailRequest $request)
    {
        $validated = $request->validated();
        $empresa = new Empresa();
        $empresa->fill($validated);
        try {
            $empresa->save();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.nif.notunique'),
                'redirect' => false
            ]);
        }
        $user = Utilizador::where(Utilizador::CONFIRMACAO_HASH, $validated['hash'])->first();
        if ($user) {
            $user->nome = $validated['nome'];
            $user->nome_curto = null;
            //create a nao aluno if it doesn't exist
            $nao_aluno = NaoAluno::firstOrNew(
                [NaoAluno::UTILIZADOR_EMAIL => $user->email]
            );
            if (!$nao_aluno->exists) {
                $nao_aluno->save();
            }
            //create a manager
            $gestor = new Gestor();
            $gestor->cargo = $validated['cargo'];
            $gestor->empresa_id = $empresa->id;
            $gestor->nao_aluno_utilizador_email = $user->email;
            $gestor->save();
            //attach role
            $user->assignRole(PapelUtilizador::Gestor);

            //create a legal rep
            //check if email is different
            $repUser = Utilizador::firstOrNew([Utilizador::EMAIL => $validated['email']]);
            if (!$repUser->exists) {
                $repUser->nome = $validated['nome_representante_legal'];
                $repUser->nome_curto = $validated['nome_representante_legal'];
                $repUser->confirmacao_hash = Authentication::generateHash('EmpresaRelLegal');
                $repUser->save();
                Authentication::sendConfirmationEmail($repUser);
            }
            //check if nao aluno exists
            $nao_aluno = NaoAluno::firstOrNew([
                NaoAluno::UTILIZADOR_EMAIL => $validated['email']
            ]);
            if (!$nao_aluno->exists) {
                $nao_aluno->save();
            }
            //check if legal rep exists
            $repLegal = Representante::firstOrNew(
                [Representante::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']],
                [Representante::EMPRESA_ID => $empresa->id]
            );
            if (!$repLegal->exists) {
                $repLegal->cargo = $validated['cargo_representante_legal'];
                $repLegal->telefone = $validated['phone'];
                $repLegal->save();
            }
            //attach role
            $repUser->assignRole(PapelUtilizador::EmpresaRepLegal);
        }
        $user->confirmacao = true;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => __('company.messages.success'),
            'redirect' => route('login'),
        ]);
    }

    /**
     * Function to edit company data
     */
    public function edit(CompanyDetailsRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = session()->get('user');
            $empresa = null;
            if ($user->nao_aluno->gestor)
                $empresa = $user->nao_aluno->gestor->empresa;
            else if ($user->nao_aluno->representante)
                $empresa = $user->nao_aluno->representante->empresa;
            if (is_null($empresa))
                throw new \Exception("User is not a manager or legal rep, company not found");
            $empresa->fill($validated);
            $empresa->save();
            return response()->json([
                'success' => true,
                'message' => __('company.messages.edit_success'),
                'redirect' => false
            ]);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('company.messages.edit_error'),
                'redirect' => false
            ]);
        }
    }


    /**
     * Function to request new gestor
     */
    public function requestNewGestor(Request $request)
    {
        $requestingUser = session()->get('user');
        $validated = $request->validate([
            'email' => 'required|email',
            'nome' => 'required|string',
        ]);

        $user = Utilizador::firstOrNew(
            [Utilizador::EMAIL => $validated['email']]
        );
        // dd($user);
        if (!$user->exists) {
            $user->nome = $validated['nome'];
            $user->nome_curto = null;
            $user->ativo = true;
            $user->save();
        }

        if (!$user->ativo) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.gestor.error.not_active'),
                'redirect' => false
            ]);
        }
        //check if user is already a nao_aluno
        $nao_aluno = NaoAluno::firstOrNew(
            [NaoAluno::UTILIZADOR_EMAIL => $validated['email']]
        );
        // dd($nao_aluno)  ;
        if (!$nao_aluno->exists) {
            $nao_aluno->save();
        }
        //check if user is already a gestor
        $gestor = Gestor::firstOrNew(
            [Gestor::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($gestor->exists) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.gestor.error.exists'),
                'redirect' => false
            ]);
        }
        //check if is rep legal, if it exists, use data from that.
        $repLegal = Representante::firstOrNew(
            [Representante::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($repLegal->exists) {
            $gestor->cargo = $repLegal->cargo;
            $gestor->empresa_id = $repLegal->empresa_id;
            $gestor->save();
            $user->assignRole(PapelUtilizador::Gestor);
            return response()->json([
                'success' => true,
                'message' => __('company.messages.request.gestor.success_quick'),
                'redirect' => false
            ]);
        } else {
            $gestor->cargo = '';
            if ($requestingUser->nao_aluno->gestor)
                $empresa = $requestingUser->nao_aluno->gestor->empresa;
            else if ($requestingUser->nao_aluno->representante)
                $empresa = $requestingUser->nao_aluno->representante->empresa;
            $gestor->empresa_id = $empresa->id;
            $gestor->save();
        }

        //send email to user to confirm email and cargo (password should be kept if user already exists)


        $user->confirmacao_hash = Authentication::generateHash('Gestor');
        $user->save();
        Authentication::sendConfirmationEmail($user);
        return response()->json([
            'success' => true,
            'message' => __('company.messages.request.gestor.success'),
            'redirect' => false
        ]);
    }


    /**
     * Function to request new legal rep
     */
    public function requestNewRep(Request $request)
    {
        $requestingUser = session()->get('user');
        $validated = $request->validate([
            'email' => 'required|email',
            'nome' => 'required|string',
        ]);

        $user = Utilizador::firstOrNew(
            [Utilizador::EMAIL => $validated['email']]
        );
        // dd($user);
        if (!$user->exists) {
            $user->nome = $validated['nome'];
            $user->nome_curto = null;
            $user->ativo = true;
            $user->save();
        }

        if (!$user->ativo) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.rep.error.not_active'),
                'redirect' => false
            ]);
        }
        //check if user is already a nao_aluno
        $nao_aluno = NaoAluno::firstOrNew(
            [NaoAluno::UTILIZADOR_EMAIL => $validated['email']]
        );
        // dd($nao_aluno)  ;
        if (!$nao_aluno->exists) {
            $nao_aluno->save();
        }
        //check if user is already a rep
        $rep = Representante::firstOrNew(
            [Representante::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($rep->exists) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.rep.error.exists'),
                'redirect' => false
            ]);
        }
        //check if is gestor, if it exists, use data from that.
        $gestor = Gestor::firstOrNew(
            [Gestor::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($gestor->exists) {
            $rep->cargo = $gestor->cargo;
            $rep->empresa_id = $gestor->empresa_id;
            $rep->telefone = '';
            $rep->save();
            $user->assignRole(PapelUtilizador::EmpresaRepLegal);
            return response()->json([
                'success' => true,
                'message' => __('company.messages.request.rep.success_quick'),
                'redirect' => false
            ]);
        } else {
            $rep->cargo = '';
            $rep->telefone = '';
            if ($requestingUser->nao_aluno->representante)
                $empresa = $requestingUser->nao_aluno->representante->empresa;
            else if ($requestingUser->nao_aluno->gestor)
                $empresa = $requestingUser->nao_aluno->gestor->empresa;
            $rep->empresa_id = $empresa->id;
            $rep->save();
        }

        //send email to user to confirm email and cargo (password should be kept if user already exists)


        $user->confirmacao_hash = Authentication::generateHash('RepLegal');
        $user->save();
        Authentication::sendConfirmationEmail($user);
        return response()->json([
            'success' => true,
            'message' => __('company.messages.request.rep.success'),
            'redirect' => false
        ]);
    }

        /**
     * Function to request colaborator
     */
    public function requestNewColab(Request $request)
    {
        $requestingUser = session()->get('user');
        $validated = $request->validate([
            'email' => 'required|email',
            'nome' => 'required|string',
        ]);

        $user = Utilizador::firstOrNew(
            [Utilizador::EMAIL => $validated['email']]
        );
        // dd($user);
        if (!$user->exists) {
            $user->nome = $validated['nome'];
            $user->nome_curto = null;
            $user->ativo = true;
            $user->save();
        }

        if (!$user->ativo) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.colab.error.not_active'),
                'redirect' => false
            ]);
        }
        //check if user is already a nao_aluno
        $nao_aluno = NaoAluno::firstOrNew(
            [NaoAluno::UTILIZADOR_EMAIL => $validated['email']]
        );
        // dd($nao_aluno)  ;
        if (!$nao_aluno->exists) {
            $nao_aluno->save();
        }
        //check if user is already a colab
        $colab = Colaborador::firstOrNew(
            [Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($colab->exists) {
            return response()->json([
                'success' => false,
                'message' => __('company.messages.request.colab.error.exists'),
                'redirect' => false
            ]);
        }
        //check if is gestor or representante, if it exists, use data from that.
        $gestor = Gestor::firstOrNew(
            [Gestor::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        $rep = Representante::firstOrNew(
            [Representante::NAO_ALUNO_UTILIZADOR_EMAIL => $validated['email']]
        );
        if ($gestor->exists || $rep->exists) {
            $colab->cargo = $gestor->cargo ?? $rep->cargo;
            $colab->empresa_id = $gestor->empresa_id ?? $rep->empresa_id;
            $colab->telefone = $rep->telefone ?? '';
            $colab->cv = '';
            $colab->save();
            $user->assignRole(PapelUtilizador::EmpresaColab);
            return response()->json([
                'success' => true,
                'message' => __('company.messages.request.colab.success_quick'),
                'redirect' => false
            ]);
        } else {
            $colab->cargo = '';
            $colab->cv = '';
            $colab->telefone = '';
            if ($requestingUser->nao_aluno->representante)
                $empresa = $requestingUser->nao_aluno->representante->empresa;
            else if ($requestingUser->nao_aluno->gestor)
                $empresa = $requestingUser->nao_aluno->gestor->empresa;
            $colab->empresa_id = $empresa->id;
            $colab->save();
        }

        //send email to user to confirm email and cargo (password should be kept if user already exists)


        $user->confirmacao_hash = Authentication::generateHash('Colab');
        $user->save();
        Authentication::sendConfirmationEmail($user);
        return response()->json([
            'success' => true,
            'message' => __('company.messages.request.colab.success'),
            'redirect' => false
        ]);
    }

    // /**
    //  * Create a legal representative for a company
    //  */
    // public static function createLegalRep(Empresa $empresa, $email, $nome){
    //     //get user or create
    //     $user = Utilizador::firstOrNew(['email' => $email]);
    //     $nao_aluno = NaoAluno::firstOrNew(['utilizador_email' => $email]);
    //     $repLegal = Representante::firstOrNew([
    //         'nao_aluno_utilizador_email' => $email,
    //         'empresa_id' => $empresa->id
    //     ]);
    //     if(!$user->exists){
    //         $user->nome = $nome;
    //         $user->nome_curto = $nome;
    //     }
    //     $user->confirmacao_hash = Authentication::generateHash('EmpresaRelLegal');
    //     $user->save();
    //     Authentication::sendConfirmationEmail($user);
    //     if(!$nao_aluno->exists){
    //         $nao_aluno->save();
    //     }

    //     if(!$repLegal->exists){
    //         $repLegal->cargo = "Placeholder";
    //         $repLegal->telefone = "Placeholder";
    //         $repLegal->save();
    //     }
    // }

    // /**
    //  * Create a manager for a company
    //  */
    // public static function createManager(Empresa $empresa, $empManagerData, bool $isNew = true){
    //     //get user or create
    //     $user = Utilizador::firstOrNew(['email' => $email]);
    //     $nao_aluno = NaoAluno::firstOrNew(['utilizador_email' => $email]);
    //     $gestor = Gestor::firstOrNew([
    //         'nao_aluno_utilizador_email' => $email,
    //         'empresa_id' => $empresa->id
    //     ]);
    //     if(!$user->exists){
    //         $user->nome = "Placeholder";
    //         $user->nome_curto = "Placeholder";
    //     }
    //     $user->confirmacao_hash = Authentication::generateHash('Empresa');
    //     $user->save();
    //     Authentication::sendConfirmationEmail($user);
    //     if(!$nao_aluno->exists){
    //         $nao_aluno->save();
    //     }

    //     if(!$gestor->exists){
    //         $gestor->cargo = "Placeholder";
    //         $gestor->save();
    //     }
    // }

    //Function to deative a given colaborator, manager or legal. Must keep one active, must not deactivate themselves

    
}