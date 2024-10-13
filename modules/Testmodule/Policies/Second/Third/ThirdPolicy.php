<?php

namespace Modules\Testmodule\Policies\Second\Third;

use App\Models\User;
use Modules\Testmodule\Models\Second\Third\ThirdModel;

class ThirdPolicy
{
    public function view(User $user, ThirdModel $thirdModel)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, ThirdModel $thirdModel)
    {
        //
    }

    public function delete(User $user, ThirdModel $thirdModel)
    {
        //
    }
}
