<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
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

    public function menuData()
    {
        $user_role = Auth::user()->role()->first()->rol;

        if ($user_role == "docente") {

            $docente_id = Auth::user()->docentes()->first()->id;

            $clases = Clase::where('docente_id', $docente_id)->with('materia')->get();

            $docente_data = [
                'clases' => $clases,
                'role' => $user_role
            ];

            return response()->json($docente_data);
        } else if ($user_role == "alumno") {

            $alumno_id = Auth::user()->alumnos()->first()->id;

            $alumno = Alumno::find($alumno_id);

            $clases = $alumno->clases()->with('materia')->get();

            $alumno_data = [  
                'role' => $user_role,
                'clases' => $clases
            ];

            return response()->json($alumno_data);
        } else if ($user_role == "administrador") {
            return response()->json(null);
        }
    }
}
