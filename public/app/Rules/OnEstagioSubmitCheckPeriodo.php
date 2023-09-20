<?php

namespace App\Rules;

use App\Estagio;
use App\EstagioPeriodo;
use App\OpcaoTematica;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OnEstagioSubmitCheckPeriodo implements Rule
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

        try {
            $mytimeAsString = Carbon::now()->toDateString();
            EstagioPeriodo::where('datainicio','<=',$mytimeAsString)
//                ->where('idperiodo_estagio',$value)
                ->where('datafim','>=',$mytimeAsString)
                ->findOrFail($value);
            return true;
        } catch (ModelNotFoundException $e){
            print($e);
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
        return 'O periodo selecionado é invalido';
    }
}
