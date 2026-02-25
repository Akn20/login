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
            \Log::info('ROLE DEBUG: no role', [
                'user_id' => $user->id,
                'allowed' => $roles,
            ]);

            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        $userRole = strtolower($user->role->name);
        $allowed = array_map('strtolower', $roles);

        \Log::info('ROLE DEBUG', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $userRole,
            'allowed' => $allowed,
            'path' => $request->path(),
        ]);

        if (! in_array($userRole, $allowed, true)) {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}
