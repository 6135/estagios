<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateNIF implements Rule
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
    private $error = 0;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //validate NIF 
        $nif = $value; //9 digits, for a single person must start with a 1,2 or a 3. For a company must start with a 5,6,8 or 9. 9 can be used for foreigners with no NIF.
        $nif = preg_replace('/[^0-9]/', '', $nif); //remove all non numeric characters
        //if it doesnt start with any of those numbers
        if(!preg_match('/^[1235689]/', $nif)){
            $this->error = 1;
            return false;
        } elseif(strlen($nif) != 9){
            $this->error = 2;
            return false;
        }
        //control sum for nif
        $sum = 0;
        for($i = 0; $i < 8; $i++){
            $sum += $nif[$i] * (9 - $i);
        }
        $sum = 11 - ($sum % 11);
        if($sum >= 10){
            $sum = 0;
        }
        if($sum != $nif[8]){
            $this->error = 3;
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch($this->error){
            case 1:
                return __('messages.validation.nif.start');
            case 2:
                return __('messages.validation.nif.length');
            case 3:
                return __('messages.validation.nif.checksum');
            default:
                return __('messages.validation.nif.unknown');
        }
        
    }
}
