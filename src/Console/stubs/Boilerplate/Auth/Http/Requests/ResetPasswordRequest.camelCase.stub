<?php

namespace App\Http\Requests\Auth;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required',
            'email' => ['required', 'email', 'max:' . CmnEnum::DEFAULT_EMAIL_CHAR_MAX],
            'password' => [
                'required', 
                //'confirmed', 
                'required_with:passwordConfirmation',
                'same:passwordConfirmation',
                Password::min(CmnEnum::PASSWORD_MIN_LENGTH)
            ],
            'passwordConfirmation' => ['required']
        ];
    }
}
