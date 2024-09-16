<?php

namespace Modules\Accesscontrol\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accesscontrol\Models\Permission;
use Modules\Accesscontrol\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        $superAdminRole = Role::where('name', 'Super admin')->first();
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $superAdminRole->permissions()->attach($permission);
        }
    }
}
