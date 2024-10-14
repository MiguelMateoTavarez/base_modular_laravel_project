<?php

namespace Modules\Accesscontrol\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Accesscontrol\Enums\ActionsEnum;
use Modules\Accesscontrol\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $models = [
            class_basename(User::class),
        ];

        foreach ($models as $model) {
            foreach (ActionsEnum::cases() as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action->value}_{$model}",
                    'description' => "Permission for {$action->value} in {$model}",
                ]);
            }
        }
    }
}
