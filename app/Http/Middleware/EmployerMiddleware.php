<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'employer') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Access denied. Only employers can access this page.');
    }
} 