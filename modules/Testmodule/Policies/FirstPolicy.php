<?php

namespace Modules\Testmodule\Policies;

use App\Models\User;
use Modules\Testmodule\Models\FirstModel;

class FirstPolicy
{
    public function view(User $user, FirstModel $firstModel)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, FirstModel $firstModel)
    {
        //
    }

    public function delete(User $user, FirstModel $firstModel)
    {
        //
    }
}
