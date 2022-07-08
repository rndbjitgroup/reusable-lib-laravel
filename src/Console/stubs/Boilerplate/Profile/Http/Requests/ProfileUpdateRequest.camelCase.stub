<?php

namespace App\Http\Requests\Profile;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,png,svg'
            ],
            'name' => 'required|string',
            'email' => [
                'required', 
                'email', 
                'unique:' . config('constants.table.users') . ',email,' . Auth::user()->id,
                'max:' . CmnEnum::DEFAULT_EMAIL_CHAR_MAX,
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
            ],
            'contactNo' => [
                'required', 
                'digits_between:' . CmnEnum::CONTACT_NO_MIN . ',' . CmnEnum::CONTACT_NO_MAX, 
            ]
        ];
    }
}
