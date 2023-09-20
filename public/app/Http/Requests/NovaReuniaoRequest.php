<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//idreuniao, estagio_idestagio, data, hora, participantes, eplanotrabalho, comentarios, estado, created
/**
 * Class NovaReuniaoRequest
 * @package App\Http\Requests
 * @property \Illuminate\Routing\Route|mixed|object|string $idreuniao
 * @property \Illuminate\Routing\Route|mixed|object|string $estagio_idestagio
 * @property \Illuminate\Routing\Route|mixed|object|string $data
 * @property \Illuminate\Routing\Route|mixed|object|string $hora
 * @property \Illuminate\Routing\Route|mixed|object|string $participantes
 * @property \Illuminate\Routing\Route|mixed|object|string $eplanotrabalho
 * @property \Illuminate\Routing\Route|mixed|object|string $comentarios
 * @property \Illuminate\Routing\Route|mixed|object|string $estado
 * @property \Illuminate\Routing\Route|mixed|object|string $created
 */
class NovaReuniaoRequest extends FormRequest
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
        return [
            'estagio_idestagio' => 'required',
            'data' => 'required|date_format:Y-m-d',
            'participantes' => 'min:0|max:5000',
            'eplanotrabalho' => 'min:0|max:5000',
            'comentarios' => 'required|min:10|max:5000',
        ];
    }
}
