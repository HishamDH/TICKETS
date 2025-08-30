<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403, 'User not authenticated.');
        }
    
        $userRole = auth()->user()->role;
    
        // سجل الرتب المسموحة والرتبة الحالية
        \Log::info('User role: ' . $userRole);
        \Log::info('Allowed roles: ' . implode(', ', $roles));
    
        if (!in_array($userRole, $roles)) {
            abort(403, 'Access denied by role. Your role: ' . $userRole);
        }
    
        return $next($request);
    }
    
    
}
