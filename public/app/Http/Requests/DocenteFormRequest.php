<?php

namespace App\Http\Requests;

use App\Models\Utilizador;
use App\Models\PapelUtilizador as Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * @property string $nome
 * @property string $nome_curto
 * @property string $especialidade
 */
class DocenteFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info('[DocenteFormRequest] authorize()');
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
            'nome' => 'required|string|max:255',
            'nome_curto' => 'required|string|max:255',
            'especializacao_nome' => 'required|string|exists:especializacao,nome',
        ];
    }
}
