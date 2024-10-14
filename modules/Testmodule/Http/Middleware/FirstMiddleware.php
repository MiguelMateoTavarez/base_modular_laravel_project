<?php

namespace Modules\Testmodule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirstMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //

        return $next($request);
    }
}
