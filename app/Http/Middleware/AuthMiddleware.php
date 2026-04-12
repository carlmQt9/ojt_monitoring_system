<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

/**
 * Authentication Middleware
 * 
 * Ensures that only authenticated users can access protected routes.
 * This is the first layer of the RBAC system.
 */
class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user session exists
        if (!session('user_id')) {
            // For API routes, return JSON error
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in.'
                ], 401);
            }
            
            // For web routes, redirect to login
            return redirect()->route('login')
                ->withErrors(['auth' => 'You must be logged in to access this page.']);
        }

        // Verify user still exists in database
        $user = User::find(session('user_id'));
        
        if (!$user) {
            session()->flush();
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'User account not found.'
                ], 401);
            }
            
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists.']);
        }

        // Sync session with latest user data
        session(['user' => $user]);

        return $next($request);
    }
}
