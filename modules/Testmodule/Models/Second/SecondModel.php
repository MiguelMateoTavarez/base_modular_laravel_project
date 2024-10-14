<?php

namespace Modules\Testmodule\Models\Second;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecondModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        //
    ];
}
