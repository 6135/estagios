<?php

namespace App\Rules;

use App\OpcaoTematica;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use mysql_xdevapi\Exception;

class NullOrExists implements Rule
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
//        dd($value);
        if($value == "null" or $value == null)
            return true;
        try {
            OpcaoTematica::query()->find($value);
            return true;
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
