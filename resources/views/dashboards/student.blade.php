<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard - OJT Monitoring System</title>
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
            background: rgba(34,197,94,0.28);
            border-left: 3px solid #22c55e;
            color: #4ade80;
        }
        .nav-item:not(.active):hover {
            background: rgba(255,255,255,0.05);
            color: #d1fae5;
        }
        /* section fade */
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
        body.light #sidebar .nav-item.active { background: rgba(34,197,94,0.25) !important; }
        body.light #sidebar .nav-item.active .nav-label,
        body.light #sidebar .nav-item.active .nav-icon { color: #86efac !important; }
        body.light #sidebar .nav-item:not(.active):hover { background: rgba(255,255,255,0.08) !important; }
        body.light #top-header { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light #top-header span, body.light #top-header p, body.light #top-header button { color: #1a2a4a !important; }
        /* ===== END SIDEBAR ===== */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .time-in-btn {
            animation: pulse-ring 2s infinite;
        }

        .success-slide {
            animation: slideInRight 0.5s ease-out;
        }

        .reminder-notification {
            animation: slideDown 0.4s ease-out;
        }

        .camera-video {
            transform: scaleX(-1);
        }

        #cameraCanvas {
            display: none;
        }

        /* hide cabinet scrollbars for cleaner UI */
        .cabinet-body, .requirements-list {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .cabinet-body::-webkit-scrollbar, .requirements-list::-webkit-scrollbar { display: none; }
        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg,#dde8f5,#c8daf0,#d8eaf8) !important; color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-green"] { color: #fff !important; }
        body.light h1,body.light h2,body.light h3,body.light h4,
        body.light p,body.light span,body.light label,body.light div,
        body.light td,body.light th,body.light li,body.light small { color: #1a2a4a; }
        body.light .text-white,body.light .text-gray-100,body.light .text-gray-200 { color: #1a2a4a !important; }
        body.light .text-gray-300 { color: #2d3f5a !important; }
        body.light .text-gray-400 { color: #3d5070 !important; }
        body.light .text-gray-500 { color: #4a6080 !important; }
        body.light .text-green-400,.body.light .text-green-300 { color: #15803d !important; }
        body.light .text-blue-400,body.light .text-blue-300 { color: #1d4ed8 !important; }
        body.light .text-orange-400,body.light .text-orange-300 { color: #c2410c !important; }
        body.light .text-yellow-400,body.light .text-yellow-300 { color: #92400e !important; }
        body.light .text-red-400,body.light .text-red-300 { color: #b91c1c !important; }
        body.light .text-purple-400,body.light .text-purple-300 { color: #6d28d9 !important; }
        body.light .text-indigo-400,body.light .text-indigo-300 { color: #4338ca !important; }
        body.light button[class*="bg-green-6"],body.light button[class*="bg-blue-6"],
        body.light button[class*="bg-red-6"],body.light button[class*="bg-orange-6"],
        body.light button[class*="bg-yellow-6"],body.light button[class*="bg-indigo-6"],
        body.light button[class*="bg-purple-6"],body.light a[class*="bg-green-6"],
        body.light a[class*="bg-blue-6"],body.light a[class*="bg-red-6"] { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: #c8daf0 !important; }
        body.light [class*="bg-slate-800"] { background: #d0e4f8 !important; }
        body.light [class*="bg-slate-700"] { background: #bdd4ec !important; }
        body.light [class*="bg-slate-600"] { background: #aac4e0 !important; }
        body.light [class*="border-slate-7"] { border-color: #7aaad4 !important; }
        body.light [class*="border-slate-6"] { border-color: #8ab8dc !important; }
        body.light .border-green-500 { border-color: #16a34a !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.9) !important; border-color: #7aaad4 !important; color: #1a2a4a !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #5a7a9a !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: #fff !important; border-color: #16a34a !important; border-left: 4px solid #16a34a !important; }
        body.light .header-info-card h1 { color: #1a2a4a !important; }
        body.light .header-info-card .subtitle { color: #4a6080 !important; }
        body.light .header-info-card .stat-label { color: #4a6080 !important; }
        body.light .header-info-card .stat-value-white { color: #1a2a4a !important; }
        body.light .header-info-card .stat-value-green { color: #15803d !important; }
        body.light .header-info-card .stat-value-blue { color: #1d4ed8 !important; }
        body.light .header-info-card .divider { background: #cbd5e1 !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">

    <?php
        $_sh = \App\Models\StudentHours::where('student_id', $user->id)->first();
        $_required = $_sh ? $_sh->total_hours_required : 600;
        $_allRecordsTotal = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereNotNull('time_out')->where('status', 'approved')->get()
            ->sum(fn($r) => max(0, \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out))) / 60);
        $_completed = $_sh ? $_sh->hours_completed : round($_allRecordsTotal, 2);
        $_progress = $_required > 0 ? min(100, round(($_completed / $_required) * 100, 1)) : 0;
    ?>

    @include('partials.success-popup')
    <div id="confirmModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-4">
                <div id="confirmIcon" class="text-4xl mb-3">⚠️</div>
                <h3 id="confirmTitle" class="text-lg font-bold text-white mb-1">Are you sure?</h3>
                <p id="confirmMsg" class="text-gray-400 text-sm"></p>
            </div>
            <div class="flex gap-3 mt-5">
                <button onclick="closeConfirm()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <a id="confirmBtn" href="#" class="flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-green-600 hover:bg-green-700">Confirm</a>
            </div>
        </div>
    </div>

    <!-- Sidebar Backdrop (mobile) -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 z-30 lg:hidden" onclick="closeSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-40 bg-slate-900 border-r border-slate-700/60 flex flex-col overflow-hidden">

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b border-slate-700/60 shrink-0">
            <div class="flex items-center gap-3 min-w-0 sidebar-brand-text">
                <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21a12.083 12.083 0 01-6.16-10.422L12 14z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-white truncate">OJT Monitoring System</p>
                    <p class="text-xs text-gray-400 truncate">Student Portal</p>
                </div>
            </div>
            <!-- collapse toggle (desktop) -->
            <button onclick="toggleSidebarCollapse()" class="hidden lg:flex w-7 h-7 items-center justify-center rounded-md text-gray-400 hover:text-white hover:bg-slate-700 transition-colors shrink-0" title="Collapse sidebar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Student Info -->
        <div class="sidebar-user px-4 py-3 border-b border-slate-700/40 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-green-400 truncate">{{ $user->company->name ?? 'No Company' }}</p>
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
            <button onclick="showSection('timein')" data-section="timein"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">⏱️</span>
                <span class="nav-label">Time In / Out</span>
            </button>
            <button onclick="showSection('history')" data-section="history"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📅</span>
                <span class="nav-label">Attendance History</span>
            </button>
            <button onclick="showSection('requirements')" data-section="requirements"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📁</span>
                <span class="nav-label">Requirements</span>
            </button>
            <button onclick="showSection('reports')" data-section="reports"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📋</span>
                <span class="nav-label">Reports</span>
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
        <!-- Hamburger (mobile) / collapse toggle label -->
        <button onclick="toggleSidebar()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white transition-colors lg:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <!-- Page title (updates with active section) -->
        <span id="header-section-title" class="text-sm font-semibold text-white">Overview</span>
        <!-- Progress pill + theme toggle -->
        <div class="ml-auto flex items-center gap-2">
            <span class="hidden sm:flex items-center gap-1.5 px-3 py-1 bg-green-500/15 border border-green-500/30 rounded-full text-xs text-green-400 font-semibold">
                <span>📈</span> {{ $_progress }}%
            </span>
            <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                class="w-8 h-8 rounded-full flex items-center justify-center transition-all"
                style="background:rgba(22,163,74,0.8);border:1px solid rgba(134,239,172,0.4)">
                <svg id="iconMoon" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg id="iconSun" class="w-4 h-4 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            </button>
        </div>
    </header>
    <!-- ===== END TOP HEADER ===== -->

    <!-- ===== MAIN CONTENT ===== -->
    <div id="main-content" class="pt-14 lg:ml-64 min-h-screen transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <?php
            $totalDays = \App\Models\TimeInRecord::where('student_id', $user->id)->count();
            $verifiedDays = \App\Models\TimeInRecord::where('student_id', $user->id)->where('verified', true)->count();
            $allReqs = \App\Models\StudentRequirement::where('student_id', $user->id)->get();
            $pendingReqs = $allReqs->where('status', 'pending')->count();
            $approvedReqs = $allReqs->where('status', 'approved')->count();
            $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->value('label');
        ?>

        <!-- ===== SECTION: OVERVIEW ===== -->
        <section id="section-overview" class="dash-section">

        <!-- Header Info Card -->
        <div class="header-info-card mb-8 bg-gradient-to-r from-slate-800/50 to-green-900/30 border border-slate-700 rounded-xl p-6">
            <h1 class="text-4xl font-bold text-white mb-1">Your OJT Journey</h1>
            <p class="subtitle text-gray-400 mb-5">Time in with your photo, then log your daily hours</p>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                <div>
                    <span class="stat-label text-sm text-gray-400">👤 Student:</span>
                    <p class="stat-value-white text-lg font-semibold text-white">{{ $user->name }}</p>
                </div>
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">🏢 Company:</span>
                    <p class="stat-value-green text-lg font-semibold text-green-400">{{ $user->company->name ?? 'Not Assigned' }}</p>
                </div>
                @if($activeSchoolYear)
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">📅 School Year:</span>
                    <p class="stat-value-blue text-lg font-semibold text-blue-400">{{ $activeSchoolYear }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Overview Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-green-500/50 transition-colors">
                <div class="text-gray-400 text-sm font-medium mb-2">📅 Days Attended</div>
                <div class="text-3xl font-bold text-white">{{ $totalDays }}</div>
                <p class="text-xs text-gray-500 mt-2">{{ $verifiedDays }} verified</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-blue-500/50 transition-colors">
                <div class="text-gray-400 text-sm font-medium mb-2">⏱️ Hours Completed</div>
                <div class="text-3xl font-bold text-green-400">{{ number_format($_completed, 2) }}</div>
                <p class="text-xs text-gray-500 mt-2">of {{ $_required }} required</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-orange-500/50 transition-colors">
                <div class="text-gray-400 text-sm font-medium mb-2">📋 Pending Reports</div>
                <div class="text-3xl font-bold text-yellow-400">{{ $pendingReqs }}</div>
                <p class="text-xs text-gray-500 mt-2">{{ $approvedReqs }} approved</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-green-500/50 transition-colors">
                <div class="text-gray-400 text-sm font-medium mb-2">📈 Overall Progress</div>
                <div class="text-3xl font-bold text-green-400">{{ $_progress }}%</div>
                <p class="text-xs text-gray-500 mt-2">{{ number_format(max(0, $_required - $_completed), 1) }} hrs remaining</p>
            </div>
        </div>

        <!-- ===== OVERVIEW CHARTS ===== -->
        <?php
            // Last 7 days attendance for bar chart
            $_last7 = [];
            $_last7Labels = [];
            for ($i = 6; $i >= 0; $i--) {
                $d = \Carbon\Carbon::now()->subDays($i);
                $_last7Labels[] = $d->format('D');
                $rec = \App\Models\TimeInRecord::where('student_id', $user->id)
                    ->whereDate('date', $d->toDateString())
                    ->whereNotNull('time_out')
                    ->first();
                if ($rec) {
                    $_last7[] = round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out)) / 60, 2);
                } else {
                    $_last7[] = 0;
                }
            }
            // Requirements status breakdown
            $_reqApproved = $allReqs->where('status','approved')->count();
            $_reqPending  = $allReqs->where('status','pending')->count();
            $_reqRejected = $allReqs->where('status','rejected')->count();
        ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Donut: OJT Progress -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col items-center">
                <h3 class="text-sm font-semibold text-gray-400 mb-4 self-start">📈 OJT Progress</h3>
                <div class="relative w-36 h-36">
                    <canvas id="chartProgress"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ $_progress }}%</span>
                        <span class="text-xs text-gray-400">done</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">{{ number_format($_completed,1) }} / {{ $_required }} hrs</p>
            </div>
            <!-- Bar: Hours last 7 days -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">⏱️ Hours This Week</h3>
                <canvas id="chartWeek" height="140"></canvas>
            </div>
            <!-- Doughnut: Reports Status -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col items-center">
                <h3 class="text-sm font-semibold text-gray-400 mb-4 self-start">📋 Reports Status</h3>
                @if($allReqs->count() > 0)
                <div class="relative w-36 h-36">
                    <canvas id="chartReports"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ $allReqs->count() }}</span>
                    </div>
                </div>
                <div class="flex gap-3 mt-3 text-xs">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>{{ $_reqApproved }} approved</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span>{{ $_reqPending }} pending</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>{{ $_reqRejected }} rejected</span>
                </div>
                @else
                <div class="flex-1 flex items-center justify-center">
                    <p class="text-gray-500 text-sm">No reports yet</p>
                </div>
                @endif
            </div>
        </div>

        </section><!-- end overview -->

        <!-- ===== SECTION: TIME IN ===== -->
        <section id="section-timein" class="dash-section hidden">

        @php
            $_timeinSH = \App\Models\StudentHours::where('student_id', $user->id)->first();
            $_timeinRequired = $_timeinSH ? $_timeinSH->total_hours_required : 600;
            $_timeinActual = \App\Models\TimeInRecord::where('student_id', $user->id)
                ->whereNotNull('time_out')->get()
                ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
            $_timeinCompleted = max($_timeinSH->hours_completed ?? 0, $_timeinActual);
            $_ojtDone = $_timeinCompleted >= $_timeinRequired;
            $required = $_timeinRequired;
            $today = date('Y-m-d');
            $totalDayHours = 0;
        @endphp

        @if($_ojtDone)
        <!-- OJT Completed Banner -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-900/40 to-emerald-900/40 border-2 border-green-500/60 rounded-2xl p-8 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-3xl font-bold text-green-400 mb-2">Congratulations!</h2>
                <p class="text-white text-lg font-semibold mb-1">You have completed your OJT!</p>
                <p class="text-gray-300 text-sm mb-4">You have successfully completed <span class="text-green-400 font-bold">{{ number_format($_timeinCompleted, 2) }} / {{ $_timeinRequired }} hours</span> of On-the-Job Training.</p>
                <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/40 rounded-full px-6 py-2">
                    <span class="text-green-400 text-lg">✓</span>
                    <span class="text-green-300 font-semibold">OJT Hours Requirement Fulfilled</span>
                </div>
                <p class="text-gray-400 text-xs mt-4">Time-in is no longer required. Please coordinate with your supervisor for final evaluation.</p>
            </div>
        </div>
        @else
        <!-- Time-In Card -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="lg:col-span-1">
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Daily Time-In</h2>
                    
                    <?php 
                    $today = date('Y-m-d');
                    $nowHour = (int) date('H');

                    // Get all today's records
                    $todayRecords = \App\Models\TimeInRecord::where('student_id', $user->id)
                        ->whereDate('date', $today)
                        ->orderBy('session')
                        ->get();

                    $morningRecord   = $todayRecords->firstWhere('session', 'morning');
                    $afternoonRecord = $todayRecords->firstWhere('session', 'afternoon');

                    // Active record = the one without time_out
                    $activeRecord = $todayRecords->whereNull('time_out')->first();

                    // Total hours today (completed sessions)
                    $totalDayMinutes = $todayRecords->whereNotNull('time_out')->sum(fn($r) =>
                        max(0, \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)))
                    );
                    $totalDayHours = round($totalDayMinutes / 60, 2);
                    $regularHours  = min($totalDayHours, 8);
                    $otHours       = max(0, round($totalDayHours - 8, 2));

                    // Can time in afternoon? Morning must be timed out and now >= 12:50
                    $nowMin = (int) date('i');
                    $canTimeInAfternoon = false;
                    if ($morningRecord && $morningRecord->time_out && !$afternoonRecord
                        && ($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50))) {
                        $canTimeInAfternoon = true;
                    }

                    // Determine what to show
                    $todayRecord = $activeRecord ?? $todayRecords->last();
                    ?>
                    <span id="todayTimeIn" data-time="{{ optional($activeRecord)->time_in ?? '' }}" class="hidden"></span>

                    @if($todayRecords->isNotEmpty())
                        <!-- Sessions Summary -->
                        <div class="space-y-4">

                            {{-- Morning Session --}}
                            @if($morningRecord)
                            <div class="bg-green-500/10 border border-green-500 rounded-lg p-4">
                                <h4 class="text-sm font-bold text-green-400 mb-2">🌅 Morning Session</h4>
                                <p class="text-gray-400 text-sm">Time In: <span class="text-green-400 font-semibold">{{ \Carbon\Carbon::parse($morningRecord->time_in)->format('h:i A') }}</span></p>
                                @if($morningRecord->time_out)
                                    <p class="text-gray-400 text-sm">Time Out: <span class="text-orange-400 font-semibold">{{ \Carbon\Carbon::parse($morningRecord->time_out)->format('h:i A') }}</span></p>
                                    <p class="text-gray-400 text-sm">Hours: <span class="text-blue-400 font-semibold">{{ number_format(\Carbon\Carbon::parse($morningRecord->time_in)->diffInMinutes(\Carbon\Carbon::parse($morningRecord->time_out)) / 60, 2) }} hrs</span></p>
                                @else
                                    <p class="text-yellow-400 text-xs mt-1">⏳ Currently active</p>
                                @endif
                            </div>
                            @endif

                            {{-- Afternoon Session --}}
                            @if($afternoonRecord)
                            <div class="bg-blue-500/10 border border-blue-500 rounded-lg p-4">
                                <h4 class="text-sm font-bold text-blue-400 mb-2">🌇 Afternoon Session</h4>
                                <p class="text-gray-400 text-sm">Time In: <span class="text-green-400 font-semibold">{{ \Carbon\Carbon::parse($afternoonRecord->time_in)->format('h:i A') }}</span></p>
                                @if($afternoonRecord->time_out)
                                    <p class="text-gray-400 text-sm">Time Out: <span class="text-orange-400 font-semibold">{{ \Carbon\Carbon::parse($afternoonRecord->time_out)->format('h:i A') }}</span></p>
                                    <p class="text-gray-400 text-sm">Hours: <span class="text-blue-400 font-semibold">{{ number_format(\Carbon\Carbon::parse($afternoonRecord->time_in)->diffInMinutes(\Carbon\Carbon::parse($afternoonRecord->time_out)) / 60, 2) }} hrs</span></p>
                                @else
                                    <p class="text-yellow-400 text-xs mt-1">⏳ Currently active</p>
                                @endif
                            </div>
                            @endif

                            {{-- Daily Total Summary --}}
                            @if($totalDayHours > 0)
                            <div class="bg-slate-700/50 border border-slate-600 rounded-lg p-4">
                                <h4 class="text-sm font-bold text-white mb-2">📊 Today's Summary</h4>
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div>
                                        <p class="text-xs text-gray-400">Total</p>
                                        <p class="text-lg font-bold text-white">{{ number_format($totalDayHours, 2) }}<span class="text-xs text-gray-400"> hrs</span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Regular</p>
                                        <p class="text-lg font-bold text-green-400">{{ number_format($regularHours, 2) }}<span class="text-xs text-gray-400"> hrs</span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">OT</p>
                                        <p class="text-lg font-bold {{ $otHours > 0 ? 'text-yellow-400' : 'text-gray-500' }}">{{ number_format($otHours, 2) }}<span class="text-xs text-gray-400"> hrs</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Active Time-Out Button --}}
                            @if($activeRecord && !$activeRecord->time_out)
                            <form method="POST" action="{{ route('time-out') }}" id="timeOutForm">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $user->id }}">
                                <input type="hidden" name="date" value="{{ $today }}">
                                <input type="hidden" name="session" value="{{ $activeRecord->session }}">
                                <input type="hidden" name="photo_base64" id="timeOutPhotoBase64">
                                <input type="hidden" name="time_out" id="timeOut" required>
                                <button type="button" id="timeOutBtn" onclick="openTimeoutOptionsModal(); return false;"
                                    class="w-full px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                    🕐 Time Out ({{ ucfirst($activeRecord->session) }} Session)
                                </button>
                            </form>
                            @endif

                            {{-- Afternoon Time-In Button (lunch break flow) --}}
                            @if($canTimeInAfternoon)
                            <div class="bg-blue-500/10 border border-blue-400 rounded-lg p-4">
                                <p class="text-blue-300 text-sm mb-3">🍽️ Lunch break done! You can now time in for your afternoon session.</p>
                                <form method="POST" action="{{ route('time-in') }}" enctype="multipart/form-data" id="afternoonTimeInForm">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $user->id }}">
                                    <input type="hidden" name="date" value="{{ $today }}">
                                    <input type="hidden" name="session" value="afternoon">
                                    <input type="hidden" name="photo_base64" id="afternoonPhotoBase64">
                                    <button type="button" onclick="openCameraModal('afternoon')" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                                        📷 Time In — Afternoon Session
                                    </button>
                                </form>
                            </div>
                            @endif

                            {{-- All sessions done --}}
                            @if(!$activeRecord && !$canTimeInAfternoon)
                            <div class="bg-green-500/5 rounded-lg p-4">
                                <p class="text-gray-300 text-center text-sm">✓ All sessions completed for today.</p>
                            </div>
                            @endif

                        </div>
                    @else
                        <!-- Time-In Form with Camera -->
                        <form method="POST" action="{{ route('time-in') }}" enctype="multipart/form-data" class="space-y-6" id="timeInForm">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $user->id }}">
                            <input type="hidden" name="date" value="{{ $today }}">
                            <input type="hidden" name="session" value="morning">
                           <input type="hidden" name="photo_base64" id="photoBase64">

                            <!-- Current Time Display -->
                            <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/30 rounded-lg p-4 mb-4">
                                <p class="text-gray-300 text-sm mb-2">Current Time</p>
                                <p class="text-3xl font-bold text-blue-400" id="currentTime">--:--:--</p>
                            </div>

                            <!-- Time In -->
                            <div>
                                <label for="timeIn" class="block text-sm font-medium text-gray-300 mb-2">Time In</label>
                                <div class="flex gap-2">
                                    <input type="time" name="time_in" id="timeIn" required readonly
                                        class="flex-1 px-4 py-3 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none text-lg"
                                        value="{{ date('H:i') }}">
                                    <button type="button" id="autoSetTimeIn" class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-semibold text-sm whitespace-nowrap">
                                        Now
                                    </button>
                                </div>
                            </div>

                            <!-- Camera Capture Section (replaced Upload tab with camera-only button) -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-400 mb-2">Capture a photo with your camera to time in.</p>
                                <button type="button" id="openCameraForTimeIn" onclick="openCameraModal('timein')" class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">📷 Open Camera</button>
                            </div>

                            <!-- Photo Preview (populated from modal) -->
                            <div id="cameraCapturePreview" class="hidden bg-slate-700/30 rounded-lg p-4 mb-4">
                                <p class="text-gray-400 text-xs mb-2">Photo captured:</p>
                                <img id="capturedImage" src="" alt="Captured" class="w-full rounded-lg max-h-48 object-cover">
                                <div class="flex gap-2 mt-4">
                                    <button type="button" id="retakeCameraBtn" class="flex-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors font-semibold text-sm">
                                        Retake
                                    </button>
                                    <button type="button" id="useCameraPhotoBtn" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-semibold text-sm">
                                        Use Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Selected Photo Indicator -->
                            <div id="photoSelected" class="hidden bg-green-500/10 border border-green-500 rounded-lg p-3 flex items-center gap-2 mb-4">
                                <span class="text-green-400">✓</span>
                                <span class="text-green-300 text-sm">Photo selected</span>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Progress Summary -->
            <div class="lg:col-span-1">
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 sticky top-20">
                    <h3 class="text-xl font-bold text-white mb-6">Your Progress</h3>
                    
                    <?php 
                    $studentHours = \App\Models\StudentHours::where('student_id', $user->id)
                        ->firstOrCreate(['student_id' => $user->id], ['total_hours_required' => 600]);
                    $required = $studentHours->total_hours_required;
                    $displayCompleted = $studentHours->hours_completed;
                    $progressPercentage = $required > 0 ? ($displayCompleted / $required) * 100 : 0;
                    ?>

                    <div class="space-y-4">
                        <div>
                                <div class="flex justify-between mb-2">
                                <span class="text-gray-300">Completed</span>
                                <span id="completedHours" class="text-green-400 font-bold">{{ number_format($displayCompleted, 2) }}/{{ $required }}</span>
                            </div>
                            <div class="w-full bg-slate-700/50 rounded-full h-3 overflow-hidden border border-slate-600">
                                  <div id="progressFill" class="h-full bg-gradient-to-r from-green-500 to-blue-500 transition-all duration-500" 
                                      style="width: {{ max(0.1, min($progressPercentage, 100)) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ number_format($displayCompleted, 2) }} hours completed</p>
                        </div>

                        <div class="pt-4 border-t border-slate-600">
                            <p class="text-gray-400 text-sm mb-3">Quick Stats</p>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Remaining Hours</span>
                                    <span id="remainingHours" class="text-blue-400 font-semibold">{{ number_format(max(0, $required - $displayCompleted), 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Progress</span>
                                    <span id="progressPercent" class="text-orange-400 font-semibold">{{ number_format($progressPercentage, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        </section><!-- end timein -->

        <!-- ===== SECTION: HISTORY ===== -->
        <section id="section-history" class="dash-section hidden">

        <!-- Time-In History -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 w-full">
            <h3 class="text-xl font-bold text-white mb-6">Your Time-In History</h3>
            
            <?php 
            $timeInRecords = \App\Models\TimeInRecord::where('student_id', $user->id)
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
            ?>

            @if($timeInRecords->isNotEmpty())
            <div class="space-y-3">
                @foreach($timeInRecords as $record)
                <div class="flex items-center justify-between bg-slate-700/30 p-4 rounded-lg hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4">
                        @if($record->photo_path)
                        <img src="{{ url('storage/' . $record->photo_path) }}" alt="Time-in photo"
                            class="w-12 h-12 rounded-lg object-cover cursor-pointer hover:ring-2 hover:ring-green-400 transition-all"
                            onerror="this.onerror=null;this.src='';this.closest('div').innerHTML='<div class=\'w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center\'><span class=\'text-gray-400\'>📸</span></div>';"
                            onclick="openFileViewer('{{ url('storage/' . $record->photo_path) }}','{{ $record->date->format('M d, Y') }} — Time-in Photo')">
                        @else
                        <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400">📸</span>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-300 font-semibold">{{ $record->date->format('M d, Y') }}</p>
                            <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }} @if($record->time_out) - {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }} @endif</p>
                        </div>
                    </div>
                    @if($record->verified)
                    <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs rounded-full font-semibold">Verified</span>
                    @else
                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-xs rounded-full font-semibold">Pending</span>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-400 text-center py-8">No time-in records yet. Start by timing in today!</p>
            @endif
        </div>

        </section><!-- end history -->

        <!-- ===== SECTION: REQUIREMENTS ===== -->
        <section id="section-requirements" class="dash-section hidden">
        <?php
            $requirements = \App\Models\StudentRequirement::where('student_id', $user->id)->orderBy('created_at', 'desc')->get();
            $submittedTitles = $requirements->pluck('title')->map(fn($t)=>strtolower($t))->toArray();
            // key = display name, value = max photos allowed (1 = single file, >1 = multiple)
            $onboarding = [
                'Internship Application Form' => 3,
                'Letter of Acceptance'        => 1,
                'Parental Consent'            => 1,
                'School ID'                   => 1,
                'Government ID'               => 1,
                'Vaccination Card'            => 1,
                'Medical Report'              => 5,
                'Insurance'                   => 3,
            ];
        ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Onboarding Cabinet -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">📂 Onboarding Requirements</h3>
                <p class="text-gray-400 text-xs mb-4">Documents required to begin OJT</p>
                <ul class="space-y-3">
                    @foreach($onboarding as $item => $maxFiles)
                        <?php $found = $requirements->first(fn($r)=> stripos($r->title, $item) !== false); $exists = (bool)$found; ?>
                        <li class="flex justify-between items-center p-3 bg-slate-700/40 rounded-lg">
                            <div>
                                <div class="text-gray-200 font-semibold text-sm">{{ $item }}</div>
                                <div class="text-xs mt-0.5 {{ $exists ? ($found->status==='approved' ? 'text-green-400' : ($found->status==='denied' ? 'text-red-400' : 'text-yellow-400')) : 'text-gray-500' }}">
                                    {{ $exists ? ucfirst($found->status) : 'Not submitted' }}
                                    @if($maxFiles > 1)<span class="text-gray-500 ml-1">(up to {{ $maxFiles }} photos)</span>@endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($found && $found->file_path)
                                    <button type="button" onclick="openFileViewer('{{ asset('storage/' . $found->file_path) }}','{{ addslashes($item) }}')" class="px-2 py-1 bg-blue-600/80 hover:bg-blue-600 text-white rounded text-xs">View</button>
                                @endif
                                @if(!$exists || $found->status === 'denied')
                                    <button type="button" onclick="openUploadModal('{{ addslashes($item) }}', {{ $maxFiles }})" class="px-2 py-1 {{ $exists && $found->status === 'denied' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded text-xs">{{ $exists && $found->status === 'denied' ? 'Resubmit' : 'Upload' }}</button>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Daily Submissions Cabinet -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">📋 Daily Submissions</h3>
                        <p class="text-gray-400 text-xs mt-1">Narratives & daily reports</p>
                    </div>
                    <button type="button" onclick="openUploadModal('Daily Report')" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold">+ Upload</button>
                </div>
                <?php $dailyReqs = $requirements->filter(fn($r)=> stripos($r->title,'narrative')!==false || stripos($r->title,'daily')!==false || stripos($r->title,'report')!==false); ?>
                @if($dailyReqs->isNotEmpty())
                <div class="space-y-3">
                    @foreach($dailyReqs as $daily)
                    <div class="flex justify-between items-start p-3 bg-slate-700/40 rounded-lg">
                        <div>
                            <div class="text-gray-200 font-semibold text-sm">{{ $daily->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $daily->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($daily->file_path)
                                <button type="button" onclick="openFileViewer('{{ asset('storage/' . $daily->file_path) }}','{{ addslashes($daily->title) }}')" class="px-2 py-1 bg-blue-600/80 hover:bg-blue-600 text-white rounded text-xs">View</button>
                            @endif
                            <span class="text-xs px-2 py-0.5 rounded-full
                                @if($daily->status==='approved') bg-green-500/20 text-green-400
                                @elseif($daily->status==='denied') bg-red-500/20 text-red-400
                                @else bg-yellow-500/20 text-yellow-400 @endif">
                                {{ ucfirst($daily->status) }}
                            </span>
                            @if($daily->status === 'denied')
                                <button type="button" onclick="openUploadModal('{{ addslashes($daily->title) }}')" class="px-2 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-xs">Resubmit</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm text-center py-6">No daily submissions yet.</p>
                @endif
            </div>

        </div>
        </section><!-- end requirements -->

        <!-- ===== SECTION: REPORTS ===== -->
        <section id="section-reports" class="dash-section hidden">
        <?php
            $allSubmitted = \App\Models\StudentRequirement::where('student_id', $user->id)->orderBy('created_at','desc')->get();
            $onboardingKeys = ['Internship Application Form','Letter of Acceptance','Parental Consent','School ID','Government ID','Vaccination Card','Medical Report','Insurance'];
            $onboardingReports = $allSubmitted->filter(fn($r) => collect($onboardingKeys)->contains(fn($k) => stripos($r->title, $k) !== false));
            $dailyReports = $allSubmitted->filter(fn($r) => !collect($onboardingKeys)->contains(fn($k) => stripos($r->title, $k) !== false));
            // Build a map of title => latest submission for resubmit check
            $latestByTitle = $allSubmitted->groupBy(fn($r) => strtolower(trim($r->title)))
                ->map(fn($group) => $group->sortByDesc('created_at')->first());
        ?>
        <div class="space-y-6">

            <!-- Onboarding Requirements Cabinet -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">📂 Onboarding Requirements</h3>
                @if($onboardingReports->isNotEmpty())
                <div class="space-y-3">
                    @foreach($onboardingReports as $req)
                    <div class="bg-slate-700/30 rounded-lg p-3 border-l-4
                        @if($req->status==='approved') border-green-500
                        @elseif($req->status==='denied') border-red-500
                        @else border-yellow-500 @endif">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <p class="text-gray-300 font-semibold text-sm">{{ $req->title }}</p>
                                <p class="text-gray-400 text-xs">{{ $req->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($req->status==='approved') bg-green-500/20 text-green-400
                                @elseif($req->status==='denied') bg-red-500/20 text-red-400
                                @else bg-yellow-500/20 text-yellow-400 @endif">
                                {{ ucfirst($req->status) }}
                            </span>
                        </div>
                        @if($req->feedback)
                        <p class="text-gray-400 text-xs mt-2 bg-slate-800/50 p-2 rounded border-l border-blue-500"><strong>Feedback:</strong> {{ $req->feedback }}</p>
                        @endif
                        @if($req->file_path)
                        <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" class="inline-flex items-center gap-1 text-blue-400 hover:text-blue-300 text-xs mt-2">📎 View File</button>
                        @endif
                        @if($req->status === 'denied')
                            @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                            @if($latestForThis && $latestForThis->id === $req->id)
                            <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" class="inline-flex items-center gap-1 text-orange-400 hover:text-orange-300 text-xs mt-2 ml-2">&#8635; Resubmit</button>
                            @else
                            <span class="inline-flex items-center gap-1 text-gray-500 text-xs mt-2 ml-2 cursor-not-allowed" title="Already resubmitted">&#8635; Resubmitted</span>
                            @endif
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-6 text-sm">No onboarding documents submitted yet.</p>
                @endif
            </div>

            <!-- Daily Submissions Cabinet -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Daily Submissions</h3>
                    <button type="button" onclick="openUploadModal('')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold">+ Upload Report</button>
                </div>
                @if($dailyReports->isNotEmpty())
                <div class="space-y-3">
                    @foreach($dailyReports as $req)
                    <div class="bg-slate-700/30 rounded-lg p-3 border-l-4
                        @if($req->status==='approved') border-green-500
                        @elseif($req->status==='denied') border-red-500
                        @else border-yellow-500 @endif">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <p class="text-gray-300 font-semibold text-sm">{{ $req->title }}</p>
                                <p class="text-gray-400 text-xs">{{ $req->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($req->status==='approved') bg-green-500/20 text-green-400
                                @elseif($req->status==='denied') bg-red-500/20 text-red-400
                                @else bg-yellow-500/20 text-yellow-400 @endif">
                                {{ ucfirst($req->status) }}
                            </span>
                        </div>
                        @if($req->feedback)
                        <p class="text-gray-400 text-xs mt-2 bg-slate-800/50 p-2 rounded border-l border-blue-500"><strong>Feedback:</strong> {{ $req->feedback }}</p>
                        @endif
                        @if($req->file_path)
                        <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" class="inline-flex items-center gap-1 text-blue-400 hover:text-blue-300 text-xs mt-2">📎 View File</button>
                        @endif
                        @if($req->status === 'denied')
                            @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                            @if($latestForThis && $latestForThis->id === $req->id)
                            <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" class="inline-flex items-center gap-1 text-orange-400 hover:text-orange-300 text-xs mt-2 ml-2">&#8635; Resubmit</button>
                            @else
                            <span class="inline-flex items-center gap-1 text-gray-500 text-xs mt-2 ml-2 cursor-not-allowed" title="Already resubmitted">&#8635; Resubmitted</span>
                            @endif
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-6 text-sm">No daily reports submitted yet.</p>
                @endif
            </div>

        </div>
        </section><!-- end reports -->

    </div><!-- end inner px wrapper -->
    </div><!-- end main-content -->

    <!-- ===== FILE VIEWER MODAL ===== -->
    <div id="fileViewerModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/80 p-4" onclick="if(event.target===this)closeFileViewer()">
        <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span id="fileViewerTitle" class="text-sm font-semibold text-white truncate">File Preview</span>
                <div class="flex items-center gap-2">
                    <a id="fileViewerDownload" href="#" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">⬇ Open / Download</a>
                    <button onclick="closeFileViewer()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg leading-none">✕</button>
                </div>
            </div>
            <div id="fileViewerBody" class="flex-1 overflow-auto flex items-center justify-center p-4 min-h-[300px]"></div>
        </div>
    </div>
    <!-- ===== END FILE VIEWER MODAL ===== -->

    <!-- ===== UPLOAD MODAL ===== -->
    <div id="uploadModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-white">📤 Upload Requirement</h3>
                <button type="button" onclick="closeUploadModal()" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
            </div>
            <form method="POST" action="{{ route('upload-requirement') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="return validateUploadForm(this)">
                @csrf
                <input type="hidden" name="student_id" value="{{ $user->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title *</label>
                <input type="text" name="title" id="modal_req_title" required maxlength="255"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none"
                        placeholder="e.g., Narrative Report, Resume">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description (Optional)</label>
                    <textarea name="description" rows="2" maxlength="1000"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none"
                        placeholder="Brief description..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">File *</label>
                    <input type="file" name="file[]" id="modal_req_file"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp"
                        onchange="handleFileSelect(this, 5)"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 cursor-pointer">
                    <small id="modal_file_hint" class="text-gray-400 block mt-1">PDF, Word, Images/Files &mdash; Max <strong>5 MB</strong> each</small>
                    <!-- Selected files preview -->
                    <div id="modal_file_preview" class="hidden mt-2 space-y-1"></div>
                    <p id="modal_file_error" class="text-red-400 text-xs mt-1 hidden"></p>
                    @error('file')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="button" onclick="closeUploadModal()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all">Upload</button>
                </div>
            </form>
        </div>
    </div>
    <!-- ===== END UPLOAD MODAL ===== -->

    <!-- OT Summary Modal (shown before final time-out) -->
    <div id="otSummaryModal" class="hidden fixed inset-0 z-[70] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <h3 class="text-lg font-bold text-white mb-4 text-center">📊 Time Summary</h3>
            <div class="grid grid-cols-3 gap-3 text-center mb-5">
                <div class="bg-slate-700/60 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Session</p>
                    <p id="otSessionHours" class="text-xl font-bold text-white">0.00</p>
                    <p class="text-xs text-gray-500">hrs</p>
                </div>
                <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Regular</p>
                    <p id="otRegularHours" class="text-xl font-bold text-green-400">0.00</p>
                    <p class="text-xs text-gray-500">hrs</p>
                </div>
                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">OT</p>
                    <p id="otOvertimeHours" class="text-xl font-bold text-yellow-400">0.00</p>
                    <p class="text-xs text-gray-500">hrs</p>
                </div>
            </div>
            <p id="otMessage" class="text-center text-sm text-gray-400 mb-5"></p>
            <div class="flex gap-3">
                <button onclick="closeOtSummary()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold">Cancel</button>
                <button onclick="confirmTimeOut()" class="flex-1 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold">Confirm Time Out</button>
            </div>
        </div>
    </div>

    <!-- Timeout Options Modal (choose how to time out) -->
    <div id="timeoutOptionsModal" class="hidden fixed inset-0 z-40 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-slate-900 rounded-xl max-w-lg w-full p-6 border border-slate-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Time Out Options</h3>
                <button type="button" id="closeTimeoutOptions" onclick="closeTimeoutOptionsModal(); return false;" class="text-gray-400 hover:text-white">✕</button>
            </div>
 
            <div class="flex flex-col gap-3">
                <button type="button" id="quickTimeoutBtn" onclick="handleQuickTimeout(); return false;" class="w-full px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold">Quick Time-out</button>
                <button type="button" id="cancelTimeoutOptions" onclick="closeTimeoutOptionsModal(); return false;" class="w-full px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Camera Modal (shared for Time In / Time Out) -->
    <div id="cameraModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-slate-900 rounded-xl max-w-2xl w-full p-6 border border-slate-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white" id="cameraModalTitle">Capture Photo</h3>
                <button type="button" id="closeCameraModal" class="text-gray-400 hover:text-white">✕</button>
            </div>

            <!-- Fixed-size media container so capture/preview do not change layout -->
            <div class="relative mb-4 rounded-lg overflow-hidden border-2 border-dashed border-slate-600 h-64">
                <video id="cameraModalVideo" class="w-full h-full object-cover camera-video" playsinline webkit-playsinline autoplay muted></video>
                <img id="cameraModalImage" src="" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover">
            </div>

            <!-- Capture control only -->
            <div class="flex gap-2 mb-4">
                <button type="button" id="cameraModalCaptureBtn" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">📸 Capture</button>
            </div>

            <!-- Preview area with Retake + Use Photo below the image -->
            <div id="cameraModalPreview" class="hidden">
                <p class="text-xs text-gray-400 mb-2">Captured:</p>
                <div class="flex gap-2 mt-2">
                    <button type="button" id="cameraModalRetakeBtn" class="flex-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-semibold hidden">Retake</button>
                    <button type="button" id="cameraModalUseBtn" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold hidden">Use Photo</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============ TIME DISPLAY ============
        function updateCurrentTime() {
            const el = document.getElementById('currentTime');
            if (!el) return;
            el.textContent = new Date().toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true });
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Auto-reload at 12:00 (morning auto-timeout) and 12:50 (afternoon time-in opens)
        (function() {
            function msUntil(h, m) {
                const now = new Date();
                const target = new Date();
                target.setHours(h, m, 0, 0);
                if (target <= now) return null;
                return target - now;
            }
            const t1 = msUntil(12, 0);   // noon: morning auto-timeout fires
            const t2 = msUntil(12, 50);  // 12:50: afternoon time-in button opens
            if (t1 !== null) setTimeout(() => location.reload(), t1);
            if (t2 !== null) setTimeout(() => location.reload(), t2);
        })();

        // ============ AUTO SET TIME IN ============
        const autoSetTimeInBtn = document.getElementById('autoSetTimeIn');
        if (autoSetTimeInBtn) {
            autoSetTimeInBtn.addEventListener('click', () => {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                document.getElementById('timeIn').value = `${hours}:${minutes}`;
            });
        }

        // ============ SET CURRENT TIME FOR TIME OUT ============
        const setCurrentTimeBtn = document.getElementById('setCurrentTimeBtn');
        if (setCurrentTimeBtn) {
            setCurrentTimeBtn.addEventListener('click', () => {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                document.getElementById('timeOut').value = `${hours}:${minutes}`;
            });
        }

        // ============ CAMERA (modal) ============
        let cameraStream = null;
        let cameraPhoto = null;
        let captureTarget = null; // 'timein' | 'timeout'
        const cameraCanvas = document.createElement('canvas');

        async function startCamera() {
            const cameraModalVideo = document.getElementById('cameraModalVideo');
            const cameraModalCaptureBtn = document.getElementById('cameraModalCaptureBtn');
            if (!cameraModalVideo) return;

            // Build getUserMedia function — supports all browsers including Edge
            let getMedia = null;
            if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
                getMedia = (c) => navigator.mediaDevices.getUserMedia(c);
            } else {
                // Legacy prefixed versions (older Edge, Firefox, Chrome)
                const legacyGUM = navigator.getUserMedia
                    || navigator.webkitGetUserMedia
                    || navigator.mozGetUserMedia
                    || navigator.msGetUserMedia;
                if (legacyGUM) {
                    getMedia = (c) => new Promise((res, rej) => legacyGUM.call(navigator, c, res, rej));
                }
            }

            // Last resort for Edge: try creating mediaDevices manually
            if (!getMedia && window.MediaStreamTrack && window.MediaStreamTrack.getSources) {
                getMedia = (c) => new Promise((res, rej) => {
                    navigator.getUserMedia(c, res, rej);
                });
            }

            if (!getMedia) {
                alert('Camera is not available.\n\nIf you are using Edge:\n• Click the \ud83d\udd12 lock icon in the address bar\n• Set Camera to \'Allow\'\n• Reload the page\n\nOr try opening this page in Chrome.');
                return;
            }

            // Constraint sets: front camera preferred, fallback to any camera
            const constraintSets = [
                { video: { facingMode: { ideal: 'user' }, width: { ideal: 1280 }, height: { ideal: 720 } }, audio: false },
                { video: { facingMode: 'user' }, audio: false },
                { video: { facingMode: { ideal: 'environment' } }, audio: false },
                { video: true, audio: false },
            ];

            let lastError = null;
            for (const constraints of constraintSets) {
                try {
                    cameraStream = await getMedia(constraints);
                    break;
                } catch (err) {
                    lastError = err;
                    if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') break;
                }
            }

            if (!cameraStream) {
                const err = lastError;
                const isEdge = navigator.userAgent.includes('Edg/');
                let msg = 'Unable to access camera.\n';
                if (!err || err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    msg += 'Camera permission was denied.\n\n';
                    if (isEdge) {
                        msg += 'Edge fix: Click the 🔒 lock icon in the address bar → Camera → Allow → Reload the page.';
                    } else {
                        msg += 'To fix:\n• iOS Safari: Settings → Safari → Camera → Allow\n• Android Chrome: tap the 🔒 icon in the address bar → Camera → Allow\n• Desktop: click the camera icon in the address bar and allow access, then reload.';
                    }
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    msg += 'No camera device was found on this device.';
                } else if (err.name === 'NotReadableError' || err.name === 'TrackStartError') {
                    msg += 'Camera is already in use by another app. Please close other apps using the camera and try again.';
                } else if (err.name === 'OverconstrainedError') {
                    msg += 'Camera does not meet the required settings. Try reloading.';
                } else {
                    msg += (err.message || 'Unknown error') + '.\nTry reloading the page.';
                }
                alert(msg);
                return;
            }

            try {
                cameraModalVideo.srcObject = cameraStream;
                cameraModalVideo.setAttribute('playsinline', 'true');  // critical for iOS Safari
                cameraModalVideo.setAttribute('webkit-playsinline', 'true'); // older iOS
                cameraModalVideo.setAttribute('autoplay', '');
                cameraModalVideo.setAttribute('muted', '');
                cameraModalVideo.muted = true;
                cameraModalVideo.playsInline = true;
                await cameraModalVideo.play();
                if (cameraModalCaptureBtn) {
                    cameraModalCaptureBtn.disabled = false;
                    cameraModalCaptureBtn.textContent = '📸 Capture';
                    cameraModalCaptureBtn.onclick = null;
                }
            } catch (err) {
                // Some browsers (iOS) need explicit user gesture to play
                if (cameraModalCaptureBtn) {
                    cameraModalCaptureBtn.disabled = false;
                    cameraModalCaptureBtn.textContent = '▶ Tap to Start Camera';
                    cameraModalCaptureBtn.onclick = async () => {
                        try { await cameraModalVideo.play(); } catch(e) {}
                        cameraModalCaptureBtn.textContent = '📸 Capture';
                        cameraModalCaptureBtn.onclick = null;
                    };
                }
            }
        }
        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(t => t.stop());
                cameraStream = null;
            }
            const cameraModalVideo = document.getElementById('cameraModalVideo');
            if (cameraModalVideo) {
                cameraModalVideo.pause();
                cameraModalVideo.srcObject = null;
            }
            const cameraModalCaptureBtn = document.getElementById('cameraModalCaptureBtn');
            if (cameraModalCaptureBtn) cameraModalCaptureBtn.disabled = true;
        }

        function openCameraModal(target) {
            console.log('=== openCameraModal called with:', target, '===');
            
            captureTarget = target;
            const modal = document.getElementById('cameraModal');
            
            if (!modal) {
                console.error('Camera modal element not found!');
                alert('Camera modal not found. Please refresh the page.');
                return;
            }
            
            console.log('Modal element found:', modal);
            console.log('Modal display before:', window.getComputedStyle(modal).display);
            
            // Show modal - remove hidden class
            modal.classList.remove('hidden');
            console.log('Removed hidden class from modal');
            console.log('Modal display after:', window.getComputedStyle(modal).display);
            console.log('Modal classes after:', modal.className);
            
            // Set title
            const title = document.getElementById('cameraModalTitle');
            if (title) {
                title.textContent = target === 'timein' ? 'Capture Photo for Time In' : 'Capture Photo for Time Out';
                console.log('Modal title set to:', title.textContent);
            }
            
            // Show capture button, hide others
            const captureBtn = document.getElementById('cameraModalCaptureBtn');
            if (captureBtn) {
                captureBtn.classList.remove('hidden');
                captureBtn.disabled = false;
                console.log('Capture button shown and enabled');
            }
            
            const retakeBtn = document.getElementById('cameraModalRetakeBtn');
            if (retakeBtn) {
                retakeBtn.classList.add('hidden');
            }
            
            const useBtn = document.getElementById('cameraModalUseBtn');
            if (useBtn) {
                useBtn.classList.add('hidden');
            }
            
            const preview = document.getElementById('cameraModalPreview');
            if (preview) {
                preview.classList.add('hidden');
            }
            
            const videoEl = document.getElementById('cameraModalVideo');
            const imgEl = document.getElementById('cameraModalImage');
            if (videoEl) {
                videoEl.classList.remove('hidden');
                console.log('Video element shown');
            }
            if (imgEl) {
                imgEl.classList.add('hidden');
            }
            
            cameraPhoto = null;
            
            console.log('About to call startCamera()');
            startCamera();
            console.log('startCamera() completed');
        }
        function closeCameraModal() {
            const cameraModal = document.getElementById('cameraModal');
            const cameraModalImage = document.getElementById('cameraModalImage');
            const cameraModalVideo = document.getElementById('cameraModalVideo');
            const cameraModalPreview = document.getElementById('cameraModalPreview');
            const cameraModalRetakeBtn = document.getElementById('cameraModalRetakeBtn');
            const cameraModalUseBtn = document.getElementById('cameraModalUseBtn');
            const cameraModalCaptureBtn = document.getElementById('cameraModalCaptureBtn');
            
            if (cameraModal) cameraModal.classList.add('hidden');
            stopCamera();
            // reset UI
            if (cameraModalImage) cameraModalImage.src = '';
            cameraModalImage?.classList.add('hidden');
            cameraModalVideo?.classList.remove('hidden');
            cameraModalPreview?.classList.add('hidden');
            cameraModalRetakeBtn?.classList.add('hidden');
            cameraModalUseBtn?.classList.add('hidden');
            cameraModalCaptureBtn?.classList.remove('hidden');
            cameraPhoto = null;
            captureTarget = null;
        }

        // ============ OT SUMMARY MODAL ============
        let pendingTimeOutSubmit = false;

        function openOtSummaryModal(sessionHours, previousDayHours) {
            const totalDay   = Math.round((previousDayHours + sessionHours) * 100) / 100;
            const regular    = Math.min(totalDay, 8);
            const ot         = Math.max(0, Math.round((totalDay - 8) * 100) / 100);

            document.getElementById('otSessionHours').textContent  = sessionHours.toFixed(2);
            document.getElementById('otRegularHours').textContent  = regular.toFixed(2);
            document.getElementById('otOvertimeHours').textContent = ot.toFixed(2);

            const msg = ot > 0
                ? `Great work! You have ${ot.toFixed(2)} hrs of overtime today.`
                : `You worked ${totalDay.toFixed(2)} hrs today. No overtime.`;
            document.getElementById('otMessage').textContent = msg;

            document.getElementById('otSummaryModal').classList.remove('hidden');
        }
        function closeOtSummary() {
            document.getElementById('otSummaryModal').classList.add('hidden');
            pendingTimeOutSubmit = false;
        }
        function confirmTimeOut() {
            document.getElementById('otSummaryModal').classList.add('hidden');
            const form = document.getElementById('timeOutForm');
            if (form) {
                if (typeof form.requestSubmit === 'function') form.requestSubmit();
                else form.submit();
            }
        }

        // ============ TIMEOUT OPTIONS (alternate flow) ============
        function openTimeoutOptionsModal() {
            const m = document.getElementById('timeoutOptionsModal');
            if (m) m.classList.remove('hidden');
        }
        function closeTimeoutOptionsModal() {
            const m = document.getElementById('timeoutOptionsModal');
            if (m) m.classList.add('hidden');
        }
        function handleQuickTimeout() {
            const timeOutInput = document.getElementById('timeOut');
            if (timeOutInput) {
                const now = new Date();
                const hh = String(now.getHours()).padStart(2,'0');
                const mm = String(now.getMinutes()).padStart(2,'0');
                timeOutInput.value = `${hh}:${mm}`;

                // Calculate session hours for OT summary
                try {
                    const timeInEl  = document.getElementById('todayTimeIn');
                    const timeInStr = timeInEl ? timeInEl.dataset.time : null;
                    if (timeInStr) {
                        const parts = timeInStr.split(':');
                        const inDate = new Date();
                        inDate.setHours(parseInt(parts[0],10), parseInt(parts[1],10), 0, 0);
                        const sessionMins = Math.max(0, Math.floor((now - inDate) / 60000));
                        const sessionHrs  = Math.round((sessionMins / 60) * 100) / 100;
                        const prevHours   = {{ $totalDayHours ?? 0 }};
                        closeTimeoutOptionsModal();
                        openOtSummaryModal(sessionHrs, prevHours);
                        return;
                    }
                } catch (err) {
                    console.warn('OT calc error', err);
                }
            }
            closeTimeoutOptionsModal();
            confirmTimeOut();
        }
        function updateProgressAfterTimeout(hours) {
            // Update displayed completed and remaining hours and progress percent
            try {
                const completedEl = document.getElementById('completedHours');
                const remainingEl = document.getElementById('remainingHours');
                const percentEl = document.getElementById('progressPercent');
                const progressFill = document.getElementById('progressFill');

                if (!completedEl || !remainingEl || !percentEl || !progressFill) return;

                // completed element shows like "12.00/600"
                const text = completedEl.textContent || '';
                const parts = text.split('/');
                let completed = parseFloat(parts[0]) || 0;
                const total = parseFloat(parts[1]) || {{ $required }};

                completed = Math.round((completed + hours) * 100) / 100;
                const remaining = Math.max(0, Math.round((total - completed) * 100) / 100);
                const percent = total > 0 ? Math.round((completed / total) * 10000) / 100 : 0;

                completedEl.textContent = completed.toFixed(2) + '/' + total;
                remainingEl.textContent = remaining.toFixed(2);
                percentEl.textContent = percent.toFixed(2) + '%';
                progressFill.style.width = Math.max(1, Math.min(percent, 100)) + '%';
            } catch (err) {
                console.error('updateProgressAfterTimeout error', err);
            }
        }
        function handleTimeoutWithPhoto() {
            closeTimeoutOptionsModal();
            // open existing camera modal flow
            openCameraModal('timeout');
        }

        // Attach listeners after DOM ready and with guards + logs
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Initializing camera controls');
            
            // Get DOM elements
            const cameraModalCaptureBtn = document.getElementById('cameraModalCaptureBtn');
            const cameraModalUseBtn = document.getElementById('cameraModalUseBtn');
            const cameraModalRetakeBtn = document.getElementById('cameraModalRetakeBtn');
            const cameraModalImage = document.getElementById('cameraModalImage');
            const cameraModalVideo = document.getElementById('cameraModalVideo');
            const cameraModalPreview = document.getElementById('cameraModalPreview');
            
            // Add listener for Time Out button: open options modal
            const timeOutBtn = document.getElementById('timeOutBtn');
            if (timeOutBtn) {
                console.log('timeOutBtn found, adding click listener to open options modal');
                timeOutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('timeOutBtn clicked, opening Timeout Options');
                    openTimeoutOptionsModal();
                });
            } else {
                console.warn('timeOutBtn not found in DOM');
            }

            // Wire up Timeout Options modal buttons
            const quickTimeoutBtn = document.getElementById('quickTimeoutBtn');
            const photoTimeoutBtn = document.getElementById('photoTimeoutBtn');
            const closeTimeoutOptionsBtn = document.getElementById('closeTimeoutOptions');
            const cancelTimeoutOptionsBtn = document.getElementById('cancelTimeoutOptions');

            if (quickTimeoutBtn) quickTimeoutBtn.addEventListener('click', (e) => { e.preventDefault(); handleQuickTimeout(); });
            if (photoTimeoutBtn) photoTimeoutBtn.addEventListener('click', (e) => { e.preventDefault(); handleTimeoutWithPhoto(); });
            if (closeTimeoutOptionsBtn) closeTimeoutOptionsBtn.addEventListener('click', (e) => { e.preventDefault(); closeTimeoutOptionsModal(); });
            if (cancelTimeoutOptionsBtn) cancelTimeoutOptionsBtn.addEventListener('click', (e) => { e.preventDefault(); closeTimeoutOptionsModal(); });
            
            const openCameraForTimeInBtn = document.getElementById('openCameraForTimeIn');
            if (openCameraForTimeInBtn) {
                openCameraForTimeInBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('openCameraForTimeIn clicked');
                    openCameraModal('timein');
                });
            }
            const openCameraForTimeOutBtn = document.getElementById('openCameraForTimeOut');
            if (openCameraForTimeOutBtn) {
                openCameraForTimeOutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('openCameraForTimeOut clicked');
                    openCameraModal('timeout');
                });
            }
            const closeCameraModalBtn = document.getElementById('closeCameraModal');
            if (closeCameraModalBtn) closeCameraModalBtn.addEventListener('click', (e) => { e.preventDefault(); closeCameraModal(); });

            if (cameraModalCaptureBtn) {
                cameraModalCaptureBtn.addEventListener('click', () => {
                    try {
                        cameraCanvas.width = cameraModalVideo.videoWidth || 640;
                        cameraCanvas.height = cameraModalVideo.videoHeight || 480;
                        const ctx = cameraCanvas.getContext('2d');
                        // flip horizontally
                        ctx.save();
                        ctx.scale(-1, 1);
                        ctx.drawImage(cameraModalVideo, -cameraCanvas.width, 0, cameraCanvas.width, cameraCanvas.height);
                        ctx.restore();
                        cameraPhoto = cameraCanvas.toDataURL('image/jpeg', 0.9);

                        // show captured image inside the fixed media box (keeps size)
                        cameraModalImage.src = cameraPhoto;
                        cameraModalImage.classList.remove('hidden');
                        cameraModalVideo.classList.add('hidden');

                        // reveal preview controls (Retake + Use) below the box
                        cameraModalPreview.classList.remove('hidden');
                        cameraModalRetakeBtn.classList.remove('hidden');
                        cameraModalUseBtn.classList.remove('hidden');

                        // hide capture button and stop live feed
                        cameraModalCaptureBtn.classList.add('hidden');
                        stopCamera();
                    } catch (err) {
                        console.error('capture error', err);
                        alert('Capture failed. Check camera and try again.');
                    }
                });
            } else {
                console.warn('cameraModalCaptureBtn not found');
            }

            if (cameraModalUseBtn) {
                cameraModalUseBtn.addEventListener('click', async () => {
                    if (!cameraPhoto) return;
                    // compute time string
                    const now = new Date();
                    const hh = String(now.getHours()).padStart(2,'0');
                    const mm = String(now.getMinutes()).padStart(2,'0');
                    const timeShort = `${hh}:${mm}`;

                    // disable to prevent double-clicks
                    cameraModalUseBtn.disabled = true;

                    if (captureTarget === 'timein') {
                        // Auto-submit time-in via AJAX
                        const fd = new FormData();
                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('student_id', '{{ $user->id }}');
                        fd.append('date', '{{ $today }}');
                        fd.append('time_in', timeShort);
                        fd.append('session', 'morning');
                        fd.append('photo_base64', cameraPhoto);

                        try {
                            const resp = await fetch('{{ route("time-in") }}', { method: 'POST', body: fd });
                            if (resp.ok) {
                                closeCameraModal();
                                showSuccess('Time-in recorded successfully!', null, true);
                                return;
                            } else {
                                const txt = await resp.text();
                                console.error('Time-in failed', resp.status, txt);
                                alert('Failed to record Time In. Please try again.');
                            }
                        } catch (err) {
                            console.error(err);
                            alert('Camera submission error. Check console and try again.');
                        } finally {
                            cameraModalUseBtn.disabled = false;
                        }
                    } else if (captureTarget === 'afternoon') {
                        // Afternoon session time-in
                        const fd = new FormData();
                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('student_id', '{{ $user->id }}');
                        fd.append('date', '{{ $today }}');
                        fd.append('time_in', timeShort);
                        fd.append('session', 'afternoon');
                        fd.append('photo_base64', cameraPhoto);

                        try {
                            const resp = await fetch('{{ route("time-in") }}', { method: 'POST', body: fd });
                            if (resp.ok) {
                                closeCameraModal();
                                showSuccess('Afternoon session time-in recorded!', null, true);
                                return;
                            } else {
                                alert('Failed to record afternoon time-in. Please try again.');
                            }
                        } catch (err) {
                            console.error(err);
                            alert('Camera submission error.');
                        } finally {
                            cameraModalUseBtn.disabled = false;
                        }
                    } else if (captureTarget === 'timeout') {
                        console.log('Processing timeout capture');
                        
                        const timeOutPhotoBase64Input = document.getElementById('timeOutPhotoBase64');
                        const timeOutInput = document.getElementById('timeOut');
                        const timeOutForm = document.getElementById('timeOutForm');
                        
                        console.log('timeOutPhotoBase64Input:', timeOutPhotoBase64Input);
                        console.log('timeOutInput:', timeOutInput);
                        console.log('timeOutForm:', timeOutForm);
                        
                        if (!timeOutPhotoBase64Input || !timeOutInput || !timeOutForm) {
                            console.error('Missing timeout form elements!');
                            alert('Error: Form elements not found. Please refresh the page.');
                            cameraModalUseBtn.disabled = false;
                            return;
                        }
                        
                        timeOutPhotoBase64Input.value = cameraPhoto;
                        timeOutInput.value = timeShort;

                        // update UI immediately with approximate hours worked
                        try {
                            const timeInEl2 = document.getElementById('todayTimeIn');
                            const timeInStr2 = timeInEl2 ? timeInEl2.dataset.time : null;
                            if (timeInStr2) {
                                const p = timeInStr2.split(':');
                                if (p.length >= 2) {
                                    const ih = parseInt(p[0], 10);
                                    const im = parseInt(p[1], 10);
                                    const inDate2 = new Date();
                                    inDate2.setHours(ih, im, 0, 0);
                                    const now2 = new Date();
                                    const minsWorked2 = Math.max(0, Math.floor((now2 - inDate2) / 60000));
                                    const hrsWorked2 = Math.round((minsWorked2 / 60) * 100) / 100;
                                    console.log('Camera timeout approximate hoursWorked:', hrsWorked2);
                                    updateProgressAfterTimeout(hrsWorked2);
                                }
                            }
                        } catch (err) {
                            console.warn('Could not compute immediate hours for camera timeout UI update', err);
                        }
                        
                        console.log('Form values set:', {
                            photo_base64: timeOutPhotoBase64Input.value.substring(0, 50) + '...',
                            time_out: timeOutInput.value
                        });
                        
                        closeCameraModal();
                        
                        try {
                            console.log('Submitting timeout form...');
                            if (timeOutForm && typeof timeOutForm.requestSubmit === 'function') {
                                timeOutForm.requestSubmit();
                            } else if (timeOutForm) {
                                timeOutForm.submit();
                            }
                            console.log('Form submit called');
                        } catch (err) {
                            console.error('Error submitting form:', err);
                            alert('Error submitting form: ' + err.message);
                            cameraModalUseBtn.disabled = false;
                        }
                    }
                });
            }

            if (cameraModalRetakeBtn) {
                cameraModalRetakeBtn.addEventListener('click', () => {
                    // hide captured image, hide preview controls, show live feed and capture button
                    cameraPhoto = null;
                    cameraModalImage.src = '';
                    cameraModalImage.classList.add('hidden');
                    cameraModalPreview.classList.add('hidden');
                    cameraModalRetakeBtn.classList.add('hidden');
                    cameraModalUseBtn.classList.add('hidden');
                    cameraModalCaptureBtn.classList.remove('hidden');
                    cameraModalVideo.classList.remove('hidden');
                    // restart camera feed
                    startCamera();
                });
            }

            // --- requirement polling (refresh progress if changed) ---
            let studentReq = {{ $required }};
            function refreshProgress(newReq) {
                const completedText = document.getElementById('completedHours')?.textContent || '';
                const completed = parseFloat(completedText.split('/')[0]) || 0;
                const remaining = Math.max(0, newReq - completed);
                const percent = newReq > 0 ? (completed / newReq) * 100 : 0;
                document.getElementById('completedHours').textContent = completed.toFixed(2) + '/' + newReq;
                document.getElementById('remainingHours').textContent = remaining.toFixed(2);
                document.getElementById('progressPercent').textContent = percent.toFixed(2) + '%';
                document.getElementById('progressFill').style.width = Math.max(1, Math.min(percent, 100)) + '%';
            }
            function checkRequirement() {
                fetch('/api/settings')
                    .then(r => r.json())
                    .then(o => {
                        if (o.required_hours && o.required_hours != studentReq) {
                            studentReq = o.required_hours;
                            refreshProgress(studentReq);
                        }
                    })
                    .catch(e => console.error('requirement poll error', e));
            }
            setInterval(checkRequirement, 30000);

        });

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
            timein: '⏱️ Time In / Out',
            history: '📅 Attendance History',
            requirements: '📁 Requirements',
            reports: '📋 Reports'
        };

        function showSection(name) {
            // hide all
            document.querySelectorAll('.dash-section').forEach(s => s.classList.add('hidden'));
            // show target
            const target = document.getElementById('section-' + name);
            if (target) { target.classList.remove('hidden'); target.classList.add('dash-section'); }
            // update active nav
            document.querySelectorAll('.nav-item[data-section]').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.section === name);
            });
            // update header title
            const titleEl = document.getElementById('header-section-title');
            if (titleEl) titleEl.textContent = sectionTitles[name] || name;
            // close mobile sidebar
            closeSidebar();
            // persist
            localStorage.setItem('activeSection', name);
        }

        // restore on load
        (function() {
            const saved = localStorage.getItem('activeSection') || 'overview';
            showSection(saved);
            // restore collapse state
            if (localStorage.getItem('sidebarCollapsed') === '1' && window.innerWidth >= 1024) {
                sidebarCollapsed = true;
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
                topHeader.style.left = '64px';
            }
        })();
        // ===== END SIDEBAR LOGIC =====

        // ===== FILE VIEWER MODAL =====
        function openFileViewer(url, title) {
            const modal = document.getElementById('fileViewerModal');
            const body  = document.getElementById('fileViewerBody');
            const dl    = document.getElementById('fileViewerDownload');
            const ttl   = document.getElementById('fileViewerTitle');
            ttl.textContent = title || 'File Preview';
            dl.href = url;
            body.innerHTML = '';
            const ext = url.split('?')[0].split('.').pop().toLowerCase();
            if (['jpg','jpeg','png','gif','webp','bmp'].includes(ext)) {
                const img = document.createElement('img');
                img.src = url;
                img.className = 'max-w-full max-h-[70vh] rounded-lg object-contain';
                body.appendChild(img);
            } else if (ext === 'pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.className = 'w-full rounded-lg border-0';
                iframe.style.height = '65vh';
                body.appendChild(iframe);
            } else {
                body.innerHTML = `<div class="text-center py-10">
                    <div class="text-5xl mb-4">📄</div>
                    <p class="text-gray-300 font-semibold mb-1">${title}</p>
                    <p class="text-gray-500 text-sm mb-4">Preview not available for this file type.</p>
                    <a href="${url}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold">Open File</a>
                </div>`;
            }
            modal.classList.remove('hidden');
        }
        function closeFileViewer() {
            document.getElementById('fileViewerModal').classList.add('hidden');
            document.getElementById('fileViewerBody').innerHTML = '';
        }
        // ===== END FILE VIEWER MODAL =====

        // ===== FILE SIZE VALIDATION =====
        let _selectedFiles = []; // accumulate files across selections
        let _maxFilesAllowed = 1;

        function handleFileSelect(input, maxMB) {
            const errEl = document.getElementById('modal_file_error');
            const preview = document.getElementById('modal_file_preview');
            if (errEl) errEl.classList.add('hidden');

            if (!input.files || !input.files.length) return;

            // Validate new files
            for (let i = 0; i < input.files.length; i++) {
                const f = input.files[i];
                const sizeMB = f.size / (1024 * 1024);
                if (sizeMB > maxMB) {
                    input.value = '';
                    if (errEl) { errEl.textContent = '"' + f.name + '" exceeds ' + maxMB + ' MB limit.'; errEl.classList.remove('hidden'); }
                    return;
                }
                // Avoid duplicates by name+size
                const exists = _selectedFiles.some(x => x.name === f.name && x.size === f.size);
                if (!exists) {
                    if (_selectedFiles.length >= _maxFilesAllowed) {
                        if (errEl) { errEl.textContent = 'Maximum ' + _maxFilesAllowed + ' file(s) allowed.'; errEl.classList.remove('hidden'); }
                        input.value = '';
                        return;
                    }
                    _selectedFiles.push(f);
                }
            }
            input.value = ''; // reset so same file can be re-added if removed
            renderFilePreview(preview);
        }

        function renderFilePreview(preview) {
            preview.innerHTML = '';
            if (!_selectedFiles.length) { preview.classList.add('hidden'); return; }
            preview.classList.remove('hidden');
            const header = document.createElement('p');
            header.className = 'text-xs text-gray-400 mb-1';
            header.textContent = _selectedFiles.length + ' file(s) selected:';
            preview.appendChild(header);
            _selectedFiles.forEach((f, idx) => {
                const sizeMB = (f.size / (1024 * 1024)).toFixed(2);
                const row = document.createElement('div');
                row.className = 'flex items-center gap-2 px-2 py-1 bg-slate-700/60 rounded text-xs';
                row.innerHTML =
                    '<span class="text-green-400 shrink-0">&#10003;</span>' +
                    '<span class="text-gray-200 truncate flex-1">' + (idx + 1) + '. ' + f.name + '</span>' +
                    '<span class="text-gray-400 shrink-0 mr-1">' + sizeMB + ' MB</span>' +
                    '<button type="button" onclick="removeSelectedFile(' + idx + ')" class="text-red-400 hover:text-red-300 shrink-0 font-bold">&times;</button>';
                preview.appendChild(row);
            });
        }

        function removeSelectedFile(idx) {
            _selectedFiles.splice(idx, 1);
            renderFilePreview(document.getElementById('modal_file_preview'));
        }

        function checkFileSize(input, maxMB) {
            return handleFileSelect(input, maxMB);
        }
        function validateUploadForm(form) {
            const errEl = document.getElementById('modal_file_error');
            // For multi-file: inject accumulated files into the input via DataTransfer
            const fileInput = form.querySelector('input[type="file"]');
            if (_selectedFiles.length > 0 && typeof DataTransfer !== 'undefined') {
                const dt = new DataTransfer();
                _selectedFiles.forEach(f => dt.items.add(f));
                fileInput.files = dt.files;
            }
            if (!fileInput.files || !fileInput.files.length) {
                if (errEl) { errEl.textContent = 'Please select at least one file.'; errEl.classList.remove('hidden'); }
                return false;
            }
            for (let i = 0; i < fileInput.files.length; i++) {
                const sizeMB = fileInput.files[i].size / (1024 * 1024);
                if (sizeMB > 5) {
                    if (errEl) { errEl.textContent = '"' + fileInput.files[i].name + '" exceeds 5 MB.'; errEl.classList.remove('hidden'); }
                    return false;
                }
            }
            // Show upload loading overlay
            showUploadLoader();
            return true;
        }
        // ===== END FILE SIZE VALIDATION =====

        // ===== UPLOAD LOADER =====
        function showUploadLoader() {
            document.getElementById('uploadLoader').classList.remove('hidden');
        }
        function hideUploadLoader() {
            document.getElementById('uploadLoader').classList.add('hidden');
        }
        // Safety: hide loader if page is restored from bfcache (back button)
        window.addEventListener('pageshow', hideUploadLoader);
        // ===== END UPLOAD LOADER =====

        // ===== UPLOAD MODAL =====
        function openUploadModal(title, maxFiles) {
            maxFiles = maxFiles || 1;
            _maxFilesAllowed = maxFiles;
            _selectedFiles = [];
            const titleInput = document.getElementById('modal_req_title');
            titleInput.value = title || '';
            // Lock title if it's a pre-defined onboarding item
            if (title) {
                titleInput.setAttribute('readonly', 'readonly');
                titleInput.classList.add('opacity-60', 'cursor-not-allowed');
            } else {
                titleInput.removeAttribute('readonly');
                titleInput.classList.remove('opacity-60', 'cursor-not-allowed');
            }
            const fileInput = document.getElementById('modal_req_file');
            const preview = document.getElementById('modal_file_preview');
            if (preview) { preview.innerHTML = ''; preview.classList.add('hidden'); }
            const errEl = document.getElementById('modal_file_error');
            if (errEl) errEl.classList.add('hidden');
            if (maxFiles > 1) {
                fileInput.setAttribute('multiple', 'multiple');
                document.getElementById('modal_file_hint').innerHTML =
                    'Images only &mdash; Max <strong>' + maxFiles + ' photos</strong>, 5 MB each. You can select files one by one.';
                fileInput.setAttribute('accept', '.jpg,.jpeg,.png,.gif,.webp');
            } else {
                fileInput.removeAttribute('multiple');
                document.getElementById('modal_file_hint').innerHTML =
                    'PDF, Word, Images/Files &mdash; Max <strong>5 MB</strong>';
                fileInput.setAttribute('accept', '.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp');
            }
            fileInput.value = '';
            document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('modal_req_title').focus();
        }
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            _selectedFiles = [];
            const preview = document.getElementById('modal_file_preview');
            if (preview) { preview.innerHTML = ''; preview.classList.add('hidden'); }
            const errEl = document.getElementById('modal_file_error');
            if (errEl) errEl.classList.add('hidden');
        }
        document.getElementById('uploadModal')?.addEventListener('click', function(e){ if(e.target===this) closeUploadModal(); });
        // ===== END UPLOAD MODAL =====

        // Confirm modal (logout / home)
        function showConfirm(type) {
            const icon = document.getElementById('confirmIcon');
            const title = document.getElementById('confirmTitle');
            const msg = document.getElementById('confirmMsg');
            const btn = document.getElementById('confirmBtn');
            if (type === 'logout') {
                icon.textContent = '🚪';
                title.textContent = 'Logout?';
                msg.textContent = 'You will be signed out of your account.';
                btn.textContent = 'Yes, Logout';
                btn.className = 'flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-green-600 hover:bg-green-700';
                btn.href = '/logout';
                btn.onclick = function() { _allowLeave = true; };
            } else {
                icon.textContent = '🏠';
                title.textContent = 'Go to Home?';
                msg.textContent = 'You will leave the dashboard and go to the landing page.';
                btn.textContent = 'Yes, Go Home';
                btn.className = 'flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-blue-600 hover:bg-blue-700';
                btn.href = '/';
                btn.onclick = function() { _allowLeave = true; };
            }
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        function closeConfirm() { document.getElementById('confirmModal').classList.add('hidden'); }
        document.getElementById('confirmModal')?.addEventListener('click', function(e){ if(e.target===this) closeConfirm(); });

        // ===== OVERVIEW CHARTS =====
        (function() {
            const progressVal = {{ $_progress }};
            const remaining = 100 - progressVal;
            // Donut: OJT Progress
            new Chart(document.getElementById('chartProgress'), {
                type: 'doughnut',
                data: {
                    datasets: [{ data: [progressVal, remaining],
                        backgroundColor: ['#22c55e','#1e293b'],
                        borderWidth: 0, hoverOffset: 4 }]
                },
                options: { cutout:'72%', plugins:{ legend:{display:false}, tooltip:{enabled:false} }, animation:{duration:900} }
            });

            // Bar: Hours last 7 days
            new Chart(document.getElementById('chartWeek'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($_last7Labels) !!},
                    datasets: [{ data: {!! json_encode($_last7) !!},
                        backgroundColor: 'rgba(34,197,94,0.7)',
                        borderRadius: 6, borderSkipped: false }]
                },
                options: {
                    plugins:{ legend:{display:false} },
                    scales:{
                        x:{ ticks:{color:'#94a3b8'}, grid:{display:false} },
                        y:{ ticks:{color:'#94a3b8'}, grid:{color:'rgba(148,163,184,0.1)'}, beginAtZero:true }
                    },
                    animation:{duration:900}
                }
            });

            // Doughnut: Reports Status
            const rCanvas = document.getElementById('chartReports');
            if (rCanvas) {
                new Chart(rCanvas, {
                    type: 'doughnut',
                    data: {
                        datasets: [{ data: [{{ $_reqApproved }}, {{ $_reqPending }}, {{ $_reqRejected }}],
                            backgroundColor: ['#22c55e','#facc15','#ef4444'],
                            borderWidth: 0, hoverOffset: 4 }]
                    },
                    options: { cutout:'72%', plugins:{ legend:{display:false}, tooltip:{enabled:false} }, animation:{duration:900} }
                });
            }
        })();
        // ===== END OVERVIEW CHARTS =====

        // ===== LEAVE PAGE CONFIRMATION =====
        let _allowLeave = true;
        // ===== END LEAVE PAGE CONFIRMATION =====

        // Theme toggle (global scope so onclick attribute works)
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
    </script>
    <!-- ===== UPLOAD LOADER OVERLAY ===== -->
    <div id="uploadLoader" class="hidden fixed inset-0 z-[200] flex flex-col items-center justify-center bg-black/75">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl px-10 py-8 flex flex-col items-center gap-5 shadow-2xl" style="box-shadow:0 0 40px rgba(34,197,94,0.2)">
            <!-- Animated spinner -->
            <div class="relative w-16 h-16">
                <svg class="w-16 h-16 animate-spin" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="28" stroke="#1e293b" stroke-width="6"/>
                    <path d="M32 4a28 28 0 0 1 28 28" stroke="#22c55e" stroke-width="6" stroke-linecap="round"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
            </div>
            <div class="text-center">
                <p class="text-green-400 font-bold text-sm tracking-widest">UPLOADING...</p>
                <p class="text-gray-400 text-xs mt-1">Please wait, do not close this page.</p>
            </div>
        </div>
    </div>
    <!-- ===== END UPLOAD LOADER OVERLAY ===== -->

</body>
</html>
