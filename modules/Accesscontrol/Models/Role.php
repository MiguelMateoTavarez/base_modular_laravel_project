<?php

namespace Modules\Accesscontrol\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1)
 * @method static findOrFail(string $id)
 * @method static paginated()
 */
class Role extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
