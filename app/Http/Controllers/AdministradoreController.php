<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministradoreRequest;
use App\Models\Administradore;
use App\Models\Ciudade;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class AdministradoreController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search'];

        $administradores = Administradore::with('persona.ciudade', 'user', 'estado')
            ->orderBy('id', 'desc')
            ->filter($request->only($queries))
            ->get();

        return Inertia::render('Administradores/Index', [
            'administradores' => $administradores,
            'filters' => $request->all($queries)
        ]);
    }

    
    public function create()
    {
        $departamentos = Departamento::all();
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $rol = Role::where('rol', 'administrador')->get();

        return Inertia::render('Administradores/Create', [
            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'rol' => $rol
        ]);
    }

    public function store(AdministradoreRequest $request)
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

        Administradore::create([
            'cargo' => $request->cargo,
            'persona_id' => $persona->id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('administradores.index')->with('success', 'Administrador Registrado Exitosamente');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Administradore $administradore)
    {

       // return $administradore;


        $departamentos = Departamento::all();
        $currentDpto = Ciudade::find($administradore->persona->ciudade_id)->departamento->id;
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $roles = Role::all();
        $currentRole = User::find($administradore->user_id)->role->id;

        return Inertia::render('Administradores/Edit', [
            'administradore' => [
                'id' => $administradore->id,
                'cargo' => $administradore->cargo,
                'persona' => $administradore
                    ->persona()
                    ->get()
                    ->map->only('id', 'nombre', 'apellido', 'ci_numero', 'sexo', 'telefono', 'direccion', 'ciudade_id'),
                'user' => $administradore
                    ->user()
                    ->get()
                    ->map
                    ->only('email', 'password', 'role_id'),
                'estado_id' => $administradore->estado_id,
            ],

            'departamentos' => $departamentos,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'currentDpto' => $currentDpto,
            'roles' => $roles,
            'currentRole' => $currentRole
        ]);
    }

   
    public function update(AdministradoreRequest $request, Administradore $administradore)
    {
        $persona = Persona::find($administradore->persona_id);
        $user = User::find($administradore->user_id);

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

        $administradore->update([
            'cargo' => $request->cargo,
            'persona_id' => $persona->id,
            'user_id' => $user->id,
            'estado_id' => $request->estado_id
        ]);

        return Redirect::route('administradores.index')->with('success', 'Administrador Actualizado Exitosamente');
    }

    
    public function destroy($id)
    {
        $administradore = Administradore::find($id);

        $userAdministradore = User::find($administradore->user_id);

        $userAdministradore->delete();

        return Redirect::route('administradores.index')->with('success', 'Administrador Eliminado Exitosamente');

    }
}
