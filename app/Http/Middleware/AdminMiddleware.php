<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // If not admin, redirect them back to home with error
        return redirect('/dashboard')->with('error', 'You do not have admin access.');
    }
}
