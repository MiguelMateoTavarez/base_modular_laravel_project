<?php

namespace Modules\Security\Policies;

use App\Models\User;
use Modules\Security\Models\Role;

class RolePolicy
{
    public function view(User $user, Role $role)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Role $role)
    {
        //
    }

    public function delete(User $user, Role $role)
    {
        //
    }
}
