<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if not authenticated
        if (!$request->user()) {
            return $next($request);
        }

        $user = $request->user();

        // Only enforce password reset for admin users (Super Admin and Editor)
        $isAdminUser = in_array($user->role, [
            \App\Enums\UserRole::SUPER_ADMIN,
            \App\Enums\UserRole::EDITOR
        ]);

        // Skip if not an admin user - regular users don't need forced password reset
        if (!$isAdminUser) {
            return $next($request);
        }

        // Skip for Livewire AJAX requests to prevent JSON parsing errors
        if ($request->header('X-Livewire')) {
            return $next($request);
        }

        // Check if admin user needs to reset password
        if ($user->must_reset_password) {
            // Prevent redirect loop - allow access to password change route and logout
            if ($request->routeIs('password.change') || $request->routeIs('logout')) {
                return $next($request);
            }
            
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
