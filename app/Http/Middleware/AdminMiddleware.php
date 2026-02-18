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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // assuming you have a `role` relationship or column
        if (!auth()->user()->role || auth()->user()->role->name !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }


        return $next($request);
    }
}

