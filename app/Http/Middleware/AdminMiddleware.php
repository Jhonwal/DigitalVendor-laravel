<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin email (admin@example.com)
        if (!auth()->check() || auth()->user()->email !== 'admin@example.com') {
            // Redirect to home with error message if not admin
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }
        
        return $next($request);
    }
}
