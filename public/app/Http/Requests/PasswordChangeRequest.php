<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            //password and old_password must be different
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed|different:old_password',
            'password_confirmation' => 'required|string|min:8|different:old_password',
        ];
    }
}
