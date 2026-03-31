<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Supervisor Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        /* ===== SIDEBAR ===== */
        #sidebar {
            width: 256px;
            transition: transform 0.3s ease, width 0.3s ease;
            transform: translateX(-100%);
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0); }
            #sidebar.collapsed { width: 64px; }
            #sidebar.collapsed .nav-label,
            #sidebar.collapsed .sidebar-brand-text,
            #sidebar.collapsed .sidebar-user { display: none; }
            #sidebar.collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
            #sidebar.collapsed .nav-icon { margin: 0; }
            #main-content { margin-left: 256px; transition: margin-left 0.3s ease; }
            #main-content.sidebar-collapsed { margin-left: 64px; }
        }
        @media (max-width: 1023px) {
            #main-content { margin-left: 0 !important; }
        }
        #sidebar-backdrop { display: none; }
        #sidebar-backdrop.show { display: block; }
        .nav-item.active {
            background: rgba(109,40,217,0.28);
            border-left: 3px solid #7c3aed;
            color: #a78bfa;
        }
        .nav-item:not(.active):hover {
            background: rgba(255,255,255,0.05);
            color: #ede9fe;
        }
        .dash-section { animation: fadeSection 0.25s ease; }
        @keyframes fadeSection { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        /* light mode sidebar */
        body.light #sidebar,
        body.light #sidebar [class*="bg-slate"],
        body.light #sidebar [class*="bg-gray"] { background: #1e3a5f !important; border-color: #2d5a8e !important; }
        body.light #sidebar .nav-label,
        body.light #sidebar .nav-icon,
        body.light #sidebar .sidebar-brand-text p,
        body.light #sidebar .sidebar-user p,
        body.light #sidebar nav button,
        body.light #sidebar nav button span,
        body.light #sidebar > div p,
        body.light #sidebar > div span { color: #e2eaf5 !important; }
        body.light #sidebar .nav-item.active { background: rgba(109,40,217,0.25) !important; }
        body.light #sidebar .nav-item.active .nav-label,
        body.light #sidebar .nav-item.active .nav-icon { color: #c4b5fd !important; }
        body.light #sidebar .nav-item:not(.active):hover { background: rgba(255,255,255,0.08) !important; }
        body.light #top-header { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light #top-header span, body.light #top-header p, body.light #top-header button { color: #1a2a4a !important; }
        /* ===== END SIDEBAR ===== */
        @keyframes progressFill {
            from {
                width: 0;
            }
            to {
                width: var(--progress-width);
            }
        }

        .progress-bar {
            animation: progressFill 1.5s ease-out forwards;
        }

        .student-card {
            transition: all 0.3s ease;
        }

        .student-details {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease, padding 0.4s ease;
        }

        .student-card.expanded .student-details {
            max-height: 2000px;
            opacity: 1;
            padding: 24px 0 0 0;
        }

        .expand-icon {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .student-card.expanded .expand-icon {
            transform: rotate(180deg);
        }

        .student-header-btn {
            cursor: pointer;
            user-select: none;
        }

        .star-rating {
            display: flex;
            gap: 8px;
            font-size: 24px;
        }

        .star {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .star:hover {
            transform: scale(1.2);
        }

        .modal-backdrop {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg,#dde8f5,#c8daf0,#d8eaf8) !important; color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-purple"] { color: #fff !important; }
        body.light h1,body.light h2,body.light h3,body.light h4,
        body.light p,body.light span,body.light label,body.light div,
        body.light td,body.light th,body.light li,body.light small { color: #1a2a4a; }
        body.light .text-white,body.light .text-gray-100,body.light .text-gray-200 { color: #1a2a4a !important; }
        body.light .text-gray-300 { color: #2d3f5a !important; }
        body.light .text-gray-400 { color: #3d5070 !important; }
        body.light .text-gray-500 { color: #4a6080 !important; }
        body.light .text-green-400,body.light .text-green-300 { color: #15803d !important; }
        body.light .text-blue-400,body.light .text-blue-300 { color: #1d4ed8 !important; }
        body.light .text-orange-400,body.light .text-orange-300 { color: #c2410c !important; }
        body.light .text-yellow-400,body.light .text-yellow-300 { color: #92400e !important; }
        body.light .text-red-400,body.light .text-red-300 { color: #b91c1c !important; }
        body.light .text-purple-400,body.light .text-purple-300 { color: #6d28d9 !important; }
        body.light .text-indigo-400,body.light .text-indigo-300 { color: #4338ca !important; }
        body.light .text-cyan-400 { color: #0369a1 !important; }
        body.light button[class*="bg-green-6"],body.light button[class*="bg-blue-6"],
        body.light button[class*="bg-red-6"],body.light button[class*="bg-orange-6"],
        body.light button[class*="bg-yellow-6"],body.light button[class*="bg-indigo-6"],
        body.light button[class*="bg-purple-6"],body.light a[class*="bg-green-6"],
        body.light a[class*="bg-blue-6"],body.light a[class*="bg-purple-6"] { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: #c8daf0 !important; }
        body.light [class*="bg-slate-800"] { background: #d0e4f8 !important; }
        body.light [class*="bg-slate-700"] { background: #bdd4ec !important; }
        body.light [class*="bg-slate-6"] { background: #aac4e0 !important; }
        body.light [class*="border-slate-7"] { border-color: #7aaad4 !important; }
        body.light [class*="border-slate-6"] { border-color: #8ab8dc !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.9) !important; border-color: #7aaad4 !important; color: #1a2a4a !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #5a7a9a !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: #fff !important; border-color: #7c3aed !important; border-left: 4px solid #7c3aed !important; }
        body.light .header-info-card h1 { color: #1a2a4a !important; }
        body.light .header-info-card .subtitle { color: #4a6080 !important; }
        body.light .header-info-card .stat-label { color: #4a6080 !important; }
        body.light .header-info-card .stat-value-white { color: #1a2a4a !important; }
        body.light .header-info-card .stat-value-purple { color: #6d28d9 !important; }
        body.light .header-info-card .stat-value-indigo { color: #4338ca !important; }
        body.light .header-info-card .divider { background: #cbd5e1 !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    <!-- Sidebar Backdrop (mobile) -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 z-30 lg:hidden" onclick="closeSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-40 bg-slate-900 border-r border-slate-700/60 flex flex-col overflow-hidden">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b border-slate-700/60 shrink-0">
            <div class="flex items-center gap-3 min-w-0 sidebar-brand-text">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21a12.083 12.083 0 01-6.16-10.422L12 14z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-white truncate">OJT Monitoring System</p>
                    <p class="text-xs text-gray-400 truncate">Supervisor Portal</p>
                </div>
            </div>
            <button onclick="toggleSidebarCollapse()" class="hidden lg:flex w-7 h-7 items-center justify-center rounded-md text-gray-400 hover:text-white hover:bg-slate-700 transition-colors shrink-0" title="Collapse sidebar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Supervisor Info -->
        <div class="sidebar-user px-4 py-3 border-b border-slate-700/40 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-purple-400 truncate">{{ $user->company->name ?? 'Supervisor' }}</p>
                </div>
            </div>
        </div>

        <!-- Nav Items -->
        <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-1">
            <button onclick="showSection('overview')" data-section="overview"
                class="nav-item active w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">🏠</span>
                <span class="nav-label">Overview</span>
            </button>
            <button onclick="showSection('interns')" data-section="interns"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">👥</span>
                <span class="nav-label">Interns</span>
            </button>
        </nav>

        <!-- Sidebar Footer -->
        <div class="px-2 py-3 border-t border-slate-700/60 space-y-1 shrink-0">
            <button onclick="showConfirm('logout')"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">🚪</span>
                <span class="nav-label">Logout</span>
            </button>
        </div>
    </aside>
    <!-- ===== END SIDEBAR ===== -->

    <!-- ===== TOP HEADER BAR ===== -->
    <header id="top-header" class="fixed top-0 right-0 left-0 lg:left-64 z-20 h-14 bg-slate-900/90 backdrop-blur border-b border-slate-700/50 flex items-center px-4 gap-3 transition-all duration-300">
        <button onclick="toggleSidebar()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white transition-colors lg:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span id="header-section-title" class="text-sm font-semibold text-white">Overview</span>
        <div class="ml-auto flex items-center gap-2">
            <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                class="w-8 h-8 rounded-full flex items-center justify-center transition-all"
                style="background:rgba(109,40,217,0.8);border:1px solid rgba(167,139,250,0.4)">
                <svg id="iconMoon" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg id="iconSun" class="w-4 h-4 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            </button>
        </div>
    </header>
    <!-- ===== END TOP HEADER ===== -->

    @include('partials.success-popup')
    @include('partials.pixel-loader')

    <!-- Confirm Modal -->
    <div id="confirmModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-4">
                <div id="confirmIcon" class="text-4xl mb-3">⚠️</div>
                <h3 id="confirmTitle" class="text-lg font-bold text-white mb-1">Are you sure?</h3>
                <p id="confirmMsg" class="text-gray-400 text-sm"></p>
            </div>
            <div class="flex gap-3 mt-5">
                <button onclick="closeConfirm()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <a id="confirmBtn" href="#" class="flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-purple-600 hover:bg-purple-700">Confirm</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="pt-14 lg:ml-64 min-h-screen transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @php
        $user = $user ?? auth()->user();
        $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->value('label');
    @endphp

        <!-- Header with Supervisor Info -->
        <section id="section-overview" class="dash-section">
        <div class="header-info-card mb-8 bg-gradient-to-r from-slate-800/50 to-purple-900/30 border border-slate-700 rounded-xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Supervisor Dashboard</h1>
                    <p class="subtitle text-gray-400 mb-4">Manage interns, approve submissions, and track progress</p>
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="stat-label text-sm text-gray-400">👤 Supervisor:</span>
                            <p class="stat-value-white text-lg font-semibold text-white">{{ $user->name }}</p>
                        </div>
                        <div class="divider h-8 w-px bg-slate-600"></div>
                        <div>
                            <span class="stat-label text-sm text-gray-400">🏢 Company:</span>
                            <p class="stat-value-purple text-lg font-semibold text-purple-400">{{ $user->company->name ?? 'Not Assigned' }}</p>
                        </div>
                        @if($activeSchoolYear)
                        <div class="divider h-8 w-px bg-slate-600"></div>
                        <div>
                            <span class="stat-label text-sm text-gray-400">📅 School Year:</span>
                            <p class="stat-value-indigo text-lg font-semibold text-indigo-400">{{ $activeSchoolYear }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor Stats -->
        @php
            // ensure $user exists and avoid calling ->id on null
            $user = $user ?? auth()->user();

            if (! $user) {
                $supervisorStudents = collect();
                $totalStudents = 0;
                $completedStudents = 0;
                $inProgressStudents = 0;
                $avgProgress = 0;
            } else {
                // include students either assigned to this supervisor OR registered to the supervisor's company
                $companyId = $user->company->id ?? null;
                $supervisorStudents = \App\Models\User::where('role', 'student')
                    ->where(function($q) use ($user, $companyId) {
                        $q->where('supervisor_id', $user->id);
                        if ($companyId) {
                            $q->orWhere('company_id', $companyId);
                        }
                    })
                    ->when($activeSchoolYear, fn($q) => $q->where('school_year', $activeSchoolYear))
                    ->get();

                $totalStudents = $supervisorStudents->count();
                $completedStudents = 0;
                $inProgressStudents = 0;
                $totalProgress = 0;

                foreach($supervisorStudents as $student) {
                    $studentHours = \App\Models\StudentHours::where('student_id', $student->id)->first();
                    $actualCompleted = \App\Models\TimeInRecord::where('student_id', $student->id)
                        ->whereNotNull('time_out')
                        ->get()
                        ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
                    $displayHours = max($studentHours->hours_completed ?? 0, $actualCompleted);
                    $required = $studentHours->total_hours_required ?? 600;
                    $progress = $required > 0 ? ($displayHours / $required) * 100 : 0;
                    $totalProgress += $progress;
                    if($progress >= 100) $completedStudents++;
                    elseif($progress > 0) $inProgressStudents++;
                }
                $avgProgress = $totalStudents > 0 ? round($totalProgress / $totalStudents, 1) : 0;
            }
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-purple-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">🎓 My Interns</div>
                <div class="text-3xl font-bold text-white">{{ $totalStudents }}</div>
                <p class="text-xs text-gray-500 mt-1">Under supervision</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-green-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">✅ Completed</div>
                <div class="text-3xl font-bold text-green-400">{{ $completedStudents }}</div>
                <p class="text-xs text-gray-500 mt-1">600 hrs done</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-blue-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">⏳ In Progress</div>
                <div class="text-3xl font-bold text-blue-400">{{ $inProgressStudents }}</div>
                <p class="text-xs text-gray-500 mt-1">Currently working</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-purple-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">📈 Avg Progress</div>
                <div class="text-3xl font-bold text-purple-400">{{ $avgProgress }}%</div>
                <p class="text-xs text-gray-500 mt-1">Average completion</p>
            </div>
        </div>

        @php
            /* chart data */
            $_progLabels = []; $_progData = [];
            foreach($supervisorStudents as $_s2) {
                $_sh3 = \App\Models\StudentHours::where('student_id',$_s2->id)->first();
                $_req3 = $_sh3 ? $_sh3->total_hours_required : 600;
                $_done3 = \App\Models\TimeInRecord::where('student_id',$_s2->id)->whereNotNull('time_out')->get()
                    ->sum(fn($r)=>\Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out))/60);
                $_progLabels[] = explode(' ',$_s2->name)[0]; // first name only
                $_progData[] = $_req3>0 ? round(min(($_done3/$_req3)*100,100),1) : 0;
            }
            // pending requirements per student
            $_pendingLabels = []; $_pendingData = [];
            foreach($supervisorStudents as $_s3) {
                $__reqs = \App\Models\StudentRequirement::where('student_id',$_s3->id)->where('status','pending')->count();
                if($__reqs > 0) { $_pendingLabels[] = explode(' ',$_s3->name)[0]; $_pendingData[] = $__reqs; }
            }
            // time-ins last 7 days for this company
            $_compId = $user->company->id ?? null;
            $_tiLabels = []; $_tiCounts = [];
            for($i=6;$i>=0;$i--) {
                $d=\Carbon\Carbon::now()->subDays($i);
                $_tiLabels[]=$d->format('D');
                $q=\App\Models\TimeInRecord::whereDate('date',$d->toDateString());
                if($_compId) $q->whereHas('student',fn($sq)=>$sq->where('company_id',$_compId));
                $_tiCounts[]=$q->count();
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Bar: intern progress % -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 md:col-span-2">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">📈 Intern Progress (%)</h3>
                @if(count($_progLabels))
                <canvas id="chartInternProgress" height="120"></canvas>
                @else
                <p class="text-gray-500 text-sm text-center py-6">No interns yet</p>
                @endif
            </div>
            <!-- Doughnut: completion status -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col items-center">
                <h3 class="text-sm font-semibold text-gray-400 mb-4 self-start">🎓 Completion Status</h3>
                @php $_notStarted = $totalStudents - $completedStudents - $inProgressStudents; @endphp
                @if($totalStudents > 0)
                <div class="relative w-32 h-32">
                    <canvas id="chartStatus"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ $totalStudents }}</span>
                    </div>
                </div>
                <div class="flex flex-col gap-1 mt-3 text-xs">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>{{ $completedStudents }} completed</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span>{{ $inProgressStudents }} in progress</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-500 inline-block"></span>{{ $_notStarted }} not started</span>
                </div>
                @else
                <p class="text-gray-500 text-sm mt-8">No interns yet</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bar: daily time-ins -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">⏱️ Daily Time-Ins (7 days)</h3>
                <canvas id="chartDailyTI" height="130"></canvas>
            </div>
            <!-- Bar: pending requirements -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">🔔 Pending Requirements per Intern</h3>
                @if(count($_pendingLabels))
                <canvas id="chartPending" height="130"></canvas>
                @else
                <p class="text-gray-500 text-sm text-center py-6">No pending requirements 🎉</p>
                @endif
            </div>
        </div>

        </section><!-- end overview -->

        <!-- Interns Section -->
        <section id="section-interns" class="dash-section hidden">
        <!-- Interns Progress Monitoring Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-6">👥 Interns Management & Progress Tracking</h2>
            
            @if($supervisorStudents->isEmpty())
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                <p class="text-gray-400">No interns assigned to your company. Interns will appear here once they register.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($supervisorStudents as $student)
                    <?php
                    $studentHours = \App\Models\StudentHours::where('student_id', $student->id)->firstOrCreate(
                        ['student_id' => $student->id],
                        ['total_hours_required' => 600, 'hours_completed' => 0, 'hours_remaining' => 600]
                    );
                    $actualCompleted = \App\Models\TimeInRecord::where('student_id', $student->id)
                        ->whereNotNull('time_out')
                        ->get()
                        ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
                    $studentHours->hours_completed = max($studentHours->hours_completed ?? 0, $actualCompleted);
                    $progressPercentage = ($studentHours->hours_completed / ($studentHours->total_hours_required ?? 600)) * 100;
                    $dailyLogs = \App\Models\DailyHourLog::where('student_id', $student->id)->orderBy('log_date', 'desc')->limit(7)->get();
                    $pendingTimeEdits = \App\Models\TimeInRecord::where('student_id', $student->id)->where('status', 'pending')->count();
                    $timeInRecords = \App\Models\TimeInRecord::where('student_id', $student->id)->orderBy('date', 'desc')->limit(5)->get();
                    $requirements = \App\Models\StudentRequirement::where('student_id', $student->id)->get();
                    $pendingRequirements = $requirements->where('status', 'pending')->count();
                    $evaluation = null;
                    $studentRating = 0;
                    $studentFeedback = '';
                    if (class_exists('App\\Models\\StudentEvaluation')) {
                        $evaluation = \App\Models\StudentEvaluation::where('student_id', $student->id)
                            ->where('supervisor_id', $user->id)
                            ->first();
                        if ($evaluation) {
                            $studentRating = $evaluation->rating ?? 0;
                            $studentFeedback = $evaluation->feedback ?? '';
                        }
                    }
                    $taskLogs = \App\Models\TimeInRecord::where('student_id', $student->id)
                        ->whereNotNull('photo_path')
                        ->orderBy('date', 'desc')
                        ->get();
                    $canEvaluate = $studentHours->hours_completed >= ($studentHours->total_hours_required ?? 600);
                    ?>
                    <div class="student-card bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-purple-500/50 transition-colors" data-student-id="{{ $student->id }}">
                        <!-- Clickable Student Header -->
                        <div class="student-header-btn cursor-pointer" onclick="toggleStudentExpand(this)">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-white">{{ $student->name }}</h3>
                                            <p class="text-sm text-gray-400">{{ $student->email }}</p>
                                        </div>
                                        <span class="expand-icon text-purple-400 text-xl">▼</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsed Summary -->
                        <div class="mt-4 pt-4 border-t border-slate-700">
                            <?php
                                $totalReq = $studentHours->total_hours_required ?? 600;
                                $completedRaw = $studentHours->hours_completed ?? 0;
                                $completedAbs = abs($completedRaw);
                                $displayCompleted = ($completedRaw < 0 ? '-' : '') . number_format($completedAbs, 2);
                                $displayRemaining = number_format(max(0, $totalReq - $completedAbs), 2);
                                $displayPercentSigned = number_format(($completedRaw / $totalReq) * 100, 2);
                                $progressWidth = max(0, min(abs(($completedRaw / $totalReq) * 100), 100));
                            ?>
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                <div class="bg-slate-700/30 rounded-lg p-2.5">
                                    <p class="text-gray-400 text-xs mb-1">✅ Completed</p>
                                    <p class="text-base font-bold text-green-400">{{ $displayCompleted }}</p>
                                </div>
                                <div class="bg-slate-700/30 rounded-lg p-2.5">
                                    <p class="text-gray-400 text-xs mb-1">⏳ Remaining</p>
                                    <p class="text-base font-bold text-blue-400">{{ $displayRemaining }}</p>
                                </div>
                                <div class="bg-slate-700/30 rounded-lg p-2.5">
                                    <p class="text-gray-400 text-xs mb-1">📈 Progress</p>
                                    <p class="text-base font-bold text-purple-400">{{ $displayPercentSigned }}%</p>
                                </div>
                                <div class="bg-slate-700/30 rounded-lg p-2.5">
                                    <p class="text-gray-400 text-xs mb-1">🔔 Pending</p>
                                    <p class="text-base font-bold text-yellow-400">{{ $pendingTimeEdits + $pendingRequirements }}</p>
                                </div>
                                <div class="bg-slate-700/30 rounded-lg p-2.5 col-span-2 sm:col-span-1">
                                    <p class="text-gray-400 text-xs mb-1">⭐ Rating</p>
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-lg @if($i <= $studentRating) text-yellow-400 @else text-gray-600 @endif">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="w-full bg-slate-700/50 rounded-full h-3 overflow-hidden border border-slate-600">
                                    <div class="progress-bar h-full rounded-full transition-all duration-1000 bg-gradient-to-r from-purple-500 to-blue-500" 
                                         style="--progress-width: {{ $progressWidth }}%; width: {{ $progressWidth }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expandable Details Section -->
                        <div class="student-details">
                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2 mb-6">
                                <button onclick="showTimeEditsModal({{ $student->id }}, '{{ $student->name }}')" class="px-3 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded text-sm transition-colors text-center">
                                    ⏱️ Time Edits ({{ $pendingTimeEdits }})
                                </button>
                                <button onclick="showTaskLogsModal({{ $student->id }}, '{{ $student->name }}')" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm transition-colors text-center">
                                    📸 Task Logs
                                </button>
                                <button onclick="showRequirementsModal({{ $student->id }}, '{{ $student->name }}')" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm transition-colors text-center">
                                    📋 Requirements ({{ count($requirements) }})
                                </button>
                                @if($canEvaluate)
                                    @if($evaluation)
                                    <button onclick="showEvaluationModal({{ $student->id }}, '{{ $student->name }}', true)" class="px-3 py-2 bg-green-700 hover:bg-green-800 text-white rounded text-sm transition-colors text-center">
                                        ✅ Already Evaluated
                                    </button>
                                    @else
                                    <button onclick="showEvaluationModal({{ $student->id }}, '{{ $student->name }}')" class="px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded text-sm transition-colors text-center">
                                        ⭐ Evaluate Student
                                    </button>
                                    @endif
                                @else
                                <button disabled title="Student must complete {{ $studentHours->total_hours_required ?? 600 }} hours before evaluation" class="px-3 py-2 bg-slate-600 text-slate-400 rounded text-sm cursor-not-allowed opacity-60 text-center">
                                    ⭐ Evaluate Student
                                </button>
                                @endif                                <button onclick="openSupDtrModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="col-span-2 sm:col-span-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition-colors text-center">
                                    📄 Final DTR Report
                                </button>
                            </div>

                            <!-- Tabs -->
                            <div class="border-b border-slate-600 mb-4">
                                <div class="grid grid-cols-3 sm:flex sm:space-x-4">
                                    <button class="tab-button px-3 py-2 border-b-2 border-purple-500 text-purple-400 font-semibold text-xs sm:text-sm text-center" data-tab="daily-logs-{{ $student->id }}">Daily Logs</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm text-center" data-tab="time-records-{{ $student->id }}">Time Edits</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm text-center" data-tab="task-logs-{{ $student->id }}">Task Logs</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm text-center" data-tab="requirements-{{ $student->id }}">Requirements</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm text-center col-span-2 sm:col-span-1" data-tab="evaluation-{{ $student->id }}">Evaluation</button>
                                </div>
                            </div>

                            <!-- Daily Logs Tab -->
                            <div id="daily-logs-{{ $student->id }}" class="tab-content">
                                @if($dailyLogs->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($dailyLogs as $log)
                                    <div class="bg-slate-700/30 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-gray-200 font-semibold">{{ $log->log_date->format('M d, Y') }}</p>
                                                <p class="text-gray-400 text-sm">{{ $log->description ?? 'No description' }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full @if($log->status === 'approved') bg-green-500/20 text-green-300 @elseif($log->status === 'denied') bg-red-500/20 text-red-300 @else bg-yellow-500/20 text-yellow-300 @endif">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            @php $supHours = number_format($log->hours_logged, 2); @endphp
                                            <span class="text-purple-400 font-semibold">
                                                @if($log->hours_logged > 0)
                                                    +{{ $supHours }} hours
                                                @elseif($log->hours_logged < 0)
                                                    {{ $supHours }} hours
                                                @else
                                                    0.00 hours
                                                @endif
                                            </span>
                                            @if($log->is_overtime)
                                            <span class="px-2 py-1 bg-red-500/20 text-red-300 text-xs rounded">Overtime</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No daily logs yet</p>
                                @endif
                            </div>

                            <!-- Time Edits Tab -->
                            <div id="time-records-{{ $student->id }}" class="tab-content hidden">
                                @if($timeInRecords->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($timeInRecords as $record)
                                    <div class="bg-slate-700/30 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-gray-200 font-semibold">{{ $record->date->format('M d, Y') }}</p>
                                                <p class="text-gray-400 text-sm">{{ $record->time_in }} @if($record->time_out) - {{ $record->time_out }} @endif</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full @if($record->status === 'approved') bg-green-500/20 text-green-300 @elseif($record->status === 'denied') bg-red-500/20 text-red-300 @else bg-yellow-500/20 text-yellow-300 @endif">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                        </div>
                                        @if($record->status === 'pending')
                                        <div class="flex gap-2 mt-3">
                                            <form method="POST" action="{{ route('approve-time-in', $record->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">Approve</button>
                                            </form>
                                            <button onclick="showDenyTimeEditModal({{ $record->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">Deny</button>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No time-in records yet</p>
                                @endif
                            </div>

                            <!-- Task Logs Tab -->
                            <div id="task-logs-{{ $student->id }}" class="tab-content hidden">
                                @if($taskLogs->isNotEmpty())
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($taskLogs as $record)
                                    <div class="bg-slate-700/30 rounded-lg overflow-hidden">
                                        <button type="button" onclick="openMediaPopup('{{ asset('storage/' . $record->photo_path) }}','{{ $record->date->format('M d, Y') }}')" class="relative group block w-full">
                                            <img src="{{ asset('storage/' . $record->photo_path) }}" alt="Time-in photo"
                                                class="w-full h-32 object-cover hover:opacity-80 transition-opacity rounded-t-lg">
                                            <span class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-t-lg opacity-0 group-hover:opacity-100 transition-opacity text-xs text-white font-semibold">View</span>
                                        </button>
                                        <div class="p-2">
                                            <p class="text-gray-200 text-xs font-semibold">{{ $record->date->format('M d, Y') }}</p>
                                            <p class="text-gray-400 text-xs">In: {{ $record->time_in }}{{ $record->time_out ? ' · Out: '.$record->time_out : '' }}</p>
                                            <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full
                                                @if($record->status === 'approved') bg-green-500/20 text-green-300
                                                @elseif($record->status === 'denied') bg-red-500/20 text-red-300
                                                @else bg-yellow-500/20 text-yellow-300 @endif">
                                                {{ ucfirst($record->status ?? 'pending') }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No time-in photos yet</p>
                                @endif
                            </div>

                            <!-- Requirements Tab -->
                            <div id="requirements-{{ $student->id }}" class="tab-content hidden">
                                @if($requirements->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($requirements as $req)
                                    <div class="bg-slate-700/30 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-gray-200 font-semibold">{{ $req->title }}</p>
                                                <p class="text-gray-400 text-sm">{{ $req->description }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full @if($req->status === 'approved') bg-green-500/20 text-green-300 @elseif($req->status === 'denied') bg-red-500/20 text-red-300 @else bg-yellow-500/20 text-yellow-300 @endif">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </div>
                                        @if($req->file_path)
                                        <button type="button" onclick="openMediaPopup('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" class="text-blue-400 text-xs hover:underline">📎 View File</button>
                                        @endif
                                        @if($req->status === 'pending')
                                        <div class="flex gap-2 mt-3">
                                            <button onclick="showApproveRequirementModal({{ $req->id }}, '{{ $student->email }}')" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">Approve</button>
                                            <button onclick="showDenyRequirementModal({{ $req->id }})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">Deny</button>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No requirements yet</p>
                                @endif
                            </div>

                            <!-- Evaluation Tab -->
                            <div id="evaluation-{{ $student->id }}" class="tab-content hidden">
                                @if(!$canEvaluate)
                                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4 text-center">
                                    <p class="text-yellow-300 font-semibold mb-1">🔒 Evaluation Locked</p>
                                    <p class="text-gray-400 text-sm">Student must complete {{ $studentHours->total_hours_required ?? 600 }} required hours before they can be evaluated.</p>
                                    <p class="text-gray-500 text-xs mt-1">Current: {{ number_format($studentHours->hours_completed, 2) }} / {{ $studentHours->total_hours_required ?? 600 }} hrs</p>
                                </div>
                                @elseif($evaluation)
                                <div class="bg-slate-700/30 p-4 rounded-lg space-y-3">
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        @php
                                        $evalFields = [
                                            'attendance' => '📅 Attendance',
                                            'communication' => '💬 Communication',
                                            'collaboration' => '🤝 Collaboration',
                                            'problem_solving' => '🧠 Problem-Solving',
                                            'work_ethics' => '💼 Work Ethics',
                                            'time_management' => '⏱️ Time Management',
                                            'job_skills' => '🛠️ Job Skills',
                                            'employability' => '🎯 Employability',
                                        ];
                                        @endphp
                                        @foreach($evalFields as $field => $label)
                                        <div class="bg-slate-800/50 p-2 rounded">
                                            <p class="text-gray-400">{{ $label }}</p>
                                            <div class="flex gap-0.5 mt-1">
                                                @for($i=1;$i<=5;$i++)
                                                <span class="text-sm @if($i <= ($evaluation->$field ?? 0)) text-yellow-400 @else text-gray-600 @endif">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="border-t border-slate-600 pt-3">
                                        <p class="text-gray-400 text-xs mb-1">Overall Rating</p>
                                        <div class="flex gap-1">
                                            @for($i=1;$i<=5;$i++)
                                            <span class="text-xl @if($i <= $studentRating) text-yellow-400 @else text-gray-600 @endif">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($studentFeedback)
                                    <div>
                                        <p class="text-gray-400 text-xs mb-1">Feedback:</p>
                                        <p class="text-gray-300 text-sm bg-slate-600/50 p-3 rounded">{{ $studentFeedback }}</p>
                                    </div>
                                    @endif
                                    <button onclick="showEvaluationModal({{ $student->id }}, '{{ $student->name }}')" class="w-full mt-2 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded text-sm transition-colors">Update Evaluation</button>
                                </div>
                                @else
                                <p class="text-gray-400 text-sm mb-4">No evaluation yet</p>
                                <button onclick="showEvaluationModal({{ $student->id }}, '{{ $student->name }}')" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded text-sm transition-colors">Add Evaluation</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        </section><!-- end interns -->

    </div><!-- end inner px wrapper -->
    </div><!-- end main-content -->

    <!-- ===== MEDIA POPUP MODAL ===== -->
    <div id="mediaPopup" class="hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/85 p-4" onclick="if(event.target===this)closeMediaPopup()">
        <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span id="mediaPopupTitle" class="text-sm font-semibold text-white truncate">Preview</span>
                <div class="flex items-center gap-2">
                    <a id="mediaPopupDownload" href="#" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">⬇ Open</a>
                    <button onclick="closeMediaPopup()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white">✕</button>
                </div>
            </div>
            <div id="mediaPopupBody" class="flex-1 overflow-auto flex items-center justify-center p-4 min-h-[300px]"></div>
        </div>
    </div>
    <!-- ===== END MEDIA POPUP MODAL ===== -->

    <!-- Deny Time Edit Modal -->
    <div id="denyTimeEditModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Deny Time Edit</h3>
            
            <form id="denyTimeEditForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial</label>
                    <textarea name="reason" required rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none" placeholder="Explain why you're denying this..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyTimeEditModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">Deny</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Approve Requirement Modal -->
    <div id="approveRequirementModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Approve Requirement</h3>
            
            <form id="approveRequirementForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feedback <span class="text-red-400">*</span></label>
                    <textarea name="feedback" required rows="3" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none" placeholder="Add feedback..."></textarea>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-300">Send Notification Via:</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="send_email" value="1" checked class="w-4 h-4 bg-slate-700 border-slate-600 rounded cursor-pointer">
                            <span class="ml-2 text-sm text-gray-300">📧 Email</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="send_sms" value="1" class="w-4 h-4 bg-slate-700 border-slate-600 rounded cursor-pointer">
                            <span class="ml-2 text-sm text-gray-300">📱 SMS</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeApproveRequirementModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-semibold">Approve</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Deny Requirement Modal -->
    <div id="denyRequirementModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Deny Requirement</h3>
            
            <form id="denyRequirementForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial <span class="text-red-400">*</span></label>
                    <textarea name="reason" required rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none" placeholder="Explain why..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyRequirementModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">Deny</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div id="evaluationModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-xl w-full max-w-2xl mx-auto max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center px-6 py-4 border-b border-slate-700 shrink-0">
                <h3 class="text-xl font-bold text-white">⭐ Evaluate <span id="evalStudentName"></span></h3>
                <button onclick="closeEvaluationModal()" class="text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="flex-1 overflow-y-auto px-6 py-4">
            <form id="evaluationForm" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="supervisor_id" value="{{ $user->id }}">

                <!-- Competency Ratings -->
                <div>
                    <p class="text-sm font-semibold text-yellow-400 mb-3">Performance Competency Ratings <span class="text-gray-400 font-normal">(1 = Poor, 5 = Excellent)</span></p>
                    <div class="space-y-3">
                        @php
                        $competencies = [
                            'attendance'      => ['label' => 'Attendance & Punctuality',    'icon' => '📅', 'desc' => 'Regularity and timeliness in reporting to work'],
                            'communication'   => ['label' => 'Communication Skills',         'icon' => '💬', 'desc' => 'Ability to express ideas clearly verbally and in writing'],
                            'collaboration'   => ['label' => 'Collaboration & Teamwork',     'icon' => '🤝', 'desc' => 'Works effectively with colleagues and supervisors'],
                            'problem_solving' => ['label' => 'Problem-Solving',              'icon' => '🧠', 'desc' => 'Ability to analyze and resolve work-related challenges'],
                            'work_ethics'     => ['label' => 'Work Ethics & Professionalism','icon' => '💼', 'desc' => 'Demonstrates integrity, responsibility, and professional conduct'],
                            'time_management' => ['label' => 'Time Management',              'icon' => '⏱️', 'desc' => 'Efficiently manages tasks and meets deadlines'],
                            'job_skills'      => ['label' => 'Job Skills & Competence',      'icon' => '🛠️', 'desc' => 'Technical skills and ability to perform assigned tasks'],
                            'employability'   => ['label' => 'Employability Potential',      'icon' => '🎯', 'desc' => 'Readiness and potential for future employment'],
                        ];
                        @endphp
                        @foreach($competencies as $field => $info)
                        <div class="bg-slate-700/30 rounded-lg p-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-white text-sm font-semibold">{{ $info['icon'] }} {{ $info['label'] }}</p>
                                    <p class="text-gray-400 text-xs mt-0.5">{{ $info['desc'] }}</p>
                                </div>
                                <div class="flex gap-1 shrink-0" id="stars_{{ $field }}">
                                    @for($i = 1; $i <= 5; $i++)
                                    <span class="competency-star text-2xl cursor-pointer text-gray-600 hover:text-yellow-400 transition-colors"
                                          data-field="{{ $field }}" data-value="{{ $i }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <input type="hidden" name="{{ $field }}" id="input_{{ $field }}" value="0">
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Overall Rating -->
                <div class="bg-slate-700/40 rounded-lg p-4">
                    <p class="text-sm font-semibold text-white mb-3">⭐ Overall Performance Rating</p>
                    <div class="flex gap-2" id="overallStars">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="overall-star text-3xl cursor-pointer text-gray-600 hover:text-yellow-400 transition-colors" data-value="{{ $i }}">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="0">
                    <p class="text-xs text-gray-400 mt-2" id="overallRatingLabel">Select overall rating</p>
                </div>

                <!-- Feedback -->
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">📝 Supervisor Feedback / Comments</label>
                    <textarea name="feedback" rows="3"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-yellow-500 focus:outline-none text-sm"
                        placeholder="Provide detailed feedback on the student's overall OJT performance, strengths, and areas for improvement..."></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEvaluationModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors font-semibold">Submit Evaluation</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Task Logs Modal -->
    <div id="taskLogsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop overflow-y-auto">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-2xl w-full mx-4 my-8">
            <h3 class="text-2xl font-bold text-white mb-6">Task Logs - <span id="taskLogStudentName"></span></h3>
            <div id="taskLogsContainer" class="space-y-4 max-h-96 overflow-y-auto">
                <!-- Populated by JavaScript -->
            </div>
            <button type="button" onclick="closeTaskLogsModal()" class="mt-6 w-full px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Close</button>
        </div>
    </div>

    <script>
        // ===== FILE SIZE VALIDATION =====
        function checkFileSize(input, maxMB) {
            if (input.files && input.files[0]) {
                const sizeMB = input.files[0].size / (1024 * 1024);
                if (sizeMB > maxMB) {
                    input.value = '';
                    alert(`File too large. Maximum allowed size is ${maxMB} MB. Your file is ${sizeMB.toFixed(2)} MB.`);
                    return false;
                }
            }
            return true;
        }
        // ===== END FILE SIZE VALIDATION =====

        // ===== MEDIA POPUP =====
        function openMediaPopup(url, title) {
            document.getElementById('mediaPopupTitle').textContent = title || 'Preview';
            document.getElementById('mediaPopupDownload').href = url;
            const body = document.getElementById('mediaPopupBody');
            body.innerHTML = '';
            const ext = url.split('?')[0].split('.').pop().toLowerCase();
            if (['jpg','jpeg','png','gif','webp','bmp'].includes(ext)) {
                const img = document.createElement('img');
                img.src = url;
                img.className = 'max-w-full max-h-[70vh] rounded-lg object-contain';
                body.appendChild(img);
            } else if (ext === 'pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = url; iframe.className = 'w-full rounded-lg border-0';
                iframe.style.height = '65vh'; body.appendChild(iframe);
            } else {
                body.innerHTML = `<div class="text-center py-10"><div class="text-5xl mb-4">📄</div><p class="text-gray-300 font-semibold mb-1">${title}</p><p class="text-gray-500 text-sm mb-4">Preview not available.</p><a href="${url}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold">Open File</a></div>`;
            }
            document.getElementById('mediaPopup').classList.remove('hidden');
        }
        function closeMediaPopup() {
            document.getElementById('mediaPopup').classList.add('hidden');
            document.getElementById('mediaPopupBody').innerHTML = '';
        }
        document.addEventListener('keydown', e => { if(e.key==='Escape') closeMediaPopup(); });
        // ===== END MEDIA POPUP =====

        // ===== OVERVIEW CHARTS =====
        (function(){
            const gc = 'rgba(148,163,184,0.1)', tc = '#94a3b8';

            @if(count($_progLabels))
            new Chart(document.getElementById('chartInternProgress'),{
                type:'bar',
                data:{
                    labels:{!! json_encode($_progLabels) !!},
                    datasets:[{data:{!! json_encode($_progData) !!},
                        backgroundColor:'rgba(109,40,217,0.7)', borderRadius:6, borderSkipped:false}]
                },
                options:{
                    plugins:{legend:{display:false}},
                    scales:{
                        x:{ticks:{color:tc},grid:{display:false}},
                        y:{ticks:{color:tc},grid:{color:gc},beginAtZero:true,max:100,
                            title:{display:true,text:'%',color:tc}}
                    },animation:{duration:900}
                }
            });
            @endif

            @if($totalStudents > 0)
            new Chart(document.getElementById('chartStatus'),{
                type:'doughnut',
                data:{datasets:[{data:[{{ $completedStudents }},{{ $inProgressStudents }},{{ $_notStarted }}],
                    backgroundColor:['#22c55e','#60a5fa','#475569'],borderWidth:0,hoverOffset:4}]},
                options:{cutout:'72%',plugins:{legend:{display:false},tooltip:{enabled:false}},animation:{duration:900}}
            });
            @endif

            new Chart(document.getElementById('chartDailyTI'),{
                type:'bar',
                data:{
                    labels:{!! json_encode($_tiLabels) !!},
                    datasets:[{data:{!! json_encode($_tiCounts) !!},
                        backgroundColor:'rgba(139,92,246,0.7)',borderRadius:6,borderSkipped:false}]
                },
                options:{
                    plugins:{legend:{display:false}},
                    scales:{
                        x:{ticks:{color:tc},grid:{display:false}},
                        y:{ticks:{color:tc,stepSize:1},grid:{color:gc},beginAtZero:true}
                    },animation:{duration:900}
                }
            });

            @if(count($_pendingLabels))
            new Chart(document.getElementById('chartPending'),{
                type:'bar',
                data:{
                    labels:{!! json_encode($_pendingLabels) !!},
                    datasets:[{data:{!! json_encode($_pendingData) !!},
                        backgroundColor:'rgba(234,179,8,0.75)',borderRadius:6,borderSkipped:false}]
                },
                options:{
                    plugins:{legend:{display:false}},
                    scales:{
                        x:{ticks:{color:tc},grid:{display:false}},
                        y:{ticks:{color:tc,stepSize:1},grid:{color:gc},beginAtZero:true}
                    },animation:{duration:900}
                }
            });
            @endif
        })();
        // ===== END OVERVIEW CHARTS =====

        // ===== SIDEBAR LOGIC =====
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const mainContent = document.getElementById('main-content');
        const topHeader = document.getElementById('top-header');
        let sidebarCollapsed = false;

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            backdrop.classList.toggle('show');
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            backdrop.classList.remove('show');
        }
        function toggleSidebarCollapse() {
            sidebarCollapsed = !sidebarCollapsed;
            sidebar.classList.toggle('collapsed', sidebarCollapsed);
            mainContent.classList.toggle('sidebar-collapsed', sidebarCollapsed);
            topHeader.style.left = sidebarCollapsed ? '64px' : '256px';
            localStorage.setItem('sidebarCollapsed', sidebarCollapsed ? '1' : '0');
        }

        const sectionTitles = {
            overview: '🏠 Overview',
            interns: '👥 Interns'
        };

        function showSection(name) {
            document.querySelectorAll('.dash-section').forEach(s => s.classList.add('hidden'));
            const target = document.getElementById('section-' + name);
            if (target) target.classList.remove('hidden');
            document.querySelectorAll('.nav-item[data-section]').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.section === name);
            });
            const titleEl = document.getElementById('header-section-title');
            if (titleEl) titleEl.textContent = sectionTitles[name] || name;
            closeSidebar();
            localStorage.setItem('supervisor_activeSection', name);
        }

        (function() {
            showSection(localStorage.getItem('supervisor_activeSection') || 'overview');
            if (localStorage.getItem('sidebarCollapsed') === '1' && window.innerWidth >= 1024) {
                sidebarCollapsed = true;
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
                topHeader.style.left = '64px';
            }
        })();
        // ===== END SIDEBAR LOGIC =====

        // Toggle student card expansion — collapse others first
        function toggleStudentExpand(element) {
            const card = element.closest('.student-card');
            const isExpanded = card.classList.contains('expanded');
            // Collapse all cards first
            document.querySelectorAll('.student-card.expanded').forEach(c => c.classList.remove('expanded'));
            if (!isExpanded) {
                card.classList.add('expanded');
                // Scroll to card on mobile
                setTimeout(() => {
                    card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }

        // Robust per-card tab switching (avoids global ID problems and freezing)
        document.querySelectorAll('.student-card').forEach(card => {
            const buttons = card.querySelectorAll('.tab-button');
            const contents = card.querySelectorAll('.tab-content');

            // initialize: ensure only first tab is visible for this card
            if (buttons.length && contents.length) {
                buttons.forEach((btn, idx) => {
                    btn.classList.toggle('border-purple-500', idx === 0);
                    btn.classList.toggle('text-purple-400', idx === 0);
                    btn.classList.toggle('border-transparent', idx !== 0);
                    btn.classList.toggle('text-gray-400', idx !== 0);

                    const tabName = btn.getAttribute('data-tab');
                    const contentEl = card.querySelector('#' + tabName);
                    if (contentEl) contentEl.classList.toggle('hidden', idx !== 0);
                });
            }

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const tabName = this.getAttribute('data-tab');
                    // reset all buttons in this card
                    buttons.forEach(btn => {
                        btn.classList.remove('border-purple-500', 'text-purple-400');
                        btn.classList.add('border-transparent', 'text-gray-400');
                    });
                    // hide all contents in this card
                    contents.forEach(tab => tab.classList.add('hidden'));

                    // activate clicked
                    this.classList.remove('border-transparent', 'text-gray-400');
                    this.classList.add('border-purple-500', 'text-purple-400');
                    const target = card.querySelector('#' + tabName);
                    if (target) {
                        target.classList.remove('hidden');
                        // ensure card expanded and scroll into view
                        if (!card.classList.contains('expanded')) card.classList.add('expanded');
                        setTimeout(() => {
                            window.scrollTo({ top: card.getBoundingClientRect().top + window.pageYOffset - 80, behavior: 'smooth' });
                        }, 80);
                    }
                });
            });
        });

        // Deny Time Edit Modal
        function showDenyTimeEditModal(recordId) {
            document.getElementById('denyTimeEditForm').action = `{{ url('/deny-time-in') }}/${recordId}`;
            document.getElementById('denyTimeEditModal').classList.remove('hidden');
        }

        function closeDenyTimeEditModal() {
            document.getElementById('denyTimeEditModal').classList.add('hidden');
        }

        // Approve Requirement Modal
        function showApproveRequirementModal(requirementId, studentEmail) {
            document.getElementById('approveRequirementForm').action = `{{ url('/approve-requirement') }}/${requirementId}`;
            document.getElementById('approveRequirementModal').classList.remove('hidden');
        }

        function closeApproveRequirementModal() {
            document.getElementById('approveRequirementModal').classList.add('hidden');
        }

        // Deny Requirement Modal
        function showDenyRequirementModal(requirementId) {
            document.getElementById('denyRequirementForm').action = `{{ url('/deny-requirement') }}/${requirementId}`;
            document.getElementById('denyRequirementModal').classList.remove('hidden');
        }

        function closeDenyRequirementModal() {
            document.getElementById('denyRequirementModal').classList.add('hidden');
        }

        // Evaluation Modal
        function showEvaluationModal(studentId, studentName, isEvaluated = false) {
            const student = document.querySelector(`.student-card[data-student-id="${studentId}"]`);
            if (student && !student.classList.contains('expanded')) student.classList.add('expanded');
            document.getElementById('evalStudentName').textContent = studentName;
            const form = document.getElementById('evaluationForm');
            form.action = `{{ url('/save-evaluation') }}/${studentId}`;
            // Reset all stars
            document.querySelectorAll('.competency-star').forEach(s => {
                s.classList.remove('text-yellow-400'); s.classList.add('text-gray-600');
            });
            document.querySelectorAll('.overall-star').forEach(s => {
                s.classList.remove('text-yellow-400'); s.classList.add('text-gray-600');
            });
            ['attendance','communication','collaboration','problem_solving','work_ethics','time_management','job_skills','employability'].forEach(f => {
                const el = document.getElementById('input_' + f);
                if (el) el.value = 0;
            });
            document.getElementById('ratingInput').value = 0;
            document.getElementById('overallRatingLabel').textContent = 'Select overall rating';

            // Disable form if already evaluated
            const submitBtn = form.querySelector('button[type="submit"]');
            const allStars = form.querySelectorAll('.competency-star, .overall-star');
            const feedbackArea = form.querySelector('textarea[name="feedback"]');
            if (isEvaluated) {
                if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = '✅ Already Submitted'; submitBtn.className = submitBtn.className.replace('bg-yellow-600 hover:bg-yellow-700', 'bg-slate-600 cursor-not-allowed'); }
                allStars.forEach(s => s.style.pointerEvents = 'none');
                if (feedbackArea) feedbackArea.disabled = true;
            } else {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Submit Evaluation'; submitBtn.className = submitBtn.className.replace('bg-slate-600 cursor-not-allowed', 'bg-yellow-600 hover:bg-yellow-700'); }
                allStars.forEach(s => s.style.pointerEvents = '');
                if (feedbackArea) feedbackArea.disabled = false;
            }

            document.getElementById('evaluationModal').classList.remove('hidden');
        }

        function closeEvaluationModal() {
            document.getElementById('evaluationModal').classList.add('hidden');
        }

        // Competency star ratings
        const overallLabels = ['', 'Poor', 'Below Average', 'Average', 'Good', 'Excellent'];
        const competencyFields = ['attendance','communication','collaboration','problem_solving','work_ethics','time_management','job_skills','employability'];

        function recalcOverallRating() {
            const scores = competencyFields.map(f => parseInt(document.getElementById('input_' + f).value) || 0);
            const filled = scores.filter(s => s > 0);
            if (filled.length === 0) return;
            const avg = Math.round(filled.reduce((a,b) => a+b, 0) / filled.length);
            // Set overall rating
            document.getElementById('ratingInput').value = avg;
            document.getElementById('overallRatingLabel').textContent = overallLabels[avg] || '';
            document.querySelectorAll('.overall-star').forEach((s, idx) => {
                s.classList.toggle('text-yellow-400', idx < avg);
                s.classList.toggle('text-gray-600', idx >= avg);
            });
        }

        document.querySelectorAll('.competency-star').forEach(star => {
            star.addEventListener('click', function() {
                const field = this.getAttribute('data-field');
                const value = parseInt(this.getAttribute('data-value'));
                document.getElementById('input_' + field).value = value;
                document.querySelectorAll(`.competency-star[data-field="${field}"]`).forEach((s, idx) => {
                    s.classList.toggle('text-yellow-400', idx < value);
                    s.classList.toggle('text-gray-600', idx >= value);
                });
                recalcOverallRating();
            });
        });

        // Task Logs Modal
        function showTaskLogsModal(studentId, studentName) {
            activateCardTab(studentId, 'task-logs');
        }

        function closeTaskLogsModal() {
            document.getElementById('taskLogsModal').classList.add('hidden');
        }

        // Helpers for top action buttons: ensure card expanded and activate a specific tab
        function activateCardTab(studentId, tabBase) {
            const card = document.querySelector(`.student-card[data-student-id="${studentId}"]`);
            if (!card) return;
            if (!card.classList.contains('expanded')) card.classList.add('expanded');

            // find the tab button with matching data-tab starting with the base
            const btn = Array.from(card.querySelectorAll('.tab-button')).find(b => (b.getAttribute('data-tab') || '').startsWith(tabBase));
            if (btn) btn.click();
        }

        function showTimeEditsModal(studentId, studentName) {
            activateCardTab(studentId, 'time-records');
        }

        function showRequirementsModal(studentId, studentName) {
            activateCardTab(studentId, 'requirements');
        }

        // Evaluation form — submit via AJAX
        document.getElementById('evaluationForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // prevent pixel-loader from firing
            const form = this;
            const rating = parseInt(document.getElementById('ratingInput').value);
            if (rating < 1) {
                alert('Please select an overall rating.');
                return;
            }
            const fields = ['attendance','communication','collaboration','problem_solving','work_ethics','time_management','job_skills','employability'];
            for (const f of fields) {
                if (parseInt(document.getElementById('input_' + f).value) < 1) {
                    alert('Please rate all competency areas.');
                    return;
                }
            }
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            if (typeof showPixelLoader === 'function') showPixelLoader('SAVING');

            const fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: fd,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(r => {
                if (!r.ok) throw new Error('Server error ' + r.status);
                return r.json();
            })
            .then(data => {
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                if (data.success) {
                    closeEvaluationModal();
                    if (typeof showSuccess === 'function') showSuccess('Evaluation submitted successfully!');
                    setTimeout(() => { _allowLeave = true; window.location.reload(); }, 3500);
                } else {
                    alert('Failed to submit. Please try again.');
                }
            })
            .catch(err => {
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                console.error('Evaluation error:', err);
                alert('Submission failed: ' + err.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Evaluation';
            });
        }, true); // capture phase — runs before pixel-loader listener

        // Close modals when clicking outside
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) this.classList.add('hidden');
            });
        });

        // Confirm modal
        function showConfirm(type) {
            const icon = document.getElementById('confirmIcon');
            const title = document.getElementById('confirmTitle');
            const msg = document.getElementById('confirmMsg');
            const btn = document.getElementById('confirmBtn');
            if (type === 'logout') {
                icon.textContent = '🚪'; title.textContent = 'Logout?';
                msg.textContent = 'You will be signed out of your account.';
                btn.textContent = 'Yes, Logout'; btn.href = '/logout';
                btn.className = 'flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-purple-600 hover:bg-purple-700';
                btn.onclick = function() { _allowLeave = true; };
            } else {
                icon.textContent = '🏠'; title.textContent = 'Go to Home?';
                msg.textContent = 'You will leave the dashboard and go to the landing page.';
                btn.textContent = 'Yes, Go Home'; btn.href = '/';
                btn.className = 'flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-blue-600 hover:bg-blue-700';
                btn.onclick = function() { _allowLeave = true; };
            }
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        function closeConfirm() { document.getElementById('confirmModal').classList.add('hidden'); }
        document.getElementById('confirmModal')?.addEventListener('click', function(e){ if(e.target===this) closeConfirm(); });

        // ===== LEAVE PAGE CONFIRMATION =====
        let _allowLeave = true;
        // ===== END LEAVE PAGE CONFIRMATION =====

        // Theme toggle
        function toggleTheme() {
            const isLight = document.body.classList.toggle('light');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            document.getElementById('iconMoon').classList.toggle('hidden', isLight);
            document.getElementById('iconSun').classList.toggle('hidden', !isLight);
        }
        (function(){
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light');
                document.getElementById('iconMoon').classList.add('hidden');
                document.getElementById('iconSun').classList.remove('hidden');
            }
        })();
        function openSupDtrModal(studentId, studentName) {
            const url = `/generate-dtr/${studentId}`;
            document.getElementById('supDtrModalTitle').textContent = studentName + ' — DTR Record';
            document.getElementById('supDtrOpenLink').href = url;
            document.getElementById('supDtrFrame').src = url;
            document.getElementById('supDtrModal').classList.remove('hidden');
        }
        function closeSupDtrModal() {
            document.getElementById('supDtrModal').classList.add('hidden');
            document.getElementById('supDtrFrame').src = '';
        }
    </script>
    <!-- DTR Viewer Modal -->
    <div id="supDtrModal" class="hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/80 p-4" onclick="if(event.target===this)closeSupDtrModal()">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span id="supDtrModalTitle" class="text-sm font-semibold text-white">DTR Record</span>
                <div class="flex items-center gap-2">
                    <a id="supDtrOpenLink" href="#" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">↗ Open Full Page</a>
                    <button onclick="closeSupDtrModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white">✕</button>
                </div>
            </div>
            <div class="flex-1 overflow-hidden">
                <iframe id="supDtrFrame" src="" class="w-full h-full border-0" style="min-height:75vh"></iframe>
            </div>
        </div>
    </div>
    <!-- End DTR Viewer Modal -->

</body>
</html>