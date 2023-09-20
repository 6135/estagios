<?php

namespace App\Rules;

use Adldap\Laravel\Facades\Adldap;

use App\Http\Controllers\Auth\Authentication;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class StudentEmailRule implements Rule
{
    private $_errorMessage;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    private function setMessage($string){ $this->_errorMessage = $string;}
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exp = explode('@', $value);
        $domainPart = $exp[1] ?? null;
        $username = $exp[0] ?? null;
        if($domainPart != 'student.dei.uc.pt') {
            $this->setMessage("O email do aluno deve terminar em student.dei.uc.pt");
        } else {
            // check if student exists.
            if (!Authentication::verifyLdapValidity($username))
                $this->setMessage("O email do aluno não é valido");
            else return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->_errorMessage;
    }
}
