<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'model',
        'record_id',
        'data',
        'user_id',
    ];
}
