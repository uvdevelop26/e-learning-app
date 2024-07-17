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
            'recomendacion' => 'nullable|string',
            'devuelto' => 'required|integer|min:0|max:1',
            'puntos' => 'nullable|integer|min:0',
            'entrega_id' => 'required|numeric',       
            'nombre' => 'nullable|array',
            'url' => 'nullable|array',
            'materiable_id' => 'nullable',
            'materiable_type' => 'required'
        ];
    }
}
