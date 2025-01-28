<?php

namespace App\Http\Requests\Auth;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:' . CmnEnum::DEFAULT_CHAR_MIN, 'max:'. CmnEnum::DEFAULT_TITLE_CHAR_MAX],
            'email' => [
                'required', 
                'email', 
                'unique:' . config('constants.table.users') . ',email',
                'max:' . CmnEnum::DEFAULT_EMAIL_CHAR_MAX,
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
            ],
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
