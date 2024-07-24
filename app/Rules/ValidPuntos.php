<?php

namespace App\Rules;

use App\Models\Entrega;
use App\Models\Tarea;
use Illuminate\Contracts\Validation\Rule;

class ValidPuntos implements Rule
{

    protected $entregaId;

    public function __construct($entregaId)
    {
        $this->entregaId = $entregaId;
    }


    public function passes($attribute, $value)
    {
        $entrega = Entrega::find($this->entregaId);

        if (!$entrega) {
            return false;
        }

        $tarea = Tarea::find($entrega->tarea_id);

        if (!$tarea) {
            return false;
        }

        return $value <= $tarea->puntos;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El puntaje no puede ser mayor que el puntaje máximo de la tarea.';
    }
}
