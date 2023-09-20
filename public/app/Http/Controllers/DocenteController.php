<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteFormRequest;
use App\Http\Requests\DocentePropostaFormRequest;
use App\Models\Docente;
use App\Models\Estado;
use App\Models\Proposta;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

class DocenteController extends Controller
{
    //create a clone of the navbar items array and activate the item with the given index
    public static function activate($index): array
    {
        $nvbaritems = self::navbaritems();
        $nvbaritems[$index]['active'] = true;
        return $nvbaritems;
    }

    public static function activateByName($name): array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['name'] == $name) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function activateByRoute($route): array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['route'] == $route) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function navbaritems(): array
    {
        //check if user is logged in
        $nvbarItems = array(
            [
                'name' => 'Home',
                'route' => 'home',
                'active' => false
            ],
            [
                'name' => trans_choice('professor.proposals', 2),
                'route' => 'docente.propostas',
                'active' => false
            ],
            [
                'name' => trans_choice('professor.meeting', 2),
                'route' => 'docente.reunioes',
                'active' => false
            ],
            [
                'name' => trans_choice('professor.jury.participation', 2),
                'route' => 'docente.participacoes',
                'active' => false
            ],
            [
                'name' => trans_choice('words.personaldata', 1),
                'route' => 'docente.dados',
                'active' => false
            ]
        );

        //append more items acording to user role
        //for docente
        return $nvbarItems;
    }

    //show dados aluno
    public function index()
    {
        return view(
            'layouts.docente.dados',
            array(
                'navbaritems' => self::activateByRoute('docente.dados'),
            )
        );
    }

    //edit
    public function dadosEdit(DocenteFormRequest $request)
    {
        //check if post or get
        $validated = $request->validated();
        //find or create a student;
        $docente = Docente::find(session()->get('user')->email);
        $user = session()->get('user');
        $user->fill($validated);
        $docente->fill($validated);
        $docente->save();
        $user->save();
        session()->put('user', $user);
        return json_encode([
            'success' => true,
            'message' => 'Dados guardados com sucesso!',
            'redirect' => route('docente.dados'),
            'data' => $docente
        ]);
    }

    //list Associated proposals
    public function propostas()
    {
        return view('layouts.docente.propostas', array(
            'navbaritems' => self::activateByRoute('docente.propostas'),
        )
        );
    }

    //add or edit a proposal
    public function propostaStore(DocentePropostaFormRequest $request)
    {
        //save incoming proposal
        $validated = $request->validated();
        $owner_email = session()->get('user')->email;
        $validated['nao_aluno_utilizador_email'] = $owner_email;
        $validated['estado_nome'] = Estado::AGUARDA_REVISAO_COOR_CURSO;
        $validated['deseja_entrevistas'] = false;
        //create new proposal
        $proposta = new Proposta();
        $proposta->fill($validated);

        //check if student exists
        $aluno = Utilizador::find($validated['utilizador_email']);
        if ($aluno == null) {
            $email = explode('@', $validated['utilizador_email'])[0];
            $ldapUser = Adldap::search()->where('uid', '=', $email)->first();
            Utilizador::userFromLdap($validated['utilizador_email'], $ldapUser);
        }
        $proposta->save();

        //attach specialties from especializacao_nome1 and especializacao_nome2
        $proposta->especializacao()->attach($validated['especializacao_nome1']);
        if (isset($validated['especializacao_nome2']) && $validated['especializacao_nome2'] != null && $validated['especializacao_nome2'] != '') {
            $proposta->especializacao()->attach($validated['especializacao_nome2']);
        }

        //attach orietações from orientador_secundario and orientador_terciario if they exist
        if (isset($validated['orientador_secundario']) && $validated['orientador_secundario'] != null && $validated['orientador_secundario'] != '') {
            $proposta->colaboradores()->attach($validated['orientador_secundario']);
        }
        if (isset($validated['orientador_terciario']) && $validated['orientador_terciario'] != null && $validated['orientador_terciario'] != '') {
            $proposta->colaboradores()->attach($validated['orientador_terciario']);
        }

        $data = [
            'success' => true,
            'message' => __('proposal.success.store'),
            'redirect' => route('docente.propostas'),
            'data' => $proposta
        ];
        return response()->json($data);
    }

}