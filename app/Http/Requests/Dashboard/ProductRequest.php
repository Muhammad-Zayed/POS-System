<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules = [
            'category_id'       =>['required' , 'numeric'],
            'image'             =>['nullable' , 'file' , 'mimes:jpg,png,jpeg'],
            'purchase_price'    =>['required' , 'numeric'],
            'sell_price'        =>['required' , 'numeric'],
            'stock'             =>['required' , 'numeric'],
        ];
        foreach (config('translatable.locales') as $lang) {
            $rules[$lang . '.name'] = [
                'required',
                'max:30',
                $this->method() == 'POST'
                    ? Rule::unique('product_translations','name')
                    : Rule::unique('product_translations','name')
                    ->ignore($this->product->id , 'product_id'),
            ];

            $rules[$lang . '.description'] = [
                'required'
            ];
        }
        return $rules;
    }
}
