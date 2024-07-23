<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Tarea;
use App\Models\Unidade;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return Inertia::render(
            'Acumulativos/Detalles',
            [
                'detalles' => $detalles,
                'unidad' => $unidad,
                'clase' => $clase
            ]
        );
    }

    public function pdf($clase, $unidad)
    {
        $detalles = Unidade::leftJoin('tareas', 'unidades.id', '=', 'tareas.unidade_id')
            ->leftJoin('clases', 'clases.id', '=', 'unidades.clase_id')
            ->leftJoin('entregas', 'tareas.id', '=', 'entregas.tarea_id')
            ->leftJoin('users', 'entregas.user_id', '=', 'users.id')
            ->leftJoin('devoluciones', 'devoluciones.entrega_id', '=', 'entregas.id')
            ->select(
                'clases.codigo as codigo',
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

        $currentDate = Carbon::now()->format('d/m/Y');

        $userEmail = Auth::user()->email;

        $pdf = Pdf::loadView('pdf.detalles', compact('detalles', 'currentDate', 'userEmail'));

        return $pdf->stream('lista_acumulativos.pdf');

       
    }
}
