<?php

namespace Modules\Testmodule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirstModel extends Model
{
    use SoftDeletes;
    protected $fillable = [
        //
    ];
}
