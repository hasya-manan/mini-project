<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND level is 2 which is me
        if (auth()->check() && auth()->user()->user_level == 2) {
            return $next($request);
        }

        abort(403, 'Unauthorized. Super Admin access only.');
    }
}
