<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the required role
        // super_admin can access admin routes too
        $hasAccess = false;
        
        if ($role === 'admin') {
            $hasAccess = in_array($user->role, ['admin', 'super_admin']);
        } elseif ($role === 'super_admin') {
            $hasAccess = $user->role === 'super_admin';
        } else {
            $hasAccess = $user->role === $role;
        }
        
        if (!$hasAccess) {
            // Redirect to appropriate dashboard based on actual role
            if (in_array($user->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }
        
        return $next($request);
    }
}
