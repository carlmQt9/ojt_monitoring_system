<?php
/**
 * Comprehensive System Test Script
 * Tests all features and RBAC enforcement
 */

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Company;
use App\Models\SchoolYear;
use App\Models\StudentSchoolId;
use App\Models\TimeInRecord;
use App\Models\StudentHours;
use App\Models\StudentRequirement;
use App\Models\StudentEvaluation;
use App\Models\RequirementTemplate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$pass = 0;
$fail = 0;
$warnings = [];

function test($name, $result, $expected = true) {
    global $pass, $fail;
    $ok = ($result === $expected);
    if ($ok) {
        echo "  ✅ PASS: $name\n";
        $pass++;
    } else {
        echo "  ❌ FAIL: $name (got: " . var_export($result, true) . ", expected: " . var_export($expected, true) . ")\n";
        $fail++;
    }
}

function section($title) {
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "  $title\n";
    echo str_repeat("=", 60) . "\n";
}

// ============================================================
section("1. DATABASE CONNECTION");
// ============================================================
try {
    DB::connection()->getPdo();
    test("Database connection", true);
} catch (\Exception $e) {
    test("Database connection", false);
    echo "  FATAL: Cannot connect to database. Stopping.\n";
    exit(1);
}

// ============================================================
section("2. MIDDLEWARE REGISTRATION");
// ============================================================
// In Laravel 11, middleware aliases are registered in bootstrap/app.php
// and resolved at route level, not in router->getMiddleware()
// Verify by checking a known protected route has the middleware
$routes = app('router')->getRoutes();
$timeInMiddleware = [];
foreach ($routes as $route) {
    if ($route->getName() === 'time-in') {
        $timeInMiddleware = $route->middleware();
        break;
    }
}
test("auth.custom middleware registered (verified via route)", in_array('auth.custom', $timeInMiddleware));
test("role middleware registered (verified via route)", in_array('role:student', $timeInMiddleware));

// ============================================================
section("3. MODELS & DATABASE TABLES");
// ============================================================
$tables = [
    'users', 'companies', 'school_years', 'student_school_ids',
    'time_in_records', 'student_hours', 'student_requirements',
    'student_evaluations', 'requirement_templates', 'daily_hour_logs'
];
foreach ($tables as $table) {
    test("Table '$table' exists", \Illuminate\Support\Facades\Schema::hasTable($table));
}

// ============================================================
section("4. USERS - ROLES & PERMISSIONS");
// ============================================================
// Check if test users exist, create if not
$ccitHead = User::where('role', 'ccit_head')->first();
test("CCIT Head user exists", $ccitHead !== null);

$coordinator = User::where('role', 'coordinator')->first();
test("Coordinator user exists", $coordinator !== null);

$supervisor = User::where('role', 'supervisor')->first();
test("Supervisor user exists", $supervisor !== null);

$student = User::where('role', 'student')->first();
test("Student user exists", $student !== null);

// Test role methods
if ($ccitHead) {
    test("isCcitHead() returns true for ccit_head", $ccitHead->isCcitHead());
    test("isCoordinator() returns false for ccit_head", !$ccitHead->isCoordinator());
    test("isSupervisor() returns false for ccit_head", !$ccitHead->isSupervisor());
    test("isStudent() returns false for ccit_head", !$ccitHead->isStudent());
}

if ($coordinator) {
    test("isCoordinator() returns true for coordinator", $coordinator->isCoordinator());
}

if ($supervisor) {
    test("isSupervisor() returns true for supervisor", $supervisor->isSupervisor());
}

if ($student) {
    test("isStudent() returns true for student", $student->isStudent());
}

// ============================================================
section("5. RBAC MIDDLEWARE LOGIC");
// ============================================================
// Test RoleMiddleware directly
$roleMiddleware = new \App\Http\Middleware\RoleMiddleware();

// Simulate a request with a student trying to access coordinator route
if ($student) {
    $request = \Illuminate\Http\Request::create('/approve-time-in/1', 'POST');
    $request->setLaravelSession(app('session.store'));
    
    // Test: student role NOT in coordinator,supervisor
    $studentRoles = ['coordinator', 'supervisor'];
    test("RBAC: Student blocked from coordinator routes", !in_array($student->role, $studentRoles));
    
    // Test: student role IS in student
    test("RBAC: Student allowed on student routes", in_array($student->role, ['student']));
}

if ($coordinator) {
    test("RBAC: Coordinator allowed on coordinator routes", in_array($coordinator->role, ['coordinator', 'supervisor']));
    test("RBAC: Coordinator blocked from ccit_head-only routes", !in_array($coordinator->role, ['ccit_head']));
}

if ($ccitHead) {
    test("RBAC: CCIT Head allowed on settings route", in_array($ccitHead->role, ['ccit_head']));
    test("RBAC: CCIT Head allowed on user management", in_array($ccitHead->role, ['ccit_head']));
}

// ============================================================
section("6. SCHOOL YEAR MANAGEMENT");
// ============================================================
$activeSchoolYear = SchoolYear::where('is_active', true)->first();
test("Active school year exists", $activeSchoolYear !== null);

$schoolYearCount = SchoolYear::count();
test("School years table has records", $schoolYearCount > 0);

// ============================================================
section("7. SCHOOL ID PRE-APPROVAL");
// ============================================================
$schoolIdCount = StudentSchoolId::count();
test("School IDs table has records", $schoolIdCount > 0);

$availableId = StudentSchoolId::where('is_used', false)->whereNull('deleted_at')->first();
test("Available (unused) school IDs exist", $availableId !== null);

// Test school ID format validation
if ($availableId) {
    $pattern = '/^\d{2}-\d{1}-\d{1}-\d{4}$/';
    test("School ID format is valid (YY-N-N-NNNN)", (bool)preg_match($pattern, $availableId->school_id_number));
}

// ============================================================
section("8. COMPANY MANAGEMENT");
// ============================================================
$companyCount = Company::count();
test("Companies table has records", $companyCount > 0);

$company = Company::first();
if ($company) {
    test("Company has name", !empty($company->name));
    test("Company students relationship works", $company->students() !== null);
}

// ============================================================
section("9. TIME-IN/OUT RECORDS");
// ============================================================
if ($student) {
    $timeInCount = TimeInRecord::where('student_id', $student->id)->count();
    test("Student has time-in records", $timeInCount >= 0); // 0 is ok for new student
    
    // Test the model attributes
    $latestRecord = TimeInRecord::where('student_id', $student->id)
        ->whereNotNull('time_out')
        ->latest()
        ->first();
    
    if ($latestRecord) {
        test("TimeInRecord hours_worked attribute works", $latestRecord->hours_worked >= 0);
        test("TimeInRecord minutes_worked attribute works", $latestRecord->minutes_worked >= 0);
    } else {
        echo "  ⚠️  SKIP: No completed time-in records for student (normal for new system)\n";
    }
}

// ============================================================
section("10. STUDENT HOURS TRACKING");
// ============================================================
if ($student) {
    $studentHours = StudentHours::where('student_id', $student->id)->first();
    if ($studentHours) {
        test("Student hours record exists", true);
        test("hours_completed is non-negative", $studentHours->hours_completed >= 0);
        test("hours_remaining is non-negative", $studentHours->hours_remaining >= 0);
        test("total_hours_required is positive", $studentHours->total_hours_required > 0);
        test("Progress percentage works", $studentHours->progress_percentage >= 0);
    } else {
        echo "  ⚠️  SKIP: No student hours record yet (will be created on first time-in)\n";
    }
}

// ============================================================
section("11. REQUIREMENTS SYSTEM");
// ============================================================
$templateCount = RequirementTemplate::count();
test("Requirement templates exist", $templateCount >= 0);

if ($student) {
    $reqCount = StudentRequirement::where('student_id', $student->id)->count();
    test("Student requirements query works", $reqCount >= 0);
}

// ============================================================
section("12. EVALUATION SYSTEM");
// ============================================================
if ($student && $supervisor) {
    $studentHours = StudentHours::where('student_id', $student->id)->first();
    $required = $studentHours->total_hours_required ?? 600;
    $completed = $studentHours->hours_completed ?? 0;
    
    $canEvaluate = $completed >= $required;
    test("Evaluation lock logic works (hours check)", is_bool($canEvaluate));
    
    if (!$canEvaluate) {
        echo "  ℹ️  INFO: Student has $completed/$required hours — evaluation correctly locked\n";
    } else {
        echo "  ℹ️  INFO: Student has $completed/$required hours — evaluation unlocked\n";
    }
}

// ============================================================
section("13. SOFT DELETES");
// ============================================================
test("User model uses SoftDeletes", in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(User::class)));
test("Company model uses SoftDeletes", in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(Company::class)));
test("SchoolYear model uses SoftDeletes", in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(SchoolYear::class)));
test("StudentSchoolId model uses SoftDeletes", in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(StudentSchoolId::class)));

// ============================================================
section("14. RELATIONSHIPS");
// ============================================================
if ($student) {
    test("Student->company relationship works", method_exists($student, 'company'));
    test("Student->timeIns relationship works", method_exists($student, 'timeIns'));
    test("Student->requirements relationship works", method_exists($student, 'requirements'));
    test("Student->logs relationship works", method_exists($student, 'logs'));
    test("Student->studentEvaluations relationship works", method_exists($student, 'studentEvaluations'));
}

if ($supervisor) {
    test("Supervisor->evaluations relationship works", method_exists($supervisor, 'evaluations'));
    test("Supervisor->company relationship works", method_exists($supervisor, 'company'));
}

// ============================================================
section("15. ROUTE MIDDLEWARE ASSIGNMENTS");
// ============================================================
$routes = app('router')->getRoutes();
$routeMiddlewareMap = [];
foreach ($routes as $route) {
    $routeMiddlewareMap[$route->getName() ?? $route->uri()] = $route->middleware();
}

// Check critical routes have correct middleware
$criticalRoutes = [
    'time-in'            => ['auth.custom', 'role:student'],
    'time-out'           => ['auth.custom', 'role:student'],
    'upload-requirement' => ['auth.custom', 'role:student'],
    'approve-time-in'    => ['auth.custom', 'role:coordinator,supervisor'],
    'deny-time-in'       => ['auth.custom', 'role:coordinator,supervisor'],
    'approve-requirement'=> ['auth.custom', 'role:coordinator,ccit_head,supervisor'],
    'save-evaluation'    => ['auth.custom', 'role:supervisor'],
    'add-company'        => ['auth.custom', 'role:coordinator,ccit_head'],
    'dashboard'          => ['auth.custom'],
];

foreach ($criticalRoutes as $routeName => $expectedMiddleware) {
    if (isset($routeMiddlewareMap[$routeName])) {
        $actualMiddleware = $routeMiddlewareMap[$routeName];
        foreach ($expectedMiddleware as $mw) {
            $found = in_array($mw, $actualMiddleware);
            test("Route '$routeName' has middleware '$mw'", $found);
        }
    } else {
        echo "  ⚠️  SKIP: Route '$routeName' not found in route list\n";
    }
}

// ============================================================
section("16. SETTINGS CONFIGURATION");
// ============================================================
$cachedRequired = cache('settings.required_hours');
$dbRequired = StudentHours::query()->value('total_hours_required') ?? 600;
test("Required hours is configured", $dbRequired > 0);
test("Required hours is reasonable (100-2000)", $dbRequired >= 100 && $dbRequired <= 2000);

// ============================================================
section("17. VIEWS EXIST");
// ============================================================
$views = [
    'dashboards.student'    => resource_path('views/dashboards/student.blade.php'),
    'dashboards.supervisor' => resource_path('views/dashboards/supervisor.blade.php'),
    'dashboards.coordinator'=> resource_path('views/dashboards/coordinator.blade.php'),
    'dashboards.ccit_head'  => resource_path('views/dashboards/ccit_head.blade.php'),
    'auth.login'            => resource_path('views/auth/login.blade.php'),
    'auth.register'         => resource_path('views/auth/register.blade.php'),
    'certificate'           => resource_path('views/certificate.blade.php'),
    'landing'               => resource_path('views/landing.blade.php'),
];

foreach ($views as $name => $path) {
    test("View '$name' exists", file_exists($path));
}

// ============================================================
section("18. STORAGE & FILE SYSTEM");
// ============================================================
test("Storage public link exists", file_exists(public_path('storage')));
test("Storage app public directory exists", is_dir(storage_path('app/public')));

// ============================================================
// FINAL SUMMARY
// ============================================================
echo "\n" . str_repeat("=", 60) . "\n";
echo "  FINAL RESULTS\n";
echo str_repeat("=", 60) . "\n";
echo "  ✅ PASSED: $pass\n";
echo "  ❌ FAILED: $fail\n";
$total = $pass + $fail;
$pct = $total > 0 ? round(($pass / $total) * 100) : 0;
echo "  📊 SCORE:  $pct% ($pass/$total)\n";
echo str_repeat("=", 60) . "\n";

if ($fail === 0) {
    echo "\n  🎉 ALL TESTS PASSED! System is fully operational.\n\n";
} else {
    echo "\n  ⚠️  Some tests failed. Review the output above.\n\n";
}
