<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\NaoAluno;
use App\Models\PapelUtilizador;
use App\Models\Representante;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ColaboradorController extends Controller
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
        // dd($request->cv);
        // dd(php_ini_loaded_file());
        // dd(php_ini_loaded_file());
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'telefone' => 'required|string|max:255',
            'formacao' =>  'string|max:255',
            'anosexperiencia' => 'integer|min:0|max:50',
            'hash' => 'required|string|exists:utilizador,confirmacao_hash',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'cv'    => 'required|mimes:pdf|max:10000'
        ]);
        $validated['cv'] = $request->file('cv');

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
        $colab = Colaborador::firstOrNew(
            [Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL => $user->email],
        );
        if($colab){
            $colab->cargo = $validated['cargo'];
            $colab->telefone = $validated['telefone'];
            $colab->formacao = $validated['formacao'] == "Mestrado ou equivalente";
            $colab->anosexperiencia = $validated['anosexperiencia'];
            $path = $validated['cv']->store('cv');
            $colab->cv = $path;
            $colab->nao_aluno()->associate($nao_aluno);
            $colab->save();
        }
        $user->assignRole(PapelUtilizador::EmpresaColab);
        
        return response()->json([
            'success' => true,
            'message' => 'Email confirmed',
            'redirect' => route('home')
        ]);
    }




}
