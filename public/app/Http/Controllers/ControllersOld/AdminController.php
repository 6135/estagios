<?php

namespace App\Http\Controllers;

use App\EmpresaColaborador;
use App\Estagio;
use App\Helpers\DataTableApi;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class AdminController
 * @package App\Http\Controllers
 * 
 * Responsável por gerir as operações de administração do sistema, como por exemplo: 
 * - gestão de utilizadores
 * - gestão de docentes
 * - gestão de empresas
 * - gestão de alunos
 * - gestão de permissoes de utilizadores
 * - gestão de cursos
 * - gestão de estágios
 * - gestão de relatórios
 * - gestão de logs
 * - gestão de configurações como por exemplo: periodos de estágio, etc.
 * - gestão de estatísticas
 * 
 * Coordenador e Administrador do sistema
 */
class AdminController extends Controller
{
    /**
     * Ver todos os estagios submetidos para um determinado curso
     */
    public function tabledataEstagios($idperiodo = null)
    {

        $estagios = array();
        $idEmpresa = 0;
        if (session()->get('profile') == Role::Admin) {

            $estagios = Estagio::with([
                'docentes' => function ($query) {
                    $query->select('nomedocente as nome');
                },
                'colaboradores' => function ($query) {
                    $query->allColab()->select("titulo", "nome");
                },
                'aluno' => function ($query) {
                    $query->select('emailaluno', 'nomealuno');
                }
            ])
                ->select(
                    'idestagio',
                    'tituloestagio',
                    'estadoestagio',
                    'data_defesaInt',
                    'alunoatribuido'
                );
            if(!is_null($idperiodo))
                $estagios = $estagios->where('periodo_estagio_idperiodo_estagio', $idperiodo)->get();
            else 
                $estagios = $estagios->get();
            Log::debug($estagios);
        } else return response()->json(['error' => 'Unauthorized'], 401);

        $data = [];
        foreach ($estagios as $estagio) {
            if (is_null($estagio->aluno))
                $estagio->nomealuno = "Sem aluno atribuido";
            else
                $estagio->nomealuno = $estagio->aluno->emailaluno . "@student.dei.uc.pt";
            $estagio->estadoestagiotext = Estagio::getEstado($estagio->estadoestagio)['text'];
            $estagio->estadoestagiobadge = Estagio::getEstado($estagio->estadoestagio)['badge'];
            $estagio->candidatosCount = count($estagio->alunos);
            $estagio->operationOID = $estagio->idestagio;
            $estagio->responsaveis = implode(", ", array_column(array_merge($estagio->colaboradores->toArray(), $estagio->docentes->toArray()), 'nome'));

            $data[] = $estagio;

        }
        $dtb = new DataTableApi();
        return $dtb->inits($data);

    }

    /**
     * Alterar o estado de um estagio entre aceite, e rejeitado
     */

    public function alterarEstadoEstagio(Request $request){
        $estagio = Estagio::find($request->idestagio);
        if(is_null($estagio))
            return response()->json(['error' => 'Estagio não encontrado'], 404);
        else {
            $estagio->estadoestagio = $request->estadoestagio;
            $estagio->save();
            return response()->json(['success' => 'Estado alterado com sucesso'], 200);
        }
    }

}