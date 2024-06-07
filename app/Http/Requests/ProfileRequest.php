<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'telefono' => 'required',
            'direccion' => 'required|max:200',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable'
        ];
    }
}
