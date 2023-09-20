<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Estagio;
use App\EstagioPeriodo;
use App\Helpers\DataTableApi;
use App\Http\Requests\AlunoEditaDadosFormRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

use Illuminate\Support\Facades\Log;


class AlunoController extends Controller
{
    /**
     * @suppress PHP1413
     */
    public function dados(){
        //get userID from session data, if it exists. And get the user with that userID
        Log::info('[AlunoController] dados()');
        $user = new User();
        if(session()->has('userID')) {
            $user = User::find(session()->get('userID'));
            // $ldapobj = Adldap::search()->whereStartsWith('mail', $user->email)->first();
            // $ldapobj = $ldapobj ?? $user;

            if($user && $user->hasRoleByPermission(Role::Aluno))
                return json_encode(array($user->getRoleObjectActive(),$user->id, 'success' => __('student.data.success')));
        }


        return json_encode(['error' => __('student.data.error')]);
    }

    public function editDados(AlunoEditaDadosFormRequest $request, $studentID = null){
        Log::info('[AlunoController] editDados()');
        //check if active profile is student
        //if it is, update the student object with the data from the request
        //if it is not, return error. StudentID if null, get it from session data
        $studentID = $studentID ?? session()->get('userID');        

        $user = User::find($studentID);
        $studentObj = $user->hasRoleByPermission(Role::Aluno) ? $user->getRoleObject(Role::Aluno) : null;
        if($studentObj){
            $studentObj->update($request->all());
            return json_encode([$studentObj, 'success' => __('student.data.update.success')]);
        } else
            return json_encode(['error' => __('student.data.update.error')]);

    }

    /**
     * List of intership proposals for the student to pick.
     * @param \App\Curso $curso
     * @return mixed
     */
    public function tableDataPropostasEstagio($curso = null){
        Log::info('[AlunoController] propostasEstagio()');
        //verify is profile is aluno, if it is, get all accepted internship proposals with no student assigned
        //if it is not, return error
        //get curret periodo de estagio
        if(session()->has('userID') 
            && User::find(session()->get('userID'))
            && User::find(session()->get('userID'))->hasRoleByPermission(Role::Aluno) 
            ) {
            
            //if curso is null
            $periodos = EstagioPeriodo::current()->activeForAlunos();
            $curso = Curso::find($curso);

            //if curso is not null, filter by curso
            if($curso)
                $periodos = $periodos->where('curso', $curso->titulo);

            //get all estagios with estadoestagio = 20 (accepted) and from any of the current periodos
            $estagios = Estagio::where('estadoestagio', 20)->whereIn('periodo_estagio_idperiodo_estagio', $periodos->pluck('idperiodo_estagio'))->get();

            //if curso is not null, filter by curso
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
            Log::info('[AlunoController] propostasEstagio() '. __('student.proposal.list.success'));
            return $dtb->inits($data);

        } 
        return json_encode(['error' => __('student.proposal.list.error')]);
    }
    private function attachProposals($estagios,$aluno){
        $num_escolha = 1;
        $aluno->estagios()->detach();
        foreach ($estagios as $estagio) {
           $aluno->estagios()->attach($estagio->idestagio, [
                'num_escolha' =>$num_escolha,
                'periodo_estagio_idperiodo_estagio'=>$estagio->periodo_estagio_idperiodo_estagio,
            ]);
            $num_escolha++;
        }
    }
    /**
     * List of picked intership proposals by the student. Order matters. At most 5
     * @param Request $request
     * @return mixed
     */
    public function propostasEstagioPicked(Request $request){
        Log::info('[AlunoController] propostasEstagioPicked()');
        //verify is profile is aluno, if it is, get all selected internship proposals. Verify if the student is the one that selected. Verify that the proposal has no other students.

        if(session()->has('userID') 
            && User::find(session()->get('userID'))
            && User::find(session()->get('userID'))->hasRoleByPermission(Role::Aluno) 
            ) {
                $aluno = User::find(session()->get('userID'))->getRoleObjectActive();
                $estagios = $request->estagios ?? [0];
                //get all estagios with IDs in $estagios. vbelong to the current periodo de estagio, and are in estadoestagio = 20 (accepted)
                $estagios = Estagio::estado(20)->currentActiveForAlunos()->whereIn('idestagio', $estagios)->get();
                //attach each choice
                if(count($estagios) > 5)
                    return json_encode(['error' => __('student.proposal.list.gte5')]);
                elseif(count($estagios) < 5)
                    return json_encode(['error' => __('student.proposal.list.lt5')]);

                $this->attachProposals($estagios,$aluno);
                return json_encode(['success' => __('student.proposal.list.success')]);
            }
        return json_encode(array('error'=>__('permission.error')));
    }
    /**
     * Let's the student reorder the picked proposals
     * @param Request $request
     */
    public function reorderProposals(Request $request){
        Log::info('[AlunoController] reorderProposals()');
        //verify is profile is aluno, if it is, get all selected internship proposals. Verify if the student is the one that selected. Verify that the proposal has no other students.
        if(session()->has('userID') 
            && User::find(session()->get('userID'))
            && User::find(session()->get('userID'))->hasRoleByPermission(Role::Aluno) 
            ) {
                $aluno = User::find(session()->get('userID'))->getRoleObjectActive();
                $estagiosPrevious = $aluno->estagios()->get()->pluck('idestagio')->toArray();
                $estagios = $request->estagios ?? [0];
                //check if these two arrays have the same elements. If not, return error
                if(count(array_diff($estagiosPrevious,$estagios)) > 0)
                    return json_encode(['error' => __('student.proposal.list.reorder.different')]);
                //check if they have the same order. if yes, return error
                if($estagiosPrevious == $estagios)
                    return json_encode(['error' => __('student.proposal.list.reorder.same')]);
                //attach each choice
                if(count($estagios) > 5)
                    return json_encode(['error' => __('student.proposal.list.gte5')]);
                elseif(count($estagios) < 5)
                    return json_encode(['error' => __('student.proposal.list.lt5')]);
                $this->attachProposals($estagios,$aluno);
                return json_encode(['success' => __('student.proposal.list.success'),$estagios,$estagiosPrevious]);
            }
        return json_encode(array('error'=>__('permission.error')));
    }

    

}