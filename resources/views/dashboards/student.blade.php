<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    @include('partials.pagination')
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
        /* LIGHT MODE - Beautiful soft design */
        body.light { background: #ffffff !important; color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) { background: rgba(255,255,255,0.95) !important; border-color: #d1dce6 !important; box-shadow: 0 2px 8px rgba(30,58,95,0.08) !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-green"] { color: #fff !important; }
        body.light h1,body.light h2,body.light h3,body.light h4,
        body.light p,body.light span,body.light label,body.light div,
        body.light td,body.light th,body.light li,body.light small { color: #2d4a6f; }
        body.light .text-white,body.light .text-gray-100,body.light .text-gray-200 { color: #1e3a5f !important; }
        body.light .text-gray-300 { color: #3d5a7f !important; }
        body.light .text-gray-400 { color: #4a6a8f !important; }
        body.light .text-gray-500 { color: #5a7a9f !important; }
        body.light .text-green-100,body.light .text-green-200,body.light .text-green-300,body.light .text-green-400 { color: #16a34a !important; }
        body.light .text-blue-100,body.light .text-blue-200,body.light .text-blue-300,body.light .text-blue-400 { color: #2563eb !important; }
        body.light .text-orange-100,body.light .text-orange-200,body.light .text-orange-300,body.light .text-orange-400 { color: #ea580c !important; }
        body.light .text-yellow-100,body.light .text-yellow-200,body.light .text-yellow-300,body.light .text-yellow-400 { color: #ca8a04 !important; }
        body.light .text-red-100,body.light .text-red-200,body.light .text-red-300,body.light .text-red-400 { color: #dc2626 !important; }
        body.light .text-purple-100,body.light .text-purple-200,body.light .text-purple-300,body.light .text-purple-400 { color: #7c3aed !important; }
        body.light .text-indigo-100,body.light .text-indigo-200,body.light .text-indigo-300,body.light .text-indigo-400 { color: #4f46e5 !important; }
        body.light .text-cyan-200,body.light .text-cyan-300,body.light .text-cyan-400 { color: #0891b2 !important; }
        body.light button[class*="bg-green-6"],body.light button[class*="bg-blue-6"],
        body.light button[class*="bg-red-6"],body.light button[class*="bg-orange-6"],
        body.light button[class*="bg-yellow-6"],body.light button[class*="bg-indigo-6"],
        body.light button[class*="bg-purple-6"],body.light a[class*="bg-green-6"],
        body.light a[class*="bg-blue-6"],body.light a[class*="bg-red-6"] { color: #fff !important; }
        body.light button.bg-indigo-600,body.light button.bg-indigo-700,
        body.light button.bg-red-600,body.light button.bg-red-700,
        body.light button.bg-blue-600,body.light button.bg-blue-700,
        body.light button.bg-green-600,body.light button.bg-green-700,
        body.light button.bg-orange-600,body.light button.bg-orange-700,
        body.light button.bg-purple-600,body.light button.bg-purple-700 { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; }
        body.light [class*="bg-slate-800"] { background: rgba(255,255,255,0.85) !important; box-shadow: 0 1px 3px rgba(30,58,95,0.08) !important; }
        body.light [class*="bg-slate-700"] { background: rgba(248,250,252,0.9) !important; }
        body.light [class*="bg-slate-600"]:not(button):not([type="button"]):not([type="submit"]) { background: #f1f5f9 !important; }
        body.light button[class*="bg-slate-600"], body.light [type="button"][class*="bg-slate-600"] { background: #64748b !important; color: #fff !important; }
        body.light [class*="border-slate-7"] { border-color: #cbd5e1 !important; }
        body.light [class*="border-slate-6"] { border-color: #cbd5e1 !important; }
        body.light [class*="divide-slate-7"] > * { border-color: #cbd5e1 !important; }
        body.light .border-green-500 { border-color: #22c55e !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.95) !important; border-color: #b8cfe0 !important; color: #1e3a5f !important; box-shadow: 0 1px 2px rgba(30,58,95,0.05) !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #7a9ab8 !important; }
        body.light input:focus,body.light textarea:focus,body.light select:focus { border-color: #22c55e !important; box-shadow: 0 0 0 3px rgba(34,197,94,0.1) !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,253,244,0.8) 100%) !important; border-color: #86efac !important; border-left: 4px solid #22c55e !important; box-shadow: 0 4px 12px rgba(34,197,94,0.08) !important; }
        body.light .header-info-card h1 { color: #1e3a5f !important; }
        body.light .header-info-card .subtitle { color: #5a7a9f !important; }
        body.light .header-info-card .stat-label { color: #5a7a9f !important; }
        body.light .header-info-card .stat-value-white { color: #1e3a5f !important; }
        body.light .header-info-card .stat-value-green { color: #16a34a !important; }
        body.light .header-info-card .stat-value-blue { color: #2563eb !important; }
        body.light .header-info-card .divider { background: #d1dce6 !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    @include('partials.dashboard-skeleton')

    <?php
        $_sh = \App\Models\StudentHours::where('student_id', $user->id)->first();
        $_required = $_sh ? $_sh->total_hours_required : 600;
        $_allRecordsTotal = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereNotNull('time_out')->where('status', 'approved')->get()
            ->sum(function($r){$i=\Carbon\Carbon::parse($r->time_in);$o=\Carbon\Carbon::parse($r->time_out);if($o->lte($i))$o->addDay();return max(0,$i->diffInMinutes($o))/60;});
        $_completed = $_sh ? $_sh->hours_completed : round($_allRecordsTotal, 2);
        // Pending hours = timed out but not yet approved (awaiting supervisor)
        $_pendingHours = round(\App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereNotNull('time_out')->where('status', 'pending')->get()
            ->sum(fn($r) => max(0, floatval($r->regular_hours ?? 0))), 2);
        $_progress = $_required > 0 ? min(100, round(($_completed / $_required) * 100, 1)) : 0;

        // ── Nav badge counts ──────────────────────────────────────────────
        // Time In/Out: records pending approval (timed out, awaiting review)
        $_navBadgeTimein = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereNotNull('time_out')->where('status', 'pending')->count();
        // Attendance History: denied records that may need attention
        $_navBadgeHistory = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->where('status', 'denied')->count();
        // Requirements: pending (awaiting approval) + denied (needs resubmission)
        $_navBadgeRequirements = \App\Models\StudentRequirement::where('student_id', $user->id)
            ->whereIn('status', ['pending', 'denied'])->count();
        // Reports / Narratives: remind the student when today's entry is missing
        $_today = \Carbon\Carbon::now('Asia/Manila')->toDateString();
        $_navBadgeReports = \App\Models\DailyNarrative::where('student_id', $user->id)
            ->whereDate('report_date', $_today)->doesntExist() ? 1 : 0;
    ?>

    @include('partials.success-popup')
    <div id="confirmModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 max-w-sm w-full shadow-2xl transform scale-100 transition-all">
            <div class="text-center mb-6">
                <div id="confirmIcon" class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/20 mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h3 id="confirmTitle" class="text-xl font-bold text-white mb-2">Are you sure?</h3>
                <p id="confirmMsg" class="text-gray-400 text-sm"></p>
            </div>
            <div class="flex gap-3 mt-6">
                <button onclick="closeConfirm()" class="flex-1 px-5 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all hover:scale-105 transform">Cancel</button>
                <a id="confirmBtn" href="#" class="flex-1 px-5 py-3 text-center text-white rounded-xl font-semibold transition-all bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 shadow-lg shadow-green-500/30 hover:shadow-green-500/50 hover:scale-105 transform">Confirm</a>
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
                <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-8 h-8 rounded-lg object-cover shrink-0">
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
                @if($_navBadgeTimein > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-yellow-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeTimein }}</span>
                @endif
            </button>
            <button onclick="showSection('history')" data-section="history"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📅</span>
                <span class="nav-label">Attendance History</span>
                @if($_navBadgeHistory > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeHistory }}</span>
                @endif
            </button>
            <button onclick="showSection('requirements')" data-section="requirements"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📁</span>
                <span class="nav-label">Requirements</span>
                @if($_navBadgeRequirements > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-orange-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeRequirements }}</span>
                @endif
            </button>
            <button onclick="showSection('reports')" data-section="reports"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📋</span>
                <span class="nav-label">Reports</span>
                @if($_navBadgeReports > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-green-600 text-white text-[10px] font-bold leading-none">{{ $_navBadgeReports }}</span>
                @endif
            </button>
        </nav>

        <!-- Sidebar Footer -->
        <div class="px-2 py-3 border-t border-slate-700/60 space-y-1 shrink-0">
            <button onclick="showConfirm('logout')"
                class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-red-400 hover:text-white hover:bg-gradient-to-r hover:from-red-600 hover:to-red-700 transition-all cursor-pointer shadow-lg hover:shadow-red-500/30 transform hover:scale-[1.02]">
                <svg class="nav-icon w-5 h-5 shrink-0 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
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
                <div class="text-gray-400 text-sm font-medium mb-2">📋 Pending Items</div>
                <div class="text-3xl font-bold text-yellow-400">{{ $_navBadgeRequirements }}</div>
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
                $d = \Carbon\Carbon::now('Asia/Manila')->subDays($i);
                $_last7Labels[] = $d->format('D');
                $rec = \App\Models\TimeInRecord::where('student_id', $user->id)
                    ->whereDate('date', $d->toDateString())
                    ->whereNotNull('time_out')
                    ->where('status', 'approved')
                    ->first();
                if ($rec) {
                    // Use stored regular_hours when available; fall back to computed diff
                    $recHrs = floatval($rec->regular_hours ?? 0);
                    if ($recHrs <= 0) {
                        $recHrs = (function($ti,$to){$i=\Carbon\Carbon::parse($ti);$o=\Carbon\Carbon::parse($to);if($o->lte($i))$o->addDay();return $i->diffInMinutes($o)/60;})($rec->time_in,$rec->time_out);
                    }
                    $_last7[] = round($recHrs, 2);
                } else {
                    $_last7[] = 0;
                }
            }
            // Requirements status breakdown
            $_reqApproved = $allReqs->where('status','approved')->count();
            $_reqPending  = $allReqs->where('status','pending')->count();
            $_reqRejected = $allReqs->where('status','denied')->count();
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
            $_timeinCompleted = $_timeinSH->hours_completed ?? 0;
            $_ojtDone = $_timeinCompleted >= $_timeinRequired;
            $required = $_timeinRequired;
            $today = \Carbon\Carbon::now('Asia/Manila')->toDateString();
            $totalDayHours = 0;
        @endphp

        @if($_ojtDone)
        <!-- OJT Completed Banner -->
        <div class="mb-8">
            {{-- ── Top congratulations banner ── --}}
            <div class="bg-gradient-to-br from-green-900/50 via-emerald-900/40 to-teal-900/30 border border-green-500/40 rounded-2xl p-8 text-center mb-6">
                <div class="text-6xl mb-3">🎉</div>
                <h2 class="text-3xl font-bold text-green-400 mb-1">Congratulations, {{ explode(' ', $user->name)[0] }}!</h2>
                <p class="text-white text-base font-semibold mb-3">You have successfully completed your On-the-Job Training.</p>
                <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/40 rounded-full px-6 py-2">
                    <span class="text-green-400">✓</span>
                    <span class="text-green-300 font-semibold text-sm">
                        {{ number_format($_timeinCompleted, 2) }} / {{ $_timeinRequired }} hours — OJT Requirement Fulfilled
                    </span>
                </div>
            </div>

            {{-- ── Certificate section ── --}}
            @if($user->certificate_awarded_at)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Left: certificate image or placeholder --}}
                <div class="bg-slate-800/60 border border-yellow-500/30 rounded-2xl overflow-hidden flex flex-col">
                    @if($user->certificate_image_path)
                    {{-- Clickable certificate preview --}}
                    <div class="relative group cursor-pointer flex-1 flex items-center justify-center bg-slate-900/50 min-h-[220px]"
                         onclick="openCertImageModal('{{ asset('storage/' . $user->certificate_image_path) }}', '{{ addslashes($user->name) }}')">
                        <img src="{{ asset('storage/' . $user->certificate_image_path) }}"
                             alt="Certificate of Completion"
                             class="w-full h-full object-contain max-h-72 transition-transform duration-300 group-hover:scale-[1.02]">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-black/70 text-white text-sm font-semibold px-4 py-2 rounded-xl">
                                🔍 Click to view full size
                            </span>
                        </div>
                    </div>
                    {{-- Action buttons --}}
                    <div class="flex gap-3 p-4 border-t border-slate-700/60">
                        <button onclick="openCertImageModal('{{ asset('storage/' . $user->certificate_image_path) }}', '{{ addslashes($user->name) }}')"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">
                            👁 View
                        </button>
                        <button onclick="_certImageUrl='{{ asset('storage/' . $user->certificate_image_path) }}';_certImageName='{{ addslashes($user->name) }}';printCertImage()"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors">
                            🖨️ Print
                        </button>
                        <button onclick="_certImageUrl='{{ asset('storage/' . $user->certificate_image_path) }}';_certImageName='{{ addslashes($user->name) }}';downloadCertImage()"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-xl transition-colors">
                            ⬇️ Download
                        </button>
                    </div>
                    @else
                    {{-- Not yet uploaded --}}
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center min-h-[220px]">
                        <div class="text-5xl mb-4 opacity-40">📄</div>
                        <p class="text-gray-400 font-semibold">Certificate not yet uploaded</p>
                        <p class="text-gray-500 text-xs mt-2">Your supervisor will upload it soon. Check back later.</p>
                    </div>
                    @endif
                </div>

                {{-- Right: award details --}}
                <div class="bg-slate-800/60 border border-yellow-500/30 rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 bg-yellow-500/20 border border-yellow-500/40 rounded-xl flex items-center justify-center text-2xl shrink-0">🏅</div>
                            <div>
                                <p class="text-yellow-300 font-bold text-lg leading-tight">Certificate of Completion</p>
                                <p class="text-gray-400 text-xs">OJT Monitoring System</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">Recipient</span>
                                <span class="text-white font-semibold text-sm">{{ $user->name }}</span>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">Company</span>
                                <span class="text-white text-sm">{{ $user->company->name ?? '—' }}</span>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">Hours Rendered</span>
                                <span class="text-green-400 font-bold text-sm">{{ number_format($_timeinCompleted, 2) }} hrs</span>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">Awarded by</span>
                                <span class="text-white text-sm">{{ $user->certificate_awarded_by }}</span>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">Date Awarded</span>
                                <span class="text-white text-sm">{{ $user->certificate_awarded_at->format('F d, Y') }}</span>
                            </div>
                            @if($user->school_year)
                            <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-xl">
                                <span class="text-gray-400 text-xs w-24 shrink-0 pt-0.5">School Year</span>
                                <span class="text-white text-sm">{{ $user->school_year }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-700/60">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-green-400 text-xs font-semibold">OJT Successfully Completed</span>
                        </div>
                    </div>
                </div>

            </div>
            @else
            {{-- ── No certificate yet — show layout with empty fields + reminder ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Left: placeholder image area --}}
                <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl overflow-hidden flex flex-col">
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center min-h-[240px] bg-slate-900/30">
                        <div class="w-20 h-20 rounded-2xl bg-slate-700/50 border-2 border-dashed border-slate-600 flex items-center justify-center mb-4">
                            <span class="text-4xl opacity-30">📄</span>
                        </div>
                        <p class="text-gray-500 text-sm font-semibold">Certificate not yet issued</p>
                        <p class="text-gray-600 text-xs mt-1">Your supervisor will upload it here once ready.</p>
                    </div>
                    {{-- Disabled action buttons --}}
                    <div class="flex gap-3 p-4 border-t border-slate-700/40">
                        <button disabled class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-slate-700/40 text-slate-500 text-sm font-semibold rounded-xl cursor-not-allowed">👁 View</button>
                        <button disabled class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-slate-700/40 text-slate-500 text-sm font-semibold rounded-xl cursor-not-allowed">🖨️ Print</button>
                        <button disabled class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-slate-700/40 text-slate-500 text-sm font-semibold rounded-xl cursor-not-allowed">⬇️ Download</button>
                    </div>
                </div>

                {{-- Right: empty info card + reminder --}}
                <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 bg-slate-700/50 border border-slate-600 rounded-xl flex items-center justify-center text-2xl shrink-0 opacity-50">🏅</div>
                            <div>
                                <p class="text-gray-400 font-bold text-lg leading-tight">Certificate of Completion</p>
                                <p class="text-gray-600 text-xs">OJT Monitoring System</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach(['Recipient','Company','Hours Rendered','Awarded by','Date Awarded','School Year'] as $label)
                            <div class="flex items-center gap-3 p-3 bg-slate-700/20 rounded-xl">
                                <span class="text-gray-600 text-xs w-24 shrink-0">{{ $label }}</span>
                                <div class="flex-1 h-3 bg-slate-700/50 rounded-full"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reminder --}}
                    <div class="mt-5 pt-4 border-t border-slate-700/40">
                        <div class="flex items-start gap-3 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-xl">
                            <span class="text-yellow-400 text-lg shrink-0 mt-0.5">⏳</span>
                            <div>
                                <p class="text-yellow-300 text-sm font-semibold">Awaiting Certificate</p>
                                <p class="text-gray-400 text-xs mt-0.5">Please coordinate with your supervisor for your final evaluation and certificate issuance.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endif
        </div>
        @else
        <!-- Time-In Card -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="lg:col-span-1">
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Daily Time-In</h2>
                    
                    <?php 
                    $today   = \Carbon\Carbon::now('Asia/Manila')->toDateString();
                    $nowHour = (int) \Carbon\Carbon::now('Asia/Manila')->format('H');

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
                    $totalDayMinutes = $todayRecords->whereNotNull('time_out')->sum(function($r){
                        $i=\Carbon\Carbon::parse($r->time_in);$o=\Carbon\Carbon::parse($r->time_out);
                        if($o->lte($i))$o->addDay();return max(0,$i->diffInMinutes($o));
                    });
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
                                    <p class="text-gray-400 text-sm">Hours: <span class="text-blue-400 font-semibold">{{ number_format((function($ti,$to){$i=\Carbon\Carbon::parse($ti);$o=\Carbon\Carbon::parse($to);if($o->lte($i))$o->addDay();return $i->diffInMinutes($o)/60;})($morningRecord->time_in,$morningRecord->time_out), 2) }} hrs</span></p>
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
                                    <p class="text-gray-400 text-sm">Hours: <span class="text-blue-400 font-semibold">{{ number_format((function($ti,$to){$i=\Carbon\Carbon::parse($ti);$o=\Carbon\Carbon::parse($to);if($o->lte($i))$o->addDay();return $i->diffInMinutes($o)/60;})($afternoonRecord->time_in,$afternoonRecord->time_out), 2) }} hrs</span></p>
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
                            @php
                                // Check OT status from today's records
                                $_otRecord = $todayRecords->where('ot_hours', '>', 0)->first();
                            @endphp
                            @if($_otRecord)
                                @if($_otRecord->ot_status === 'pending')
                                <div class="bg-yellow-500/10 border border-yellow-500/50 rounded-lg p-3 mt-2">
                                    <p class="text-yellow-300 text-xs font-semibold">⏳ OT Hours Pending</p>
                                    <p class="text-yellow-200 text-xs mt-1">You have <strong>{{ number_format($_otRecord->ot_hours, 2) }} OT hrs</strong> that will only be credited after you submit and get an <strong>OT Letter</strong> approved. Go to <strong>Requirements</strong> and upload your OT Letter.</p>
                                </div>
                                @elseif($_otRecord->ot_status === 'approved')
                                <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-3 mt-2">
                                    <p class="text-green-300 text-xs font-semibold">✓ OT Hours Approved</p>
                                    <p class="text-green-200 text-xs mt-1">Your <strong>{{ number_format($_otRecord->ot_hours, 2) }} OT hrs</strong> have been credited.</p>
                                </div>
                                @endif
                            @endif
                            @endif
                            {{-- Active Time-Out Button / OT Gate --}}
                            @if($activeRecord && !$activeRecord->time_out)
                            @php
                                // Minutes from all completed sessions today (excluding active)
                                $_prevMins = $todayRecords->whereNotNull('time_out')->where('id','!=',$activeRecord->id)
                                    ->sum(function($r){$i=\Carbon\Carbon::parse($r->time_in);$o=\Carbon\Carbon::parse($r->time_out);if($o->lte($i))$o->addDay();return max(0,$i->diffInMinutes($o));});
                                // Elapsed minutes in the current active session (server now - time_in)
                                $_activeElapsed = max(0, \Carbon\Carbon::createFromTimeString($activeRecord->time_in)->diffInMinutes(\Carbon\Carbon::now('Asia/Manila')));
                                // Total minutes logged today = completed + currently elapsed
                                $_totalDayMinsNow = $_prevMins + $_activeElapsed;
                                // Has student hit 8 hours (480 mins) based on actual time data?
                                $_hit8Hours = $_totalDayMinsNow >= 480;
                                // Has student already submitted an OT letter today?
                                $_otLetterToday = \App\Models\StudentRequirement::where('student_id', $user->id)
                                    ->whereDate('created_at', $today)
                                    ->where(function($q){ $q->where('title','like','%OT%')->orWhere('title','like','%overtime%')->orWhere('title','like','%over time%'); })
                                    ->orderByDesc('created_at')->first();
                                // For JS live check: pass prevMins and timeIn so JS can compute elapsed
                                $_prevHours = round($_prevMins / 60, 4);
                            @endphp
                            <form method="POST" action="{{ route('time-out') }}" id="timeOutForm">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $user->id }}">
                                <input type="hidden" name="date" value="{{ $today }}">
                                <input type="hidden" name="session" value="{{ $activeRecord->session }}">
                                <input type="hidden" name="photo_base64" id="timeOutPhotoBase64">
                                <input type="hidden" name="time_out" id="timeOut" required>
                            </form>

                            {{-- OT Gate wrapper: JS will swap between timeout btn and OT prompt --}}
                            <div id="otGateWrapper">

                                {{-- Normal Time Out button (shown when < 8 hrs) --}}
                                <div id="normalTimeoutBtn">
                                    <button type="button" id="timeOutBtn" onclick="openTimeoutOptionsModal(); return false;"
                                        class="w-full px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                        🕐 Time Out ({{ ucfirst($activeRecord->session) }} Session)
                                    </button>
                                </div>

                                {{-- OT Gate: shown when 8 hrs reached --}}
                                <div id="otGatePrompt" class="hidden">
                                    <div class="bg-yellow-500/10 border border-yellow-500 rounded-xl p-4">
                                        <p class="text-yellow-300 font-bold text-sm mb-1">⏰ You have reached 8 hours today!</p>
                                        <p class="text-yellow-200 text-xs mb-3">Your regular hours are complete. Do you want to continue working overtime? Submit an OT Letter to proceed, or time out now with only 8 hours recorded.</p>
                                        <div class="flex flex-col gap-2">
                                            @if(!$_otLetterToday)
                                            {{-- No OT letter yet: show upload form --}}
                                            <button type="button" onclick="openOtLetterForm()" id="showOtLetterBtn"
                                                class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm">
                                                📄 Submit OT Letter to Continue OT
                                            </button>
                                            @elseif($_otLetterToday->status === 'pending')
                                            {{-- OT letter submitted, waiting --}}
                                            <div class="bg-blue-500/10 border border-blue-400 rounded-lg p-3">
                                                <p class="text-blue-300 text-xs font-semibold">📋 OT Letter submitted — waiting for supervisor/coordinator approval.</p>
                                                <p class="text-blue-200 text-xs mt-1">You may continue working. Your OT time is being tracked. Time out when done.</p>
                                            </div>
                                            <button type="button" id="timeOutBtn" onclick="openTimeoutOptionsModal(); return false;"
                                                class="w-full px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold text-sm">
                                                🕐 Time Out (OT in progress)
                                            </button>
                                            @elseif($_otLetterToday->status === 'approved')
                                            {{-- OT letter approved --}}
                                            <div class="bg-green-500/10 border border-green-500 rounded-lg p-3">
                                                <p class="text-green-300 text-xs font-semibold">✅ OT Letter approved! Your overtime hours will be credited.</p>
                                            </div>
                                            <button type="button" id="timeOutBtn" onclick="openTimeoutOptionsModal(); return false;"
                                                class="w-full px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold text-sm">
                                                🕐 Time Out (OT approved)
                                            </button>
                                            @elseif($_otLetterToday->status === 'denied')
                                            {{-- OT letter denied --}}
                                            <div class="bg-red-500/10 border border-red-500 rounded-lg p-3">
                                                <p class="text-red-300 text-xs font-semibold">❌ OT Letter denied. Only your 8 regular hours will be recorded.</p>
                                            </div>
                                            <button type="button" id="timeOutBtn" onclick="openTimeoutOptionsModal(); return false;"
                                                class="w-full px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold text-sm">
                                                🕐 Time Out (8 hrs only)
                                            </button>
                                            @endif

                                            {{-- Always show: time out with 8 hrs only --}}
                                            @if(!$_otLetterToday || $_otLetterToday->status === 'denied')
                                            <button type="button" onclick="openTimeoutOptionsModal(); return false;"
                                                class="w-full px-4 py-2.5 bg-slate-600 hover:bg-slate-500 text-white rounded-lg font-semibold text-sm">
                                                🕐 Time Out Now (8 hrs only)
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Inline OT Letter Upload Form (hidden by default) --}}
                                    <div id="otLetterForm" class="hidden mt-3 bg-slate-700/50 border border-slate-600 rounded-xl p-4">
                                        <h4 class="text-sm font-bold text-white mb-3">📄 Upload OT Letter</h4>
                                        <form method="POST" action="{{ route('upload-requirement') }}" enctype="multipart/form-data"
                                            onsubmit="return validateOtLetterForm(this)" id="otLetterUploadForm">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $user->id }}">
                                            <input type="hidden" name="title" value="OT Letter - {{ \Carbon\Carbon::now('Asia/Manila')->format('M d, Y') }}">
                                            <div class="mb-3">
                                                <label class="block text-xs text-gray-300 mb-1">Description (optional)</label>
                                                <textarea name="description" rows="2" maxlength="1000"
                                                    class="w-full px-3 py-2 bg-slate-800 border border-slate-600 text-white rounded-lg text-xs focus:border-blue-500 focus:outline-none"
                                                    placeholder="Reason for overtime..."></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block text-xs text-gray-300 mb-1">OT Letter File *</label>
                                                <input type="file" name="file[]" id="otLetterFile" required
                                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                    class="w-full px-3 py-2 bg-slate-800 border border-slate-600 text-white rounded-lg text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white cursor-pointer">
                                                <p class="text-gray-400 text-xs mt-1">PDF, Word, or Image — Max 15 MB</p>
                                                <p id="otLetterFileError" class="text-red-400 text-xs mt-1 hidden"></p>
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="button" onclick="closeOtLetterForm()"
                                                    class="flex-1 px-3 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg text-xs font-semibold">Cancel</button>
                                                <button type="submit"
                                                    class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">Submit OT Letter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>{{-- end otGateWrapper --}}

                            <script>
                            function syncUploadBtn(totalMins) {
                                var btn = document.getElementById('otUploadBtn');
                                var msg = document.getElementById('otEmptyMsg');
                                if (totalMins >= 480) {
                                    if (btn) {
                                        btn.disabled = false;
                                        btn.title = '';
                                        btn.className = 'px-2.5 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all cursor-pointer';
                                    }
                                    if (msg) msg.innerHTML = 'No OT letters submitted yet. Click <strong>+ Upload</strong> to submit an OT letter.';
                                } else {
                                    if (btn) {
                                        btn.disabled = true;
                                        btn.title = 'Complete 8 hours today to unlock upload';
                                        btn.className = 'px-2.5 py-1.5 bg-slate-700 text-gray-500 rounded-lg text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all cursor-not-allowed opacity-50';
                                    }
                                    if (msg) msg.innerHTML = 'Complete <strong>8 hours</strong> today to unlock OT letter submission.';
                                }
                            }
                            (function() {
                                // prevMins = total minutes already logged in completed sessions today
                                var prevMins       = {{ $_prevMins }};
                                var timeInStr      = '{{ $activeRecord->time_in }}';
                                var otLetterStatus = '{{ $_otLetterToday ? $_otLetterToday->status : "none" }}';

                                function parseHHMM(str) {
                                    var p = str.split(':');
                                    return parseInt(p[0]) * 60 + parseInt(p[1]);
                                }

                                function checkOtGate() {
                                    var now = new Date();
                                    var nowTotalMins = now.getHours() * 60 + now.getMinutes();
                                    var timeInMins   = parseHHMM(timeInStr);
                                    // elapsed minutes in this active session
                                    var elapsed = nowTotalMins - timeInMins;
                                    if (elapsed < 0) elapsed += 1440; // handle midnight wrap
                                    // total day minutes = previous completed sessions + current elapsed
                                    var totalDayMins = prevMins + elapsed;

                                    var normalBtn = document.getElementById('normalTimeoutBtn');
                                    var otPrompt  = document.getElementById('otGatePrompt');
                                    if (!normalBtn || !otPrompt) return;

                                    // Show OT gate only when student has actually accumulated 8 hrs (480 mins)
                                    // and OT letter is not already approved or pending
                                    if (totalDayMins >= 480 && otLetterStatus !== 'approved' && otLetterStatus !== 'pending') {
                                        normalBtn.classList.add('hidden');
                                        otPrompt.classList.remove('hidden');
                                    } else {
                                        normalBtn.classList.remove('hidden');
                                        otPrompt.classList.add('hidden');
                                    }

                                    syncUploadBtn(totalDayMins);
                                }

                                // Run immediately and every 30 seconds
                                checkOtGate();
                                setInterval(checkOtGate, 30000);
                            })();

                            function openOtLetterForm() {
                                var f = document.getElementById('otLetterForm');
                                var b = document.getElementById('showOtLetterBtn');
                                if (f) f.classList.remove('hidden');
                                if (b) b.classList.add('hidden');
                            }
                            function closeOtLetterForm() {
                                var f = document.getElementById('otLetterForm');
                                var b = document.getElementById('showOtLetterBtn');
                                if (f) f.classList.add('hidden');
                                if (b) b.classList.remove('hidden');
                            }
                            function validateOtLetterForm(form) {
                                var fileInput = form.querySelector('input[type="file"]');
                                var errEl = document.getElementById('otLetterFileError');
                                if (!fileInput.files || !fileInput.files.length) {
                                    if (errEl) { errEl.textContent = 'Please select a file.'; errEl.classList.remove('hidden'); }
                                    return false;
                                }
                                var sizeMB = fileInput.files[0].size / (1024 * 1024);
                                if (sizeMB > 15) {
                                    if (errEl) { errEl.textContent = 'File exceeds 15 MB.'; errEl.classList.remove('hidden'); }
                                    return false;
                                }
                                showUploadLoader();
                                return true;
                            }
                            </script>
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
                                <p class="text-sm text-gray-400 dark:text-gray-400 mb-2">Capture a photo with your camera to time in.</p>
                                <button type="button" id="openCameraForTimeIn" onclick="openCameraModal('timein')"
                                    class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-400 dark:disabled:bg-slate-600">
                                    📷 Open Camera
                                </button>
                                <!-- Lunch break lock notice -->
                                <div id="lunchLockNotice" class="hidden mt-3 flex items-center gap-3 px-4 py-3 bg-orange-500/10 border border-orange-500/40 rounded-lg">
                                    <span class="text-orange-400 text-lg shrink-0">🍽️</span>
                                    <div>
                                        <p class="text-orange-300 text-sm font-semibold">Lunch Break — Time-in locked</p>
                                        <p class="text-gray-400 text-xs mt-0.5">Afternoon session opens at <strong>12:50 PM</strong>. Resuming in <span id="lunchCountdown" class="text-orange-300 font-bold"></span></p>
                                    </div>
                                </div>
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
                    // Pending hours = timed out but awaiting approval
                    $pendingHoursDisplay = round(\App\Models\TimeInRecord::where('student_id', $user->id)
                        ->whereNotNull('time_out')->where('status', 'pending')->get()
                        ->sum(fn($r) => max(0, floatval($r->regular_hours ?? 0))), 2);
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
                                @if($pendingHoursDisplay > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-yellow-400">⏳ Pending Approval</span>
                                    <span class="text-yellow-400 font-semibold">+{{ number_format($pendingHoursDisplay, 2) }} hrs</span>
                                </div>
                                <p class="text-xs text-gray-500">Pending hours will be added once your supervisor approves your time-in.</p>
                                @endif
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
                ->orderBy('session', 'asc')
                ->limit(20)
                ->get();
            // Group by date
            $groupedRecords = $timeInRecords->groupBy(fn($r) => $r->date->format('Y-m-d'));
            ?>

            @if($groupedRecords->isNotEmpty())
            <div class="space-y-4" data-pagination-list data-page-size="3">
                @foreach($groupedRecords as $date => $sessions)
                @php
                    $morning   = $sessions->firstWhere('session', 'morning');
                    $afternoon = $sessions->firstWhere('session', 'afternoon');
                    $anyVerified = $sessions->contains('verified', true);
                    $anyPending  = $sessions->contains(fn($r) => !$r->verified);
                    $displayDate = \Carbon\Carbon::parse($date)->format('M d, Y');
                @endphp
                <div class="bg-slate-700/30 rounded-xl p-4 hover:bg-slate-700/50 transition-colors">
                    {{-- Date header + status --}}
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-200 font-semibold text-sm">{{ $displayDate }}</p>
                        <div class="flex gap-1.5">
                            @if($anyVerified)
                            <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full font-semibold">Verified</span>
                            @endif
                            @if($anyPending)
                            <span class="px-2 py-0.5 bg-yellow-500/20 text-yellow-400 text-xs rounded-full font-semibold">Pending</span>
                            @endif
                        </div>
                    </div>

                    {{-- Sessions row --}}
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Morning session --}}
                        <div class="bg-slate-800/50 rounded-lg p-3">
                            <p class="text-xs font-semibold text-blue-400 mb-2">🌅 Morning</p>
                            @if($morning)
                            <p class="text-gray-400 text-xs mb-2">
                                {{ \Carbon\Carbon::parse($morning->time_in)->format('h:i A') }}
                                @if($morning->time_out) → {{ \Carbon\Carbon::parse($morning->time_out)->format('h:i A') }} @endif
                            </p>
                            <div class="flex gap-2">
                                {{-- Morning time-in photo --}}
                                <div class="flex flex-col items-center gap-1 flex-1">
                                    @if($morning->photo_path)
                                    <img src="{{ url('storage/' . $morning->photo_path) }}" alt="In"
                                        class="w-full h-16 rounded-lg object-cover cursor-pointer hover:ring-2 hover:ring-green-400 transition-all"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                        onclick="openFileViewer('{{ url('storage/' . $morning->photo_path) }}','{{ $displayDate }} Morning — Time-in')">
                                    <div class="w-full h-16 bg-slate-600 rounded-lg items-center justify-center hidden"><span class="text-gray-400 text-xs">📸</span></div>
                                    @else
                                    <div class="w-full h-16 bg-slate-600/40 rounded-lg flex items-center justify-center border border-dashed border-slate-500"><span class="text-gray-500 text-xs">📸</span></div>
                                    @endif
                                    <span class="text-gray-500 text-[10px]">In</span>
                                </div>
                                {{-- Morning time-out photo --}}
                                <div class="flex flex-col items-center gap-1 flex-1">
                                    @if(isset($morning->time_out_photo_path) && $morning->time_out_photo_path)
                                    <img src="{{ url('storage/' . $morning->time_out_photo_path) }}" alt="Out"
                                        class="w-full h-16 rounded-lg object-cover cursor-pointer hover:ring-2 hover:ring-orange-400 transition-all"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                        onclick="openFileViewer('{{ url('storage/' . $morning->time_out_photo_path) }}','{{ $displayDate }} Morning — Time-out')">
                                    <div class="w-full h-16 bg-slate-600 rounded-lg items-center justify-center hidden"><span class="text-gray-400 text-xs">📸</span></div>
                                    @elseif($morning->time_out)
                                    <div class="w-full h-16 bg-slate-600/30 rounded-lg flex items-center justify-center border border-dashed border-slate-500"><span class="text-gray-500 text-xs">—</span></div>
                                    @else
                                    <div class="w-full h-16 bg-slate-600/20 rounded-lg flex items-center justify-center border border-dashed border-slate-600"><span class="text-gray-500 text-xs">⏳</span></div>
                                    @endif
                                    <span class="text-gray-500 text-[10px]">Out</span>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center justify-center h-20 text-gray-600 text-xs">No morning session</div>
                            @endif
                        </div>

                        {{-- Afternoon session --}}
                        <div class="bg-slate-800/50 rounded-lg p-3">
                            <p class="text-xs font-semibold text-orange-400 mb-2">🌇 Afternoon</p>
                            @if($afternoon)
                            <p class="text-gray-400 text-xs mb-2">
                                {{ \Carbon\Carbon::parse($afternoon->time_in)->format('h:i A') }}
                                @if($afternoon->time_out) → {{ \Carbon\Carbon::parse($afternoon->time_out)->format('h:i A') }} @endif
                            </p>
                            <div class="flex gap-2">
                                {{-- Afternoon time-in photo --}}
                                <div class="flex flex-col items-center gap-1 flex-1">
                                    @if($afternoon->photo_path)
                                    <img src="{{ url('storage/' . $afternoon->photo_path) }}" alt="In"
                                        class="w-full h-16 rounded-lg object-cover cursor-pointer hover:ring-2 hover:ring-green-400 transition-all"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                        onclick="openFileViewer('{{ url('storage/' . $afternoon->photo_path) }}','{{ $displayDate }} Afternoon — Time-in')">
                                    <div class="w-full h-16 bg-slate-600 rounded-lg items-center justify-center hidden"><span class="text-gray-400 text-xs">📸</span></div>
                                    @else
                                    <div class="w-full h-16 bg-slate-600/40 rounded-lg flex items-center justify-center border border-dashed border-slate-500"><span class="text-gray-500 text-xs">📸</span></div>
                                    @endif
                                    <span class="text-gray-500 text-[10px]">In</span>
                                </div>
                                {{-- Afternoon time-out photo --}}
                                <div class="flex flex-col items-center gap-1 flex-1">
                                    @if(isset($afternoon->time_out_photo_path) && $afternoon->time_out_photo_path)
                                    <img src="{{ url('storage/' . $afternoon->time_out_photo_path) }}" alt="Out"
                                        class="w-full h-16 rounded-lg object-cover cursor-pointer hover:ring-2 hover:ring-orange-400 transition-all"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                        onclick="openFileViewer('{{ url('storage/' . $afternoon->time_out_photo_path) }}','{{ $displayDate }} Afternoon — Time-out')">
                                    <div class="w-full h-16 bg-slate-600 rounded-lg items-center justify-center hidden"><span class="text-gray-400 text-xs">📸</span></div>
                                    @elseif($afternoon->time_out)
                                    <div class="w-full h-16 bg-slate-600/30 rounded-lg flex items-center justify-center border border-dashed border-slate-500"><span class="text-gray-500 text-xs">—</span></div>
                                    @else
                                    <div class="w-full h-16 bg-slate-600/20 rounded-lg flex items-center justify-center border border-dashed border-slate-600"><span class="text-gray-500 text-xs">⏳</span></div>
                                    @endif
                                    <span class="text-gray-500 text-[10px]">Out</span>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center justify-center h-20 text-gray-600 text-xs">No afternoon session</div>
                            @endif
                        </div>
                    </div>
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
            // Load from DB templates set by CCIT head
            $tplOnboarding = \App\Models\RequirementTemplate::where('category','onboarding')->orderBy('sort_order')->orderBy('name')->get();
            $tplDaily      = \App\Models\RequirementTemplate::where('category','daily')->orderBy('sort_order')->orderBy('name')->get();
            $onboarding = $tplOnboarding->pluck('max_files','name')->toArray();
        ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Onboarding Cabinet -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">📂 Onboarding Requirements</h3>
                <p class="text-gray-400 text-xs mb-4">Documents required to begin OJT</p>
                @if(empty($onboarding))
                <p class="text-gray-500 text-sm text-center py-4">No requirements have been set up yet. Please check back later.</p>
                @else
                <ul class="space-y-3" data-pagination-list>
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
                @endif
            </div>

            <!-- Daily Submissions Cabinet -->
            @php
                $narratives = \App\Models\DailyNarrative::where('student_id', $user->id)
                    ->orderBy('day_number', 'desc')->get();
                $todayNarrative = $narratives->first(fn($n) => $n->report_date->isSameDay(\Carbon\Carbon::now('Asia/Manila')));
            @endphp
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">📒 Daily Narrative</h3>
                        <p class="text-gray-400 text-xs mt-1">Daily OJT journal entries</p>
                    </div>
                <div class="flex items-center gap-2 flex-wrap justify-end">
                        @if($narratives->isNotEmpty())
                        <button type="button" onclick="openNarrativeDownloadModal()"
                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold whitespace-nowrap">
                            ⬇ Download
                        </button>
                        @endif
                        <button type="button"
                            onclick="openNarrativeModal({{ $todayNarrative ? $todayNarrative->id : 'null' }}, {{ $todayNarrative ? json_encode($todayNarrative->description) : "''" }})"
                            class="px-3 py-1.5 {{ $todayNarrative ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg text-xs font-semibold whitespace-nowrap">
                            {{ $todayNarrative ? '✏ Edit Today' : '+ Daily Report' }}
                        </button>
                    </div>
                </div>

                @if($narratives->isNotEmpty())
                <div class="space-y-2 max-h-72 overflow-y-auto pr-1" data-pagination-list data-page-size="10">
                    @foreach($narratives as $n)
                    <div class="flex items-start gap-3 p-3 bg-slate-700/40 rounded-lg cursor-pointer hover:bg-slate-700/60 transition-colors"
                         onclick="openNarrativeViewModal({{ $n->id }}, '{{ addslashes($n->description) }}', '{{ $n->photo_url }}', {{ $n->day_number }}, '{{ \Carbon\Carbon::parse($n->report_date)->format('M d, Y') }}')">
                        <div class="w-9 h-9 bg-indigo-500/20 border border-indigo-500/40 rounded-lg flex items-center justify-center shrink-0">
                            <span class="text-indigo-400 text-xs font-bold">D{{ $n->day_number }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-gray-200 text-sm font-semibold">Day {{ $n->day_number }}</p>
                                <span class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($n->report_date)->format('M d, Y') }}</span>
                                @if($n->photo_path)<span class="text-xs text-indigo-400">📷</span>@endif
                            </div>
                            <p class="text-gray-400 text-xs mt-0.5 truncate">{{ Str::limit($n->description, 80) }}</p>
                        </div>
                        <button type="button"
                            onclick="event.stopPropagation(); openNarrativeModal({{ $n->id }}, {{ json_encode($n->description) }})"
                            class="shrink-0 px-2 py-1 bg-slate-600 hover:bg-slate-500 text-gray-300 rounded text-xs">✏</button>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm text-center py-6">No narrative entries yet. Click <strong>+ Daily Report</strong> to start.</p>
                @endif
            </div>

        </div>
        </section><!-- end requirements -->

        <!-- ===== SECTION: REPORTS ===== -->
        <section id="section-reports" class="dash-section hidden">
        <?php
            $allSubmitted = \App\Models\StudentRequirement::where('student_id', $user->id)->orderBy('created_at','desc')->get();
            $dbOnboardingKeys = \App\Models\RequirementTemplate::where('category','onboarding')->pluck('name')->toArray();
            $onboardingKeys = $dbOnboardingKeys;
            $onboardingReports = $allSubmitted->filter(fn($r) => collect($onboardingKeys)->contains(fn($k) => stripos($r->title, $k) !== false));

            // Daily template keys from DB
            $dbDailyKeys = \App\Models\RequirementTemplate::where('category','daily')->pluck('name')->toArray();

            // Daily Submissions = OT letters + any submission matching a daily template title
            $otLetters = $allSubmitted->filter(function($r) use ($onboardingKeys, $dbDailyKeys) {
                $isNotOnboarding = !collect($onboardingKeys)->contains(fn($k) => stripos($r->title, $k) !== false);
                $isOT = stripos($r->title, 'OT') !== false ||
                        stripos($r->title, 'overtime') !== false ||
                        stripos($r->title, 'over time') !== false;
                $isDailyTemplate = collect($dbDailyKeys)->contains(fn($k) => stripos($r->title, $k) !== false);
                return $isNotOnboarding && ($isOT || $isDailyTemplate);
            })->values();

            $latestByTitle = $allSubmitted->groupBy(fn($r) => strtolower(trim($r->title)))
                ->map(fn($group) => $group->sortByDesc('created_at')->first());
        ?>

        <!-- Onboarding Requirements — Responsive Table/Cards -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-3 sm:p-5 mb-5">
            <h3 class="text-sm sm:text-base font-bold text-white mb-3">📂 Onboarding Requirements</h3>
            @if($onboardingReports->isNotEmpty())
            
            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-400 uppercase bg-slate-700/30 border-b border-slate-600">
                        <tr>
                            <th class="px-3 py-2">Title</th>
                            <th class="px-3 py-2">Date</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($onboardingReports as $req)
                        @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                        <tr class="hover:bg-slate-700/20 transition-colors">
                            <td class="px-3 py-2.5">
                                <div>
                                    <p class="text-gray-200 text-sm font-medium">{{ $req->title }}</p>
                                    @if($req->feedback)
                                    <p class="text-xs text-blue-400 mt-1"><strong>Feedback:</strong> {{ Str::limit($req->feedback, 40) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-2.5 text-gray-400 text-xs whitespace-nowrap">
                                {{ $req->created_at->format('M d, Y') }}
                                <br><span class="text-[10px] text-gray-500">{{ $req->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="px-3 py-2.5">
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full
                                    @if($req->status==='approved') bg-green-500/20 text-green-400
                                    @elseif($req->status==='denied') bg-red-500/20 text-red-400
                                    @else bg-yellow-500/20 text-yellow-400 @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2.5 text-right">
                                <div class="flex gap-1.5 justify-end">
                                    @if($req->file_path)
                                    <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" 
                                        class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-[10px]">View</button>
                                    @endif
                                    @if($req->status === 'denied' && $latestForThis && $latestForThis->id === $req->id)
                                    <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" 
                                        class="px-2 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-[10px]">Resubmit</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden space-y-2">
                @foreach($onboardingReports as $req)
                @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                <div class="bg-slate-700/30 rounded-lg p-3 border-l-4 
                    @if($req->status==='approved') border-green-500
                    @elseif($req->status==='denied') border-red-500
                    @else border-yellow-500 @endif">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="text-white text-sm font-medium flex-1">{{ $req->title }}</p>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full shrink-0
                            @if($req->status==='approved') bg-green-500/20 text-green-400
                            @elseif($req->status==='denied') bg-red-500/20 text-red-400
                            @else bg-yellow-500/20 text-yellow-400 @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-xs mb-2">{{ $req->created_at->format('M d, Y h:i A') }}</p>
                    @if($req->feedback)
                    <p class="text-xs text-blue-400 mb-2 bg-slate-800/50 px-2 py-1 rounded">
                        <strong>Feedback:</strong> {{ $req->feedback }}
                    </p>
                    @endif
                    <div class="flex gap-2">
                        @if($req->file_path)
                        <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" 
                            class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">View</button>
                        @endif
                        @if($req->status === 'denied' && $latestForThis && $latestForThis->id === $req->id)
                        <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" 
                            class="px-2.5 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-xs">Resubmit</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            @else
            <p class="text-gray-400 text-xs sm:text-sm text-center py-4">No onboarding documents submitted yet.</p>
            @endif
        </div>

        <!-- Daily Submissions — OT Letters Only (Responsive) -->
        @php
            // Keep the OT upload gate available even when the time-in card branch did not run.
            $totalDayMinutes = \App\Models\TimeInRecord::where('student_id', $user->id)
                ->whereDate('date', \Carbon\Carbon::now('Asia/Manila')->toDateString())
                ->whereNotNull('time_out')
                ->get()
                ->sum(function ($record) {
                    $timeIn = \Carbon\Carbon::parse($record->time_in);
                    $timeOut = \Carbon\Carbon::parse($record->time_out);
                    if ($timeOut->lte($timeIn)) {
                        $timeOut->addDay();
                    }
                    return max(0, $timeIn->diffInMinutes($timeOut));
                });
        @endphp
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-3 sm:p-5 mb-5">
            <div class="flex items-center justify-between mb-3 gap-2 flex-wrap">
                <h3 class="text-sm sm:text-base font-bold text-white">📋 Daily Submissions
                    <span class="ml-1 px-1.5 py-0.5 bg-slate-700 text-gray-400 text-[10px] rounded-full font-normal">{{ $otLetters->count() }}</span>
                </h3>
                <button type="button" id="otUploadBtn" onclick="openUploadModal('OT Letter')"
                    class="px-2.5 py-1.5 rounded-lg text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all
                        {{ $totalDayMinutes >= 480 ? 'bg-green-600 hover:bg-green-700 text-white cursor-pointer' : 'bg-slate-700 text-gray-500 cursor-not-allowed opacity-50' }}"
                    {{ $totalDayMinutes < 480 ? 'disabled title="Complete 8 hours today to unlock upload"' : '' }}>
                    + Upload
                </button>
            </div>

            @if($otLetters->isNotEmpty())
            <!-- Filter tabs -->
            <div class="flex gap-1.5 sm:gap-2 mb-3 flex-wrap" id="dailySubmissionsTabs">
                <button onclick="filterDailySubmissions('all')" class="daily-tab-btn active px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-[10px] sm:text-xs font-semibold">
                    All ({{ $otLetters->count() }})
                </button>
                <button onclick="filterDailySubmissions('pending')" class="daily-tab-btn px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-700/50 hover:bg-slate-600 text-gray-300 rounded-lg text-[10px] sm:text-xs font-semibold">
                    Pending ({{ $otLetters->where('status', 'pending')->count() }})
                </button>
                <button onclick="filterDailySubmissions('approved')" class="daily-tab-btn px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-700/50 hover:bg-slate-600 text-gray-300 rounded-lg text-[10px] sm:text-xs font-semibold">
                    Approved ({{ $otLetters->where('status', 'approved')->count() }})
                </button>
                <button onclick="filterDailySubmissions('denied')" class="daily-tab-btn px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-700/50 hover:bg-slate-600 text-gray-300 rounded-lg text-[10px] sm:text-xs font-semibold">
                    Denied ({{ $otLetters->where('status', 'denied')->count() }})
                </button>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-400 uppercase bg-slate-700/30 border-b border-slate-600">
                        <tr>
                            <th class="px-3 py-2">Title</th>
                            <th class="px-3 py-2">Date</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($otLetters as $req)
                        @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                        <tr class="daily-submission-row hover:bg-slate-700/20 transition-colors" data-status="{{ $req->status }}">
                            <td class="px-3 py-2.5">
                                <div>
                                    <p class="text-gray-200 text-sm font-medium">{{ $req->title }}</p>
                                    @if($req->feedback)
                                    <p class="text-xs text-blue-400 mt-1"><strong>Feedback:</strong> {{ Str::limit($req->feedback, 40) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-2.5 text-gray-400 text-xs whitespace-nowrap">
                                {{ $req->created_at->format('M d, Y') }}
                                <br><span class="text-[10px] text-gray-500">{{ $req->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="px-3 py-2.5">
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full
                                    @if($req->status==='approved') bg-green-500/20 text-green-400
                                    @elseif($req->status==='denied') bg-red-500/20 text-red-400
                                    @else bg-yellow-500/20 text-yellow-400 @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2.5 text-right">
                                <div class="flex gap-1.5 justify-end">
                                    @if($req->file_path)
                                    <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" 
                                        class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-[10px]">View</button>
                                    @endif
                                    @if($req->status === 'denied' && $latestForThis && $latestForThis->id === $req->id)
                                    <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" 
                                        class="px-2 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-[10px]">Resubmit</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden space-y-2">
                @foreach($otLetters as $req)
                @php $latestForThis = $latestByTitle[strtolower(trim($req->title))] ?? null; @endphp
                <div class="daily-submission-row bg-slate-700/30 rounded-lg p-3 border-l-4 
                    @if($req->status==='approved') border-green-500
                    @elseif($req->status==='denied') border-red-500
                    @else border-yellow-500 @endif"
                    data-status="{{ $req->status }}">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="text-white text-sm font-medium flex-1">{{ $req->title }}</p>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full shrink-0
                            @if($req->status==='approved') bg-green-500/20 text-green-400
                            @elseif($req->status==='denied') bg-red-500/20 text-red-400
                            @else bg-yellow-500/20 text-yellow-400 @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-xs mb-2">{{ $req->created_at->format('M d, Y h:i A') }}</p>
                    @if($req->feedback)
                    <p class="text-xs text-blue-400 mb-2 bg-slate-800/50 px-2 py-1 rounded">
                        <strong>Feedback:</strong> {{ $req->feedback }}
                    </p>
                    @endif
                    <div class="flex gap-2">
                        @if($req->file_path)
                        <button type="button" onclick="openFileViewer('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')" 
                            class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">View</button>
                        @endif
                        @if($req->status === 'denied' && $latestForThis && $latestForThis->id === $req->id)
                        <button type="button" onclick="openUploadModal('{{ addslashes($req->title) }}')" 
                            class="px-2.5 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-xs">Resubmit</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            @else
            @if($totalDayMinutes >= 480)
                <p id="otEmptyMsg" class="text-gray-400 text-xs sm:text-sm text-center py-4 sm:py-6">No OT letters submitted yet. Click <strong>+ Upload</strong> to submit an OT letter.</p>
            @else
                <p id="otEmptyMsg" class="text-gray-400 text-xs sm:text-sm text-center py-4 sm:py-6">Complete <strong>8 hours</strong> today to unlock OT letter submission.</p>
            @endif
            @endif
        </div>

        <!-- Daily Narrative — Responsive List -->
        @php
            $narrativeReports = \App\Models\DailyNarrative::where('student_id', $user->id)
                ->orderBy('day_number', 'desc')->get();
            $todayNarrativeReport = $narrativeReports->first(function ($narrative) {
                return \Carbon\Carbon::parse($narrative->report_date, 'Asia/Manila')
                    ->isSameDay(\Carbon\Carbon::now('Asia/Manila'));
            });
        @endphp
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-3 sm:p-5">
            <div class="flex items-center justify-between mb-3 gap-2 flex-wrap">
                <h3 class="text-sm sm:text-base font-bold text-white">📒 Daily Narrative
                    <span class="ml-1 px-1.5 py-0.5 bg-slate-700 text-gray-400 text-[10px] rounded-full font-normal">{{ $narrativeReports->count() }}</span>
                </h3>
                <div class="flex gap-1.5 sm:gap-2 flex-wrap">
                    @if($narrativeReports->isNotEmpty())
                    <button type="button" onclick="openNarrativeDownloadModal()" class="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[11px] sm:text-xs font-semibold whitespace-nowrap">⬇ Download</button>
                    @endif
                    <button type="button"
                        @if(!$todayNarrativeReport)
                        onclick="openNarrativeModal(null,'')"
                        @endif
                        class="px-2.5 py-1.5 {{ $todayNarrativeReport ? 'bg-slate-600 text-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 text-white' }} rounded-lg text-[11px] sm:text-xs font-semibold whitespace-nowrap"
                        @if($todayNarrativeReport)
                        disabled title="Today's narrative has already been submitted"
                        @endif>
                        {{ $todayNarrativeReport ? 'Submitted Today' : '+ Daily Report' }}
                    </button>
                </div>
            </div>

            @if($narrativeReports->isNotEmpty())
            <!-- Mobile-friendly card list -->
            <div class="space-y-1.5 sm:space-y-2" data-pagination-list data-page-size="10">
                @foreach($narrativeReports as $i => $nr)
                <div class="narrative-entry-row
                    flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3 bg-slate-700/30 rounded-lg border border-slate-700/50
                    hover:bg-slate-700/50 transition-colors cursor-pointer"
                    data-narrative-id="{{ $nr->id }}"
                    onclick="openNarrativeViewModal({{ $nr->id }},'{{ addslashes($nr->description) }}','{{ $nr->photo_url }}',{{ $nr->day_number }},'{{ \Carbon\Carbon::parse($nr->report_date)->format('M d, Y') }}')">

                    {{-- Day badge --}}
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-indigo-400 text-[10px] sm:text-xs font-bold">D{{ $nr->day_number }}</span>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                            <span class="text-gray-400 text-[10px] sm:text-[11px] whitespace-nowrap">{{ \Carbon\Carbon::parse($nr->report_date)->format('M d, Y') }}</span>
                            @if($nr->photo_path)
                            <span class="text-indigo-400 text-[10px]">📷</span>
                            @endif
                        </div>
                        <p class="text-gray-200 text-[11px] sm:text-xs font-medium leading-snug mt-0.5 truncate">{{ Str::limit($nr->description, 50) }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1 shrink-0" onclick="event.stopPropagation()">
                        <button type="button"
                            onclick="openNarrativeModal({{ $nr->id }}, {{ json_encode($nr->description) }})"
                            class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-slate-600 hover:bg-slate-500 text-gray-300 rounded text-[10px] sm:text-xs">✏</button>
                    </div>
                </div>
                @endforeach
            </div>
            </div>

            @else
            <p class="text-gray-400 text-xs sm:text-sm text-center py-4 sm:py-6">No narrative entries yet. Click <strong>+ Daily Report</strong> to start.</p>
            @endif
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
                        onchange="handleFileSelect(this, 15)"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 cursor-pointer">
                    <small id="modal_file_hint" class="text-gray-400 block mt-1">PDF, Word, Images/Files &mdash; Max <strong>15 MB</strong> each</small>
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

    <!-- ===== NARRATIVE SUBMIT/EDIT MODAL ===== -->
    <div id="narrativeModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/70 p-4" onclick="if(event.target===this)closeNarrativeModal()">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700">
                <h3 id="narrativeModalTitle" class="text-lg font-bold text-white">📝 Daily Narrative Report</h3>
                <button onclick="closeNarrativeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg">✕</button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <!-- Hidden fields -->
                <input type="hidden" id="narrativeEntryId" value="">

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Report Date *</label>
                    <input type="date" id="narrativeDate"
                        max="{{ \Carbon\Carbon::now('Asia/Manila')->toDateString() }}"
                        value="{{ \Carbon\Carbon::now('Asia/Manila')->toDateString() }}"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none">
                    <p id="narrativeDateNote" class="text-xs text-gray-500 mt-1">One entry per day. Past dates allowed if you forgot to submit.</p>
                </div>

                <!-- Photo upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">
                        📷 Photo <span class="text-gray-500 font-normal">(optional — max 5 MB)</span>
                    </label>
                    <div id="narrativePhotoArea" class="relative">
                        <input type="file" id="narrativePhoto"
                            accept="image/jpeg,image/png,image/webp"
                            onchange="previewNarrativePhoto(this)"
                            class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg text-sm
                                   file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold
                                   file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, WebP — max 5 MB</p>
                        <p id="narrativePhotoError" class="text-red-400 text-xs mt-1 hidden"></p>
                    </div>
                    <!-- Photo preview -->
                    <div id="narrativePhotoPreview" class="hidden mt-2 relative inline-block">
                        <img id="narrativePreviewImg" src="" alt="Preview"
                            class="max-h-32 rounded-lg border border-slate-600 object-contain">
                        <button type="button" onclick="clearNarrativePhoto()"
                            class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs flex items-center justify-center leading-none">✕</button>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">
                        What did you accomplish today? *
                    </label>
                    <textarea id="narrativeDescription" rows="5" maxlength="5000"
                        placeholder="Describe the tasks you worked on, what you learned, and any observations..."
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none resize-none text-sm leading-relaxed"></textarea>
                    <div class="flex justify-between mt-1">
                        <p id="narrativeDescError" class="text-red-400 text-xs hidden"></p>
                        <p class="text-gray-500 text-xs ml-auto"><span id="narrativeCharCount">0</span>/5000</p>
                    </div>
                </div>

                <!-- Error -->
                <p id="narrativeSubmitError" class="text-red-400 text-sm hidden"></p>
            </div>

            <div class="flex gap-3 px-6 pb-5">
                <button type="button" onclick="closeNarrativeModal()"
                    class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <button type="button" id="narrativeSubmitBtn" onclick="submitNarrative()"
                    class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all">
                    <span id="narrativeSubmitLabel">Submit Report</span>
                </button>
            </div>
        </div>
    </div>
    <!-- ===== END NARRATIVE SUBMIT MODAL ===== -->

    <!-- ===== NARRATIVE VIEW MODAL ===== -->
    <div id="narrativeViewModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/70 p-4" onclick="if(event.target===this)closeNarrativeViewModal()">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700 shrink-0">
                <div>
                    <h3 id="nvTitle" class="text-lg font-bold text-white">Day —</h3>
                    <p id="nvDate" class="text-xs text-gray-400 mt-0.5"></p>
                </div>
                <button onclick="closeNarrativeViewModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg">✕</button>
            </div>
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                <div id="nvPhotoWrap" class="hidden text-center">
                    <img id="nvPhoto" src="" alt="Day photo"
                        class="max-h-52 rounded-xl border border-slate-600 object-contain mx-auto">
                </div>
                <p id="nvDesc" class="text-gray-200 text-sm leading-relaxed whitespace-pre-wrap"></p>
            </div>
            <div class="flex gap-3 px-6 pb-5 shrink-0 border-t border-slate-700 pt-4">
                <button type="button" onclick="closeNarrativeViewModal()"
                    class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold">Close</button>
                <button type="button" id="nvEditBtn" onclick=""
                    class="flex-1 px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-semibold">✏ Edit</button>
            </div>
        </div>
    </div>
    <!-- ===== END NARRATIVE VIEW MODAL ===== -->

    <!-- ===== NARRATIVE DOWNLOAD MODAL ===== -->
    <div id="narrativeDownloadModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/70 p-4" onclick="if(event.target===this)closeNarrativeDownloadModal()">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700">
                <h3 class="text-lg font-bold text-white">⬇ Download Narrative Report</h3>
                <button onclick="closeNarrativeDownloadModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg">✕</button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div class="bg-slate-700/40 rounded-xl p-4 text-center">
                    <div class="text-4xl mb-2">📄</div>
                    <p class="text-white font-semibold text-sm">OJT Narrative Report</p>
                    <p class="text-gray-400 text-xs mt-1">All <span id="dlDayCount" class="text-indigo-400 font-bold"></span> narrative entries compiled into one Word document</p>
                </div>
                <div class="bg-slate-700/20 rounded-lg p-3 space-y-1 text-xs text-gray-400">
                    <p>✓ University header &amp; student info</p>
                    <p>✓ Day-by-day entries with dates</p>
                    <p>✓ Photos embedded per day</p>
                    <p>✓ Signature block</p>
                    <p>✓ Compatible with Microsoft Word</p>
                </div>
            </div>
            <div class="flex gap-3 px-6 pb-5">
                <button type="button" onclick="closeNarrativeDownloadModal()"
                    class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold">Cancel</button>
                <a id="narrativeDownloadLink" href="{{ route('narrative-report.download', $user->id) }}"
                    onclick="closeNarrativeDownloadModal(); setTimeout(() => { if(typeof showSuccess === 'function') showSuccess('📄 Narrative report downloaded successfully!'); }, 300);"
                    class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-center transition-all">
                    📄 Download Report
                </a>
            </div>
        </div>
    </div>
    <!-- ===== END NARRATIVE DOWNLOAD MODAL ===== -->

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
                <h3 class="text-lg font-semibold text-white">🕐 Time Out</h3>
                <button type="button" id="closeTimeoutOptions" onclick="closeTimeoutOptionsModal(); return false;" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <p class="text-gray-400 text-sm mb-4">Take a photo to confirm your time-out.</p>
            <div class="flex flex-col gap-3">
                <button type="button" id="photoTimeoutBtn" onclick="handleTimeoutWithPhoto(); return false;"
                    class="w-full px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold text-lg">
                    📷 Capture Photo &amp; Time Out
                </button>
                <button type="button" id="cancelTimeoutOptions" onclick="closeTimeoutOptionsModal(); return false;"
                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Camera Modal (shared for Time In / Time Out) -->
    <div id="cameraModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-2 sm:p-4">
        <div class="bg-slate-900 rounded-xl w-full max-w-xl sm:max-w-2xl p-4 sm:p-6 border border-slate-700 flex flex-col" style="max-height:95vh">
            <div class="flex justify-between items-center mb-3 shrink-0">
                <h3 class="text-lg font-semibold text-white" id="cameraModalTitle">Capture Photo</h3>
                <button type="button" id="closeCameraModal" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
            </div>

            <!-- Face guide status bar -->
            <div id="faceGuideStatus" class="flex items-center gap-2 px-3 py-2 rounded-lg mb-3 text-sm font-semibold transition-all duration-300 shrink-0" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.4)">
                <span id="faceGuideIcon">🔴</span>
                <span id="faceGuideText" class="text-red-300">Position your face inside the oval frame</span>
            </div>

            <!-- Video container — fills available space, no stretch -->
            <div class="relative rounded-lg overflow-hidden mb-3 transition-all duration-300 flex-1 min-h-0" id="cameraVideoContainer"
                style="border:4px solid #ef4444;background:#000;aspect-ratio:4/3;max-height:60vh">
                <video id="cameraModalVideo" class="w-full h-full camera-video" style="object-fit:contain;display:block" playsinline webkit-playsinline autoplay muted></video>
                <img id="cameraModalImage" src="" alt="Preview" class="hidden absolute inset-0 w-full h-full" style="object-fit:contain">

                <!-- Oval face guide frame — guide only, full photo is captured -->
                <div id="faceGuideOverlay" class="absolute inset-0 pointer-events-none flex items-center justify-center">
                    <!-- Oval border only — no dark overlay, full background visible in capture -->
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <ellipse id="faceOvalBorder" cx="50" cy="46" rx="22" ry="28" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-dasharray="4 2"/>
                    </svg>
                    <div class="absolute bottom-2 left-0 right-0 text-center">
                        <span id="faceGuideLabel" class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(0,0,0,0.6);color:#fca5a5">👤 Align face here</span>
                    </div>
                </div>
            </div>

            <!-- Capture button -->
            <div class="flex gap-2 mb-3 shrink-0" id="cameraCaptureRow">
                <button type="button" id="cameraModalCaptureBtn" disabled
                    class="flex-1 px-4 py-3 rounded-lg font-semibold transition-all duration-300 bg-slate-600 text-slate-400 dark:bg-slate-600 dark:text-slate-400 cursor-not-allowed text-base">
                    📸 Capture
                </button>
            </div>

            <!-- Preview area -->
            <div id="cameraModalPreview" class="hidden shrink-0">
                <p class="text-xs text-gray-400 mb-2">Captured:</p>
                <div class="flex gap-2 mt-2">
                    <button type="button" id="cameraModalRetakeBtn" class="flex-1 px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-semibold hidden">Retake</button>
                    <button type="button" id="cameraModalUseBtn" class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold hidden">Use Photo</button>
                </div>
            </div>

            <!-- Fallback: upload photo from device -->
            <div id="cameraFallback" class="hidden mt-3 border-t border-slate-700 pt-3 shrink-0">
                <p class="text-gray-400 text-xs mb-2">📁 Or upload a photo from your device:</p>
                <input type="file" id="cameraFallbackInput" accept="image/*" capture="user"
                    class="w-full text-sm text-gray-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:font-semibold file:cursor-pointer cursor-pointer bg-slate-800 rounded-lg px-3 py-2 border border-slate-600">
            </div>
        </div>
    </div>

    <script>
        // Global error handler to prevent navigation breaking
        window.addEventListener('error', function(e) {
            console.error('Global error caught:', e.error);
            return false;
        });

        // Navigation recovery function
        function recoverNavigation() {
            try {
                // Ensure at least one section is visible
                const sections = document.querySelectorAll('.dash-section');
                const visibleSections = Array.from(sections).filter(s => !s.classList.contains('hidden'));
                
                if (visibleSections.length === 0) {
                    // No sections visible, show overview
                    const overview = document.getElementById('section-overview');
                    if (overview) {
                        overview.classList.remove('hidden');
                        console.log('Navigation recovered: showing overview section');
                    }
                }
                
                // Ensure at least one nav item is active
                const navItems = document.querySelectorAll('.nav-item[data-section]');
                const activeNavs = Array.from(navItems).filter(n => n.classList.contains('active'));
                
                if (activeNavs.length === 0 && navItems.length > 0) {
                    // No active nav, activate first one
                    navItems[0].classList.add('active');
                    console.log('Navigation recovered: activated first nav item');
                }
            } catch (error) {
                console.error('Error in navigation recovery:', error);
            }
        }

        // Run recovery check periodically
        setInterval(recoverNavigation, 5000);

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

        // ── Lunch-break camera lock (12:05 → 12:49) ──────────────────────
        (function() {
            const btn     = document.getElementById('openCameraForTimeIn');
            const notice  = document.getElementById('lunchLockNotice');
            const counter = document.getElementById('lunchCountdown');
            if (!btn) return;

            function checkLunchLock() {
                const now  = new Date();
                const h    = now.getHours();
                const m    = now.getMinutes();
                const totalMin = h * 60 + m;
                const lockStart = 12 * 60 + 5;   // 12:05
                const lockEnd   = 12 * 60 + 50;  // 12:50

                const locked = totalMin >= lockStart && totalMin < lockEnd;
                btn.disabled = locked;
                if (notice) notice.classList.toggle('hidden', !locked);

                if (locked && counter) {
                    // countdown to 12:50
                    const target = new Date();
                    target.setHours(12, 50, 0, 0);
                    const diff = Math.max(0, Math.floor((target - now) / 1000));
                    const mm = String(Math.floor(diff / 60)).padStart(2, '0');
                    const ss = String(diff % 60).padStart(2, '0');
                    counter.textContent = mm + ':' + ss;
                }
            }

            checkLunchLock();
            setInterval(checkLunchLock, 1000);
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
        let faceDetectLoop = null;
        let faceInFrame = false;
        let cameraPhotoCaptured = false;

        // ===== FACE DETECTION =====
        function setFaceGuide(detected) {
            if (cameraPhotoCaptured) return;
            faceInFrame = detected;
            const container = document.getElementById('cameraVideoContainer');
            const statusBar = document.getElementById('faceGuideStatus');
            const icon = document.getElementById('faceGuideIcon');
            const text = document.getElementById('faceGuideText');
            const oval = document.getElementById('faceOvalBorder');
            const label = document.getElementById('faceGuideLabel');
            const captureBtn = document.getElementById('cameraModalCaptureBtn');

            if (detected) {
                // Green — face in frame
                if (container) container.style.borderColor = '#22c55e';
                if (statusBar) { statusBar.style.background = 'rgba(34,197,94,0.15)'; statusBar.style.borderColor = 'rgba(34,197,94,0.4)'; }
                if (icon) icon.textContent = '🟢';
                if (text) { text.textContent = 'Face detected — ready to capture!'; text.className = 'text-green-300'; }
                if (oval) { oval.setAttribute('stroke', '#22c55e'); oval.setAttribute('stroke-dasharray', '0'); }
                if (label) { label.style.color = '#86efac'; label.textContent = '✓ Face aligned'; }
                if (captureBtn) {
                    captureBtn.disabled = false;
                    captureBtn.className = 'flex-1 px-4 py-2.5 rounded-lg font-semibold transition-all duration-300 bg-green-600 hover:bg-green-700 text-white cursor-pointer';
                    captureBtn.textContent = '📸 Capture';
                }
            } else {
                // Red — no face
                if (container) container.style.borderColor = '#ef4444';
                if (statusBar) { statusBar.style.background = 'rgba(239,68,68,0.15)'; statusBar.style.borderColor = 'rgba(239,68,68,0.4)'; }
                if (icon) icon.textContent = '🔴';
                if (text) { text.textContent = 'Position your face inside the oval frame'; text.className = 'text-red-300'; }
                if (oval) { oval.setAttribute('stroke', '#ef4444'); oval.setAttribute('stroke-dasharray', '4 2'); }
                if (label) { label.style.color = '#fca5a5'; label.textContent = '👤 Align face here'; }
                if (captureBtn) {
                    captureBtn.disabled = true;
                    captureBtn.className = 'flex-1 px-4 py-2.5 rounded-lg font-semibold transition-all duration-300 bg-gray-400 dark:bg-slate-600 text-white dark:text-slate-400 cursor-not-allowed';
                    captureBtn.textContent = '📸 Capture';
                }
            }
        }

        // face-api.js model loaded flag
        let faceApiReady = false;
        (async function loadFaceApi() {
            try {
                if (typeof faceapi === 'undefined') return;
                // Load model weights from jsDelivr CDN — avoids InfinityFree binary file restrictions
                const modelUrl = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js-models@master/tiny_face_detector';
                await faceapi.nets.tinyFaceDetector.loadFromUri(modelUrl);
                faceApiReady = true;
            } catch(e) {
                console.warn('face-api.js model failed to load:', e);
                faceApiReady = false;
            }
        })();

        async function startFaceDetection(videoEl) {
            // ── face-api.js TinyFaceDetector — real neural net, works for all skin tones ──
            if (typeof faceapi !== 'undefined') {
                // Wait up to 12s for model to be ready (CDN can be slow on first load)
                let waited = 0;
                while (!faceApiReady && waited < 12000) {
                    await new Promise(r => setTimeout(r, 100));
                    waited += 100;
                }

                if (faceApiReady) {
                    const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 });
                    let detecting = false;

                    async function faceApiLoop() {
                        faceDetectLoop = requestAnimationFrame(faceApiLoop);
                        if (detecting) return;  // don't stack calls
                        if (!cameraStream || videoEl.readyState < 2 || videoEl.paused) return;
                        detecting = true;
                        try {
                            const result = await faceapi.detectSingleFace(videoEl, options);
                            if (!result) {
                                setFaceGuide(false);
                                detecting = false;
                                return;
                            }
                            // Check the detected face box is inside our oval guide
                            const vw = videoEl.videoWidth  || videoEl.offsetWidth;
                            const vh = videoEl.videoHeight || videoEl.offsetHeight;
                            const box = result.box;
                            // Face center in normalized coords
                            const fcx = (box.x + box.width  / 2) / vw;
                            const fcy = (box.y + box.height / 2) / vh;
                            // Oval guide: cx=50%, cy=46%, rx=22%, ry=28% (from SVG)
                            // Allow 25% extra tolerance so normal head positioning works
                            const oCX = 0.50, oCY = 0.46;
                            const oRX = 0.22 * 1.25, oRY = 0.28 * 1.25;
                            const dx = (fcx - oCX) / oRX;
                            const dy = (fcy - oCY) / oRY;
                            const inOval = dx * dx + dy * dy <= 1.0;
                            // Face must be a reasonable size relative to frame
                            const faceW = box.width / vw;
                            const sizeOk = faceW > 0.08 && faceW < 0.95;
                            setFaceGuide(inOval && sizeOk);
                        } catch(e) {
                            setFaceGuide(false);
                        }
                        detecting = false;
                    }
                    faceDetectLoop = requestAnimationFrame(faceApiLoop);
                    return;
                }
            }

            // ── Fallback: simple motion/presence detection (face-api not available) ─────────
            // Just checks if there's something in front of the camera with enough brightness
            // and variance. Not perfect but better than nothing.
            const dc = document.createElement('canvas');
            let lastTs = 0;
            function fallbackLoop(ts) {
                faceDetectLoop = requestAnimationFrame(fallbackLoop);
                if (ts - lastTs < 200) return;
                lastTs = ts;
                if (!cameraStream || videoEl.readyState < 2) { setFaceGuide(false); return; }
                try {
                    dc.width = 160; dc.height = 120;
                    const ctx = dc.getContext('2d');
                    ctx.drawImage(videoEl, 0, 0, 160, 120);
                    // Sample centre region (rough oval area)
                    const imgData = ctx.getImageData(40, 15, 80, 90).data;
                    let sum = 0, sqSum = 0, n = 0;
                    for (let i = 0; i < imgData.length; i += 4) {
                        const lum = (imgData[i]*77 + imgData[i+1]*150 + imgData[i+2]*29) >> 8;
                        sum += lum; sqSum += lum*lum; n++;
                    }
                    const avg = sum / n;
                    const variance = sqSum / n - avg * avg;
                    // Something meaningful is in front of the camera
                    setFaceGuide(avg > 20 && variance > 300);
                } catch(e) { setFaceGuide(false); }
            }
            faceDetectLoop = requestAnimationFrame(fallbackLoop);
        }
        // ===== END FACE DETECTION =====

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
                // Do NOT enable capture button here — face detection controls it via setFaceGuide(true)
                if (cameraModalCaptureBtn) {
                    cameraModalCaptureBtn.disabled = true;
                    cameraModalCaptureBtn.textContent = '📸 Capture';
                    cameraModalCaptureBtn.onclick = null;
                }
                // Start face detection — setFaceGuide(true) will enable the button when face is aligned
                startFaceDetection(cameraModalVideo);
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
            // Stop face detection loop
            if (faceDetectLoop) { cancelAnimationFrame(faceDetectLoop); faceDetectLoop = null; }
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
            cameraPhotoCaptured = false;
            
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
            cameraPhotoCaptured = false;
            if (cameraModalImage) cameraModalImage.src = '';
            cameraModalImage?.classList.add('hidden');
            cameraModalVideo?.classList.remove('hidden');
            cameraModalPreview?.classList.add('hidden');
            cameraModalRetakeBtn?.classList.add('hidden');
            // reset face guide to red
            setFaceGuide(false);
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
            showPageLoader('Recording time-out… please wait');
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
                        cameraPhotoCaptured = true;
                        stopCamera();
                        setFaceGuide(true);
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

                        showPageLoader('Recording time-in… please wait');
                        try {
                            const resp = await fetch('{{ route("time-in") }}', { method: 'POST', body: fd });
                            if (resp.ok) {
                                closeCameraModal();
                                showSuccess('Time-in recorded successfully!', null, true);
                                return;
                            } else {
                                const txt = await resp.text();
                                console.error('Time-in failed', resp.status, txt);
                                document.getElementById('pageLoader').classList.add('hidden');
                                alert('Failed to record Time In. Please try again.');
                            }
                        } catch (err) {
                            console.error(err);
                            document.getElementById('pageLoader').classList.add('hidden');
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

                        showPageLoader('Recording afternoon time-in… please wait');
                        try {
                            const resp = await fetch('{{ route("time-in") }}', { method: 'POST', body: fd });
                            if (resp.ok) {
                                closeCameraModal();
                                showSuccess('Afternoon session time-in recorded!', null, true);
                                return;
                            } else {
                                document.getElementById('pageLoader').classList.add('hidden');
                                alert('Failed to record afternoon time-in. Please try again.');
                            }
                        } catch (err) {
                            console.error(err);
                            document.getElementById('pageLoader').classList.add('hidden');
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
                        showPageLoader('Recording time-out… please wait');
                        
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
                            document.getElementById('pageLoader').classList.add('hidden');
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
                    // reset face guide to red before restarting
                    cameraPhotoCaptured = false;
                    setFaceGuide(false);
                    // restart camera feed + face detection
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
            try {
                sidebar.classList.toggle('open');
                backdrop.classList.toggle('show');
            } catch (error) {
                console.error('Error toggling sidebar:', error);
            }
        }
        function closeSidebar() {
            try {
                sidebar.classList.remove('open');
                backdrop.classList.remove('show');
            } catch (error) {
                console.error('Error closing sidebar:', error);
            }
        }
        function toggleSidebarCollapse() {
            try {
                sidebarCollapsed = !sidebarCollapsed;
                sidebar.classList.toggle('collapsed', sidebarCollapsed);
                mainContent.classList.toggle('sidebar-collapsed', sidebarCollapsed);
                topHeader.style.left = sidebarCollapsed ? '64px' : '256px';
                localStorage.setItem('sidebarCollapsed', sidebarCollapsed ? '1' : '0');
            } catch (error) {
                console.error('Error toggling sidebar collapse:', error);
            }
        }

        // Navigation safety wrapper
        function safeShowSection(name) {
            if (document.readyState === 'loading') {
                // DOM not ready yet, wait for it
                document.addEventListener('DOMContentLoaded', () => showSection(name));
            } else {
                // DOM is ready, proceed
                showSection(name);
            }
        }

        // Override onclick handlers to use safe version
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[onclick*="showSection"]').forEach(btn => {
                const match = btn.getAttribute('onclick').match(/showSection\('([^']+)'\)/);
                if (match) {
                    const sectionName = match[1];
                    btn.removeAttribute('onclick');
                    btn.addEventListener('click', () => safeShowSection(sectionName));
                }
            });
        });

        const sectionTitles = {
            overview: '🏠 Overview',
            timein: '⏱️ Time In / Out',
            history: '📅 Attendance History',
            requirements: '📁 Requirements',
            reports: '📋 Reports'
        };

        function showSection(name) {
            try {
                if (typeof showDashboardSkeleton === 'function') showDashboardSkeleton(name);

                // hide all sections
                document.querySelectorAll('.dash-section').forEach(s => s.classList.add('hidden'));
                
                // show target section
                const target = document.getElementById('section-' + name);
                if (target) { 
                    target.classList.remove('hidden'); 
                    target.classList.add('dash-section'); 
                } else {
                    console.warn('Section not found:', 'section-' + name);
                    return;
                }
                
                // update active nav state
                document.querySelectorAll('.nav-item[data-section]').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.section === name);
                });
                
                // update header title
                const titleEl = document.getElementById('header-section-title');
                if (titleEl) titleEl.textContent = sectionTitles[name] || name;
                
                // close mobile sidebar
                if (typeof closeSidebar === 'function') {
                    closeSidebar();
                }
                
                // persist active section
                sessionStorage.setItem('activeSection', name);
                
                // trigger section-specific initialization if needed
                if (name === 'timein') {
                    // Initialize camera or other time-in specific features
                    setTimeout(() => {
                        if (typeof initializeTimeIn === 'function') {
                            initializeTimeIn();
                        }
                    }, 100);
                }
                
                // Debug logging
                console.log('Section switched to:', name, 'Target found:', !!target);
            } catch (error) {
                console.error('Error in showSection:', error);
                // Try to recover by showing overview
                setTimeout(() => {
                    const overview = document.getElementById('section-overview');
                    if (overview) {
                        overview.classList.remove('hidden');
                        console.log('Recovered to overview section');
                    }
                }, 100);
            }
        }

        // restore on load with error handling
        (function() {
            try {
                const saved = sessionStorage.getItem('activeSection') || 'overview';
                showSection(saved);
                
                // restore collapse state
                if (localStorage.getItem('sidebarCollapsed') === '1' && window.innerWidth >= 1024) {
                    sidebarCollapsed = true;
                    if (sidebar) sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('sidebar-collapsed');
                    if (topHeader) topHeader.style.left = '64px';
                }
            } catch (error) {
                console.error('Error during initialization:', error);
                // Fallback to overview section
                showSection('overview');
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
                if (sizeMB > 15) {
                    if (errEl) { errEl.textContent = '"' + fileInput.files[i].name + '" exceeds 15 MB.'; errEl.classList.remove('hidden'); }
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
        window.addEventListener('pageshow', function() {
            hideUploadLoader();
            document.getElementById('pageLoader').classList.add('hidden');
        });
        // ===== END UPLOAD LOADER =====

        // ===== UPLOAD MODAL =====
        function openUploadModal(title, maxFiles) {
            // Guard: if called from the OT upload button, check it's enabled
            if (title === 'OT Letter') {
                var btn = document.getElementById('otUploadBtn');
                if (btn && btn.disabled) return;
            }
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
                    'Images only &mdash; Max <strong>' + maxFiles + ' photos</strong>, 15 MB each. You can select files one by one.';
                fileInput.setAttribute('accept', '.jpg,.jpeg,.png,.gif,.webp');
            } else {
                fileInput.removeAttribute('multiple');
                document.getElementById('modal_file_hint').innerHTML =
                    'PDF, Word, Images/Files &mdash; Max <strong>15 MB</strong>';
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

        // ===== DAILY SUBMISSIONS FILTER =====
        function filterDailySubmissions(status) {
            // Update tab styles
            document.querySelectorAll('.daily-tab-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-slate-700', 'text-white');
                btn.classList.add('bg-slate-700/50', 'text-gray-300');
            });
            event.target.classList.add('active', 'bg-slate-700', 'text-white');
            event.target.classList.remove('bg-slate-700/50', 'text-gray-300');

            // Filter rows
            const rows = document.querySelectorAll('.daily-submission-row');
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // ===== NARRATIVE REPORT =====
        let _narrativeEditId = null;

        function openNarrativeModal(entryId, existingDesc) {
            _narrativeEditId = entryId || null;
            document.getElementById('narrativeEntryId').value = _narrativeEditId || '';

            // If editing, pre-fill description; date is locked to the existing entry's date
            const descEl = document.getElementById('narrativeDescription');
            descEl.value = existingDesc || '';
            updateNarrativeCharCount();

            // Title reflects mode
            document.getElementById('narrativeModalTitle').textContent =
                _narrativeEditId ? '✏ Edit Narrative Entry' : '📝 Daily Narrative Report';
            document.getElementById('narrativeSubmitLabel').textContent =
                _narrativeEditId ? 'Save Changes' : 'Submit Report';

            // For new entries, default to today; for edits lock the date field
            const dateEl = document.getElementById('narrativeDate');
            dateEl.disabled = !!_narrativeEditId;
            dateEl.classList.toggle('opacity-50', !!_narrativeEditId);
            document.getElementById('narrativeDateNote').textContent = _narrativeEditId
                ? 'Date is fixed for existing entries.'
                : 'One entry per day. Past dates allowed if you forgot to submit.';

            // Reset photo state
            clearNarrativePhoto();
            document.getElementById('narrativeSubmitError').classList.add('hidden');
            document.getElementById('narrativeDescError').classList.add('hidden');

            document.getElementById('narrativeViewModal').classList.add('hidden');
            document.getElementById('narrativeModal').classList.remove('hidden');
            descEl.focus();
        }

        function closeNarrativeModal() {
            document.getElementById('narrativeModal').classList.add('hidden');
            _narrativeEditId = null;
        }

        function updateNarrativeCharCount() {
            const val = document.getElementById('narrativeDescription').value;
            document.getElementById('narrativeCharCount').textContent = val.length;
        }
        document.getElementById('narrativeDescription')?.addEventListener('input', updateNarrativeCharCount);

        function previewNarrativePhoto(input) {
            const errEl = document.getElementById('narrativePhotoError');
            errEl.classList.add('hidden');
            if (!input.files || !input.files.length) return;
            const file = input.files[0];
            const sizeMB = file.size / (1024 * 1024);
            if (sizeMB > 5) {
                errEl.textContent = 'Photo exceeds 5 MB. Please choose a smaller image.';
                errEl.classList.remove('hidden');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('narrativePreviewImg').src = e.target.result;
                document.getElementById('narrativePhotoPreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function clearNarrativePhoto() {
            document.getElementById('narrativePhoto').value = '';
            document.getElementById('narrativePhotoPreview').classList.add('hidden');
            document.getElementById('narrativePreviewImg').src = '';
            document.getElementById('narrativePhotoError').classList.add('hidden');
        }

        async function submitNarrative() {
            const descEl   = document.getElementById('narrativeDescription');
            const errEl    = document.getElementById('narrativeSubmitError');
            const descErr  = document.getElementById('narrativeDescError');
            const btn      = document.getElementById('narrativeSubmitBtn');
            const label    = document.getElementById('narrativeSubmitLabel');

            errEl.classList.add('hidden');
            descErr.classList.add('hidden');

            const desc = descEl.value.trim();
            if (desc.length < 10) {
                descErr.textContent = 'Please write at least 10 characters describing your day.';
                descErr.classList.remove('hidden');
                descEl.focus();
                return;
            }

            // Photo error check
            const photoErr = document.getElementById('narrativePhotoError');
            if (!photoErr.classList.contains('hidden')) return;

            btn.disabled = true;
            const origLabel = label.textContent;
            label.textContent = 'Saving…';

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');
            formData.append('description', desc);

            const photoFile = document.getElementById('narrativePhoto').files[0];
            if (photoFile) formData.append('photo', photoFile);

            let url, method;
            if (_narrativeEditId) {
                // PUT via POST + _method spoofing
                formData.append('_method', 'PUT');
                url    = '/daily-narrative/' + _narrativeEditId;
                method = 'POST';
            } else {
                const dateVal = document.getElementById('narrativeDate').value;
                if (!dateVal) {
                    errEl.textContent = 'Please select a date.';
                    errEl.classList.remove('hidden');
                    btn.disabled = false; label.textContent = origLabel;
                    return;
                }
                formData.append('report_date', dateVal);
                url    = '/daily-narrative';
                method = 'POST';
            }

            try {
                const res  = await fetch(url, { method, body: formData });
                const data = await res.json();

                if (data.success) {
                    closeNarrativeModal();
                    const isEdit = !!_narrativeEditId;
                    const msg = data.message || (isEdit
                        ? 'Your narrative entry has been updated successfully.'
                        : 'Day ' + (data.narrative?.day_number ?? '') + ' narrative submitted successfully.');
                    
                    // Ensure showSuccess is available
                    if (typeof showSuccess === 'function') {
                        showSuccess(msg, null, true);
                    } else {
                        alert(msg);
                        window.location.reload();
                    }
                } else {
                    errEl.textContent = data.message || 'Something went wrong. Please try again.';
                    errEl.classList.remove('hidden');
                    btn.disabled = false; label.textContent = origLabel;
                }
            } catch (e) {
                errEl.textContent = 'Network error. Please try again.';
                errEl.classList.remove('hidden');
                btn.disabled = false; label.textContent = origLabel;
            }
        }

        // View modal
        function openNarrativeViewModal(id, desc, photoUrl, dayNum, dateStr) {
            document.getElementById('nvTitle').textContent = 'Day ' + dayNum;
            document.getElementById('nvDate').textContent  = dateStr;
            document.getElementById('nvDesc').textContent  = desc;
            const photoWrap = document.getElementById('nvPhotoWrap');
            const photoImg  = document.getElementById('nvPhoto');
            if (photoUrl) {
                photoImg.src = photoUrl;
                photoWrap.classList.remove('hidden');
            } else {
                photoWrap.classList.add('hidden');
            }
            // Wire edit button
            document.getElementById('nvEditBtn').onclick = () => {
                closeNarrativeViewModal();
                openNarrativeModal(id, desc);
            };
            document.getElementById('narrativeViewModal').classList.remove('hidden');
        }
        function closeNarrativeViewModal() {
            document.getElementById('narrativeViewModal').classList.add('hidden');
        }

        // Download modal
        function openNarrativeDownloadModal() {
            const count = document.querySelectorAll('.narrative-entry-row, [data-narrative-id]').length
                        || {{ \App\Models\DailyNarrative::where('student_id', $user->id)->count() }};
            document.getElementById('dlDayCount').textContent = count;
            document.getElementById('narrativeDownloadModal').classList.remove('hidden');
        }
        function closeNarrativeDownloadModal() {
            document.getElementById('narrativeDownloadModal').classList.add('hidden');
        }
        // ===== END NARRATIVE REPORT =====

        // ===== REPORTS SECTION =====
        function toggleReqCard(btn) {
            const detail = btn.nextElementSibling;
            const chevron = btn.querySelector('.req-chevron');
            detail.classList.toggle('hidden');
            if (chevron) chevron.style.transform = detail.classList.contains('hidden') ? '' : 'rotate(180deg)';
        }

        let _dailyShowAll = false;
        function filterDailyReports(status) {
            _dailyShowAll = false;
            document.querySelectorAll('#dailyFilterTabs button').forEach(b => {
                b.className = b.className.replace('bg-indigo-600 text-white','bg-slate-700 text-gray-400 hover:text-white');
            });
            const activeBtn = document.getElementById('dtab-' + status);
            if (activeBtn) activeBtn.className = activeBtn.className.replace('bg-slate-700 text-gray-400 hover:text-white','bg-indigo-600 text-white');

            let visible = 0;
            document.querySelectorAll('.daily-row').forEach(row => {
                const match = status === 'all' || row.dataset.status === status;
                if (match && visible < 10) { row.classList.remove('hidden'); visible++; }
                else row.classList.add('hidden');
            });
            const showMoreBtn = document.getElementById('showMoreDailyBtn');
            if (showMoreBtn) {
                const total = [...document.querySelectorAll('.daily-row')].filter(r => status === 'all' || r.dataset.status === status).length;
                showMoreBtn.classList.toggle('hidden', total <= 10);
                showMoreBtn.textContent = `Show more (${total - visible} remaining)`;
            }
        }

        function showMoreDaily() {
            const activeTab = document.querySelector('#dailyFilterTabs button.bg-indigo-600')?.id?.replace('dtab-','') || 'all';
            const hidden = [...document.querySelectorAll('.daily-row')].filter(r => {
                const match = activeTab === 'all' || r.dataset.status === activeTab;
                return match && r.classList.contains('hidden');
            });
            hidden.slice(0, 20).forEach(r => r.classList.remove('hidden'));
            const remaining = hidden.length - 20;
            const btn = document.getElementById('showMoreDailyBtn');
            if (btn) {
                if (remaining <= 0) btn.classList.add('hidden');
                else btn.textContent = `Show more (${remaining} remaining)`;
            }
        }
        // ===== END REPORTS SECTION =====

        // Confirm modal (logout / home)
        function showConfirm(type) {
            const icon = document.getElementById('confirmIcon');
            const title = document.getElementById('confirmTitle');
            const msg = document.getElementById('confirmMsg');
            const btn = document.getElementById('confirmBtn');
            if (type === 'logout') {
                icon.innerHTML = '<svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>';
                icon.className = 'inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/20 mb-4';
                title.textContent = 'Logout?';
                msg.textContent = 'You will be signed out of your account.';
                btn.textContent = 'Yes, Logout';
                btn.className = 'flex-1 px-5 py-3 text-center text-white rounded-xl font-semibold transition-all bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:scale-105 transform';
                btn.href = '/logout';
                btn.onclick = function() { _allowLeave = true; sessionStorage.clear(); showPageLoader('Signing out…'); };
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
        function showPageLoader(msg) {
            const el = document.getElementById('pageLoader');
            if (el) { document.getElementById('pageLoaderMsg').textContent = msg || 'Please wait…'; el.classList.remove('hidden'); }
        }
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

    <!-- ===== CERTIFICATE IMAGE MODAL ===== -->
    <div id="certImageModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/85 p-4"
         onclick="if(event.target===this)closeCertImageModal()">
        <div class="bg-slate-900 border border-yellow-500/30 rounded-2xl shadow-2xl flex flex-col"
             style="max-width:960px;width:100%;max-height:92vh;">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span class="text-sm font-semibold text-yellow-300">🏅 OJT Certificate of Completion</span>
                <div class="flex items-center gap-2">
                    <button onclick="printCertImage()"
                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">🖨️ Print</button>
                    <button onclick="downloadCertImage()"
                        class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-xs font-semibold">⬇️ Download</button>
                    <button onclick="closeCertImageModal()"
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg">✕</button>
                </div>
            </div>
            <div class="flex-1 overflow-auto flex items-center justify-center p-4 bg-slate-950/50 rounded-b-2xl">
                <img id="certImageEl" src="" alt="Certificate"
                     class="max-w-full max-h-full object-contain rounded-lg shadow-xl">
            </div>
        </div>
    </div>
    <!-- ===== END CERTIFICATE IMAGE MODAL ===== -->

    <script>
    let _certImageUrl = '', _certImageName = '';
    function openCertImageModal(url, name) {
        _certImageUrl = url; _certImageName = name;
        document.getElementById('certImageEl').src = url;
        document.getElementById('certImageModal').classList.remove('hidden');
    }
    function closeCertImageModal() {
        document.getElementById('certImageModal').classList.add('hidden');
        document.getElementById('certImageEl').src = '';
    }
    function printCertImage() {
        const win = window.open('', '_blank');
        win.document.write(`<!DOCTYPE html><html><head><style>
            *{margin:0;padding:0;box-sizing:border-box;}
            body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:#fff;}
            img{max-width:100%;max-height:100vh;object-fit:contain;}
            @page{size:landscape;margin:5mm;}
        </style></head><body><img src="${_certImageUrl}" onload="window.print();window.close()"></body></html>`);
        win.document.close();
    }
    function downloadCertImage() {
        const a = document.createElement('a');
        a.href = _certImageUrl;
        a.download = 'OJT_Certificate_' + _certImageName.replace(/\s+/g,'_') + '.' + _certImageUrl.split('.').pop();
        document.body.appendChild(a); a.click(); document.body.removeChild(a);
    }
    </script>

    <!-- Page loader overlay -->
    <div id="pageLoader" class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-6"
         style="background:rgba(5,13,46,0.95);backdrop-filter:blur(8px);">
        <div class="relative">
            <svg class="animate-spin" style="width:64px;height:64px;" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="rgba(34,197,94,0.2)" stroke-width="3"/>
                <path d="M4 12a8 8 0 018-8" stroke="#4ade80" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-green-500/30 rounded-full animate-pulse"></div>
            </div>
        </div>
        <p id="pageLoaderMsg" style="color:#86efac;font-size:16px;font-weight:600;font-family:sans-serif;letter-spacing:.05em;">Please wait…</p>
    </div>

</body>
</html>
