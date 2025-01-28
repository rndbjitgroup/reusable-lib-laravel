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
