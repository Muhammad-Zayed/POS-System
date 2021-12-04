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
        $roles =  [
            'first_name'    =>['required','max:10'],
            'last_name'     =>['required','max:10'],
            'email'         =>['required','email','unique:users,email'],
            'image'         =>['nullable' , 'file' , 'mimes:jpg,png,jpeg'],
            'permissions' =>['required','array','min:1'],
        ];

        if ($this->method() == 'POST') {
            $roles['password'] = ['required','min:6','max:191','confirmed'];
        }else{
            $roles['email'] = ['required','email','unique:users,email,'.$this->user->id];
        }
        return $roles;
    }
}
