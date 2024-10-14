<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        AuditLog::create([
            'event' => 'User logged in',
            'user_id' => $event->user->id,
            'timestamp' => now(),
        ]);
    }
}
