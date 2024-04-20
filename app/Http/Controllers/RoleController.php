<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return Inertia::render('Control/Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function show(Role $role)
    {
        return Inertia::render('Control/Roles/Show', [
            'role' => $role
        ]);
    }

    public function edit(Role $role)
    {

        $permissions = Permission::all();

        return Inertia::render('Control/Roles/Form', [
            'isEdit' => true,
            'role' => RoleResource::make($role),
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return Inertia::render('Control/Roles/Form', [
            'isEdit' => false,
            'role' => null,
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $role = Role::create($validated);

        $role->syncPermissions($validated['permissions']);

        return redirect()->route('roles.index');
    }

    public function update(Request $request, Role $role)
    {

        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $role->update($validated);

        $role->syncPermissions($validated['permissions']);


        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {

        $role->delete();

        return redirect()->route('roles.index');
    }
}
