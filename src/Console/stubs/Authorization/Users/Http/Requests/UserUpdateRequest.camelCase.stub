<?php

namespace App\Http\Requests\Users;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return true;
        return Gate::allows('user-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'min:' . CmnEnum::DEFAULT_CHAR_MIN, 'max:'. CmnEnum::DEFAULT_TITLE_CHAR_MAX],
            'email' => [
                'nullable', 
                'email', 
                'unique:' . config('constants.table.users') . ',email,' . $this->user->id,
                'max:' . CmnEnum::DEFAULT_EMAIL_CHAR_MAX,
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
            ],
            'password' => [
                'nullable', 
                //'confirmed', 
                'required_with:passwordConfirmation',
                'same:passwordConfirmation',
                Password::min(CmnEnum::PASSWORD_MIN_LENGTH)
            ],
            'passwordConfirmation' => ['nullable'],
            'roles' => [
                'required',
                'array',
                'exists:'. config('constants.table.roles') . ',id'
            ]
        ];
    }
}
