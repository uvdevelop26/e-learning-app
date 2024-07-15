<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AsignAlumnosRequest extends FormRequest
{

    protected $clase;

    public function __construct()
    {
        // Obtener la clase usando la request actual
        $this->clase = \App\Models\Clase::find(request()->clase);
    }

    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'alumnos' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->clase && $this->clase->alumnos()->where('alumno_id', $value)->exists()) {
                        $fail('El alumno ya está asignado a esta clase.');
                    }
                },
            ],
        ];
    }
}
