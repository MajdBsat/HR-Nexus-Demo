<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $userType = $user->user_type;

        if (empty($roles)) {
            return $next($request);
        }

        foreach ($roles as $role) {
            // Check if user has required role type
            // 0 = Guest, 1 = Employee, 2 = HR
            if ($role === 'guest' && $userType === 0) {
                return $next($request);
            }

            if ($role === 'employee' && $userType === 1) {
                return $next($request);
            }

            if ($role === 'hr' && $userType === 2) {
                return $next($request);
            }

            // HR has access to all resources
            if ($userType === 2) {
                return $next($request);
            }

            // Employee has access to guest resources
            if ($role === 'guest' && $userType === 1) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Forbidden: You do not have access to this resource'], 403);
    }
}
