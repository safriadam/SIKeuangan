<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class createAnggaran extends Request
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

            'bibit'             =>'required',
            'nutrisi'           =>'required',
            'bahan_lain'        =>'required',
            
            
          
        ];
    }

    public function messages()
    {
        return [
            'bibit.required'        => 'Anggaran bibit harus di isi',
            'nutrisi.required'      => 'Anggaran nutrisi harus di isi',
            'bahan_lain.required'   => 'Anggaran bahan lain harus di isi',
        ];
    }
    
}
