<?php

namespace Modules\Testmodule\Policies\Second;

use App\Models\User;
use Modules\Testmodule\Models\Second\SecondModel;

class SecondPolicy
{
    public function view(User $user, SecondModel $secondModel)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, SecondModel $secondModel)
    {
        //
    }

    public function delete(User $user, SecondModel $secondModel)
    {
        //
    }
}
