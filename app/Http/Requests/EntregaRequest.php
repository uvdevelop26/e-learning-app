<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntregaRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'completado' => 'nullable',
            'tarea_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'url' => 'nullable|array',
            'nombre' => 'nullable|array',
            'materiable_id' => 'nullable|numeric',
            'materiable_type' => 'required' 
        ];
    }
}
