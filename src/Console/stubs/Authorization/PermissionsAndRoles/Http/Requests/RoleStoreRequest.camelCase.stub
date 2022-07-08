<?php

namespace App\Http\Requests\PermissionsAndRoles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('role-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'displayTitle' => [
                'required', 
                'string',
                Rule::unique(config('constants.table.roles'), 'display_title')->whereNull('deleted_at')
            ],
            'permissions' => [
                'required',
                'array',
                'exists:'. config('constants.table.permissions') . ',id'
            ] 
        ];
    }
}
