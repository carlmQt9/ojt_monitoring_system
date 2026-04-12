# RBAC Implementation Documentation

## Overview
This document describes the Role-Based Access Control (RBAC) algorithm implementation for the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System.

## Architecture

### 1. Middleware Components

#### AuthMiddleware (`app/Http/Middleware/AuthMiddleware.php`)
- **Purpose**: First layer of security - ensures user is authenticated
- **Function**: Checks if `session('user_id')` exists and user record is valid
- **Response**: Redirects to login if not authenticated

#### RoleMiddleware (`app/Http/Middleware/RoleMiddleware.php`)
- **Purpose**: Second layer - enforces role-based access control
- **Function**: Validates user's role against allowed roles for the route
- **Algorithm**:
  ```
  1. Check if user is authenticated (session exists)
  2. Retrieve user from database
  3. Verify user is approved (except students)
  4. Check if user->role is in allowed roles array
  5. If yes: grant access
  6. If no: return 403 Forbidden
  ```

### 2. Middleware Registration

In `bootstrap/app.php`:
```php
$middleware->alias([
    'auth.custom' => \App\Http\Middleware\AuthMiddleware::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

### 3. Route Protection Patterns

#### Pattern 1: Single Role Protection
```php
Route::middleware(['auth.custom', 'role:student'])->group(function () {
    // Only students can access these routes
});
```

#### Pattern 2: Multiple Role Protection
```php
Route::middleware(['auth.custom', 'role:coordinator,supervisor'])->group(function () {
    // Both coordinators and supervisors can access
});
```

#### Pattern 3: All Authenticated Users
```php
Route::middleware(['auth.custom'])->group(function () {
    // Any authenticated user can access
});
```

## RBAC Algorithm Flowchart Implementation

### Step 1: User Requests Access to Protected Resource
- User clicks a link or submits a form
- Request is sent to Laravel router

### Step 2: AuthMiddleware Execution
```php
if (!session('user_id')) {
    return redirect()->route('login');
}
$user = User::find(session('user_id'));
if (!$user) {
    session()->flush();
    return redirect()->route('login');
}
```

### Step 3: RoleMiddleware Execution
```php
if (!in_array($user->role, $roles)) {
    abort(403, 'Access Denied');
}
```

### Step 4: Access Granted
- Request proceeds to controller/route handler
- User can perform authorized action

## Separation of Duties (SoD) Implementation

### Student Role Permissions
- ✅ Time-in/Time-out (own records only)
- ✅ View own attendance history
- ✅ Upload own requirements
- ✅ View own progress
- ❌ Cannot approve any records
- ❌ Cannot access other students' data
- ❌ Cannot modify system settings

### Supervisor Role Permissions
- ✅ View assigned students only
- ✅ Approve/deny time-in records (own company)
- ✅ Approve/deny requirements (own company)
- ✅ Submit evaluations (after hours completed)
- ❌ Cannot access students from other companies
- ❌ Cannot manage companies
- ❌ Cannot modify system settings

### Coordinator Role Permissions
- ✅ View all students
- ✅ Manage companies
- ✅ Approve/deny time-in records (all students)
- ✅ Approve/deny requirements (all students)
- ❌ Cannot submit evaluations
- ❌ Cannot manage users
- ❌ Cannot modify system settings

### CCIT Head Role Permissions
- ✅ Full user management (all roles)
- ✅ System settings configuration
- ✅ School year management
- ✅ School ID whitelist management
- ✅ View all system data
- ✅ Generate system-wide reports
- ✅ Approve requirements (shared with coordinator)

## Security Features

### 1. Session-Based Authentication
- User credentials stored in encrypted session
- Session validated on every request
- Automatic session cleanup on logout

### 2. Server-Side Validation
- All role checks performed on server
- No client-side role enforcement
- Cannot be bypassed by modifying frontend

### 3. Database-Level Verification
- User role retrieved from database on each request
- Role changes take effect immediately
- No caching of permission data

### 4. Cross-Role Access Prevention
```php
// Example: Student cannot time-in for another student
if ($validated['student_id'] != session('user_id')) {
    abort(403, 'You can only record time-in for yourself.');
}

// Example: Supervisor can only evaluate own company students
if ($student->company_id !== $supervisor->company_id) {
    abort(403, 'You can only evaluate students in your company.');
}
```

## Testing the RBAC Implementation

### Test Case 1: Unauthorized Role Access
1. Login as Student
2. Try to access `/api/settings` (CCIT Head only)
3. Expected: 403 Forbidden error

### Test Case 2: Cross-Student Data Access
1. Login as Student A
2. Try to submit time-in for Student B
3. Expected: 403 Forbidden error

### Test Case 3: Supervisor Company Boundary
1. Login as Supervisor from Company A
2. Try to approve time-in for student from Company B
3. Expected: 403 Forbidden error

### Test Case 4: Evaluation Hours Requirement
1. Login as Supervisor
2. Try to evaluate student with < 600 hours
3. Expected: 403 Forbidden with message

## Performance Considerations

### Middleware Execution Order
1. Global middleware (session, CSRF)
2. auth.custom (authentication check)
3. role:xxx (authorization check)
4. Route handler

### Database Queries
- 1 query per request to verify user exists
- Cached in session for subsequent checks within same request
- Minimal performance impact

## Compliance with Thesis Requirements

✅ **Role-Based Access Control Algorithm**: Implemented via RoleMiddleware
✅ **Separation of Duties**: Enforced through route-level restrictions
✅ **Permission per Role**: Defined in route groups
✅ **Unauthorized Access Prevention**: 403 errors for invalid access
✅ **Session-Based Authentication**: Laravel session management
✅ **Middleware-Based Enforcement**: Custom middleware registered in bootstrap

## Migration from Old System

### Before (No RBAC):
```php
Route::get('/dashboard', function () {
    if ($user->role === 'student') {
        return view('dashboards.student');
    }
    // Simple if-else, no security
});
```

### After (With RBAC):
```php
Route::middleware(['auth.custom', 'role:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboards.student');
    });
});
```

## Conclusion

This RBAC implementation provides:
- **Security**: Multi-layer protection with authentication + authorization
- **Scalability**: Easy to add new roles or modify permissions
- **Maintainability**: Centralized permission logic in middleware
- **Compliance**: Matches thesis description of RBAC algorithm
- **Auditability**: Clear separation of duties and access logs

The system now implements a true RBAC algorithm as described in the research paper, not just conditional rendering.
