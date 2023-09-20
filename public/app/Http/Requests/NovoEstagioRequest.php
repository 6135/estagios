<?php

namespace App\Http\Requests;

use App\Rules\ExistsAndDiffersColab;
use App\Rules\NullOrExists;
use App\Rules\OnEstagioSubmitCheckPeriodo;
use App\Rules\StudentEmailRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Routing\Route|mixed|object|string $tituloEstagio
 * @property \Illuminate\Routing\Route|mixed|object|string $legal_rep
 * @property \Illuminate\Routing\Route|mixed|object|string $periodo_estagios
 * @property \Illuminate\Routing\Route|mixed|object|string $floatingSelectAE
 * @property \Illuminate\Routing\Route|mixed|object|string $titEstagio
 * @property \Illuminate\Routing\Route|mixed|object|string $floatingInputNomeEntidade
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaEnquandramento
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaObjetivos
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaPlano1Semestre
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaPlano2Semestre
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaCondicoes
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaElementosAdicionais
 * @property \Illuminate\Routing\Route|mixed|object|string $orientadorTitle
 * @property \Illuminate\Routing\Route|mixed|object|string $floatingInputNomeOrientador
 * @property \Illuminate\Routing\Route|mixed|object|string $inputPhoneNumberOrientador
 * @property \Illuminate\Routing\Route|mixed|object|string $inputFuncaoNaEmpresa
 * @property \Illuminate\Routing\Route|mixed|object|string $inputEmailOrientador
 * @property \Illuminate\Routing\Route|mixed|object|string $floatingSelectAE2
 * @property \Illuminate\Routing\Route|mixed|object|string $radioCheckEntrevistas
 * @property \Illuminate\Routing\Route|mixed|object|string $TextareaOpcaoTematica
 */
class NovoEstagioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd($this);
        $titulosOrientador = ['Dr.','Eng.'];
//        dd($this);
        return [
            'periodo_estagios' => ['required','exists:periodo_estagio,idperiodo_estagio', new OnEstagioSubmitCheckPeriodo],
            'titEstagio' => 'required|max:255|min:10',
            'floatingSelectAE' => [new NullOrExists],
            'floatingSelectAE2' => [new NullOrExists,'nullable','different:floatingSelectAE'],//'nullable|different:floatingSelectAE|exists:opcaotematica,idopcaotematica',
            'legal_rep' => 'nullable|exists:empresa_representantes,id',
            'floatingInputLocal' => 'required|max:255|min:1',
            'TextareaEnquandramento' => 'required|max:5000|min:50',
            'TextareaObjetivos' => 'required|max:5000|min:50',
            'TextareaPlano1Semestre' => 'required|max:5000|min:50',
            'TextareaPlano2Semestre' => 'required|max:5000|min:50',
            'TextareaCondicoes' => 'max:5000',
            'TextareaElementosAdicionais' => 'max:5000',
//            'colab1' => ['nullable',new ExistsAndDiffersColab],
//            'colab2' => ['different:colab1'/*,colab3'*/, new ExistsAndDiffersColab],
//            'colab3' => ['sometimes','different:colab1,colab2',new ExistsAndDiffersColab],
            'estagioID' => 'nullable',
            'radioCheckEntrevistas' => 'required|digits_between:1,2',
            'TextareaOpcaoTematica' => 'nullable|max:1024|min:16',
            'inputEmailAluno' => ['nullable',new StudentEmailRule()]
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();
        unset($messages['tituloEstagio.max']);
        $messages['tituloEstagio.max'] = "O titulo do estagio so pode ter ate :max caracteres.";
        $messages['tituloEstagio.min'] = "O titulo do estagio tem de ter pelo menos :min caracteres.";
        return $messages; // TODO: Change the autogenerated stub
    }
}