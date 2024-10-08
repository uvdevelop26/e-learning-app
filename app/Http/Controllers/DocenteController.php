<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteRequest;
use App\Models\Ciudade;
use App\Models\Departamento;
use App\Models\Docente;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search', 'page'];

        $docentes = Docente::with('persona.ciudade', 'user', 'estado')
            ->orderBy('id', 'desc')
            ->filter($request->only($queries))
            ->paginate(6);
        return Inertia::render('Docentes/Index', [
            'docentes' => $docentes,
            'filters' => $request->all($queries)
        ]);
    }

    public function create()
    {
        $departamentos = Departamento::select('id', 'nombre')->get();
        $ciudades = Ciudade::select('id', 'nombre', 'departamento_id')->get();
        $estados = Estado::select('id', 'estado')->get();
        $rol = Role::where('rol', 'docente')->get();

        return Inertia::render('Docentes/Create', [
            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'rol' => $rol
        ]);
    }


    public function store(DocenteRequest $request)
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

        Docente::create([
            'profesion' => $request->profesion,
            'persona_id' => $persona->id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('docentes.index')->with('success', 'Docente Registrado Exitosamente');
    }


    public function show($id)
    {
    }

    public function edit(Docente $docente)
    {
        $departamentos = Departamento::select('id', 'nombre')->get();
        $currentDpto = Ciudade::find($docente->persona->ciudade_id)->departamento->id;
        $ciudades = Ciudade::select('id', 'nombre', 'departamento_id')->get();
        $estados = Estado::select('id', 'estado')->get();
        $roles = Role::all();
        $currentRole = User::find($docente->user->role_id)->id;

        return Inertia::render('Docentes/Edit', [
            'docente' => [
                'id' => $docente->id,
                'profesion' => $docente->profesion,
                'persona' => $docente
                    ->persona()
                    ->get()
                    ->map->only('id', 'nombre', 'apellido', 'ci_numero', 'sexo', 'telefono', 'direccion', 'ciudade_id'),
                'user' => $docente
                    ->user()
                    ->get()
                    ->map
                    ->only('email', 'password', 'role_id'),
                'estado_id' => $docente->estado_id,
            ],

            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'currentDpto' => $currentDpto,
            'roles' => $roles,
            'currentRole' => $currentRole
        ]);
    }


    public function update(DocenteRequest $request, Docente $docente)
    {
        $persona = Persona::find($docente->persona_id);
        $user = User::find($docente->user_id);

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

        $docente->update([
            'profesion' => $request->profesion,
            'persona_id' => $persona->id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('docentes.index')->with('success', 'Docente Actualizado Exitosamente');
    }


    public function destroy($id)
    {
        $docente = Docente::find($id);

        $userDocente = User::find($docente->user_id);

        $userDocente->delete();

        return Redirect::route('docentes.index')->with('success', 'Docente Eliminado Exitosamente');
    }

    public function pdf()
    {
        $docentes = Docente::with(['persona.ciudade', 'user'])
            ->select('id', 'profesion', 'persona_id', 'user_id')
            ->get();

        $currentDate = Carbon::now()->format('d/m/Y');

        $userEmail = Auth::user()->email;

        $pdf = Pdf::loadView('pdf.docentes', compact('docentes', 'currentDate', 'userEmail'));

        return $pdf->stream('lista_docentes.pdf');
    }

    public function xlsx()
    {
        
    }
}
