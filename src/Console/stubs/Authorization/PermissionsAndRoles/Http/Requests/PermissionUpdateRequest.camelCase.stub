<?php

namespace App\Http\Requests\PermissionsAndRoles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PermissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('permission-edit');
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
                'nullable', 
                'string',
                Rule::unique(config('constants.table.permissions'), 'display_title')->ignore($this->permission)->whereNull('deleted_at')
            ],
            
        ];
    }
}
