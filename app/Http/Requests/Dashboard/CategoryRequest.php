<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            $rules = [];
            foreach (config('translatable.locales') as $lang){
                $rules[$lang.'.name']=[
                    'required',
                    'max:20',
                    $this->method() == 'POST'
                        ? Rule::unique('category_translations','name')
                        : Rule::unique('category_translations','name')
                        ->ignore($this->category->id , 'category_id'),
                ];

            }

        return $rules;
    }
}
