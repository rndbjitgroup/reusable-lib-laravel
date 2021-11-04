<?php

namespace App\Http\Requests\Products;

use App\Enums\CmnEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('product-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'productCategoryId' => [
                'nullable',
                'exists:' . config('constants.table.product_categories') . ',id'
            ],
            'title' => [
                'nullable',
                Rule::unique(config('constants.table.products'))->whereNull('deleted_at')->ignore($this->product),
                'max:' . CmnEnum::DEFAULT_TITLE_CHAR_MAX
            ],
            'filenames' => 'nullable',
            'filenames.*' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg|max:4096',
            ],
            'size' => [
                'nullable', 
                Rule::in(config('constants.sizes'))
            ],
        ];
    }

    public function getValidatorInstance()
    {
        $this->formatData();
        return parent::getValidatorInstance();
    }

    protected function formatData()
    {
        $filenames = [];
        if (request()->hasFile('filenames')) {
            foreach (request()->filenames as $filename) {
                if ($filename) {
                    $filenames[] = $filename;
                }
            }
        }

        $input = $this->all(); 
        $input['filenames'] = $filenames;

        $this->getInputSource()->replace($input);  
        //dd($this->all());
    }

}
