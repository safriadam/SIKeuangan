<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\user;

class simpanProfil extends Request
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
            'name'                  =>'required',
            'email'                 =>'required',
            'password'              =>'required',
            'password_confirmation' =>'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                     => 'Nama harus di isi',
            'email.required'                    => 'Email harus di isi',
            'password.required'                 => 'Password harus di isi',
            'password_confirmation.required'    => 'Password tidak sama',
    
        ];
    }
}
