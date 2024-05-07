<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevolucioneRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'recomendacion' => 'nullable',
            'devuelto' => 'required',
            'entrega_id' => 'required|numeric',
            'puntaje' => 'nullable',
            'nombre' => 'nullable|array',
            'url' => 'nullable|array',
            'materiable_id' => 'nullable',
            'materiable_type' => 'required'
        ];
    }
}
