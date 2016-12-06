<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class createHarga extends Request
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
            'total_panen'        =>'required',
            'profit'             =>'required',
                 ];
    }

    public function messages()
    {
        return [
            'total_panen.required'  => 'Total panen harus di isi',
            'profit.required'       => 'Profit harus di isi',
        ];
    }
}
