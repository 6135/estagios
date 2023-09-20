<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CompanyDetailsRequest
 * @package App\Http\Requests

 * @property string $nomeempresa
 * @property string $acronimo
 * @property string $nif
 * @property string $morada
 * @property string $telefone
 * @property string $url
 * @property string $atividade
 * @property string $pais_codigo_iso
 * 
 * //Gestor
 * @property string $nome
 * @property string $cargo
 * //representante Legal
 * @property string $nome_representante_legal
 * @property string $cargo_representante_legal
 * @property string $email
 */
class CompanyDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nomeempresa' => 'required|string|max:512',
            'acronimo' => 'string|max:128',
            'morada' => 'required|string|max:512',
            'telefone' => 'required|string|max:54',
            'url' => 'string|max:128|nullable',
            'atividade' => 'required|string|max:1024',
            'pais_codigo_iso' => 'required|string|max:16|exists:pais,codigo_iso',
        ];
    }
}
