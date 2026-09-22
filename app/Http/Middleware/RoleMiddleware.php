<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

/**
 * Role-Based Access Control (RBAC) Middleware
 * 
 * This middleware enforces role-based access restrictions by:
 * 1. Verifying user authentication via session
 * 2. Checking if the authenticated user's role matches allowed roles
 * 3. Denying access (403) if role requirements are not met
 * 
 * This implements the RBAC algorithm described in the thesis:
 * - Separation of Duties (SoD) enforcement
 * - Permission-per-role validation
 * - Unauthorized access prevention
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed roles for this route
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Step 1: Check if user is authenticated
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['auth' => 'You must be logged in to access this resource.']);
        }

        // Step 2: Retrieve authenticated user from database
        $user = User::find(session('user_id'));
        
        if (!$user) {
            // User session exists but user was deleted
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists. Please contact the administrator.']);
        }

        // Step 3: Check if user is approved (except for students who are auto-approved)
        if (!$user->is_approved && $user->role !== 'student') {
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account is pending approval by the CCIT Head.']);
        }

        // Step 4: RBAC Algorithm - Check if user's role is in the allowed roles list
        if (!in_array($user->role, $roles)) {
            // Access denied - return JSON 403 for API/JSON/AJAX requests, HTML abort for web
            if ($request->expectsJson() || $request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied: Your role (' . $user->role . ') is not authorized to access this resource.',
                ], 403);
            }
            abort(403, 'Access Denied: Your role (' . $user->role . ') is not authorized to access this resource.');
        }

        // Step 5: Access granted - proceed to the requested resource
        return $next($request);
    }
}
