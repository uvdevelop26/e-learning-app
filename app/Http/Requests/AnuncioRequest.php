<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnuncioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
            'user_id' => 'required|numeric',
            'anunciable_id' => 'required|numeric',
            'anunciable_type' => 'nullable',
            'nombre' => 'nullable|max:255',
            'url' => 'nullable',
        ];
    }
}
