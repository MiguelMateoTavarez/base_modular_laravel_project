<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Accesscontrol\Database\Seeders\PermissionSeeder;
use Modules\Accesscontrol\Database\Seeders\RoleAndPermissionSeeder;
use Modules\Accesscontrol\Database\Seeders\RoleSeeder;
use Modules\Accesscontrol\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleAndPermissionSeeder::class,
        ]);

        $superAdminRole = Role::where('name', 'Super admin')->first();
        $user->roles()->attach($superAdminRole);
    }
}
