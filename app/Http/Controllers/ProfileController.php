<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Administradore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $userRole = Auth::user()->role->rol;
        $userId = Auth::user()->id;

        if ($userRole == "administrador") {

            $user = User::with('administradores.persona')
                ->find($userId);

            return Inertia::render('Profile/Show', [
                'user' => $user,
            ]);
        } elseif ($userRole == "alumno") {
            $user = User::with('alumnos.persona')
                ->find($userId);

            return Inertia::render('Profile/Show', [
                'user' => $user,
            ]);
        } else if ($userRole == "docente") {
            $user = User::with('docentes.persona')
                ->find($userId);

            return Inertia::render('Profile/Show', [
                'user' => $user,
            ]);
        }
    }


    public function update(ProfileRequest $request)
    {

        $user = User::find($request->id);

        $userRole = $user->role->rol;

        $path = $user->profile_photo_path;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '.' . $extension;

            $path = $file->storeAs('public/profile_pictures', $filename);

            if (File::exists(storage_path("app/{$user->profile_photo_path}"))) {
                File::delete(storage_path("app/{$user->profile_photo_path}"));
            }
        }

        $user->update([
            'email' => $request->email,
            'profile_photo_path' => $path
        ]);

        if ($userRole == "administrador") {
            $persona = $user->administradores()->first()->persona;

            $persona->update([
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
        } else if ($userRole == "alumno") {
            $persona = $user->alumnos()->first()->persona;

            $persona->update([
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
        } else if ($userRole == "docente") {
            $persona = $user->docentes()->first()->persona;

            $persona->update([
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
        }

        return Redirect::route("dashboard");
    }
}
