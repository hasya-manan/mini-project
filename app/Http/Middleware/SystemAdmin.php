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
       // Check if user is logged in AND is a System Admin (Level 2)
        if (auth()->check() && auth()->user()->user_level === 2) {
            return $next($request);
        }

        // If not, kick them back to the dashboard with an error
        return redirect('/dashboard')->with('error', 'You do not have this access.');
        }
        // In SystemAdmin.php
//if (auth()->check() && auth()->user()->user_level >= 1) { 
    // This allows both Company Admins (1) and Super Admins (2) 
    // to access certain admin areas.
//}
}
