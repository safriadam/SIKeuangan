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

            'nama_sayur'        =>'required',
            'bibit'              =>'required',
            'ket_bibit'         =>'required',
            'nutrisi'           =>'required',
            'ket_nutrisi'       =>'required',
            'bahan_lain'        =>'required',
            'ket_bahan_lain'    =>'required',
            'tot_anggaran'      =>'required',
            
          
        ];
    }
}
