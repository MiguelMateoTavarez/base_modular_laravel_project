<?php

namespace Modules\Accesscontrol\Eloquents\Services;

use Modules\Accesscontrol\Eloquents\Contracts\RoleInterface;
use Modules\Accesscontrol\Models\Role;

class RoleService implements RoleInterface
{
    public function index()
    {
        return Role::paginate();
    }

    public function store(array $request)
    {
        return Role::create($request);
    }

    public function show($id)
    {
        return Role::findOrFail($id);
    }

    public function update(array $request, $id)
    {
        $role = $this->show($id);
        $role->update($request);

        return $role;
    }

    public function destroy($id)
    {
        $role = $this->show($id);
        $role->delete();

        return $role;
    }

    public function attachPermissions(string $id, array $permissions): Role
    {
        $role = $this->show($id);
        $role->permissions()->syncWithoutDetaching($permissions);

        return $role->load('permissions');
    }

    public function detachPermissions(string $id, array $permissions): Role
    {
        $role = $this->show($id);
        $role->permissions()->detach($permissions);

        return $role->load('permissions');
    }
}
