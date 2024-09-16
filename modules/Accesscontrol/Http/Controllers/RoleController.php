<?php

namespace Modules\Accesscontrol\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Accesscontrol\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function attachPermissions(string $id, array $permissions): Role
    {
        $role = Role::findOrFail($id);
        $role->permissions()->syncWithoutDetaching($permissions);

        $role->load('permissions');

        return $role;
    }

    public function detachPermissions(string $id, array $permissions): Role
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach($permissions);

        $role->load('permissions');

        return $role;
    }
}
