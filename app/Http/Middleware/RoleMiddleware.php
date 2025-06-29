<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (count($roles) === 1 && strpos($roles[0], '|') !== false) {
            $roles = explode('|', $roles[0]);
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

         return redirect()->route('dashboard')->with('error', 'Unauthorized access.');

    }
}
