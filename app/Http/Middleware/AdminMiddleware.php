<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return $next($request); // Allow access if the user is an admin
        }

        return redirect('/')->with('error', 'Unauthorized access.'); // Redirect non-admin users
    }
}
