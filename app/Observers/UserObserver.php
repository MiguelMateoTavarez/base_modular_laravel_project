<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        AuditLog::create([
            'event' => 'created',
            'model' => User::class,
            'record_id' => $user->id,
            'data' => $user->toJson(),
            'user_id' => auth()->id(),
        ]);
    }

    public function updated(User $user)
    {
        AuditLog::create([
            'event' => 'updated',
            'model' => User::class,
            'record_id' => $user->id,
            'data' => $user->toJson(),
            'user_id' => auth()->id(),
        ]);
    }

    public function deleted(User $user)
    {
        AuditLog::create([
            'event' => 'deleted',
            'model' => User::class,
            'record_id' => $user->id,
            'data' => $user->toJson(),
            'user_id' => auth()->id(),
        ]);
    }
}
