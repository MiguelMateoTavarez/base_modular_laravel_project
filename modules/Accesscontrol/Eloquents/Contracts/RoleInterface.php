<?php

namespace Modules\Accesscontrol\Eloquents\Contracts;

use Modules\Accesscontrol\Models\Role;

interface RoleInterface
{
    public function index();

    public function store(array $request);

    public function show($id);

    public function update(array $request, $id);

    public function destroy($id);

    public function attachPermissions(string $id, array $permissions): Role;

    public function detachPermissions(string $id, array $permissions): Role;
}
