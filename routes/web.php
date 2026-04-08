<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Rules\ReCaptcha;
use App\Helpers\MailHelper;

Route::get('/', function () {
    return view('landing');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function () {
    $validated = request()->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    if (!$user->is_approved) {
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
})->name('register')->middleware('guest');

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
})->name('register.post')->middleware('guest');
// Student Hours Routes: Log Hours feature removed

Route::get('/dashboard', function () {
    if (!session('user_id')) {
        return redirect('/login');
    }

    $user = session('user');

    // ===== AUTO-TIMEOUT: if student forgot to time out before lunch =====
    if ($user->role === 'student') {
        $today    = now()->toDateString();
        $nowHour  = (int) now()->format('H');

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
                $inTime  = \Carbon\Carbon::createFromTimeString($openMorning->time_in);
                $outTime = \Carbon\Carbon::createFromTimeString($autoOut);
                $hoursWorked = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);
                $sh = \App\Models\StudentHours::where('student_id', $user->id)
                    ->firstOrCreate(['student_id' => $user->id], ['total_hours_required' => 600]);
                $sh->update([
                    'hours_completed' => round(max(0, $sh->hours_completed + $hoursWorked), 2),
                    'hours_remaining' => round(max(0, $sh->total_hours_required - $sh->hours_completed - $hoursWorked), 2),
                ]);
                \App\Models\DailyHourLog::create([
                    'student_id'   => $user->id,
                    'log_date'     => $today,
                    'hours_logged' => $hoursWorked,
                    'is_overtime'  => false,
                    'status'       => 'approved',
                ]);
            }
        }

        // ===== Afternoon forgot to time out: detected on NEXT DAY login =====
        // If student logs in today and yesterday's afternoon is still open with no time_out
        // — mark it as incomplete/not recorded, only morning hours count
        $yesterday = now()->subDay()->toDateString();
        $openAfternoonYesterday = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereDate('date', $yesterday)
            ->where('session', 'afternoon')
            ->whereNull('time_out')
            ->first();
        if ($openAfternoonYesterday) {
            // Mark as denied — no hours credited, afternoon time not recorded
            $openAfternoonYesterday->update([
                'time_out'      => '00:00',
                'regular_hours' => 0,
                'ot_hours'      => 0,
                'ot_status'     => null,
                'status'        => 'denied',
                'denial_reason' => 'Auto-denied: student did not time out before end of day. Only morning hours are recorded.',
            ]);
            // No hours credited — afternoon is forfeited
        }
    }
    // ===== END AUTO-TIMEOUT =====

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

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

// Time-In Routes
Route::post('/time-in', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date'       => 'required|date',
        'session'    => 'nullable|in:morning,afternoon',
    ];

    if (request()->hasFile('photo')) {
        $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
    } elseif (!request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'required_without:photo';
    }

    $validated = request()->validate($rules);

    $student = User::findOrFail($validated['student_id']);

    // Determine session: afternoon only allowed after 12:50
    $nowHour = (int) now()->format('H');
    $nowMin  = (int) now()->format('i');
    $session = $validated['session'] ?? 'morning';

    // Auto-detect afternoon if current time >= 12:50
    if ($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50)) {
        $session = 'afternoon';
    } else {
        $session = 'morning';
    }

    // Check if already timed in for this session today
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
        // File upload
        $photoPath = request()->file('photo')->store('time-in-photos', 'public');
    } elseif (request()->filled('photo_base64')) {
        // Camera capture (base64)
        $base64Image = request()->input('photo_base64');
        
        // Extract base64 data and convert to file
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

    // For security, always record server time for time-in to prevent client tampering
    $serverTimeIn = now()->format('H:i');

    $timeInRecord = \App\Models\TimeInRecord::create([
        'student_id' => $student->id,
        'date'       => $validated['date'],
        'session'    => $session,
        'time_in'    => $serverTimeIn,
        'photo_path' => $photoPath,
    ]);

    return back()->with('success', 'Successfully timed in (' . ucfirst($session) . ' session)!');
})->name('time-in');

Route::post('/time-out', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date'       => 'required|date',
        'session'    => 'nullable|in:morning,afternoon',
    ];

    if (request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'string';
    }

    $validated = request()->validate($rules);

    // Find the open (no time_out) record for today matching session
    $record = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->whereNull('time_out')
        ->when(isset($validated['session']), fn($q) => $q->where('session', $validated['session']))
        ->latest()
        ->first();

    if (!$record) {
        return back()->withErrors(['date' => 'No open time-in record found for this date.']);
    }

    // Store the timeout photo if provided
    $timeOutPhotoPath = $record->photo_path; // Keep existing time-in photo
    
    if (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        
        // Extract base64 data and convert to file
        if (strpos($base64Image, 'data:image') === 0) {
            $image_data = explode(',', $base64Image);
            $image_data = base64_decode($image_data[1]);
        } else {
            $image_data = base64_decode($base64Image);
        }
        
        $student = User::findOrFail($validated['student_id']);
        $filename = 'time-out-' . $student->id . '-' . now()->timestamp . '.jpg';
        $timeOutPhotoPath = 'time-out-photos/' . $filename;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($timeOutPhotoPath, $image_data);
    }

    // Use server time for time-out to prevent tampering
    $serverTimeOut = now()->format('H:i');
    
    // Add a new field to store timeout photo or update existing record
    // Since we can't modify the schema, we'll store both time-in and time-out photos in the same record
    // by creating the timeout photo path separately
    $record->update([
        'time_out' => $serverTimeOut,
        'photo_path' => $timeOutPhotoPath // Update with timeout photo if captured
    ]);

    // Calculate hours for THIS session
    $timeInParts  = explode(':', $record->time_in);
    $timeOutParts = explode(':', $serverTimeOut);
    $inTime  = \Carbon\Carbon::createFromTime($timeInParts[0], $timeInParts[1], 0);
    $outTime = \Carbon\Carbon::createFromTime($timeOutParts[0], $timeOutParts[1], 0);
    $sessionMinutes = max(0, $inTime->diffInMinutes($outTime));
    $sessionHours   = round($sessionMinutes / 60, 2);

    // Calculate total hours already logged today (previous sessions, already timed out)
    $prevSessionsToday = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->whereNotNull('time_out')
        ->where('id', '!=', $record->id)
        ->get();
    $prevDayMinutes = $prevSessionsToday->sum(fn($r) =>
        max(0, \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)))
    );
    $prevDayHours = round($prevDayMinutes / 60, 2);
    $totalDayHours = round($prevDayHours + $sessionHours, 2);

    // Regular hours = up to 8 per day total; OT = beyond 8
    $regularCap   = 8.0;
    $regularToday = min($totalDayHours, $regularCap);
    $otToday      = max(0, round($totalDayHours - $regularCap, 2));

    // Regular hours credited to THIS session = what this session contributes within the 8-hr cap
    $regularThisSession = max(0, round($regularToday - $prevDayHours, 2));
    $otThisSession      = max(0, round($sessionHours - $regularThisSession, 2));

    // Determine OT status for this record
    $otStatus = null;
    if ($otThisSession > 0) {
        // Check if student already has an approved OT letter for today
        $otLetterApproved = \App\Models\StudentRequirement::where('student_id', $validated['student_id'])
            ->whereDate('created_at', $validated['date'])
            ->where('status', 'approved')
            ->where(function($q) {
                $q->where('title', 'like', '%OT%')
                  ->orWhere('title', 'like', '%overtime%')
                  ->orWhere('title', 'like', '%over time%');
            })
            ->exists();
        $otStatus = $otLetterApproved ? 'approved' : 'pending';
    }

    // Update the record with computed hours
    $record->update([
        'regular_hours' => $regularThisSession,
        'ot_hours'      => $otThisSession,
        'ot_status'     => $otStatus,
    ]);

    // DO NOT add hours yet — wait for supervisor/coordinator approval of the time-in record
    // Create daily log entry as pending (only regular hours tracked here; OT handled separately)
    \App\Models\DailyHourLog::create([
        'student_id'   => $validated['student_id'],
        'log_date'     => $validated['date'],
        'hours_logged' => $regularThisSession,
        'is_overtime'  => false,
        'status'       => 'pending',
    ]);

    // If OT exists and letter already approved, create a separate OT log entry
    if ($otThisSession > 0 && $otStatus === 'approved') {
        \App\Models\DailyHourLog::create([
            'student_id'   => $validated['student_id'],
            'log_date'     => $validated['date'],
            'hours_logged' => $otThisSession,
            'is_overtime'  => true,
            'status'       => 'pending',
        ]);
    }

    $msg = $otThisSession > 0
        ? sprintf('Time-out recorded! Regular: %.2f hrs, OT: %.2f hrs. %s',
            $regularThisSession, $otThisSession,
            $otStatus === 'approved' ? 'OT letter approved — OT hours will be credited upon time-in approval.' : 'Submit an OT letter to have your overtime hours credited.')
        : sprintf('Time-out recorded! %.2f hrs — awaiting approval.', $regularThisSession);

    return back()->with('success', $msg);
})->name('time-out');

// AJAX time-out endpoint: returns JSON with updated student hours
Route::post('/time-out-ajax', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date' => 'required|date',
    ];

    if (request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'string';
    }

    $validated = request()->validate($rules);

    $record = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->first();

    if (!$record) {
        return response()->json(['error' => 'No time-in record found for this date.'], 422);
    }

    $timeOutPhotoPath = $record->photo_path;
    if (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        if (strpos($base64Image, 'data:image') === 0) {
            $image_data = explode(',', $base64Image);
            $image_data = base64_decode($image_data[1]);
        } else {
            $image_data = base64_decode($base64Image);
        }
        $student = User::findOrFail($validated['student_id']);
        $filename = 'time-out-' . $student->id . '-' . now()->timestamp . '.jpg';
        $timeOutPhotoPath = 'time-out-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($timeOutPhotoPath, $image_data);
    }

    $serverTimeOut = now()->format('H:i');

    $record->update([
        'time_out' => $serverTimeOut,
        'photo_path' => $timeOutPhotoPath,
    ]);

    $timeInParts = explode(':', $record->time_in);
    $timeOutParts = explode(':', $serverTimeOut);
    $inTime = \Carbon\Carbon::createFromTime($timeInParts[0], $timeInParts[1], 0);
    $outTime = \Carbon\Carbon::createFromTime($timeOutParts[0], $timeOutParts[1], 0);
    $minutesWorked = $outTime->diffInMinutes($inTime);
    if ($minutesWorked < 0) $minutesWorked = 0;
    $hoursWorked = round($minutesWorked / 60, 2);

    $studentHours = \App\Models\StudentHours::where('student_id', $validated['student_id'])
        ->firstOrCreate(['student_id' => $validated['student_id']], ['total_hours_required' => 600]);

    $newCompleted = round(max(0, $studentHours->hours_completed + $hoursWorked), 2);
    $newRemaining = round(max(0, $studentHours->total_hours_required - $newCompleted), 2);

    $studentHours->update([
        'hours_completed' => $newCompleted,
        'hours_remaining' => $newRemaining,
    ]);

    \App\Models\DailyHourLog::create([
        'student_id' => $validated['student_id'],
        'log_date' => $validated['date'],
        'hours_logged' => max(0, $hoursWorked),
        'status' => 'approved',
    ]);

    return response()->json([
        'success' => true,
        'hours_worked' => $hoursWorked,
        'student_hours' => [
            'hours_completed' => $studentHours->hours_completed,
            'hours_remaining' => $studentHours->hours_remaining,
            'total_hours_required' => $studentHours->total_hours_required,
            'progress_percentage' => $studentHours->total_hours_required > 0 ? round(($studentHours->hours_completed / $studentHours->total_hours_required) * 100, 2) : 0,
        ],
    ]);
})->name('time-out-ajax');

Route::get('/time-in-status/{studentId}/{date}', function ($studentId, $date) {
    $record = \App\Models\TimeInRecord::where('student_id', $studentId)
        ->whereDate('date', $date)
        ->first();

    return response()->json([
        'has_timed_in' => $record ? true : false,
        'time_in' => $record?->time_in,
        'time_out' => $record?->time_out,
        'verified' => $record?->verified,
    ]);
})->name('time-in-status');

// Student Hours Routes: Log Hours removed

Route::get('/student-progress/{studentId}', function ($studentId) {
    $student = User::findOrFail($studentId);
    $studentHours = \App\Models\StudentHours::where('student_id', $studentId)->firstOrCreate(
        ['student_id' => $studentId],
        ['total_hours_required' => 600]
    );
    
    $dailyLogs = \App\Models\DailyHourLog::where('student_id', $studentId)
        ->orderBy('log_date', 'desc')
        ->get();

    return response()->json([
        'student' => $student,
        'hours' => $studentHours,
        'daily_logs' => $dailyLogs,
        'progress_percentage' => ($studentHours->hours_completed / 600) * 100,
    ]);
})->name('student-progress');

// Approval Routes
Route::post('/approve-hours/{logId}', function ($logId) {
    $log = \App\Models\DailyHourLog::findOrFail($logId);
    $coordinator = User::findOrFail(session('user_id'));

    // If the log is pending, apply its hours to the student's totals
    if ($log->status === 'pending') {
        $hours = floatval($log->hours_logged);
        if ($hours > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $log->student_id)
                ->firstOrCreate(['student_id' => $log->student_id], ['total_hours_required' => 600]);

            $newCompleted = round(max(0, $studentHours->hours_completed + $hours), 2);
            $newRemaining = round(max(0, $studentHours->total_hours_required - $newCompleted), 2);

            $studentHours->update([
                'hours_completed' => $newCompleted,
                'hours_remaining' => $newRemaining,
            ]);
        }
    }

    $log->update([
        'status' => 'approved',
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);

    return back()->with('success', 'Hours log approved!');
})->name('approve-hours');

Route::post('/deny-hours/{logId}', function ($logId) {
    $validated = request()->validate([
        'reason' => 'required|string',
    ]);

    $log = \App\Models\DailyHourLog::findOrFail($logId);
    $coordinator = User::findOrFail(session('user_id'));
    
    $log->update([
        'status' => 'denied',
        'denial_reason' => $validated['reason'],
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);

    return back()->with('success', 'Hours log denied with reason provided.');
})->name('deny-hours');

Route::post('/approve-time-in/{recordId}', function ($recordId) {
    $record = \App\Models\TimeInRecord::findOrFail($recordId);
    $reviewer = User::findOrFail(session('user_id'));

    if ($record->status !== 'approved' && $record->time_in && $record->time_out) {
        // Get ALL sessions for this student on this date
        $allDaySessions = \App\Models\TimeInRecord::where('student_id', $record->student_id)
            ->whereDate('date', $record->date)
            ->whereNotNull('time_out')
            ->where('status', 'pending')
            ->get();

        // Check if OT letter is approved for this date
        $otLetterApproved = \App\Models\StudentRequirement::where('student_id', $record->student_id)
            ->whereDate('created_at', $record->date)
            ->where('status', 'approved')
            ->where(function($q) {
                $q->where('title', 'like', '%OT%')
                  ->orWhere('title', 'like', '%overtime%')
                  ->orWhere('title', 'like', '%over time%');
            })->exists();

        $totalToCredit = 0;
        foreach ($allDaySessions as $session) {
            $regularHours = floatval($session->regular_hours ?? 0);
            $otHours = floatval($session->ot_hours ?? 0);
            $totalToCredit += $regularHours;
            if ($otHours > 0 && $otLetterApproved) {
                $totalToCredit += $otHours;
                $session->update(['ot_status' => 'approved']);
            } elseif ($otHours > 0 && !$otLetterApproved) {
                $session->update(['ot_status' => 'pending']);
            }
            $session->update(['verified' => true, 'status' => 'approved', 'approved_by' => $reviewer->id, 'approved_at' => now()]);
        }

        if ($totalToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $record->student_id)
                ->firstOrCreate(['student_id' => $record->student_id], ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0, $studentHours->hours_completed + $totalToCredit), 2),
                'hours_remaining' => round(max(0, $studentHours->total_hours_required - $studentHours->hours_completed - $totalToCredit), 2),
            ]);
        }

        \App\Models\DailyHourLog::where('student_id', $record->student_id)
            ->whereDate('log_date', $record->date)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);
    }

    $msg = ($record->ot_hours > 0 && !\App\Models\StudentRequirement::where('student_id', $record->student_id)
        ->whereDate('created_at', $record->date)->where('status','approved')
        ->where(function($q){ $q->where('title','like','%OT%')->orWhere('title','like','%overtime%')->orWhere('title','like','%over time%'); })->exists())
        ? 'All sessions approved! Regular hours credited. OT hours pending — student must get OT letter approved.'
        : 'All sessions for this day approved and hours credited!';

    // Send email notification to student
    $studentUser = User::find($record->student_id);
    if ($studentUser) {
        $dateStr = $record->date->format('M d, Y');
        $credited = $totalToCredit;
        register_shutdown_function(function() use ($studentUser, $dateStr, $credited) {
            try { \App\Helpers\MailHelper::sendTimeInApproved($studentUser->email, $studentUser->name, $dateStr, round($credited, 2)); } catch (\Throwable) {}
        });
    }

    return back()->with('success', $msg);
})->name('approve-time-in');

Route::post('/deny-time-in/{recordId}', function ($recordId) {
    $validated = request()->validate(['reason' => 'required|string']);
    $record = \App\Models\TimeInRecord::findOrFail($recordId);
    $reviewer = User::findOrFail(session('user_id'));

    // Deny ALL sessions for this day
    $allDaySessions = \App\Models\TimeInRecord::where('student_id', $record->student_id)
        ->whereDate('date', $record->date)
        ->whereNotNull('time_out')
        ->get();

    // If any were previously approved, deduct hours back
    foreach ($allDaySessions as $session) {
        if ($session->status === 'approved') {
            $credited = floatval($session->regular_hours ?? 0);
            if (floatval($session->ot_hours ?? 0) > 0 && $session->ot_status === 'approved') {
                $credited += floatval($session->ot_hours);
            }
            if ($credited > 0) {
                $studentHours = \App\Models\StudentHours::where('student_id', $record->student_id)->first();
                if ($studentHours) {
                    $studentHours->update([
                        'hours_completed' => round(max(0, $studentHours->hours_completed - $credited), 2),
                        'hours_remaining' => round(min($studentHours->total_hours_required, $studentHours->hours_remaining + $credited), 2),
                    ]);
                }
            }
        }
        // Only credit regular hours (8 hrs max), deny OT
        $regularOnly = floatval($session->regular_hours ?? 0);
        if ($regularOnly > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $record->student_id)
                ->firstOrCreate(['student_id' => $record->student_id], ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0, $studentHours->hours_completed + $regularOnly), 2),
                'hours_remaining' => round(max(0, $studentHours->total_hours_required - $studentHours->hours_completed - $regularOnly), 2),
            ]);
        }
        $session->update([
            'status'        => 'denied',
            'ot_status'     => $session->ot_hours > 0 ? 'denied' : $session->ot_status,
            'denial_reason' => $validated['reason'],
            'approved_by'   => $reviewer->id,
            'approved_at'   => now(),
        ]);
    }

    \App\Models\DailyHourLog::where('student_id', $record->student_id)
        ->whereDate('log_date', $record->date)
        ->whereIn('status', ['pending', 'approved'])
        ->update(['status' => 'denied']);

    // Send email notification to student
    $studentUser = User::find($record->student_id);
    if ($studentUser) {
        $dateStr = $record->date->format('M d, Y');
        $reason = $validated['reason'];
        register_shutdown_function(function() use ($studentUser, $dateStr, $reason) {
            try { \App\Helpers\MailHelper::sendTimeInDenied($studentUser->email, $studentUser->name, $dateStr, $reason); } catch (\Throwable) {}
        });
    }

    return back()->with('success', 'OT denied. Only regular hours (up to 8 hrs) have been recorded.');
})->name('deny-time-in');

// Bulk approve all pending time-in records for a student
Route::post('/approve-all-time-in/{studentId}', function ($studentId) {
    $reviewer = User::findOrFail(session('user_id'));
    $pendingRecords = \App\Models\TimeInRecord::where('student_id', $studentId)
        ->where('status', 'pending')
        ->whereNotNull('time_out')
        ->whereDoesntHave('student', fn($q) => $q->whereRaw('0=1')) // always true
        ->get()
        ->filter(function($r) use ($studentId) {
            // Only approve if no active session on that date
            return !\App\Models\TimeInRecord::where('student_id', $studentId)
                ->whereDate('date', $r->date)->whereNull('time_out')->exists();
        });

    $otLetterCache = [];
    $totalToCredit = 0;
    foreach ($pendingRecords as $record) {
        $dateKey = $record->date->toDateString();
        if (!isset($otLetterCache[$dateKey])) {
            $otLetterCache[$dateKey] = \App\Models\StudentRequirement::where('student_id', $studentId)
                ->whereDate('created_at', $dateKey)->where('status', 'approved')
                ->where(fn($q) => $q->where('title','like','%OT%')->orWhere('title','like','%overtime%')->orWhere('title','like','%over time%'))
                ->exists();
        }
        $regular = floatval($record->regular_hours ?? 0);
        $ot      = floatval($record->ot_hours ?? 0);
        $totalToCredit += $regular;
        if ($ot > 0 && $otLetterCache[$dateKey]) $totalToCredit += $ot;
        $record->update(['verified' => true, 'status' => 'approved', 'approved_by' => $reviewer->id, 'approved_at' => now(),
            'ot_status' => $ot > 0 ? ($otLetterCache[$dateKey] ? 'approved' : 'pending') : $record->ot_status]);
    }
    if ($totalToCredit > 0) {
        $sh = \App\Models\StudentHours::where('student_id', $studentId)->firstOrCreate(['student_id' => $studentId], ['total_hours_required' => 600]);
        $sh->update(['hours_completed' => round(max(0, $sh->hours_completed + $totalToCredit), 2),
            'hours_remaining' => round(max(0, $sh->total_hours_required - $sh->hours_completed - $totalToCredit), 2)]);
    }
    \App\Models\DailyHourLog::where('student_id', $studentId)->where('status', 'pending')->update(['status' => 'approved']);
    // Send email notification
    $student = User::findOrFail($studentId);
    $dateStr = now()->format('M d, Y');
    register_shutdown_function(function() use ($student, $totalToCredit, $dateStr) {
        try { \App\Helpers\MailHelper::sendTimeInApproved($student->email, $student->name, $dateStr, round($totalToCredit, 2)); } catch (\Throwable) {}
    });
    return back()->with('success', 'All pending time-in records approved!');
});

// Bulk deny all pending time-in records for a student
Route::post('/deny-all-time-in/{studentId}', function ($studentId) {
    $validated = request()->validate(['reason' => 'required|string']);
    $reviewer = User::findOrFail(session('user_id'));
    $pendingRecords = \App\Models\TimeInRecord::where('student_id', $studentId)
        ->where('status', 'pending')->whereNotNull('time_out')->get()
        ->filter(fn($r) => !\App\Models\TimeInRecord::where('student_id', $studentId)
            ->whereDate('date', $r->date)->whereNull('time_out')->exists());
    $totalRegular = 0;
    foreach ($pendingRecords as $record) {
        $totalRegular += floatval($record->regular_hours ?? 0);
        $record->update(['status' => 'denied', 'ot_status' => $record->ot_hours > 0 ? 'denied' : $record->ot_status,
            'denial_reason' => $validated['reason'], 'approved_by' => $reviewer->id, 'approved_at' => now()]);
    }
    if ($totalRegular > 0) {
        $sh = \App\Models\StudentHours::where('student_id', $studentId)->firstOrCreate(['student_id' => $studentId], ['total_hours_required' => 600]);
        $sh->update(['hours_completed' => round(max(0, $sh->hours_completed + $totalRegular), 2),
            'hours_remaining' => round(max(0, $sh->total_hours_required - $sh->hours_completed - $totalRegular), 2)]);
    }
    \App\Models\DailyHourLog::where('student_id', $studentId)->where('status', 'pending')->update(['status' => 'denied']);
    // Send email notification
    $student = User::findOrFail($studentId);
    $reason = $validated['reason'];
    register_shutdown_function(function() use ($student, $reason) {
        try { \App\Helpers\MailHelper::sendTimeInDenied($student->email, $student->name, now()->format('M d, Y'), $reason); } catch (\Throwable) {}
    });
    return back()->with('success', 'All pending time-in records denied. Only regular hours credited.');
});

// Bulk approve all pending requirements for a student
Route::post('/approve-all-requirements/{studentId}', function ($studentId) {
    $validated = request()->validate(['feedback' => 'required|string|max:1000']);
    $reviewer = User::findOrFail(session('user_id'));
    $pending = \App\Models\StudentRequirement::where('student_id', $studentId)->where('status', 'pending')->get();
    foreach ($pending as $req) {
        $req->update(['status' => 'approved', 'feedback' => $validated['feedback'],
            'approved_by' => $reviewer->id, 'approved_at' => now()]);
        // Credit OT if it's an OT letter
        $isOt = stripos($req->title,'OT')!==false || stripos($req->title,'overtime')!==false || stripos($req->title,'over time')!==false;
        if ($isOt) {
            $otDate = $req->created_at->toDateString();
            $otRecs = \App\Models\TimeInRecord::where('student_id',$studentId)->whereDate('date',$otDate)
                ->where('status','approved')->where('ot_status','pending')->where('ot_hours','>',0)->get();
            $totalOt = 0;
            foreach ($otRecs as $or) { $totalOt += floatval($or->ot_hours); $or->update(['ot_status'=>'approved']); }
            if ($totalOt > 0) {
                $sh = \App\Models\StudentHours::where('student_id',$studentId)->firstOrCreate(['student_id'=>$studentId],['total_hours_required'=>600]);
                $sh->update(['hours_completed'=>round(max(0,$sh->hours_completed+$totalOt),2),'hours_remaining'=>round(max(0,$sh->total_hours_required-$sh->hours_completed-$totalOt),2)]);
            }
        }
    }
    // Send email for bulk approve requirements
    $student = User::findOrFail($studentId);
    $fb = $validated['feedback'];
    register_shutdown_function(function() use ($student, $fb) {
        try { \App\Helpers\MailHelper::sendRequirementApproved($student->email, $student->name, 'All Pending Requirements', $fb); } catch (\Throwable) {}
    });
    return back()->with('success', 'All pending requirements approved!');
});

// Bulk deny all pending requirements for a student
Route::post('/deny-all-requirements/{studentId}', function ($studentId) {
    $validated = request()->validate(['feedback' => 'required|string|max:1000']);
    $reviewer = User::findOrFail(session('user_id'));
    $pending = \App\Models\StudentRequirement::where('student_id', $studentId)->where('status', 'pending')->get();
    foreach ($pending as $req) {
        if ($req->file_path) \Illuminate\Support\Facades\Storage::disk('public')->delete($req->file_path);
        $req->update(['status' => 'denied', 'feedback' => $validated['feedback'],
            'file_path' => null, 'approved_by' => $reviewer->id, 'approved_at' => now()]);
    }
    // Send email for bulk deny requirements
    $student = User::findOrFail($studentId);
    $fb = $validated['feedback'];
    register_shutdown_function(function() use ($student, $fb) {
        try { \App\Helpers\MailHelper::sendRequirementDenied($student->email, $student->name, 'All Pending Requirements', $fb); } catch (\Throwable) {}
    });
    return back()->with('success', 'All pending requirements denied!');
});

Route::post('/upload-requirement', function () {
    $validated = request()->validate([
        'student_id'  => 'required|exists:users,id',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'file'        => 'nullable',
        'file.*'      => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:5120',
    ]);

    $files = request()->file('file');
    if (empty($files)) {
        return back()->withErrors(['file' => 'Please select at least one file.']);
    }

    // Ensure storage directories exist (fixes shared hosting 500 error)
    $dirs = [
        storage_path('app/public'),
        storage_path('app/public/requirements'),
        storage_path('app/public/time-in-photos'),
        storage_path('app/public/time-out-photos'),
    ];
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) @mkdir($dir, 0755, true);
    }

    // Normalise: single file or array
    if (!is_array($files)) $files = [$files];

    // Store each file as a separate requirement entry
    foreach ($files as $index => $file) {
        $filePath = $file->store('requirements', 'public');
        $title = $validated['title'];
        if (count($files) > 1) $title .= ' (' . ($index + 1) . ')';
        \App\Models\StudentRequirement::create([
            'student_id'  => $validated['student_id'],
            'title'       => $title,
            'description' => $validated['description'] ?? null,
            'file_path'   => $filePath,
            'status'      => 'pending',
        ]);
    }

    return back()->with('success', 'Requirement submitted successfully! Waiting for approval.');
})->name('upload-requirement');

Route::post('/approve-requirement/{requirementId}', function ($requirementId) {
    $validated = request()->validate([
        'feedback' => 'required|string|max:1000',
    ]);

    $requirement = \App\Models\StudentRequirement::with('student')->findOrFail($requirementId);
    $coordinator = User::findOrFail(session('user_id'));
    
    $requirement->update([
        'status' => 'approved',
        'feedback' => $validated['feedback'],
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);

    // If this is an OT letter, credit pending OT hours for the student on the submission date
    $isOtLetter = stripos($requirement->title, 'OT') !== false
        || stripos($requirement->title, 'overtime') !== false
        || stripos($requirement->title, 'over time') !== false;

    if ($isOtLetter) {
        $otDate = $requirement->created_at->toDateString();
        // Find all approved time-in records for this student on that date with pending OT
        $otRecords = \App\Models\TimeInRecord::where('student_id', $requirement->student_id)
            ->whereDate('date', $otDate)
            ->where('status', 'approved')
            ->where('ot_status', 'pending')
            ->where('ot_hours', '>', 0)
            ->get();

        $totalOtToCredit = 0;
        foreach ($otRecords as $otRec) {
            $totalOtToCredit += floatval($otRec->ot_hours);
            $otRec->update(['ot_status' => 'approved']);
        }

        if ($totalOtToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $requirement->student_id)
                ->firstOrCreate(['student_id' => $requirement->student_id], ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0, $studentHours->hours_completed + $totalOtToCredit), 2),
                'hours_remaining' => round(max(0, $studentHours->total_hours_required - $studentHours->hours_completed - $totalOtToCredit), 2),
            ]);
            // Log the OT hours as approved
            \App\Models\DailyHourLog::create([
                'student_id'   => $requirement->student_id,
                'log_date'     => $otDate,
                'hours_logged' => $totalOtToCredit,
                'is_overtime'  => true,
                'status'       => 'approved',
            ]);
        }
    }

    // Send email after response to avoid blocking
    if ($requirement->student) {
        $email = $requirement->student->email;
        $name  = $requirement->student->name;
        $title = $requirement->title;
        $fb    = $validated['feedback'];
        register_shutdown_function(function() use ($email, $name, $title, $fb) {
            try { \App\Helpers\MailHelper::sendRequirementApproved($email, $name, $title, $fb); } catch (\Throwable) {}
        });
    }

    return back()->with('success', 'Requirement approved!');
})->name('approve-requirement');

Route::post('/save-evaluation/{studentId}', function ($studentId) {
    try {
        $data = request()->validate([
            'supervisor_id'                    => 'required|integer',
            'rating'                           => 'nullable|integer|min:0|max:5',
            'evaluation_date'                  => 'nullable|date',
            'period_from'                      => 'nullable|date',
            'period_to'                        => 'nullable|date',
            'job_title'                        => 'nullable|string|max:255',
            'quality_of_work_rating'           => 'required|string',
            'quality_of_work_comment'          => 'nullable|string|max:1000',
            'quantity_of_work_rating'          => 'required|string',
            'quantity_of_work_comment'         => 'nullable|string|max:1000',
            'job_knowledge_rating'             => 'required|string',
            'job_knowledge_comment'            => 'nullable|string|max:1000',
            'working_relationships_rating'     => 'required|string',
            'working_relationships_comment'    => 'nullable|string|max:1000',
            'attendance_dependability_rating'  => 'required|string',
            'attendance_dependability_comment' => 'nullable|string|max:1000',
            'specific_achievements_rating'     => 'required|string',
            'specific_achievements_comment'    => 'nullable|string|max:1000',
            'feedback'                         => 'nullable|string|max:2000',
            'attendance'      => 'nullable|integer|min:0|max:5',
            'communication'   => 'nullable|integer|min:0|max:5',
            'collaboration'   => 'nullable|integer|min:0|max:5',
            'problem_solving' => 'nullable|integer|min:0|max:5',
            'work_ethics'     => 'nullable|integer|min:0|max:5',
            'time_management' => 'nullable|integer|min:0|max:5',
            'job_skills'      => 'nullable|integer|min:0|max:5',
            'employability'   => 'nullable|integer|min:0|max:5',
        ]);
        $supervisorId = $data['supervisor_id'];
        unset($data['supervisor_id']);
        // Auto-derive overall rating from PRMSU factor ratings
        $ratingMap = ['outstanding'=>5,'exceeds_expectations'=>4,'meets_expectations'=>3,'needs_improvement'=>2,'unsatisfactory'=>1];
        $factors = ['quality_of_work_rating','quantity_of_work_rating','job_knowledge_rating','working_relationships_rating','attendance_dependability_rating','specific_achievements_rating'];
        $scores = array_filter(array_map(fn($f) => $ratingMap[$data[$f] ?? ''] ?? 0, $factors));
        $data['rating'] = count($scores) ? (int) round(array_sum($scores) / count($scores)) : 1;
        $eval = \App\Models\StudentEvaluation::updateOrCreate(
            ['student_id' => $studentId, 'supervisor_id' => $supervisorId],
            $data
        );
        return response()->json(['success' => true, 'rating' => $eval->rating, 'message' => 'Evaluation submitted successfully!']);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['success' => false, 'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))], 422);
    } catch (\Throwable $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
})->name('save-evaluation');

Route::post('/reject-requirement/{requirementId}', function ($requirementId) {
    $validated = request()->validate([
        'feedback' => 'required|string|max:1000',
    ]);

    $requirement = \App\Models\StudentRequirement::with('student')->findOrFail($requirementId);
    $coordinator = User::findOrFail(session('user_id'));
    
    // Delete the old file so student must upload a new one
    if ($requirement->file_path) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($requirement->file_path);
    }

    $requirement->update([
        'status' => 'denied',
        'feedback' => $validated['feedback'],
        'file_path' => null,
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);

    // Send email after response to avoid blocking
    if ($requirement->student) {
        $email = $requirement->student->email;
        $name  = $requirement->student->name;
        $title = $requirement->title;
        $fb    = $validated['feedback'];
        register_shutdown_function(function() use ($email, $name, $title, $fb) {
            try { \App\Helpers\MailHelper::sendRequirementDenied($email, $name, $title, $fb); } catch (\Throwable) {}
        });
    }

    return response()->json(['success' => true, 'message' => 'Requirement rejected!']);
})->name('reject-requirement');

Route::get('/generate-dtr-word/{studentId}', function ($studentId) {
    $student = User::findOrFail($studentId);
    $sh = \App\Models\StudentHours::where('student_id', $studentId)->first();
    $timeInRecords = \App\Models\TimeInRecord::where('student_id', $studentId)->orderBy('date','asc')->get();
    $required   = $sh->total_hours_required ?? 600;
    $actual     = $timeInRecords->whereNotNull('time_out')->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
    $totalHours = round(max($sh->hours_completed ?? 0, $actual), 2);
    $remaining  = round(max(0, $required - $totalHours), 2);
    $pct        = $required > 0 ? round(($totalHours / $required) * 100, 2) : 0;
    $company    = $student->company->name ?? 'N/A';
    $byMonth    = $timeInRecords->groupBy(fn($r) => $r->date->format('Y-m'));
    $content    = view('reports.dtr_word', compact('student','company','byMonth','totalHours','required','remaining','pct'))->render();
    return response($content)
        ->header('Content-Type', 'application/msword')
        ->header('Content-Disposition', 'attachment; filename="DTR_' . preg_replace('/[^A-Za-z0-9_]/','',$student->name) . '_' . now()->format('Y-m-d') . '.doc"');
})->name('generate-dtr-word');

Route::get('/generate-dtr/{studentId}', function ($studentId) {
    $student = User::findOrFail($studentId);
    $sh = \App\Models\StudentHours::where('student_id', $studentId)->first();
    $timeInRecords = \App\Models\TimeInRecord::where('student_id', $studentId)->orderBy('date','asc')->get();
    $required   = $sh->total_hours_required ?? 600;
    $actual     = $timeInRecords->whereNotNull('time_out')->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
    $totalHours = round(max($sh->hours_completed ?? 0, $actual), 2);
    $remaining  = round(max(0, $required - $totalHours), 2);
    $pct        = $required > 0 ? round(($totalHours / $required) * 100, 2) : 0;
    $company    = $student->company->name ?? 'N/A';
    $byMonth    = $timeInRecords->groupBy(fn($r) => $r->date->format('Y-m'));
    return view('reports.dtr', compact('student','company','byMonth','totalHours','required','remaining','pct'));
})->name('generate-dtr');
// Company Routes
Route::post('/add-company', function () {
    $validated = request()->validate([
        'name' => 'required|string|max:255|unique:companies,name',
        'industry' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'contact_email' => 'nullable|email|max:255',
        'contact_phone' => 'nullable|string|max:20',
    ]);

    \App\Models\Company::create($validated);

    return back()->with('success', 'Company added successfully!');
})->name('add-company');

Route::delete('/delete-company/{id}', function ($id) {
    \App\Models\Company::findOrFail($id)->delete();
    return back()->with('success', 'Company removed successfully!');
})->name('delete-company');

// Forgot Password
Route::post('/forgot-password', function () {
    $validated = request()->validate(['email' => 'required|email']);
    $user = User::where('email', $validated['email'])->first();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => hash('sha256', $token), 'created_at' => now()]
        );
        $resetUrl = config('app.url') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email);
        try { MailHelper::sendPasswordReset($user->email, $user->name, $resetUrl); } catch (\Throwable) {}
    }

    return back()->with('success', 'If an account with that email exists, a password reset link has been sent.');
})->name('forgot-password')->middleware('guest');

// Reset Password GET (token link from email)
Route::get('/reset-password', function () {
    $token = request('token');
    $email = request('email');
    return view('auth.reset-password', compact('token', 'email'));
})->name('reset-password.form')->middleware('guest');

// Reset Password POST
Route::post('/reset-password', function () {
    $validated = request()->validate([
        'email'                 => 'required|email',
        'token'                 => 'required',
        'password'              => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ]);

    $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
        ->where('email', $validated['email'])
        ->first();

    if (!$record || !hash_equals($record->token, hash('sha256', $validated['token']))) {
        return back()->withErrors(['token' => 'Invalid or expired reset link.']);
    }

    if (now()->diffInMinutes($record->created_at) > 60) {
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
        return back()->withErrors(['token' => 'This reset link has expired. Please request a new one.']);
    }

    $user = User::where('email', $validated['email'])->first();
    if (!$user) {
        return back()->withErrors(['email' => 'No account found with that email.']);
    }

    $user->update(['password' => Hash::make($validated['password'])]);
    \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

    return redirect()->route('login')->with('success', 'Password reset successfully! You can now log in.');
})->name('reset-password')->middleware('guest');

// Student School ID Routes
Route::get('/api/school-ids', function () {
    $sy = request('school_year');
    $query = \App\Models\StudentSchoolId::orderBy('created_at', 'desc');
    if ($sy) $query->where('school_year', $sy);
    $ids = $query->get();
    return response()->json(['school_ids' => $ids]);
});

Route::post('/api/school-ids', function () {
    $validated = request()->validate([
        'school_id_number' => 'required|string|regex:/^\d{2}-\d{1}-\d{1}-\d{4}$/|unique:student_school_ids,school_id_number',
        'school_year'      => 'nullable|string|max:20',
    ]);
    $id = \App\Models\StudentSchoolId::create([
        'school_id_number' => $validated['school_id_number'],
        'school_year'      => $validated['school_year'] ?? null,
    ]);
    return response()->json(['success' => true, 'school_id' => $id]);
});

Route::delete('/api/school-ids/{id}', function ($id) {
    \App\Models\StudentSchoolId::findOrFail($id)->delete();
    return response()->json(['success' => true]);
});

Route::put('/api/school-ids/{id}', function ($id) {
    $sid = \App\Models\StudentSchoolId::findOrFail($id);
    $validated = request()->validate([
        'school_id_number' => 'required|string|regex:/^\d{2}-\d{1}-\d{1}-\d{4}$/|unique:student_school_ids,school_id_number,' . $id,
        'school_year'      => 'nullable|string|max:20',
    ]);
    $sid->update($validated);
    return response()->json(['success' => true, 'school_id' => $sid]);
});

Route::get('/api/companies', function () {
    $companies = \App\Models\Company::all();
    return response()->json(['companies' => $companies]);
});

// School Year Routes
Route::get('/api/school-years', function () {
    $years = \App\Models\SchoolYear::orderBy('label', 'desc')->get();
    return response()->json(['school_years' => $years]);
});

Route::post('/api/school-years', function () {
    $validated = request()->validate([
        'label' => 'required|string|regex:/^\d{4}-\d{4}$/|unique:school_years,label',
    ]);
    $sy = \App\Models\SchoolYear::create(['label' => $validated['label'], 'is_active' => false]);
    return response()->json(['success' => true, 'school_year' => $sy]);
});

Route::delete('/api/school-years/{id}', function ($id) {
    \App\Models\SchoolYear::findOrFail($id)->delete();
    return response()->json(['success' => true]);
});

Route::post('/api/school-years/{id}/activate', function ($id) {
    \App\Models\SchoolYear::query()->update(['is_active' => false]);
    \App\Models\SchoolYear::findOrFail($id)->update(['is_active' => true]);
    return response()->json(['success' => true]);
});

// save global settings (required hours and email notification flag)
Route::post('/api/settings', function () {
    \Illuminate\Support\Facades\Log::info('settings POST hit', request()->all());
    // manual validation so we can return JSON on failure
    $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
        'required_hours' => 'required|integer|min:0',
        // will manually cast checkbox value later
        'email_notifications' => 'nullable',
    ]);

    if ($validator->fails()) {
        \Illuminate\Support\Facades\Log::warning('settings validation failed', $validator->errors()->toArray());
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    $validated = $validator->validated();
    \Illuminate\Support\Facades\Log::info('settings validated', $validated);

    // update student hours requirement for all students
    \App\Models\StudentHours::query()->update(['total_hours_required' => $validated['required_hours']]);
    // ensure rows exist for any student missing an entry
    $studentIds = User::where('role', 'student')->pluck('id');
    foreach ($studentIds as $sid) {
        \App\Models\StudentHours::firstOrCreate(
            ['student_id' => $sid],
            ['hours_completed' => 0, 'total_hours_required' => $validated['required_hours']]
        );
    }

    // cache email notification flag for future use
    $notify = isset($validated['email_notifications']) ? boolval($validated['email_notifications']) : false;
    \Illuminate\Support\Facades\Log::info('settings email flag', ['raw' => request()->input('email_notifications'), 'cast' => $notify]);
    cache(['settings.email_notifications' => $notify]);

    return response()->json(['success' => true]);
});

// retrieve current settings
Route::get('/api/settings', function () {
    $required = \App\Models\StudentHours::query()->value('total_hours_required') ?? 600;
    $email = cache('settings.email_notifications', true);
    return response()->json(['required_hours' => $required, 'email_notifications' => $email]);
});

Route::get('/api/dashboard-stats', function () {
    $sy = request('school_year');
    $query = User::where('role', 'student');
    if ($sy) $query->where('school_year', $sy);
    $totalStudents = $query->count();
    $totalUsers = User::count();
    $activePrograms = (clone $query)->whereNotNull('company_id')->distinct('company_id')->count();

    $required = \App\Models\StudentHours::query()->value('total_hours_required') ?? 600;
    $students = (clone $query)->pluck('id');
    $completedCount = 0;
    $inProgressCount = 0;
    $totalProgress = 0;
    foreach ($students as $sid) {
        $sh = \App\Models\StudentHours::where('student_id', $sid)->first();
        $actual = \App\Models\TimeInRecord::where('student_id', $sid)
            ->whereNotNull('time_out')
            ->get()
            ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
        $hours = max($sh->hours_completed ?? 0, $actual);
        $req = $sh->total_hours_required ?? 600;
        $pct = $req > 0 ? ($hours / $req) * 100 : 0;
        $totalProgress += $pct;
        if ($hours >= $req) $completedCount++;
        elseif ($hours > 0) $inProgressCount++;
    }
    $completionRate = $totalStudents > 0 ? round($totalProgress / $totalStudents) : 0;

    // Users by role
    $usersByRole = [
        'student'     => User::where('role', 'student')->when($sy, fn($q) => $q->where('school_year', $sy))->count(),
        'supervisor'  => User::where('role', 'supervisor')->count(),
        'coordinator' => User::where('role', 'coordinator')->count(),
        'ccit_head'   => User::where('role', 'ccit_head')->count(),
    ];

    // Student registration trend — last 6 months
    $trend = [];
    for ($i = 5; $i >= 0; $i--) {
        $month = \Carbon\Carbon::now()->subMonths($i);
        $count = User::where('role', 'student')
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->when($sy, fn($q) => $q->where('school_year', $sy))
            ->count();
        $trend[] = $count;
    }

    return response()->json([
        'total_users'     => $totalUsers,
        'total_students'  => $totalStudents,
        'active_programs' => $activePrograms,
        'completion_rate' => $completionRate . '%',
        'completed_count' => $completedCount,
        'in_progress_count' => $inProgressCount,
        'users_by_role'   => $usersByRole,
        'student_trend'   => $trend,
    ]);
});

Route::get('/api/users', function () {
    $sy = request('school_year');
    $query = User::query();
    if ($sy) {
        $query->where(function($q) use ($sy) {
            // students: must match school year
            $q->where(function($sq) use ($sy) {
                $sq->where('role', 'student')->where('school_year', $sy);
            })
            // non-students: match school year OR have no school year (system-level users)
            ->orWhere(function($sq) use ($sy) {
                $sq->whereNotIn('role', ['student'])
                   ->where(function($inner) use ($sy) {
                       $inner->where('school_year', $sy)->orWhereNull('school_year');
                   });
            });
        });
    }
    $users = $query->get();
    $usersData = $users->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'school_year' => $user->school_year,
            'school_id_number' => $user->school_id_number,
            'company' => $user->company ? $user->company->name : null,
            'company_id' => $user->company_id,
            'is_approved' => $user->is_approved,
        ];
    });
    return response()->json(['users' => $usersData]);
});

// return single user for editing
Route::get('/api/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'school_year' => $user->school_year,
        'company_id' => $user->company_id,
    ]);
});

// create user (used by ccit head form)
Route::post('/api/users', function () {
    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => ['required','min:8','max:128','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        'role' => 'required|in:student,supervisor,coordinator,ccit_head',
        'company_id' => 'nullable|exists:companies,id',
        'school_year' => 'nullable|string|max:20',
        'school_id_number' => 'nullable|string|max:50',
    ]);

    // Company required for student/supervisor
    if (in_array($validated['role'], ['student','supervisor']) && !$validated['company_id']) {
        return response()->json(['success' => false, 'message' => 'Company is required for students and supervisors'], 422);
    }

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
        'company_id' => $validated['company_id'],
        'school_year' => $validated['school_year'] ?? null,
        'school_id_number' => $validated['school_id_number'] ?? null,
    ]);

    // Mark school ID as used when adding a student
    if ($validated['role'] === 'student' && !empty($validated['school_id_number'])) {
        \App\Models\StudentSchoolId::where('school_id_number', $validated['school_id_number'])
            ->update(['is_used' => true]);
    }

    return response()->json(['success' => true, 'user' => $user]);
});

// update existing user
Route::put('/api/users/{id}', function ($id) {
    $user = User::findOrFail($id);

    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => ['nullable','min:8','max:128','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        'role' => 'required|in:student,supervisor,coordinator,ccit_head',
        'company_id' => 'nullable|exists:companies,id',
        'school_year' => 'nullable|string|max:20',
        'school_id_number' => 'nullable|string|max:50',
    ]);

    if (in_array($validated['role'], ['student','supervisor']) && !$validated['company_id']) {
        return response()->json(['success' => false, 'message' => 'Company is required for students and supervisors'], 422);
    }

    $oldSchoolId = $user->school_id_number;

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role = $validated['role'];
    $user->company_id = $validated['company_id'];
    $user->school_year = $validated['school_year'] ?? null;
    $user->school_id_number = $validated['school_id_number'] ?? null;
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }
    $user->save();

    // Sync school ID used status when editing a student
    if ($validated['role'] === 'student') {
        $newSchoolId = $validated['school_id_number'] ?? null;
        if ($oldSchoolId && $oldSchoolId !== $newSchoolId) {
            \App\Models\StudentSchoolId::where('school_id_number', $oldSchoolId)->update(['is_used' => false]);
        }
        if ($newSchoolId && $newSchoolId !== $oldSchoolId) {
            \App\Models\StudentSchoolId::where('school_id_number', $newSchoolId)->update(['is_used' => true]);
        }
    }

    return response()->json(['success' => true, 'user' => $user]);
});

Route::get('/api/analytics', function () {
    $sy = request('school_year');
    $query = User::where('role', 'student');
    if ($sy) $query->where('school_year', $sy);
    $students = $query->get();
    $required = \App\Models\StudentHours::query()->value('total_hours_required') ?? 600;

    $analytics = $students->map(function ($student) use ($required) {
        $sh = \App\Models\StudentHours::where('student_id', $student->id)->first();
        $actual = \App\Models\TimeInRecord::where('student_id', $student->id)
            ->whereNotNull('time_out')
            ->get()
            ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
        $completed = round(max($sh->hours_completed ?? 0, $actual), 4);
        return [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'school_year' => $student->school_year,
            'hours_completed' => $completed,
            'hours_required' => $required,
            'status' => $completed >= $required ? 'Completed' : 'In Progress',
        ];
    });

    return response()->json([
        'students' => $students,
        'analytics' => $analytics,
    ]);
});

Route::delete('/api/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    // Free the school ID back to available if student had one
    if ($user->role === 'student' && $user->school_id_number) {
        \App\Models\StudentSchoolId::where('school_id_number', $user->school_id_number)
            ->update(['is_used' => false]);
    }
    $user->delete();
    return response()->json(['success' => true, 'message' => 'User removed successfully']);
});

Route::post('/api/users/{id}/approve', function ($id) {
    $user = User::findOrFail($id);
    $user->update(['is_approved' => true]);
    try { MailHelper::sendApproved($user->email, $user->name); } catch (\Throwable) {}
    return response()->json(['success' => true]);
});

Route::delete('/api/users/{id}/deny', function ($id) {
    $user = User::findOrFail($id);
    try { MailHelper::sendDenied($user->email, $user->name); } catch (\Throwable) {}
    $user->delete();
    return response()->json(['success' => true]);
});

Route::get('/api/reports/system', function () {
    $required          = \App\Models\StudentHours::query()->value('total_hours_required') ?? 600;
    $totalUsers        = User::count();
    $totalStudents     = User::where('role','student')->count();
    $totalSupervisors  = User::where('role','supervisor')->count();
    $totalCoordinators = User::where('role','coordinator')->count();
    $completedCount    = 0;
    $totalProgress     = 0;
    $studentRows       = [];
    foreach (User::where('role','student')->get() as $s) {
        $sh     = \App\Models\StudentHours::where('student_id',$s->id)->first();
        $actual = \App\Models\TimeInRecord::where('student_id',$s->id)->whereNotNull('time_out')->get()
                    ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out))/60);
        $hours  = round(max($sh->hours_completed ?? 0, $actual), 4);
        $rem    = round(max(0, $required - $hours), 4);
        $pct    = $required > 0 ? round(($hours/$required)*100,2) : 0;
        $totalProgress += $pct;
        if ($hours >= $required) $completedCount++;
        $studentRows[] = ['name'=>$s->name,'email'=>$s->email,'company'=>$s->company->name??'N/A','hours_completed'=>$hours,'required'=>$required,'remaining'=>$rem,'pct'=>$pct,'status'=>$hours>=$required?'Completed':'In Progress'];
    }
    $completionRate = $totalStudents > 0 ? round($totalProgress/$totalStudents) : 0;
    $students = $studentRows;
    $content = view('reports.system', compact('totalUsers','totalStudents','totalSupervisors','totalCoordinators','required','completedCount','completionRate','students'))->render();
    return response($content)
        ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="System_Report_' . now()->format('Y-m-d') . '.xls"');
});

Route::get('/api/reports/students', function () {
    $required = \App\Models\StudentHours::query()->value('total_hours_required') ?? 600;
    $students = [];
    foreach (User::where('role','student')->get() as $s) {
        $sh     = \App\Models\StudentHours::where('student_id',$s->id)->first();
        $actual = \App\Models\TimeInRecord::where('student_id',$s->id)->whereNotNull('time_out')->get()
                    ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out))/60);
        $hours  = round(max($sh->hours_completed ?? 0, $actual), 4);
        $rem    = round(max(0, $required - $hours), 4);
        $pct    = $required > 0 ? round(($hours/$required)*100,2) : 0;
        $students[] = ['name'=>$s->name,'email'=>$s->email,'company'=>$s->company->name??'N/A','hours_completed'=>$hours,'required'=>$required,'remaining'=>$rem,'pct'=>$pct,'status'=>$hours>=$required?'Completed':'In Progress'];
    }
    $totalUsers=$totalSupervisors=$totalCoordinators=$completedCount=$completionRate=0;
    $totalStudents=count($students);
    $content = view('reports.system', compact('totalUsers','totalStudents','totalSupervisors','totalCoordinators','required','completedCount','completionRate','students'))->render();
    return response($content)
        ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="Student_Progress_Report_' . now()->format('Y-m-d') . '.xls"');
});

Route::get('/api/reports/attendance-data', function () {
    $rows = [];
    foreach (\App\Models\TimeInRecord::with('student')->orderBy('date','desc')->get() as $rec) {
        if (!$rec->student) continue;
        $hrs = $rec->time_out ? round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out))/60, 2) : 0;
        $rows[] = [
            'student_name' => $rec->student->name,
            'date'         => $rec->date->format('Y-m-d'),
            'time_in'      => $rec->time_in ?? '—',
            'time_out'     => $rec->time_out ?? '—',
            'hours'        => $hrs,
            'status'       => $rec->status ?? 'pending',
        ];
    }
    return response()->json(['records' => $rows]);
});

Route::get('/api/reports/attendance', function () {
    $rows = [];
    foreach (\App\Models\TimeInRecord::with('student')->orderBy('date','desc')->get() as $rec) {
        $hrs = $rec->time_out ? round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out))/60,4) : 0;
        $rows[] = ['date'=>$rec->date->format('Y-m-d'),'name'=>$rec->student->name,'company'=>$rec->student->company->name??'N/A','time_in'=>$rec->time_in,'time_out'=>$rec->time_out??'-','hours'=>$hrs,'status'=>$rec->status,'verified'=>$rec->verified];
    }
    $records = $rows;
    $content = view('reports.attendance', compact('records'))->render();
    return response($content)
        ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="Attendance_Report_' . now()->format('Y-m-d') . '.xls"');
});

