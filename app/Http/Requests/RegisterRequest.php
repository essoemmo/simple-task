<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:55'],
            'email' => ['required','string','email','max:255','unique:users'],
            'phone' => ['required', 'min:10','unique:users'],
            'password' => ['required',Password::min(8)->letters()->mixedCase()->numbers(),'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.letters' => 'The password must contain at least one letter.',
            'password.numbers' => 'The password must contain at least one number.',
        ];
    }
}
