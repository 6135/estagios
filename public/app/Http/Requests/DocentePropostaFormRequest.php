<?php

namespace App\Http\Requests;

use App\Models\Utilizador;
use App\Models\PapelUtilizador as Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * @property int|null $id
 * @property array $edicao_estagio_id
 * @property string $especializacao_nome1
 * @property string|null $especializacao_nome2
 * @property string $titulo
 * @property string $enquadramento
 * @property string $objetivos
 * @property string $plano1
 * @property string $plano2
 * @property string $condicoes
 * @property string $observacoes
 * @property bool $deseja_entrevistas
 * @property array|null $orientadores
 * 
 * 
 */
class DocentePropostaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info('[DocentePropostaFormRequest] authorize()');
        if(session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->email);
            if($user && $user->hasRole(Role::Docente))
                return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //id can be null if creating a new proposal, but must be an integer if updating an existing one
            'id' => 'nullable|integer|exists:proposta,id',
            // 'edicao_estagio_id' => 'required|array|min:1',
            'especializacao_nome1' => 'required|string|exists:especializacao,nome',
            'especializacao_nome2' => 'nullable|string|exists:especializacao,nome',
            'edicao_estagio_id' => 'required|integer|exists:edicao_estagio,id',
            'titulo' => 'required|string|max:255',
            'enquadramento' => 'required|string|max:5000',
            'objetivos' => 'required|string|max:5000',
            'plano1' => 'required|string|max:5000',
            'plano2' => 'required|string|max:5000',
            'condicoes' => 'nullable|string|max:5000',
            'observacoes' => 'nullable|string|max:5000',
            // 'deseja_entrevistas' => 'required|boolean',
            'orientador_secundario' => 'nullable|string|exists:utilizador,email',
            'orientador_terciario' => 'nullable|string|exists:utilizador,email',
            'utilizador_email' => 'nullable|string|email|ends_with:@student.dei.uc.pt'

        ];
    }
}
