<?php

namespace App\Http\Requests\Blogs;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('post-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoryId' => [
                'required',
                'exists:' . config('constants.table.categories') . ',id'
            ],
            'title' => [
                'required', 
                'string',
                'unique:' . config('constants.table.posts') . ',title',
                'max:' . CmnEnum::DEFAULT_TITLE_CHAR_MAX
            ], 
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,png,svg'
            ]
        ];
    }
}
