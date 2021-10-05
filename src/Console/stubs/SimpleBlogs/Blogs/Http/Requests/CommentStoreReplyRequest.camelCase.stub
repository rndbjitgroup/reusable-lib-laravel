<?php

namespace App\Http\Requests\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CommentStoreReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('comment-reply');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parentId' => [
                'required',
                Rule::exists(config('constants.table.comments'), 'id'),
            ],
            'comment' => [
                'required',
                'string'
            ]
        ];
    }
}
