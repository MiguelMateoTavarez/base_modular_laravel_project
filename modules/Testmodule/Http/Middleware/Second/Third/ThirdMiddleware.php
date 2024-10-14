<?php

namespace Modules\Testmodule\Http\Middleware\Second\Third;

use Closure;
use Illuminate\Http\Request;

class ThirdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //

        return $next($request);
    }
}
