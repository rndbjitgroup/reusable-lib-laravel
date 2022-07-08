<?php

namespace App\Http\Requests\Blogs;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('category-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                //'unique:' . config('constants.table.categories') . ',title',
                Rule::unique(config('constants.table.categories'))->whereNull('deleted_at'),
                'max:' . CmnEnum::DEFAULT_TITLE_CHAR_MAX
            ]
        ];
    }
}
