<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AgentMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'agent') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
