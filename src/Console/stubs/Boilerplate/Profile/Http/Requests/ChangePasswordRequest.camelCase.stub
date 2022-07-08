<?php

namespace App\Http\Requests\Profile;

use App\Enums\CmnEnum;
use App\Rules\Profile\MatchOldPassword;
use App\Rules\Profile\NotMatchCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
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
            'currentPassword' => ['required', new NotMatchCurrentPassword],
            'newPassword' => [
                'required',
                'min:' . CmnEnum::PASSWORD_MIN_LENGTH, 
                //'max:' . CmnEnum::PASSWORD_MAX_LENGTH,
                //'confirmed',
                new MatchOldPassword
            ],
            'newPasswordConfirmation' => ['same:newPassword']
        ];
    }
}
