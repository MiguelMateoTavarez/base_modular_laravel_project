<?php

namespace Modules\Accesscontrol\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accesscontrol\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'Super admin',
            'description' => 'Platform\'s Super admin',
        ]);
    }
}
