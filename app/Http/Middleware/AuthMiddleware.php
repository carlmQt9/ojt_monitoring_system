<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\StudentSchoolId;

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
            // For API/AJAX routes, return JSON error
            if ($request->expectsJson() || $request->is('api/*') || $request->ajax() || $request->wantsJson()) {
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
            
            if ($request->expectsJson() || $request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User account not found.'
                ], 401);
            }
            
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists.']);
        }

        // Block students whose school ID has been archived — they cannot access any route
        if ($user->role === 'student' && $user->school_id_number) {
            $schoolIdArchived = \App\Models\StudentSchoolId::withTrashed()
                ->where('school_id_number', $user->school_id_number)
                ->whereNotNull('deleted_at')
                ->exists();
            if ($schoolIdArchived) {
                session()->flush();
                if ($request->expectsJson() || $request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your School ID has been archived. Please contact the administrator.'
                    ], 403);
                }
                return redirect()->route('login')
                    ->withErrors(['auth' => 'Your School ID has been archived. Please contact the administrator.']);
            }
        }

        // Sync session with latest user data
        session(['user' => $user]);

        return $next($request);
    }
}
