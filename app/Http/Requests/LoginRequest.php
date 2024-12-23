<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'min:10', 'exists:users,phone'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
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
