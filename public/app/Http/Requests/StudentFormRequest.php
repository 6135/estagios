<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\Authentication;
use App\Models\PapelUtilizador;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * Class StudentFormRequest
 * @property string $aluno_nome
 * @property string $aluno_nomecurto
 * @property int $aluno_numaluno
 * @property int $aluno_medialicenciatura
 * @property float $aluno_mediamestrado
 * @property mixed $aluno_cv //TODO: leave for later
 * @property string $aluno_telefone
 * @property string $aluno_morada
 * @property string $documento_id
 * @property string $documento_tipo
 * @property string $validade
 * @property string $pais_codigo_iso
 * @property int $curso_id
 */
class StudentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info('StudentFormRequest::authorize()');
        Log::info('Authentication::getUser() != null && Authentication::getUser()->hasRole(PapelUtilizador::Aluno) === true' . Authentication::getUser() != null && Authentication::getUser()->hasRole(PapelUtilizador::Aluno) === true);
        return Authentication::getUser() != null && Authentication::getUser()->hasRole(PapelUtilizador::Aluno) === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'nome_curto' => 'required|string|max:255',
            'aluno_numaluno' => 'required|integer',
            'aluno_medialicenciatura' => 'required|integer|between:0,20',
            'aluno_mediamestrado' => 'required|numeric|between:0,20',
            'aluno_cv' => 'nullable', //TODO: sort this out
            'aluno_telefone' => 'required|string|max:255',
            'aluno_morada' => 'required|string|max:255',
            'documento_id' => 'required|string|max:255',
            'documento_tipo' => 'required|string|max:255|exists:documento,tipo',
            'validade' => 'required|date',
            'pais_codigo_iso' => 'required|string|max:255',
            'curso_id' => 'required|integer',
        ];
    }
}
