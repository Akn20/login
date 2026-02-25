<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->role) {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        $userRole = strtolower($user->role->name);
        $allowed = array_map('strtolower', $roles);

        if (! in_array($userRole, $allowed, true)) {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}
