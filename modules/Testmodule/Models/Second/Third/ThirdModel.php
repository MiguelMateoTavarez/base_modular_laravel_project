<?php

namespace Modules\Testmodule\Models\Second\Third;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        //
    ];
}
