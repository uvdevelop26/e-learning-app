<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Ciudade;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AlumnoController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search'];

        $alumnos = Alumno::with('persona.ciudade', 'carrera', 'user', 'estado')
            ->orderBy('id', 'desc')
            ->filter($request->only($queries))
            ->paginate(6);

        return Inertia::render('Alumnos/Index', [
                'alumnos' => $alumnos,
                'filters' => $request->all($queries)
            ]
        );
    }


    public function create()
    {
        $departamentos = Departamento::all();
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $rol = Role::where('rol', 'alumno')->get();
        $carreras = Carrera::all();

        return Inertia::render('Alumnos/Create', [
            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'rol' => $rol,
            'carreras' => $carreras
        ]);
    }


    public function store(AlumnoRequest $request)
    {
        $persona = Persona::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci_numero' => $request->ci_numero,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ciudade_id' => $request->ciudade_id
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        Alumno::create([
            'persona_id' => $persona->id,
            'carrera_id' => $request->carrera_id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('alumnos.index');
    }


    public function show($id)
    {
        //
    }


    public function edit(Alumno $alumno)
    {
        $departamentos = Departamento::all();
        $currentDpto = Ciudade::find($alumno->persona->ciudade_id)->departamento->id;
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $roles = Role::all();
        $currentRole = User::find($alumno->user->role_id)->id;
        $carreras = Carrera::all();

        return Inertia::render('Alumnos/Edit', [
            'alumno' => [
                'id' => $alumno->id,
                'carrera_id' => $alumno->carrera_id,
                'persona' => $alumno
                    ->persona()
                    ->get()
                    ->map->only('id', 'nombre', 'apellido', 'ci_numero', 'sexo', 'telefono', 'direccion', 'ciudade_id'),
                'user' => $alumno
                    ->user()
                    ->get()
                    ->map
                    ->only('email', 'password', 'role_id'),
                'estado_id' => $alumno->estado_id,
            ],

            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'currentDpto' => $currentDpto,
            'roles' => $roles,
            'currentRole' => $currentRole,
            'carreras' => $carreras
        ]);
    }


    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $persona = Persona::find($alumno->persona_id);
        $user = User::find($alumno->user_id);

        $persona->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci_numero' => $request->ci_numero,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ciudade_id' => $request->ciudade_id
        ]);

        $user->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        $alumno->update([
            'persona_id' => $persona->id,
            'carrera_id' => $request->carrera_id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('alumnos.index');
    }


    public function destroy($id)
    {
        $alumno = Alumno::find($id);

        $alumno->delete();

        return Redirect::route('alumnos.index');
    }
}
