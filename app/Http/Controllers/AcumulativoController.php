<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Tarea;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcumulativoController extends Controller
{
    public function index($clase, $unidad)
    {
        $detalles = Unidade::leftJoin('tareas', 'unidades.id', '=', 'tareas.unidade_id')
            ->leftJoin('entregas', 'tareas.id', '=', 'entregas.tarea_id')
            ->leftJoin('users', 'entregas.user_id', '=', 'users.id')
            ->leftJoin('devoluciones', 'devoluciones.entrega_id', '=', 'entregas.id')
            ->select(
                'unidades.tema as unidad',
                'tareas.titulo as titulo',
                'tareas.puntos as puntos_asig',
                'entregas.completado as completado',
                'users.email as email',
                'devoluciones.devuelto as devuelto',
                'devoluciones.puntos as puntos_devolucion'
            )
            ->where('unidades.id', $unidad)
            ->whereNotNull('users.email')
            ->get();

        return Inertia::render('Acumulativos/Detalles', ['detalles' => $detalles]);
    }
}
