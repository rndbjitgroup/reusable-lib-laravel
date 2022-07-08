<?php

namespace App\Http\Requests\Users;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user-create');
        //return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
            'passwordConfirmation' => ['required'],
            'roles' => [
                'required',
                'array',
                'exists:'. config('constants.table.roles') . ',id'
            ] 
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'email' => '',
    //     ]);
    // }

    // public function messages()
    // {
    //     return [
    //         'title.required' => 'A title is required',
    //         'body.required' => 'A message is required',
    //     ];
    // }

    //protected function getValidatorInstance()
    //{
        // $input = $this->all();
        // $input['password'] = Hash::make($input['password']);
        // $input['password_confirmation'] = Hash::make($input['password_confirmation']);
        // $this->getInputSource()->replace($input);

        // return parent::getValidatorInstance();
    //}

}
