<?php

namespace Modules\Testmodule\Http\Middleware\Second;

use Closure;
use Illuminate\Http\Request;

class SecondMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //

        return $next($request);
    }
}
