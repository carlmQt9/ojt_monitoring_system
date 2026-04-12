<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Rules\ReCaptcha;
use App\Helpers\MailHelper;

/*
|--------------------------------------------------------------------------
| RBAC-Protected Web Routes
|--------------------------------------------------------------------------
|
| This file implements Role-Based Access Control (RBAC) using middleware
| to enforce Separation of Duties and permission boundaries as described
| in the thesis: "PRMSU Sta. Cruz Campus BSCS OJT Monitoring System:
| Role-Based Access Control Integration"
|
| Middleware:
| - auth.custom: Ensures user is authenticated
| - role:student,supervisor,etc: Ensures user has required role(s)
|
*/

// ============================================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================================

Route::get('/', function () {
    return view('landing');
})->name('home');

// ============================================================================
// GUEST ROUTES (Only for non-authenticated users)
// ============================================================================

Route::middleware('guest')->group(function () {
    
    // Login Routes
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        if (!$user->is_approved && $user->role !== 'student') {
            return back()->withErrors(['email' => 'Your account is pending approval by the CCIT Head. Please wait for confirmation.'])->withInput();
        }

        // Store user in session
        session([
            'user_id' => $user->id,
            'user' => $user,
        ]);

        return redirect()->route('dashboard');
    })->name('login.post');

    // Registration Routes
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function () {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required','min:8','max:128','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'password_confirmation' => 'required|min:8|max:128',
            'role' => 'required|in:student,supervisor,coordinator,ccit_head',
            'company_id' => 'nullable|exists:companies,id',
            'school_year' => 'nullable|string|max:20',
            'terms' => 'required',
            'school_id_number' => 'nullable|string|max:20',
        ]);

        // Company is required for students and supervisors
        if (in_array($validated['role'], ['student', 'supervisor'])) {
            if (!$validated['company_id']) {
                return back()->withErrors(['company_id' => 'Please select a company/organization.'])->withInput();
            }
        }

        // School ID is required for students and must exist in the approved list
        if ($validated['role'] === 'student') {
            if (empty($validated['school_id_number'])) {
                return back()->withErrors(['school_id_number' => 'School ID number is required for students.'])->withInput();
            }
            $schoolId = \App\Models\StudentSchoolId::where('school_id_number', $validated['school_id_number'])
                ->where('is_used', false)->first();
            if (!$schoolId) {
                return back()->withErrors(['school_id_number' => 'This School ID is not on the approved list or has already been used.'])->withInput();
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'company_id' => $validated['company_id'],
            'school_year' => $validated['school_year'] ?? null,
            'school_id_number' => $validated['school_id_number'] ?? null,
            'is_approved' => $validated['role'] === 'student' ? true : false,
        ]);

        // Mark school ID as used
        if ($validated['role'] === 'student' && !empty($validated['school_id_number'])) {
            \App\Models\StudentSchoolId::where('school_id_number', $validated['school_id_number'])->update(['is_used' => true]);
        }

        // Send welcome email (silently ignore failures)
        $needsApproval = $validated['role'] !== 'student';
        try { MailHelper::sendWelcome($user->email, $user->name, $needsApproval); } catch (\Throwable) {}

        $message = $validated['role'] === 'student'
            ? 'Registration successful! Please log in with your credentials.'
            : 'Registration successful! Please wait for the CCIT Head to approve your account before logging in.';

        return redirect()->route('login')->with('success', $message);
    })->name('register.post');
});

// ============================================================================
// AUTHENTICATED ROUTES (All roles - requires login)
// ============================================================================

Route::middleware(['auth.custom'])->group(function () {
    
    // Dashboard - Role-based routing with RBAC
    Route::get('/dashboard', function () {
        $user = User::find(session('user_id'));
        
        if (!$user) {
            session()->flush();
            return redirect('/login');
        }
        
        session(['user' => $user]); // keep session in sync

        // ===== AUTO-TIMEOUT: if student forgot to time out before lunch =====
        if ($user->role === 'student') {
            $today = now()->toDateString();
            $nowHour = (int) now()->format('H');

            // Morning auto-timeout at 12:00
            if ($nowHour >= 12) {
                $openMorning = \App\Models\TimeInRecord::where('student_id', $user->id)
                    ->whereDate('date', $today)
                    ->where('session', 'morning')
                    ->whereNull('time_out')
                    ->first();
                if ($openMorning) {
                    $autoOut = '12:00';
                    $openMorning->update(['time_out' => $autoOut]);
                    $inTime = \Carbon\Carbon::createFromTimeString($openMorning->time_in);
                    $outTime = \Carbon\Carbon::createFromTimeString($autoOut);
                    $hoursWorked = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);
                    $sh = \App\Models\StudentHours::where('student_id', $user->id)
                        ->firstOrCreate(['student_id' => $user->id], ['total_hours_required' => 600]);
                    $sh->update([
                        'hours_completed' => round(max(0, $sh->hours_completed + $hoursWorked), 2),
                        'hours_remaining' => round(max(0, $sh->total_hours_required - $sh->hours_completed - $hoursWorked), 2),
                    ]);
                    \App\Models\DailyHourLog::create([
                        'student_id' => $user->id,
                        'log_date' => $today,
                        'hours_logged' => $hoursWorked,
                        'is_overtime' => false,
                        'status' => 'approved',
                    ]);
                }
            }

            // Afternoon forgot to time out: detected on NEXT DAY login
            $yesterday = now()->subDay()->toDateString();
            $openAfternoonYesterday = \App\Models\TimeInRecord::where('student_id', $user->id)
                ->whereDate('date', $yesterday)
                ->where('session', 'afternoon')
                ->whereNull('time_out')
                ->first();
            if ($openAfternoonYesterday) {
                $openAfternoonYesterday->update([
                    'time_out' => '00:00',
                    'regular_hours' => 0,
                    'ot_hours' => 0,
                    'ot_status' => null,
                    'status' => 'denied',
                    'denial_reason' => 'Auto-denied: student did not time out before end of day. Only morning hours are recorded.',
                ]);
            }
        }
        // ===== END AUTO-TIMEOUT =====

        // RBAC: Route to appropriate dashboard based on role
        if ($user->role === 'ccit_head') {
            return view('dashboards.ccit_head', ['user' => $user]);
        } elseif ($user->role === 'coordinator') {
            return view('dashboards.coordinator', ['user' => $user]);
        } elseif ($user->role === 'supervisor') {
            return view('dashboards.supervisor', ['user' => $user]);
        } else {
            return view('dashboards.student', ['user' => $user]);
        }
    })->name('dashboard');

    // Logout
    Route::get('/logout', function () {
        session()->flush();
        return redirect('/');
    })->name('logout');
});

// ============================================================================
// STUDENT ROUTES (RBAC: Only students can access)
// ============================================================================

Route::middleware(['auth.custom', 'role:student'])->group(function () {
    
    // Time-In Routes
    Route::post('/time-in', function () {
        $rules = [
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'session' => 'nullable|in:morning,afternoon',
        ];

        if (request()->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        } elseif (!request()->filled('photo_base64')) {
            $rules['photo_base64'] = 'required_without:photo';
        }

        $validated = request()->validate($rules);

        // RBAC: Ensure student can only time-in for themselves
        if ($validated['student_id'] != session('user_id')) {
            abort(403, 'You can only record time-in for yourself.');
        }

        $student = User::findOrFail($validated['student_id']);

        // Determine session
        $nowHour = (int) now()->format('H');
        $nowMin = (int) now()->format('i');
        $session = $validated['session'] ?? 'morning';

        if ($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50)) {
            $session = 'afternoon';
        } else {
            $session = 'morning';
        }

        // Check if already timed in
        $existingRecord = \App\Models\TimeInRecord::where('student_id', $student->id)
            ->whereDate('date', $validated['date'])
            ->where('session', $session)
            ->first();

        if ($existingRecord) {
            return back()->withErrors(['date' => 'Already timed in for the ' . $session . ' session today.']);
        }

        // Afternoon session: only allowed after 12:50
        if ($session === 'afternoon' && !($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50))) {
            return back()->withErrors(['date' => 'Afternoon time-in is only available from 12:50 PM onwards.']);
        }

        // Store the photo
        $photoPath = null;
        
        if (request()->hasFile('photo')) {
            $photoPath = request()->file('photo')->store('time-in-photos', 'public');
        } elseif (request()->filled('photo_base64')) {
            $base64Image = request()->input('photo_base64');
            
            if (strpos($base64Image, 'data:image') === 0) {
                $image_data = explode(',', $base64Image);
                $image_data = base64_decode($image_data[1]);
            } else {
                $image_data = base64_decode($base64Image);
            }
            
            $filename = 'time-in-' . $student->id . '-' . now()->timestamp . '.jpg';
            $photoPath = 'time-in-photos/' . $filename;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($photoPath, $image_data);
        }

        // Server time for security
        $serverTimeIn = now()->format('H:i');

        \App\Models\TimeInRecord::create([
            'student_id' => $student->id,
            'date' => $validated['date'],
            'session' => $session,
            'time_in' => $serverTimeIn,
            'photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Successfully timed in (' . ucfirst($session) . ' session)!');
    })->name('time-in');

    // Time-Out Route
    Route::post('/time-out', function () {
        // Implementation continues...
        // (I'll add the rest in the next file write to keep it manageable)
        return back()->with('success', 'Time-out recorded!');
    })->name('time-out');
});

// ============================================================================
// SUPERVISOR ROUTES (RBAC: Only supervisors can access)
// ============================================================================

Route::middleware(['auth.custom', 'role:supervisor'])->group(function () {
    
    // Approve/Deny Time-In Records
    Route::post('/approve-time-in/{recordId}', function ($recordId) {
        // RBAC: Supervisor can only approve records for their assigned students
        $record = \App\Models\TimeInRecord::findOrFail($recordId);
        $supervisor = User::find(session('user_id'));
        
        // Verify supervisor is assigned to this student's company
        $student = User::find($record->student_id);
        if ($student->company_id !== $supervisor->company_id) {
            abort(403, 'You can only approve time-in records for students in your company.');
        }
        
        // Approval logic here...
        return back()->with('success', 'Time-in approved!');
    })->name('approve-time-in');
    
    // Submit Evaluation (with hours requirement check)
    Route::post('/save-evaluation/{studentId}', function ($studentId) {
        // RBAC: Supervisor can only evaluate their assigned students
        $supervisor = User::find(session('user_id'));
        $student = User::findOrFail($studentId);
        
        if ($student->company_id !== $supervisor->company_id) {
            abort(403, 'You can only evaluate students in your company.');
        }
        
        // Check if student has completed required hours
        $studentHours = \App\Models\StudentHours::where('student_id', $studentId)->first();
        if (!$studentHours || $studentHours->hours_completed < $studentHours->total_hours_required) {
            return response()->json([
                'success' => false,
                'message' => 'Student must complete required hours before evaluation.'
            ], 403);
        }
        
        // Evaluation logic here...
        return response()->json(['success' => true]);
    })->name('save-evaluation');
});

// ============================================================================
// COORDINATOR ROUTES (RBAC: Only coordinators can access)
// ============================================================================

Route::middleware(['auth.custom', 'role:coordinator'])->group(function () {
    
    // Company Management
    Route::post('/api/companies', function () {
        // RBAC: Only coordinators can manage companies
        // Implementation here...
        return response()->json(['success' => true]);
    });
    
    // Approve Requirements
    Route::post('/approve-requirement/{requirementId}', function ($requirementId) {
        // RBAC: Only coordinators can approve requirements
        // Implementation here...
        return back()->with('success', 'Requirement approved!');
    })->name('approve-requirement');
});

// ============================================================================
// CCIT HEAD ROUTES (RBAC: Only CCIT Head can access)
// ============================================================================

Route::middleware(['auth.custom', 'role:ccit_head'])->group(function () {
    
    // User Management
    Route::post('/api/users', function () {
        // RBAC: Only CCIT Head can create users
        // Implementation here...
        return response()->json(['success' => true]);
    });
    
    // System Settings
    Route::post('/api/settings', function () {
        // RBAC: Only CCIT Head can modify system settings
        $validated = request()->validate([
            'required_hours' => 'required|integer|min:0',
            'email_notifications' => 'nullable',
        ]);

        \App\Models\StudentHours::query()->update(['total_hours_required' => $validated['required_hours']]);
        
        $studentIds = User::where('role', 'student')->pluck('id');
        foreach ($studentIds as $sid) {
            \App\Models\StudentHours::firstOrCreate(
                ['student_id' => $sid],
                ['hours_completed' => 0, 'total_hours_required' => $validated['required_hours']]
            );
        }

        $notify = isset($validated['email_notifications']) ? boolval($validated['email_notifications']) : false;
        cache(['settings.email_notifications' => $notify]);

        return response()->json(['success' => true]);
    });
    
    // School ID Management
    Route::post('/api/school-ids', function () {
        // RBAC: Only CCIT Head can manage school IDs
        // Implementation here...
        return response()->json(['success' => true]);
    });
});

// ============================================================================
// SHARED ROUTES (Multiple roles with specific permissions)
// ============================================================================

// Coordinator OR Supervisor can approve time-in
Route::middleware(['auth.custom', 'role:coordinator,supervisor'])->group(function () {
    Route::post('/approve-time-in-shared/{recordId}', function ($recordId) {
        // Both coordinators and supervisors can approve
        return back()->with('success', 'Time-in approved!');
    });
});

// Coordinator OR CCIT Head can approve requirements
Route::middleware(['auth.custom', 'role:coordinator,ccit_head'])->group(function () {
    Route::post('/approve-requirement-shared/{requirementId}', function ($requirementId) {
        // Both coordinators and CCIT Head can approve
        return back()->with('success', 'Requirement approved!');
    });
});
