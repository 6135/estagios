<?php

namespace App\Rules;

use App\Docente;
use App\EmpresaColaborador;
use App\OpcaoTematica;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use mysql_xdevapi\Exception;

class ExistsAndDiffersColab implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value == -1 or $value == -2 or (is_null($value) and session()->get('profile') == 8))
            return true;
        try {
            $fetch = EmpresaColaborador::query()->where('id',$value)->where('empresa',session()->get('id'))->get();
            if(count($fetch)==1)
                return true;
            else {
                $fetch = Docente::query()->where('logindocente',$value)->get();
                return count($fetch)==1;
            }
        } catch (ModelNotFoundException $e){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A area de especialidade selecionada é invalida.';
    }
}
