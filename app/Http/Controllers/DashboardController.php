<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $clasesActivas = Clase::with('materia', 'estado', 'alumnos')->whereHas('estado', function ($query) {
            $query->where('estado', 'activo');
        })->get();

        return Inertia::render('Dashboard', ['clasesActivas' => $clasesActivas]);
    }

    public function users()
    {

        $user_role = Auth::user()->role()->first()->rol;


        if ($user_role == "docente") {

            $docente_id = Auth::user()->docentes()->first()->id;

            $docente_data = [
                'id' => $docente_id,
                'role' => $user_role
            ];

            return response()->json($docente_data);
        } else if ($user_role == "alumno") {

            $alumno_id = Auth::user()->alumnos()->first()->id;

            $alumno_data = [
                'id' => $alumno_id,
                'role' => $user_role
            ];

            return response()->json($alumno_data);
        } else if ($user_role == "administrador") {
            $administradore_id = Auth::user()->administradores()->first()->id;

            $administradore_data = [
                'id' => $administradore_id,
                'role' => $user_role
            ];

            return response()->json($administradore_data);
        }
    }
}
