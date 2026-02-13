<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allows HR Admin (1) and Super Admin (2)
        if (auth()->check() && auth()->user()->user_level >= 1) {
            return $next($request);
        }

        // Redirect Level 0 users back with a flash message
        return redirect('/dashboard')->with('flash', [
            'bannerStyle' => 'danger',
            'banner' => 'You do not have permission to access that area.',
        ]);
    }


}
