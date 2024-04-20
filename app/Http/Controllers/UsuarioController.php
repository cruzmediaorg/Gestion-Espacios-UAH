<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = User::all();

        return Inertia::render('Control/Usuarios/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Control/Usuarios/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create($request->all());

        return redirect()->route('usuarios.index');
    }

    public function show(User $usuario)
    {
        return Inertia::render('Control/Usuarios/Show', [
            'user' => $usuario
        ]);
    }

    public function edit(User $usuario)
    {

        $roles = Role::all();

        return Inertia::render('Control/Usuarios/Form', [
            'isEdit' => true,
            'user' => UserResource::make($usuario),
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $usuario)
    {

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'roles' => 'required|array|exists:roles,name'
        ]);

        $usuario->update($validated);

        $usuario->syncRoles($request->roles);

        return redirect()->route('usuarios.index');
    }
}
