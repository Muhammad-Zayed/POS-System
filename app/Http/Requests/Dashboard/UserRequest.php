<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' =>['required','max:10'],
            'last_name' =>['required','max:10'],
            'email' =>['required','email','unique:users,email'],
            'password' =>['required','min:8','confirmed'],
        ];
    }
}
