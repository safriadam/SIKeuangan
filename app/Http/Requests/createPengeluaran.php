<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\pengeluaran;

class createPengeluaran extends Request
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
            'real_bibit'            =>'required',
            'real_nutrisi'          =>'required',
            'real_bahan_lain'       =>'required',
            
        ];
    }

    public function messages()
    {
        return [
            'real_bibit.required'        => 'Realisasi bibit harus di isi',
            'real_nutrisi.required'      => 'Realisasi nutrisi harus di isi',
            'real_bahan_lain.required'   => 'Realisasi bahan lain harus di isi',
        ];
    }
}
