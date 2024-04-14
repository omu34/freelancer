<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {

        // Check if the user is authenticated
        if (!auth()->check()) {
            abort(403); // If not authenticated, deny access
        }

        switch ($role) {
            case 'admin':
                if (auth()->user()->role_id !== 1) {
                    abort(403);
                }
                break;
            case 'freelancer':
            case 'buyer':
            default:
                abort(403); // For other roles, deny access
                break;
        }

        return $next($request);
    }
}
