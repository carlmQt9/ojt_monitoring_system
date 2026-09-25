@php
    // ── Nav badge counts (computed before sidebar renders) ────────────────
    $_navBadgeStudents  = \App\Models\TimeInRecord::where('status', 'pending')
        ->whereNotNull('time_out')->whereHas('student')->count();
    $_navBadgeReports   = \App\Models\StudentRequirement::where('status', 'pending')
        ->whereHas('student')->count();
    // Total pending shown on both nav items
    $_navBadgeTotal     = $_navBadgeStudents + $_navBadgeReports;
    $_coordPendingTimeRecords = \App\Models\TimeInRecord::with('student')
        ->where('status', 'pending')->whereNotNull('time_out')->whereHas('student')
        ->orderBy('date')->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coordinator Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
            background: rgba(234,88,12,0.28);
            border-left: 3px solid #ea580c;
            color: #fb923c;
        }
        .nav-item:not(.active):hover {
            background: rgba(255,255,255,0.05);
            color: #fed7aa;
        }
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
        body.light #sidebar .nav-item.active { background: rgba(234,88,12,0.25) !important; }
        body.light #sidebar .nav-item.active .nav-label,
        body.light #sidebar .nav-item.active .nav-icon { color: #fdba74 !important; }
        body.light #sidebar .nav-item:not(.active):hover { background: rgba(255,255,255,0.08) !important; }
        body.light #top-header { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light #top-header span, body.light #top-header p, body.light #top-header button { color: #1a2a4a !important; }
        /* ===== END SIDEBAR ===== */
        .dash-section { animation: fadeSection 0.25s ease; }
        @keyframes fadeSection { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        @keyframes progressFill {
            from { width: 0; }
            to { width: var(--progress-width); }
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
            max-height: 1200px;
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

        /* New: compact tables and cabinet styles */
        .student-tracking-section { height: calc(100vh - 8rem); display: flex; flex-direction: column; }
        .student-tracking-section .students-table-wrapper { flex: 1; overflow-y: auto; }
        .compact-row td { padding: .5rem .75rem; }
        .cabinet-card { cursor: pointer; }
        .cabinet-body { transition: all .2s ease; }

        /* Cool custom scrollbars for table/cabinet panels */
        .min-table-wrapper::-webkit-scrollbar,
        .cabinet-body::-webkit-scrollbar { width: 10px; height: 10px; }
        .min-table-wrapper::-webkit-scrollbar-track,
        .cabinet-body::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); border-radius: 8px; }
        .min-table-wrapper::-webkit-scrollbar-thumb,
        .cabinet-body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg,#7c3aed,#06b6d4);
            border-radius: 8px;
            border: 2px solid rgba(0,0,0,0.25);
        }
        /* LIGHT MODE - Beautiful soft design */
        body.light { background: #ffffff !important; color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) { background: rgba(255,255,255,0.95) !important; border-color: #fed7aa !important; box-shadow: 0 2px 8px rgba(234,88,12,0.08) !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-orange"] { color: #fff !important; }
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
        body.light a[class*="bg-blue-6"],body.light a[class*="bg-orange-6"] { color: #fff !important; }
        body.light button.bg-indigo-600,body.light button.bg-indigo-700,
        body.light button.bg-red-600,body.light button.bg-red-700,
        body.light button.bg-blue-600,body.light button.bg-blue-700,
        body.light button.bg-green-600,body.light button.bg-green-700,
        body.light button.bg-orange-600,body.light button.bg-orange-700,
        body.light button.bg-purple-600,body.light button.bg-purple-700 { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: linear-gradient(135deg, #fffbf5 0%, #fff7ed 100%) !important; }
        body.light [class*="bg-slate-800"] { background: rgba(255,255,255,0.85) !important; box-shadow: 0 1px 3px rgba(234,88,12,0.08) !important; }
        body.light [class*="bg-slate-700"] { background: rgba(255,251,245,0.9) !important; }
        body.light [class*="bg-slate-6"] { background: #fff7ed !important; }
        body.light [class*="border-slate-7"] { border-color: #fed7aa !important; }
        body.light [class*="border-slate-6"] { border-color: #fed7aa !important; }
        body.light [class*="divide-slate-7"] > * { border-color: #fed7aa !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.95) !important; border-color: #fdba74 !important; color: #1e3a5f !important; box-shadow: 0 1px 2px rgba(234,88,12,0.05) !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #9a6a3a !important; }
        body.light input:focus,body.light textarea:focus,body.light select:focus { border-color: #ea580c !important; box-shadow: 0 0 0 3px rgba(234,88,12,0.1) !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,247,237,0.8) 100%) !important; border-color: #fdba74 !important; border-left: 4px solid #ea580c !important; box-shadow: 0 4px 12px rgba(234,88,12,0.08) !important; }
        body.light .header-info-card h1 { color: #1e3a5f !important; }
        body.light .header-info-card p.subtitle { color: #5a7a9f !important; }
        body.light .header-info-card .stat-label { color: #5a7a9f !important; }
        body.light .header-info-card .stat-value-white { color: #1e3a5f !important; }
        body.light .header-info-card .stat-value-orange { color: #ea580c !important; }
        body.light .header-info-card .stat-value-blue { color: #2563eb !important; }
        body.light .header-info-card .stat-value-indigo { color: #4f46e5 !important; }
        body.light .header-info-card .stat-value-yellow { color: #ca8a04 !important; }
        body.light .header-info-card .divider { background: #fed7aa !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    @include('partials.dashboard-skeleton')

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
                    <p class="text-xs text-gray-400 truncate">Coordinator Portal</p>
                </div>
            </div>
            <button onclick="toggleSidebarCollapse()" class="hidden lg:flex w-7 h-7 items-center justify-center rounded-md text-gray-400 hover:text-white hover:bg-slate-700 transition-colors shrink-0" title="Collapse sidebar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Coordinator Info -->
        <div class="sidebar-user px-4 py-3 border-b border-slate-700/40 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-orange-400 truncate">Coordinator</p>
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
            <button onclick="showSection('companies')" data-section="companies"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">🏢</span>
                <span class="nav-label">Companies</span>
            </button>
            <button onclick="showSection('students')" data-section="students"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">🎓</span>
                <span class="nav-label">Student Tracking</span>
                @if($_navBadgeStudents > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-yellow-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeStudents }}</span>
                @endif
            </button>
            <button onclick="showSection('reports')" data-section="reports"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">📋</span>
                <span class="nav-label flex-1 text-left">Reports & Requirements</span>
                @if($_navBadgeReports > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-orange-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeReports }}</span>
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
        <button onclick="toggleSidebar()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white transition-colors lg:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span id="header-section-title" class="text-sm font-semibold text-white">Overview</span>
        <div class="ml-auto flex items-center gap-2">
            <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                class="w-8 h-8 rounded-full flex items-center justify-center transition-all"
                style="background:rgba(234,88,12,0.8);border:1px solid rgba(253,186,116,0.4)">
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
                <a id="confirmBtn" href="#" class="flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-orange-600 hover:bg-orange-700">Confirm</a>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div id="main-content" class="pt-14 lg:ml-64 min-h-screen transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
            $activeSY = \App\Models\SchoolYear::where('is_active', true)->first();
            $_totalStudents = \App\Models\User::where('role', 'student')
                ->when($activeSY, fn($q) => $q->where('school_year', $activeSY->label))
                ->count();
            $_totalCompanies = \App\Models\Company::count();
            $_pendingReports = $_navBadgeReports;
            $_pendingTimeIns = $_navBadgeStudents;
        @endphp

        <!-- Header Info Card -->
        <section id="section-overview" class="dash-section">
        <div class="header-info-card mb-8 bg-gradient-to-r from-slate-800/50 to-orange-900/30 border border-slate-700 rounded-xl p-6">
            <h1 class="text-4xl font-bold text-white mb-1">Coordinator Dashboard</h1>
            <p class="subtitle text-gray-400 mb-5">Manage student hours, approve/deny edits, view logs, and generate DTR reports</p>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                <div>
                    <span class="stat-label text-sm text-gray-400">👤 Coordinator:</span>
                    <p class="stat-value-white text-lg font-semibold text-white">{{ $user->name }}</p>
                </div>
                @if($activeSY)
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">📅 School Year:</span>
                    <p class="stat-value-orange text-lg font-semibold text-orange-400">{{ $activeSY->label }}</p>
                </div>
                @endif
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">🎓 Total Students:</span>
                    <p class="stat-value-blue text-lg font-semibold text-blue-400">{{ $_totalStudents }}</p>
                </div>
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">🏢 Companies:</span>
                    <p class="stat-value-indigo text-lg font-semibold text-indigo-400">{{ $_totalCompanies }}</p>
                </div>
                <div class="divider h-8 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-sm text-gray-400">🔔 Pending Items:</span>
                    <p class="stat-value-yellow text-lg font-semibold text-yellow-400">{{ $_pendingReports + $_pendingTimeIns }}</p>
                </div>
            </div>
        </div>

        @php
            /* ---- Overview chart data ---- */
            // Student progress buckets
            $_studentsAll = \App\Models\User::where('role','student')
                ->when($activeSY, fn($q)=>$q->where('school_year',$activeSY->label))->get();
            $_buckets = ['0-25%'=>0,'26-50%'=>0,'51-75%'=>0,'76-100%'=>0];
            foreach($_studentsAll as $_s){
                $_sh2 = \App\Models\StudentHours::where('student_id',$_s->id)->first();
                $_req2 = $_sh2 ? $_sh2->total_hours_required : 600;
                $_done2 = $_sh2 ? ($_sh2->hours_completed ?? 0) : 0;
                $_pct2 = $_req2>0 ? ($_done2/$_req2)*100 : 0;
                if($_pct2<=25) $_buckets['0-25%']++;
                elseif($_pct2<=50) $_buckets['26-50%']++;
                elseif($_pct2<=75) $_buckets['51-75%']++;
                else $_buckets['76-100%']++;
            }
            // Reports status counts
            $_repApproved = \App\Models\StudentRequirement::where('status','approved')->whereHas('student')->count();
            $_repPending  = $_navBadgeReports;
            $_repRejected = \App\Models\StudentRequirement::where('status','denied')->whereHas('student')->count();
            // Top 5 companies by intern count
            $_topCompanies = \App\Models\Company::withCount('students')->orderByDesc('students_count')->limit(5)->get();
            // Time-ins last 7 days
            $_dtrLabels = []; $_dtrCounts = [];
            for($i=6;$i>=0;$i--){
                $d=\Carbon\Carbon::now('Asia/Manila')->subDays($i);
                $_dtrLabels[]=$d->format('D');
                $_dtrCounts[]=\App\Models\TimeInRecord::whereDate('date',$d->toDateString())->whereHas('student')->count();
            }
        @endphp

        <!-- Stat cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-orange-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">🎓 Students</div>
                <div class="text-3xl font-bold text-white">{{ $_totalStudents }}</div>
                <p class="text-xs text-gray-500 mt-1">Active this SY</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-blue-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">🏢 Companies</div>
                <div class="text-3xl font-bold text-indigo-400">{{ $_totalCompanies }}</div>
                <p class="text-xs text-gray-500 mt-1">Registered</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-yellow-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">⏳ Pending Reports</div>
                <div class="text-3xl font-bold text-yellow-400">{{ $_repPending }}</div>
                <p class="text-xs text-gray-500 mt-1">Awaiting review</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-5 hover:border-green-500/50 transition-colors">
                <div class="text-gray-400 text-sm mb-1">✅ Approved Reports</div>
                <div class="text-3xl font-bold text-green-400">{{ $_repApproved }}</div>
                <p class="text-xs text-gray-500 mt-1">{{ $_repRejected }} rejected</p>
            </div>
        </div>

        <!-- Charts row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Bar: student progress buckets -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">🎓 Student Progress Distribution</h3>
                <canvas id="chartProgress" height="160"></canvas>
            </div>
            <!-- Doughnut: reports status -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col items-center">
                <h3 class="text-sm font-semibold text-gray-400 mb-4 self-start">📋 Reports Status</h3>
                @if(($_repApproved+$_repPending+$_repRejected)>0)
                <div class="relative w-36 h-36">
                    <canvas id="chartReports"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ $_repApproved+$_repPending+$_repRejected }}</span>
                    </div>
                </div>
                <div class="flex gap-3 mt-3 text-xs flex-wrap justify-center">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>{{ $_repApproved }} approved</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span>{{ $_repPending }} pending</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>{{ $_repRejected }} rejected</span>
                </div>
                @else
                <p class="text-gray-500 text-sm mt-8">No reports yet</p>
                @endif
            </div>
            <!-- Bar: daily time-ins last 7 days -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">⏱️ Daily Time-Ins (7 days)</h3>
                <canvas id="chartDailyTimeins" height="160"></canvas>
            </div>
        </div>

        <!-- Top companies bar chart -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 mb-2">
            <h3 class="text-sm font-semibold text-gray-400 mb-4">🏢 Top Companies by Intern Count</h3>
            <canvas id="chartCompanies" height="80"></canvas>
        </div>

        </section><!-- end overview -->

        <!-- Company Statistics Section -->
        <section id="section-companies" class="dash-section hidden">
        <div class="mb-12">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <h2 class="text-2xl font-bold text-white">Company/Organization Statistics</h2>
                <div class="flex gap-2 flex-wrap">
                    <button onclick="toggleArchivedCompanies()" id="archivedTrashBtn" class="px-3 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm transition-colors">🗑 Archive Trash</button>
                    <button onclick="showAddCompanyModal()" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                        + Add Company
                    </button>
                </div>
            </div>

            <!-- All Companies Overview -->
            <div class="mb-6 bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <h3 class="text-lg font-bold text-white mb-4">All Companies Overview</h3>
                <?php 
                $activeSYLabel = $activeSY ? $activeSY->label : null;
                $allCompanies = \App\Models\Company::withCount(['students' => function($q) use ($activeSYLabel) {
                        if ($activeSYLabel) $q->where('school_year', $activeSYLabel);
                    }])
                    ->orderBy('name', 'asc')
                    ->get();
                $totalCompanies = $allCompanies->count();
                $totalInterns = $allCompanies->sum('students_count');
                $avgInternsPerCompany = $totalCompanies > 0 ? round($totalInterns / $totalCompanies, 1) : 0;
                ?>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 rounded-lg p-3 sm:p-4">
                        <p class="text-blue-300 text-xs sm:text-sm">Total Companies</p>
                        <p class="text-2xl sm:text-3xl font-bold text-blue-400 mt-1 sm:mt-2">{{ $totalCompanies }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 rounded-lg p-3 sm:p-4">
                        <p class="text-green-300 text-xs sm:text-sm">Total Interns</p>
                        <p class="text-2xl sm:text-3xl font-bold text-green-400 mt-1 sm:mt-2">{{ $totalInterns }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 rounded-lg p-3 sm:p-4">
                        <p class="text-purple-300 text-xs sm:text-sm">Avg per Company</p>
                        <p class="text-2xl sm:text-3xl font-bold text-purple-400 mt-1 sm:mt-2">{{ $avgInternsPerCompany }}</p>
                    </div>
                </div>

                @if($allCompanies->isNotEmpty())
                {{-- Desktop table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Company Name</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Industry</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Location</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Interns</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Contact</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody data-pagination-list>
                            @foreach($allCompanies as $company)
                            <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 transition-colors">
                                <td class="py-3 px-3 text-gray-300">{{ $company->name }}</td>
                                <td class="py-3 px-3 text-gray-400 text-sm">{{ $company->industry ?? '-' }}</td>
                                <td class="py-3 px-3 text-gray-400 text-sm">{{ $company->location ?? '-' }}</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-3 py-1 bg-orange-500/20 text-orange-400 rounded-full text-sm font-semibold">
                                        {{ $company->students_count }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-gray-400 text-sm">
                                    @if($company->contact_email)
                                    <a href="mailto:{{ $company->contact_email }}" class="text-blue-400 hover:underline">{{ $company->contact_email }}</a>
                                    @elseif($company->contact_phone)
                                    <a href="tel:{{ $company->contact_phone }}" class="text-blue-400 hover:underline">{{ $company->contact_phone }}</a>
                                    @else
                                    <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="showEditCompanyModal({{ $company->id }}, '{{ addslashes($company->name) }}', '{{ addslashes($company->industry ?? '') }}', '{{ addslashes($company->location ?? '') }}', '{{ addslashes($company->contact_person ?? '') }}', '{{ addslashes($company->contact_email ?? '') }}', '{{ addslashes($company->contact_phone ?? '') }}')" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">Edit</button>
                                        <button onclick="showDeleteCompanyModal({{ $company->id }}, '{{ addslashes($company->name) }}')" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Archive</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Mobile card list --}}
                <div class="sm:hidden space-y-3" data-pagination-list>
                    @foreach($allCompanies as $company)
                    <div class="bg-slate-700/30 border border-slate-600/50 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <p class="text-gray-200 font-semibold text-sm leading-tight">{{ $company->name }}</p>
                            <span class="shrink-0 px-2 py-0.5 bg-orange-500/20 text-orange-400 rounded-full text-xs font-semibold">{{ $company->students_count }} intern{{ $company->students_count != 1 ? 's' : '' }}</span>
                        </div>
                        @if($company->industry)
                        <p class="text-gray-400 text-xs mb-0.5">🏭 {{ $company->industry }}</p>
                        @endif
                        @if($company->location)
                        <p class="text-gray-400 text-xs mb-0.5">📍 {{ $company->location }}</p>
                        @endif
                        @if($company->contact_email)
                        <p class="text-xs mb-2"><a href="mailto:{{ $company->contact_email }}" class="text-blue-400">{{ $company->contact_email }}</a></p>
                        @elseif($company->contact_phone)
                        <p class="text-xs mb-2"><a href="tel:{{ $company->contact_phone }}" class="text-blue-400">{{ $company->contact_phone }}</a></p>
                        @endif
                        <div class="flex gap-2 mt-3">
                            <button onclick="showEditCompanyModal({{ $company->id }}, '{{ addslashes($company->name) }}', '{{ addslashes($company->industry ?? '') }}', '{{ addslashes($company->location ?? '') }}', '{{ addslashes($company->contact_person ?? '') }}', '{{ addslashes($company->contact_email ?? '') }}', '{{ addslashes($company->contact_phone ?? '') }}')"
                                class="flex-1 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-colors">✏️ Edit</button>
                            <button onclick="showDeleteCompanyModal({{ $company->id }}, '{{ addslashes($company->name) }}')"
                                class="flex-1 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-colors">🗑 Archive</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-8">No companies registered yet</p>
                @endif
            </div>

            <!-- Archive Trash Section (hidden by default) -->
            <?php $archivedCompanies = \App\Models\Company::onlyTrashed()->withCount('students')->orderBy('deleted_at', 'desc')->get(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Most Interns Section -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <span class="text-2xl mr-2">📈</span> Most Interns
                    </h3>
                    <?php 
                    $companiesWithMost = \App\Models\Company::withCount(['students' => function($q) use ($activeSYLabel) {
                            if ($activeSYLabel) $q->where('school_year', $activeSYLabel);
                        }])
                        ->orderBy('students_count', 'desc')
                        ->limit(5)
                        ->get();
                    ?>
                    @if($companiesWithMost->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($companiesWithMost as $company)
                        <div class="flex justify-between items-center bg-slate-700/30 p-4 rounded-lg">
                            <div>
                                <p class="text-gray-300 font-semibold">{{ $company->name }}</p>
                                @if($company->industry)
                                <p class="text-gray-400 text-sm">{{ $company->industry }}</p>
                                @endif
                                @if($company->location)
                                <p class="text-gray-400 text-xs">📍 {{ $company->location }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-400">{{ $company->students_count }}</p>
                                <p class="text-gray-400 text-xs">Interns</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-400 text-center py-8">No companies registered yet</p>
                    @endif
                </div>

                <!-- Least Interns Section -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <span class="text-2xl mr-2">📉</span> Least Interns
                    </h3>
                    <?php 
                    $companiesWithLeast = \App\Models\Company::withCount(['students' => function($q) use ($activeSYLabel) {
                            if ($activeSYLabel) $q->where('school_year', $activeSYLabel);
                        }])
                        ->orderBy('students_count', 'asc')
                        ->limit(5)
                        ->get();
                    ?>
                    @if($companiesWithLeast->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($companiesWithLeast as $company)
                        <div class="flex justify-between items-center bg-slate-700/30 p-4 rounded-lg">
                            <div>
                                <p class="text-gray-300 font-semibold">{{ $company->name }}</p>
                                @if($company->industry)
                                <p class="text-gray-400 text-sm">{{ $company->industry }}</p>
                                @endif
                                @if($company->location)
                                <p class="text-gray-400 text-xs">📍 {{ $company->location }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-orange-400">{{ $company->students_count }}</p>
                                <p class="text-gray-400 text-xs">Interns</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-400 text-center py-8">No companies registered yet</p>
                    @endif
                </div>
            </div>

        </div><!-- end mb-12 -->
        </section><!-- end companies -->

        <!-- Display all students with progress (REPLACED with compact table + search) -->
        <section id="section-students" class="dash-section hidden student-tracking-section">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 shrink-0">
                <h2 class="text-2xl font-bold text-white">Student Hours Tracking</h2>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                    <div class="flex items-center gap-2 px-3 py-2.5 w-full sm:w-72 bg-slate-700/50 border border-slate-600 rounded-xl focus-within:border-indigo-500 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                        <input id="studentSearch" type="search" placeholder="Search student by name..."
                            class="flex-1 bg-transparent text-white text-sm placeholder-gray-400 focus:outline-none">
                    </div>
                    <button type="button" onclick="openBulkTimeApprovalModal()" class="w-full sm:w-auto px-3 py-2 {{ $_coordPendingTimeRecords->isNotEmpty() ? 'bg-green-600 hover:bg-green-700' : 'bg-slate-700 hover:bg-slate-600' }} text-white rounded-lg text-sm font-semibold whitespace-nowrap transition-colors">
                        ✅ Review Time-Outs ({{ $_coordPendingTimeRecords->count() }})
                    </button>
                </div>
            </div>

            <?php 
            $activeSchoolYear = $activeSY ? $activeSY->label : null;
            $students = \App\Models\User::where('role', 'student')
                ->when($activeSchoolYear, fn($q) => $q->where(function($inner) use ($activeSchoolYear) {
                    $inner->where('school_year', $activeSchoolYear)->orWhereNull('school_year');
                }))
                ->get();
            ?>

            @if($students->isEmpty())
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                    <p class="text-gray-400">No students found. Start by registering students.</p>
                </div>
            @else
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 flex-col flex-1 min-h-0 hidden md:flex">
                    <!-- Desktop table only -->
                    <div class="flex flex-col students-table-wrapper flex-1 min-h-0">
                        <table id="studentsTable" class="w-full">
                            <thead class="text-gray-400 text-sm border-b border-slate-700/50">
                                <tr>
                                    <th class="py-2 px-3 text-left">Student</th>
                                    <th class="py-2 px-3 text-left">Company</th>
                                    <th class="py-2 px-3 text-left">Progress</th>
                                    <th class="py-2 px-3 text-left">Pending</th>
                                    <th class="py-2 px-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody data-pagination-list data-page-size="10">
                                <?php foreach($students as $student): ?>
                                    <?php 
                                        $studentHours = \App\Models\StudentHours::where('student_id', $student->id)->firstOrCreate(
                                            ['student_id' => $student->id],
                                            ['total_hours_required' => 600, 'hours_completed' => 0, 'hours_remaining' => 600]
                                        );
                                        $actualCompleted = $studentHours->hours_completed ?? 0;
                                        $displayCompleted = $actualCompleted;
                                        $required = $studentHours->total_hours_required ?? 600;
                                        $progressPct = round(($displayCompleted / $required) * 100, 2);
                                        $pendingLogs = \App\Models\DailyHourLog::where('student_id', $student->id)->where('status', 'pending')->count();
                                        $pendingTimeIns = \App\Models\TimeInRecord::where('student_id', $student->id)->whereNotNull('time_out')->where('status', 'pending')->count();
                                        $requirements = \App\Models\StudentRequirement::where('student_id', $student->id)->get();
                                        $pendingReq = $requirements->where('status', 'pending')->count();
                                    ?>
                                    <tr class="compact-row" data-pagination-group="student-{{ $student->id }}" data-student-name="{{ strtolower($student->name) }}" data-student-id="{{ $student->id }}">
                                        <td class="py-2 px-3">{{ $student->name }}<div class="text-xs text-gray-400">{{ $student->email }}</div></td>
                                        <td class="py-2 px-3 text-gray-400 text-sm">{{ $student->company ? $student->company->name : '-' }}</td>
                                        <td class="py-2 px-3">
                                            <div class="text-sm text-gray-300">{{ $progressPct }}%</div>
                                            <div class="w-full bg-slate-700/30 h-2 rounded mt-2 overflow-hidden">
                                                <div class="h-2 bg-gradient-to-r from-green-500 to-blue-500" style="width: {{ max(0, min($progressPct, 100)) }}%"></div>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-yellow-400 font-semibold">{{ $pendingLogs + $pendingTimeIns + $pendingReq }}</td>
                                        <td class="py-2 px-3 text-right">
                                            <button onclick="toggleStudentDetails({{ $student->id }})"
                                                    class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">
                                                View
                                            </button>
                                            <button onclick="openDtrModal({{ $student->id }}, '{{ addslashes($student->name) }}')"
                                                   class="ml-2 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                                View DTR
                                            </button>
                                        </td>
                                    </tr>

                                    <tr id="details-{{ $student->id }}" data-pagination-group="student-{{ $student->id }}" class="hidden bg-slate-900/40">
                                        <td colspan="5" class="p-4">
                                            @php
                                                $coordEval = class_exists('App\\Models\\StudentEvaluation')
                                                    ? \App\Models\StudentEvaluation::where('student_id', $student->id)->first()
                                                    : null;
                                                $evalRating = $coordEval ? $coordEval->rating : null;
                                                if ($coordEval) {
                                                    $rMap = ['outstanding'=>5,'exceeds_expectations'=>4,'meets_expectations'=>3,'needs_improvement'=>2,'unsatisfactory'=>1];
                                                    $wFactors = ['quality_of_work'=>20,'quantity_of_work'=>20,'job_knowledge'=>20,'working_relationships'=>20,'attendance_dependability'=>10,'specific_achievements'=>10];
                                                    $wTotal = 0; $wFilled = true;
                                                    foreach ($wFactors as $wf => $ww) {
                                                        $rv = $coordEval->{$wf.'_rating'} ?? null;
                                                        if (!$rv || !isset($rMap[$rv])) { $wFilled = false; break; }
                                                        $wTotal += ($rMap[$rv] / 5) * $ww;
                                                    }
                                                    $evalMean = $wFilled ? round($wTotal, 2) : null;
                                                } else {
                                                    $evalMean = null;
                                                }
                                            @endphp
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                <div class="bg-slate-800/50 p-3 rounded">
                                                    <p class="text-xs text-gray-400">Completed</p>
                                                    <p class="text-lg font-bold text-green-400">{{ number_format($displayCompleted, 2) }}</p>
                                                </div>
                                                <div class="bg-slate-800/50 p-3 rounded">
                                                    <p class="text-xs text-gray-400">Remaining</p>
                                                    <p class="text-lg font-bold text-blue-400">{{ number_format(max(0, $required - $displayCompleted), 2) }}</p>
                                                </div>
                                                <div class="bg-slate-800/50 p-3 rounded">
                                                    <p class="text-xs text-gray-400">Pending Items</p>
                                                    <p class="text-lg font-bold text-yellow-400">{{ $pendingLogs + $pendingTimeIns + $pendingReq }}</p>
                                                </div>
                                                <div class="bg-slate-800/50 p-3 rounded">
                                                    <p class="text-xs text-gray-400">Evaluation Rating</p>
                                                    @if($displayCompleted < $required)
                                                        <p class="text-sm text-slate-500">🔒 Locked</p>
                                                        <p class="text-xs text-gray-600">{{ number_format($displayCompleted,1) }}/{{ $required }} hrs</p>
                                                    @elseif($coordEval && $evalMean !== null)
                                                        <p class="text-lg font-bold text-blue-400">{{ $evalMean }}%</p>
                                                        <p class="text-xs text-gray-400">
                                                            @if($evalMean >= 96) Outstanding
                                                            @elseif($evalMean >= 86) Very Satisfactory
                                                            @elseif($evalMean >= 76) Satisfactory
                                                            @elseif($evalMean >= 66) Fair
                                                            @elseif($evalMean > 0) Poor
                                                            @endif
                                                        </p>
                                                    @elseif($coordEval)
                                                        <p class="text-sm text-yellow-400">Submitted</p>
                                                        <p class="text-xs text-gray-500">Old format</p>
                                                    @else
                                                        <p class="text-sm text-gray-500">Not evaluated</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-4 flex gap-2 flex-wrap">
                                                <button onclick="showLogsModal({{ $student->id }}, '{{ $student->name }}')" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">View Logs</button>
                                                <button onclick="openDtrModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">View DTR</button>
                                                @if($displayCompleted >= $required)
                                                    <button onclick="showEvalModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded text-sm">Evaluation Rating</button>
                                                @else
                                                    <button disabled title="Student must complete {{ $required }} hours before evaluation ({{ number_format($displayCompleted,2) }}/{{ $required }} hrs)" class="px-3 py-2 bg-slate-600 text-slate-400 rounded text-sm cursor-not-allowed opacity-60">🔒 Evaluation Rating</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- embed last 12 time records as JSON for modal (safe small payload) --}}
                                    <?php
                                        $studentLogs = \App\Models\TimeInRecord::where('student_id', $student->id)
                                            ->orderBy('date', 'desc')
                                            ->limit(12)
                                            ->get()
                                            ->map(function($r) {
                                                return [
                                                    'id' => $r->id,
                                                    'date' => optional($r->date)->format('M d, Y'),
                                                    'time_in' => $r->time_in,
                                                    'time_out' => $r->time_out,
                                                    'status' => $r->status ?? '',
                                                    'photo' => $r->photo_path ? asset('storage/' . $r->photo_path) : null,
                                                ];
                                            })->toArray();
                                    ?>
                                    <script type="application/json" id="studentLogsJson-{{ $student->id }}">
                                        {!! json_encode($studentLogs) !!}
                                    </script>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end desktop container -->

                    <!-- Mobile card list (visible only on mobile) -->
                    <div class="md:hidden space-y-3 mt-2" id="studentsTable" data-pagination-list data-page-size="10">
                        <?php foreach($students as $student): ?>
                        <?php
                            $studentHours2 = \App\Models\StudentHours::where('student_id', $student->id)->firstOrCreate(
                                ['student_id' => $student->id],
                                ['total_hours_required' => 600, 'hours_completed' => 0, 'hours_remaining' => 600]
                            );
                            $displayCompleted2 = $studentHours2->hours_completed ?? 0;
                            $required2 = $studentHours2->total_hours_required ?? 600;
                            $progressPct2 = round(($displayCompleted2 / $required2) * 100, 2);
                            $pendingTotal2 = \App\Models\DailyHourLog::where('student_id',$student->id)->where('status','pending')->count()
                                + \App\Models\TimeInRecord::where('student_id',$student->id)->whereNotNull('time_out')->where('status','pending')->count()
                                + \App\Models\StudentRequirement::where('student_id',$student->id)->where('status','pending')->count();
                        ?>
                        <div class="bg-slate-800/60 rounded-xl p-4 border border-slate-700/60" data-student-name="{{ strtolower($student->name) }}">
                            <!-- Name + company row -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-white font-semibold text-sm">{{ $student->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $student->email }}</p>
                                    <p class="text-gray-400 text-xs mt-0.5">{{ $student->company ? $student->company->name : '-' }}</p>
                                </div>
                                @if($pendingTotal2 > 0)
                                <span class="px-2 py-0.5 bg-yellow-500/20 text-yellow-400 text-xs rounded-full font-semibold shrink-0">{{ $pendingTotal2 }} pending</span>
                                @endif
                            </div>
                            <!-- Progress bar -->
                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>Progress</span>
                                    <span class="text-gray-300 font-semibold">{{ $progressPct2 }}%</span>
                                </div>
                                <div class="w-full bg-slate-700/50 h-2 rounded overflow-hidden">
                                    <div class="h-2 bg-gradient-to-r from-green-500 to-blue-500" style="width: {{ max(0, min($progressPct2, 100)) }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>{{ number_format($displayCompleted2, 1) }} hrs done</span>
                                    <span>{{ number_format(max(0,$required2-$displayCompleted2),1) }} hrs left</span>
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="toggleStudentDetails({{ $student->id }})" class="h-10 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold">View Details</button>
                                <button onclick="showLogsModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">Logs</button>
                                <button onclick="openDtrModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="h-10 bg-slate-600 hover:bg-slate-500 text-white rounded-lg text-xs font-semibold">View DTR</button>
                                @if($displayCompleted2 >= $required2)
                                    <button onclick="showEvalModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="h-10 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-xs font-semibold">Evaluation Rating</button>
                                @else
                                    <button disabled class="h-10 bg-slate-700 text-slate-500 rounded-lg text-xs font-semibold cursor-not-allowed">🔒 Evaluation</button>
                                @endif
                            </div>
                            <!-- Expandable details -->
                            <div id="details-{{ $student->id }}-mobile" class="hidden mt-3 pt-3 border-t border-slate-600">
                                @php
                                    $mobileEval = class_exists('App\\Models\\StudentEvaluation')
                                        ? \App\Models\StudentEvaluation::where('student_id', $student->id)->first()
                                        : null;
                                @endphp
                                <div class="grid grid-cols-2 gap-2 text-center">
                                    <div class="bg-slate-800/50 p-2 rounded">
                                        <p class="text-xs text-gray-400">Done</p>
                                        <p class="text-sm font-bold text-green-400">{{ number_format($displayCompleted2, 1) }}</p>
                                    </div>
                                    <div class="bg-slate-800/50 p-2 rounded">
                                        <p class="text-xs text-gray-400">Left</p>
                                        <p class="text-sm font-bold text-blue-400">{{ number_format(max(0,$required2-$displayCompleted2),1) }}</p>
                                    </div>
                                    <div class="bg-slate-800/50 p-2 rounded">
                                        <p class="text-xs text-gray-400">Pending</p>
                                        <p class="text-sm font-bold text-yellow-400">{{ $pendingTotal2 }}</p>
                                    </div>
                                    <div class="bg-slate-800/50 p-2 rounded">
                                        <p class="text-xs text-gray-400">Eval. Score</p>
                                        @if($mobileEval)
                                            @php
                                                $mRMap = ['outstanding'=>5,'exceeds_expectations'=>4,'meets_expectations'=>3,'needs_improvement'=>2,'unsatisfactory'=>1];
                                                $mWFactors = ['quality_of_work'=>20,'quantity_of_work'=>20,'job_knowledge'=>20,'working_relationships'=>20,'attendance_dependability'=>10,'specific_achievements'=>10];
                                                $mTotal = 0; $mFilled = true;
                                                foreach ($mWFactors as $mf => $mw) {
                                                    $mrv = $mobileEval->{$mf.'_rating'} ?? null;
                                                    if (!$mrv || !isset($mRMap[$mrv])) { $mFilled = false; break; }
                                                    $mTotal += ($mRMap[$mrv] / 5) * $mw;
                                                }
                                            @endphp
                                            @if($mFilled)
                                                <p class="text-sm font-bold text-blue-400">{{ round($mTotal, 1) }}%</p>
                                            @else
                                                <p class="text-xs text-yellow-400">Submitted</p>
                                            @endif
                                        @else
                                            <p class="text-xs text-gray-500">None</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div><!-- end mobile cards -->
            @endif
        </section><!-- end students -->

        <!-- Reports Review Section -->
        <section id="section-reports" class="dash-section hidden">
        <div class="mb-12 mx-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">📋 Student Reports &amp; Requirements</h2>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8">

            <?php
            try {
                $allReports = \App\Models\StudentRequirement::with('student')
                    ->whereHas('student', function($q) {
                        $q->whereNull('deleted_at');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Coordinator reports query failed: ' . $e->getMessage());
                $allReports = collect([]);
            }
            $reportsByStudent = $allReports->groupBy(function($r){ return $r->student->id ?? 'no-student'; });
            ?>

            @if($reportsByStudent->isNotEmpty())
                <!-- Cabinet grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-pagination-list>
                        @foreach($reportsByStudent as $studentId => $reports)
                            <?php $student = $reports->first()->student ?? null; ?>
                            <!-- Each cabinet is fully self-contained -->
                            <div class="bg-slate-800/40 border border-slate-700 rounded-xl overflow-hidden hover:border-slate-600 transition-colors">
                                <!-- Cabinet header -->
                                <div class="flex items-center justify-between gap-4 p-4 hover:bg-slate-700/20 transition-colors">
                                    <div class="min-w-0">
                                        <p class="text-white font-semibold truncate">{{ $student->name ?? 'Unknown Student' }}</p>
                                        <p class="text-gray-400 text-sm truncate">{{ $student?->company?->name ?? '' }}</p>
                                        <p class="text-gray-400 text-xs mt-0.5">{{ $reports->count() }} item(s)</p>
                                    </div>
                                    <button onclick="toggleCabinet('{{ $studentId }}')" class="shrink-0 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">Open Cabinet</button>
                                </div>
                                <!-- Cabinet body: separated by border, no extra margin -->
                                <div id="cabinet-{{ $studentId }}" class="cabinet-body hidden border-t border-slate-700/60 bg-slate-900/30">
                                    <!-- Desktop table -->
                                    <table class="hidden md:table w-full">
                                        <thead>
                                            <tr class="text-gray-400 text-xs border-b border-slate-700/50">
                                                <th class="py-2 px-4 text-left font-semibold">Title</th>
                                                <th class="py-2 px-2 text-left font-semibold">Date</th>
                                                <th class="py-2 px-2 text-left font-semibold">Status</th>
                                                <th class="py-2 px-3 text-right font-semibold"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reports as $report)
                                            <tr class="border-b border-slate-700/30 last:border-0">
                                                <td class="py-2 px-4 text-gray-300 text-sm">{{ $report->title }}</td>
                                                <td class="py-2 px-2 text-gray-400 text-xs whitespace-nowrap">{{ $report->created_at->format('M d, Y') }}</td>
                                                <td class="py-2 px-2">
                                                    <span class="px-2 py-0.5 text-xs rounded-full @if($report->status === 'approved') bg-green-500/20 text-green-300 @elseif($report->status === 'rejected' || $report->status === 'denied') bg-red-500/20 text-red-300 @else bg-yellow-500/20 text-yellow-300 @endif">
                                                        {{ ucfirst($report->status) }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-3 text-right">
                                                    <button onclick="openFileViewer({{ $report->id }}, '{{ addslashes($report->title) }}', '{{ $report->file_path ? asset('storage/' . $report->file_path) : '' }}', '{{ $report->status }}')" 
                                                        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded font-semibold whitespace-nowrap">
                                                        📄 View
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Mobile cards -->
                                    <div class="md:hidden divide-y divide-slate-700/40">
                                        @foreach($reports as $report)
                                        <div class="px-4 py-3">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div class="min-w-0">
                                                    <p class="text-gray-300 text-sm font-medium">{{ $report->title }}</p>
                                                    <p class="text-gray-500 text-xs mt-0.5">{{ $report->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <span class="shrink-0 px-2 py-0.5 text-xs rounded-full @if($report->status === 'approved') bg-green-500/20 text-green-300 @elseif($report->status === 'rejected' || $report->status === 'denied') bg-red-500/20 text-red-300 @else bg-yellow-500/20 text-yellow-300 @endif">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            </div>
                                            <button onclick="openFileViewer({{ $report->id }}, '{{ addslashes($report->title) }}', '{{ $report->file_path ? asset('storage/' . $report->file_path) : '' }}', '{{ $report->status }}')" 
                                                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg font-semibold">
                                                📄 View &amp; Review
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div><!-- end cabinet grid -->
            @else
                <p class="text-gray-400 text-center py-8">No reports submitted yet.</p>
            @endif
            </div><!-- end card -->
        </div><!-- end mb-12 -->
        </section><!-- end reports -->

    </div><!-- end inner px wrapper -->
    </div><!-- end main-content -->

    <!-- ===== DTR VIEWER MODAL ===== -->
    <div id="dtrModal" class="hidden fixed inset-0 z-[70] flex items-center justify-center bg-black/80 p-4" onclick="if(event.target===this)closeDtrModal()">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span id="dtrModalTitle" class="text-sm font-semibold text-white">DTR Record</span>
                <div class="flex items-center gap-2">
                    <a id="dtrOpenLink" href="#" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">↗ Open Full Page</a>
                    <button onclick="closeDtrModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white">✕</button>
                </div>
            </div>
            <div class="flex-1 overflow-hidden">
                <iframe id="dtrFrame" src="" class="w-full h-full border-0" style="min-height:70vh"></iframe>
            </div>
        </div>
    </div>
    <!-- ===== END DTR VIEWER MODAL ===== -->

    <!-- Deny Modal -->
    <div id="denyModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Deny Record</h3>
            
            <form id="denyForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial</label>
                    <textarea name="reason" required rows="4"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none"
                        placeholder="Explain why you're denying this record..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyModal()" 
                        class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">
                        Deny
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Approve Requirement Modal -->
    <div id="approveRequirementModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Approve Requirement</h3>
            
            <form id="approveRequirementForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feedback <span class="text-red-400">*</span></label>
                    <textarea name="feedback" required rows="3"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none"
                        placeholder="Add feedback..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeApproveRequirementModal()" 
                        class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-semibold">
                        Approve
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Requirement Modal -->
    <div id="uploadRequirementModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">Add Requirement</h3>
            
            <form method="POST" action="{{ route('upload-requirement') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="student_id" id="studentIdInput2">

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                    <input type="text" name="name" required 
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none"
                        placeholder="Requirement title">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="2" 
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none"
                        placeholder="Describe the requirement..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">File (Optional)</label>
                    <input type="file" name="file" onchange="checkFileSize(this,5)"
                        accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx,.jpg,.jpeg,.png,.txt"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                    <small class="text-gray-400 block mt-1">Max <strong>5 MB</strong> &mdash; PDF, Word, Excel, PPT, Images, TXT</small>
                    <p id="coord_file_error" class="text-red-400 text-xs mt-1 hidden"></p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeUploadRequirementModal()" 
                        class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-semibold">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Company Modal -->
    <div id="addCompanyModal" class="hidden fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 p-0 sm:p-4">
        <div class="bg-slate-800 rounded-t-2xl sm:rounded-xl w-full sm:max-w-md border border-slate-700 max-h-[90vh] flex flex-col">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-2xl sm:rounded-t-xl flex items-center justify-between shrink-0">
                <h2 class="text-lg font-bold text-white">Add New Company</h2>
                <button type="button" onclick="closeAddCompanyModal()" class="text-white/70 hover:text-white text-xl leading-none">✕</button>
            </div>

            <form action="{{ route('add-company') }}" method="POST" class="p-5 space-y-3 overflow-y-auto">
                @csrf

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-300 mb-1.5">Company Name *</label>
                    <input type="text" name="name" id="company_name" required
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="Enter company name">
                </div>

                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-300 mb-1.5">Industry</label>
                    <input type="text" name="industry" id="industry"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="e.g., Information Technology">
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-1.5">Location</label>
                    <input type="text" name="location" id="location"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="City, Province">
                </div>

                <div>
                    <label for="contact_person" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="Full name">
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="email@company.com">
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Phone</label>
                    <input type="tel" name="contact_phone" id="contact_phone"
                        class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none text-sm"
                        placeholder="09XXXXXXXXX">
                </div>

                <div class="flex gap-3 pt-2 pb-1">
                    <button type="button" onclick="closeAddCompanyModal()" 
                        class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors text-sm font-semibold">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-semibold text-sm">
                        Add Company
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Company Modal -->
    <div id="deleteCompanyModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-white mb-4">Archive Company</h3>
            <p class="text-gray-300 mb-6">Are you sure you want to archive <span id="deleteCompanyName" class="text-red-400 font-semibold"></span>? The company will be moved to the archive trash.</p>
            <form id="deleteCompanyForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteCompanyModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">Archive</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Company Modal -->
    <div id="editCompanyModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-xl max-w-md w-full border border-slate-700">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-xl">
                <h2 class="text-xl font-bold text-white">Edit Company</h2>
            </div>
            <form id="editCompanyForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Company Name *</label>
                    <input type="text" name="name" id="edit_company_name" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Industry</label>
                    <input type="text" name="industry" id="edit_industry"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Location</label>
                    <input type="text" name="location" id="edit_location"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contact Person</label>
                    <input type="text" name="contact_person" id="edit_contact_person"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contact Email</label>
                    <input type="email" name="contact_email" id="edit_contact_email"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contact Phone</label>
                    <input type="tel" name="contact_phone" id="edit_contact_phone"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditCompanyModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-semibold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Force Delete Company Modal -->
    <div id="forceDeleteCompanyModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-[200] p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-white mb-4">Permanently Delete Company</h3>
            <p class="text-gray-300 mb-6">This will <span class="text-red-400 font-semibold">permanently delete</span> <span id="forceDeleteCompanyName" class="text-red-400 font-semibold"></span>. This action cannot be undone.</p>
            <form id="forceDeleteCompanyForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeForceDeleteModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-800 hover:bg-red-900 text-white rounded-lg font-semibold">Delete Forever</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Archived Companies Modal -->
    <div id="archivedCompaniesModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg w-full max-w-3xl max-h-[85vh] flex flex-col shadow-xl border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🗑</span>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Archived Companies</h3>
                </div>
                <button onclick="closeArchivedCompaniesModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-light">×</button>
            </div>
            <div class="px-6 py-3 border-b border-gray-100 dark:border-slate-700">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" id="archivedCompaniesSearch" placeholder="Search companies..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                        oninput="filterBladeArchive('archivedCompaniesSearch', '.archived-co-row', '.archived-co-card')">
                </div>
            </div>
            <div class="overflow-auto flex-1 p-4">
                @if($archivedCompanies->isNotEmpty())
                {{-- Desktop table --}}
                <div class="hidden sm:block">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Company Name</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Industry</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Location</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Archived On</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedCompanies as $archived)
                            <tr class="archived-co-row border-b border-slate-700/50 hover:bg-slate-700/20 transition-colors opacity-80" data-search="{{ strtolower($archived->name . ' ' . ($archived->industry ?? '') . ' ' . ($archived->location ?? '')) }}">
                                <td class="py-3 px-3 text-gray-400 line-through">{{ $archived->name }}</td>
                                <td class="py-3 px-3 text-gray-500 text-sm">{{ $archived->industry ?? '-' }}</td>
                                <td class="py-3 px-3 text-gray-500 text-sm">{{ $archived->location ?? '-' }}</td>
                                <td class="py-3 px-3 text-center text-gray-500 text-sm">{{ $archived->deleted_at->format('M d, Y') }}</td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('restore-company', $archived->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Restore</button>
                                        </form>
                                        <button onclick="showForceDeleteModal({{ $archived->id }}, '{{ addslashes($archived->name) }}')" class="px-3 py-1 bg-red-800 hover:bg-red-900 text-white rounded text-sm">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Mobile cards --}}
                <div class="sm:hidden space-y-3">
                    @foreach($archivedCompanies as $archived)
                    <div class="archived-co-card bg-slate-700/30 border border-slate-600/50 rounded-xl p-4 opacity-90" data-search="{{ strtolower($archived->name . ' ' . ($archived->industry ?? '') . ' ' . ($archived->location ?? '')) }}">
                        <p class="text-gray-400 line-through font-semibold text-sm mb-0.5">{{ $archived->name }}</p>
                        @if($archived->industry)<p class="text-gray-500 text-xs">🏭 {{ $archived->industry }}</p>@endif
                        @if($archived->location)<p class="text-gray-500 text-xs">📍 {{ $archived->location }}</p>@endif
                        <p class="text-gray-500 text-xs mt-1 mb-3">Archived: {{ $archived->deleted_at->format('M d, Y') }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('restore-company', $archived->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold">♻️ Restore</button>
                            </form>
                            <button onclick="showForceDeleteModal({{ $archived->id }}, '{{ addslashes($archived->name) }}')"
                                class="flex-1 py-1.5 bg-red-800 hover:bg-red-900 text-white rounded-lg text-xs font-semibold">🗑 Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-10">No archived companies.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- File Viewer + Review Modal -->
    <div id="fileViewerModal" class="hidden fixed inset-0 bg-black/80 z-[60] flex flex-col">
        <!-- Header bar -->
        <div class="flex items-center justify-between px-4 py-3 bg-slate-900 border-b border-slate-700 shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <span id="fvTitle" class="text-white font-semibold truncate text-sm"></span>
                <span id="fvStatus" class="px-2 py-0.5 text-xs rounded-full"></span>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="toggleFullscreen()" title="Fullscreen" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm">⛶ Fullscreen</button>
                <button onclick="closeFileViewer()" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm">✕ Close</button>
            </div>
        </div>

        <!-- File preview area -->
        <div class="flex-1 overflow-hidden bg-slate-950 relative">
            <iframe id="fvFrame" src="" class="w-full h-full border-0"></iframe>
            <img id="fvImage" src="" alt="" class="hidden w-full h-full object-contain p-4">
            <div id="fvNoPreview" class="hidden absolute inset-0 flex flex-col items-center justify-center gap-4">
                <span class="text-6xl">📄</span>
                <p class="text-gray-400">Preview not available for this file type.</p>
                <a id="fvDownload" href="#" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">⬇ Open / Download File</a>
            </div>
        </div>

        <!-- Action bar (only shown for pending reports) -->
        <div id="fvActions" class="hidden shrink-0 bg-slate-900 border-t border-slate-700 px-4 py-3">
            <div class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <textarea id="fvFeedback" rows="2" placeholder="Feedback (required)..."
                    required
                    class="flex-1 px-3 py-2 bg-slate-700/60 border border-slate-600 text-white rounded-lg text-sm focus:outline-none focus:border-blue-500 resize-none"></textarea>
                <div class="flex gap-2 sm:flex-col">
                    <button onclick="submitReview('approve')" class="flex-1 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-all">✓ Approve</button>
                    <button onclick="submitReview('reject')" class="flex-1 px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transition-all">✗ Deny</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Coordinator Deny Time-In Modal -->
    <div id="coordDenyTimeModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[70]">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-white mb-6">Deny Time-In Record</h3>
            <form id="coordDenyTimeForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial <span class="text-red-400">*</span></label>
                    <textarea name="reason" required rows="3"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none"
                        placeholder="Explain why..."></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeCoordDenyTimeModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">Deny</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Modal -->
    <div id="logsModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-slate-900 rounded-xl max-w-3xl w-full p-6 border border-slate-700">
            <div class="flex justify-between items-center mb-4">
                <h3 id="logsModalTitle" class="text-lg font-semibold text-white">Time Logs</h3>
                <button type="button" onclick="closeLogsModal()" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <div id="logsModalBody" class="max-h-96 overflow-y-auto space-y-3">
                <!-- Populated dynamically -->
            </div>
        </div>
    </div>

    <div id="bulkTimeApprovalModal" class="hidden fixed inset-0 z-[80] flex items-start sm:items-center justify-center overflow-y-auto bg-black/70 p-3 sm:p-6">
        <div class="bg-slate-900 border border-slate-700 rounded-xl max-w-3xl w-full max-h-[calc(100vh-1.5rem)] sm:max-h-[85vh] overflow-hidden flex flex-col shadow-2xl">
            <div class="flex items-center justify-between px-4 py-3 sm:px-5 border-b border-slate-700 shrink-0">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-white">Review Pending Time-Outs</h3>
                    <p class="text-xs sm:text-sm text-gray-400 mt-1">Check the records before approving.</p>
                </div>
                <button type="button" onclick="closeBulkTimeApprovalModal()" class="text-gray-400 hover:text-white text-xl">✕</button>
            </div>
            <div class="p-3 sm:p-5 overflow-y-auto min-h-0">
                <div class="space-y-2">
                        @if($_coordPendingTimeRecords->isEmpty())
                            <div class="p-6 text-center text-gray-400 border border-slate-700 rounded-lg">No eligible pending timed-out records found.</div>
                        @endif
                        @foreach($_coordPendingTimeRecords as $record)
                            <div class="rounded-lg border border-slate-700 bg-slate-800/60 p-3 text-sm text-gray-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div><p class="font-semibold">{{ $record->student->name }}</p><p class="text-xs text-gray-500">{{ $record->student->email }}</p></div>
                                    <button type="button" onclick="closeBulkTimeApprovalModal(); showLogsModal({{ $record->student_id }}, '{{ addslashes($record->student->name) }}')" class="self-start sm:self-auto px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">View Logs</button>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 text-xs">
                                    <div><span class="block text-gray-500">Date</span>{{ $record->date->format('M d, Y') }}</div>
                                    <div><span class="block text-gray-500">Session</span>{{ ucfirst($record->session ?? '-') }}</div>
                                    <div><span class="block text-gray-500">Time</span>{{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }} - {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}</div>
                                    <div><span class="block text-gray-500">Hours</span>{{ number_format($record->regular_hours ?? 0, 2) }}h @if(floatval($record->ot_hours ?? 0) > 0)<span class="text-yellow-400">+{{ number_format($record->ot_hours, 2) }} OT</span>@endif</div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-3 p-3 sm:p-5 border-t border-slate-700 shrink-0 bg-slate-900">
                <button type="button" onclick="closeBulkTimeApprovalModal()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                <form method="POST" action="{{ url('/approve-all-pending-time-in') }}" class="flex-1">@csrf
                    <button type="submit" @disabled($_coordPendingTimeRecords->isEmpty()) class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-slate-700 disabled:text-gray-500 disabled:cursor-not-allowed text-white rounded-lg font-semibold">Approve All</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Global error handler to prevent navigation breaking
        window.addEventListener('error', function(e) {
            console.error('Global error caught:', e.error);
            return false;
        });

        // ===== FILE SIZE VALIDATION =====
        function checkFileSize(input, maxMB) {
            const errEl = document.getElementById('coord_file_error');
            if (input.files && input.files[0]) {
                const sizeMB = input.files[0].size / (1024 * 1024);
                if (sizeMB > maxMB) {
                    input.value = '';
                    const msg = `File too large. Max allowed: ${maxMB} MB. Your file: ${sizeMB.toFixed(2)} MB.`;
                    if (errEl) { errEl.textContent = msg; errEl.classList.remove('hidden'); }
                    else alert(msg);
                    return false;
                }
            }
            if (errEl) errEl.classList.add('hidden');
            return true;
        }
        // ===== END FILE SIZE VALIDATION =====

        // ===== DTR MODAL =====
        function openDtrModal(studentId, studentName) {
            const url = '{{ url("/generate-dtr") }}/' + studentId;
            document.getElementById('dtrModalTitle').textContent = studentName + ' — DTR Record';
            document.getElementById('dtrOpenLink').href = url;
            document.getElementById('dtrFrame').src = url;
            document.getElementById('dtrModal').classList.remove('hidden');
        }
        function closeDtrModal() {
            document.getElementById('dtrModal').classList.add('hidden');
            document.getElementById('dtrFrame').src = '';
        }
        // ===== END DTR MODAL =====

        // ===== OVERVIEW CHARTS =====
        (function(){
            const gridColor = 'rgba(148,163,184,0.1)';
        window.openBulkTimeApprovalModal = function() {
            document.getElementById('bulkTimeApprovalModal').classList.remove('hidden');
        };
        window.closeBulkTimeApprovalModal = function() {
            document.getElementById('bulkTimeApprovalModal').classList.add('hidden');
        };
            const tickColor = '#94a3b8';

            // Bar: student progress buckets
            new Chart(document.getElementById('chartProgress'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($_buckets)) !!},
                    datasets: [{ data: {!! json_encode(array_values($_buckets)) !!},
                        backgroundColor: ['#f97316','#fb923c','#fdba74','#22c55e'],
                        borderRadius: 6, borderSkipped: false }]
                },
                options: {
                    plugins:{ legend:{display:false} },
                    scales:{
                        x:{ ticks:{color:tickColor}, grid:{display:false} },
                        y:{ ticks:{color:tickColor,stepSize:1}, grid:{color:gridColor}, beginAtZero:true }
                    }, animation:{duration:900}
                }
            });

            // Doughnut: reports status
            const rCanvas = document.getElementById('chartReports');
            if(rCanvas){
                new Chart(rCanvas,{
                    type:'doughnut',
                    data:{ datasets:[{ data:[{{ $_repApproved }},{{ $_repPending }},{{ $_repRejected }}],
                        backgroundColor:['#22c55e','#facc15','#ef4444'], borderWidth:0, hoverOffset:4 }] },
                    options:{ cutout:'72%', plugins:{legend:{display:false},tooltip:{enabled:false}}, animation:{duration:900} }
                });
            }

            // Bar: daily time-ins last 7 days
            new Chart(document.getElementById('chartDailyTimeins'),{
                type:'bar',
                data:{
                    labels: {!! json_encode($_dtrLabels) !!},
                    datasets:[{ data:{!! json_encode($_dtrCounts) !!},
                        backgroundColor:'rgba(234,88,12,0.7)', borderRadius:6, borderSkipped:false }]
                },
                options:{
                    plugins:{legend:{display:false}},
                    scales:{
                        x:{ticks:{color:tickColor},grid:{display:false}},
                        y:{ticks:{color:tickColor,stepSize:1},grid:{color:gridColor},beginAtZero:true}
                    }, animation:{duration:900}
                }
            });

            // Horizontal bar: top companies
            new Chart(document.getElementById('chartCompanies'),{
                type:'bar',
                data:{
                    labels: {!! json_encode($_topCompanies->pluck('name')->toArray()) !!},
                    datasets:[{ data:{!! json_encode($_topCompanies->pluck('students_count')->toArray()) !!},
                        backgroundColor:'rgba(99,102,241,0.75)', borderRadius:6, borderSkipped:false }]
                },
                options:{
                    indexAxis:'y',
                    plugins:{legend:{display:false}},
                    scales:{
                        x:{ticks:{color:tickColor,stepSize:1},grid:{color:gridColor},beginAtZero:true},
                        y:{ticks:{color:tickColor},grid:{display:false}}
                    }, animation:{duration:900}
                }
            });
        })();
        // ===== END OVERVIEW CHARTS =====

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

        const sectionTitles = {
            overview: '🏠 Overview',
            companies: '🏢 Companies',
            students: '🎓 Student Tracking',
            reports: '📋 Reports & Requirements'
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
                sessionStorage.setItem('coordinator_activeSection', name);
                
                // trigger section-specific data loading
                if (name === 'companies') {
                    setTimeout(() => {
                        if (typeof loadCompanyData === 'function') {
                            loadCompanyData();
                        }
                    }, 100);
                } else if (name === 'students') {
                    setTimeout(() => {
                        if (typeof loadStudentData === 'function') {
                            loadStudentData();
                        }
                    }, 100);
                }
                
                // Debug logging
                console.log('Coordinator section switched to:', name, 'Target found:', !!target);
            } catch (error) {
                console.error('Error in showSection:', error);
                // Try to recover by showing overview
                setTimeout(() => {
                    const overview = document.getElementById('section-overview');
                    if (overview) {
                        overview.classList.remove('hidden');
                        console.log('Coordinator recovered to overview section');
                    }
                }, 100);
            }
        }

        (function() {
            try {
                showSection(sessionStorage.getItem('coordinator_activeSection') || 'overview');
                if (localStorage.getItem('sidebarCollapsed') === '1' && window.innerWidth >= 1024) {
                    sidebarCollapsed = true;
                    if (sidebar) sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('sidebar-collapsed');
                    if (topHeader) topHeader.style.left = '64px';
                }
            } catch (error) {
                console.error('Error during coordinator initialization:', error);
                // Fallback to overview section
                showSection('overview');
            }
        })();
        // ===== END SIDEBAR LOGIC =====

        // Toggle student card expansion (accordion style: only one expanded at a time)
        function toggleStudentExpand(element) {
            const card = element.closest('.student-card');
            const isExpanding = !card.classList.contains('expanded');
            
            if (isExpanding) {
                // Collapse all other cards
                document.querySelectorAll('.student-card').forEach(c => {
                    if (c !== card) {
                        c.classList.remove('expanded');
                    }
                });
                // Expand this card
                card.classList.add('expanded');
            } else {
                // Collapse this card
                card.classList.remove('expanded');
            }
        }

        // Tab switching: per-card handlers to avoid cross-card conflicts/freezes
        document.querySelectorAll('.student-card').forEach(card => {
            const tabButtonsContainer = card.querySelector('.border-b .flex');
            if (!tabButtonsContainer) return;
            const buttons = Array.from(tabButtonsContainer.querySelectorAll('.tab-button'));
            const tabContents = Array.from(card.querySelectorAll('.tab-content'));

            function deactivateAll() {
                buttons.forEach(btn => {
                    btn.classList.remove('border-orange-500', 'text-orange-400');
                    btn.classList.add('border-transparent', 'text-gray-400');
                });
                tabContents.forEach(tab => tab.classList.add('hidden'));
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    deactivateAll();
                    this.classList.remove('border-transparent', 'text-gray-400');
                    this.classList.add('border-orange-500', 'text-orange-400');
                    const target = card.querySelector('#' + tabName);
                    if (target) target.classList.remove('hidden');
                });
            });

            // Initialize: ensure one tab is visible per card
            const anyVisible = tabContents.some(t => !t.classList.contains('hidden'));
            if (!anyVisible && buttons.length > 0) {
                buttons[0].click();
            }
        });

        // Log Hours feature removed

        function showDenyModal(type, recordId) {
            const form = document.getElementById('denyForm');
            const url = type === 'hours' ? `{{ url('/deny-hours') }}/${recordId}` : `{{ url('/deny-time-in') }}/${recordId}`;
            form.action = url;
            document.getElementById('denyModal').classList.remove('hidden');
        }

        function closeDenyModal() {
            document.getElementById('denyModal').classList.add('hidden');
        }

        function showUploadRequirementModal(studentId, studentName) {
            document.getElementById('studentIdInput2').value = studentId;
            document.getElementById('uploadRequirementModal').classList.remove('hidden');
        }

        function closeUploadRequirementModal() {
            document.getElementById('uploadRequirementModal').classList.add('hidden');
        }

        function showApproveRequirementModal(requirementId) {
            document.getElementById('approveRequirementForm').action = `{{ url('/approve-requirement') }}/${requirementId}`;
            document.getElementById('approveRequirementModal').classList.remove('hidden');
        }

        function closeApproveRequirementModal() {
            document.getElementById('approveRequirementModal').classList.add('hidden');
        }

        function showLogsModal(studentId, studentName) {
            const t = document.getElementById('studentLogsJson-' + studentId);
            document.getElementById('logsModalTitle').textContent = studentName + ' — Recent Time Logs';
            const body = document.getElementById('logsModalBody');
            body.innerHTML = '';
            if (!t) {
                body.innerHTML = '<p class="text-gray-400">No logs available.</p>';
                document.getElementById('logsModal').classList.remove('hidden');
                return;
            }
            let logs;
            try { logs = JSON.parse(t.textContent || '[]'); } catch (e) { logs = []; }
            if (!logs.length) {
                body.innerHTML = '<p class="text-gray-400">No logs available.</p>';
            } else {
                let html = '<table class="w-full text-left"><thead><tr class="text-xs text-gray-400"><th class="py-2 pr-3">Date</th><th class="py-2 pr-3">Time In</th><th class="py-2 pr-3">Time Out</th><th class="py-2 pr-3">Status</th><th class="py-2 pr-3">Photo</th><th class="py-2">Action</th></tr></thead><tbody>';
                logs.forEach(l => {
                    const statusBadge = l.status === 'approved'
                        ? `<span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-300">${l.status}</span>`
                        : l.status === 'denied'
                        ? `<span class="px-2 py-0.5 text-xs rounded-full bg-red-500/20 text-red-300">${l.status}</span>`
                        : `<span class="px-2 py-0.5 text-xs rounded-full bg-yellow-500/20 text-yellow-300">${l.status || 'pending'}</span>`;
                    let actions = '-';
                    if (l.status === 'pending') {
                        if (!l.time_out) {
                            actions = `<span class="text-blue-300 text-xs" title="Student has not timed out yet">⏳ Active</span>`;
                        } else {
                            actions = `<div class="flex gap-1">
                                <form method="POST" action="{{ url('/approve-time-in') }}/${l.id}" style="display:inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">Approve</button>
                                </form>
                                <button onclick="showCoordDenyTimeModal(${l.id})" class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">Deny</button>
                            </div>`;
                        }
                    }
                    html += `<tr class="border-b border-slate-700/30"><td class="py-2 pr-3 text-sm">${l.date || '-'}</td><td class="py-2 pr-3 text-sm">${l.time_in || '-'}</td><td class="py-2 pr-3 text-sm">${l.time_out || '-'}</td><td class="py-2 pr-3 text-sm">${statusBadge}</td><td class="py-2 pr-3 text-sm">${l.photo ? '<button onclick="openPhotoPopup(\'' + l.photo + '\')" class="text-blue-400 hover:underline">View</button>' : '-'}</td><td class="py-2 text-sm">${actions}</td></tr>`;
                });
                html += '</tbody></table>';
                body.innerHTML = html;
            }
            document.getElementById('logsModal').classList.remove('hidden');
        }

        function closeLogsModal() {
            document.getElementById('logsModal').classList.add('hidden');
        }

        function showCoordDenyTimeModal(recordId) {
            document.getElementById('coordDenyTimeForm').action = `{{ url('/deny-time-in') }}/${recordId}`;
            document.getElementById('coordDenyTimeModal').classList.remove('hidden');
        }
        function closeCoordDenyTimeModal() {
            document.getElementById('coordDenyTimeModal').classList.add('hidden');
        }

        // Toggle student card expansion (accordion style: only one expanded at a time)
        function toggleStudentExpand(element) {
            const card = element.closest('.student-card');
            const isExpanding = !card.classList.contains('expanded');
            
            if (isExpanding) {
                // Collapse all other cards
                document.querySelectorAll('.student-card').forEach(c => {
                    if (c !== card) {
                        c.classList.remove('expanded');
                    }
                });
                // Expand this card
                card.classList.add('expanded');
            } else {
                // Collapse this card
                card.classList.remove('expanded');
            }
        }

        // Tab switching: per-card handlers to avoid cross-card conflicts/freezes
        document.querySelectorAll('.student-card').forEach(card => {
            const tabButtonsContainer = card.querySelector('.border-b .flex');
            if (!tabButtonsContainer) return;
            const buttons = Array.from(tabButtonsContainer.querySelectorAll('.tab-button'));
            const tabContents = Array.from(card.querySelectorAll('.tab-content'));

            function deactivateAll() {
                buttons.forEach(btn => {
                    btn.classList.remove('border-orange-500', 'text-orange-400');
                    btn.classList.add('border-transparent', 'text-gray-400');
                });
                tabContents.forEach(tab => tab.classList.add('hidden'));
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    deactivateAll();
                    this.classList.remove('border-transparent', 'text-gray-400');
                    this.classList.add('border-orange-500', 'text-orange-400');
                    const target = card.querySelector('#' + tabName);
                    if (target) target.classList.remove('hidden');
                });
            });

            // Initialize: ensure one tab is visible per card
            const anyVisible = tabContents.some(t => !t.classList.contains('hidden'));
            if (!anyVisible && buttons.length > 0) {
                buttons[0].click();
            }
        });

        // Log Hours feature removed

        function showDenyModal(type, recordId) {
            const form = document.getElementById('denyForm');
            const url = type === 'hours' ? `{{ url('/deny-hours') }}/${recordId}` : `{{ url('/deny-time-in') }}/${recordId}`;
            form.action = url;
            document.getElementById('denyModal').classList.remove('hidden');
        }

        function closeDenyModal() {
            document.getElementById('denyModal').classList.add('hidden');
        }

        function showUploadRequirementModal(studentId, studentName) {
            document.getElementById('studentIdInput2').value = studentId;
            document.getElementById('uploadRequirementModal').classList.remove('hidden');
        }

        function closeUploadRequirementModal() {
            document.getElementById('uploadRequirementModal').classList.add('hidden');
        }

        function showApproveRequirementModal(requirementId) {
            document.getElementById('approveRequirementForm').action = `{{ url('/approve-requirement') }}/${requirementId}`;
            document.getElementById('approveRequirementModal').classList.remove('hidden');
        }

        function closeApproveRequirementModal() {
            document.getElementById('approveRequirementModal').classList.add('hidden');
        }

        // New: Search & details toggles
        function toggleStudentDetails(studentId) {
            // Desktop accordion
            document.querySelectorAll('tr[id^="details-"]').forEach(r => {
                if (r.id === 'details-' + studentId) {
                    r.classList.toggle('hidden');
                    if (!r.classList.contains('hidden')) {
                        setTimeout(() => r.scrollIntoView({ behavior: 'smooth', block: 'center' }), 80);
                    }
                } else {
                    r.classList.add('hidden');
                }
            });
            // Mobile accordion
            document.querySelectorAll('[id^="details-"][id$="-mobile"]').forEach(el => {
                if (el.id === 'details-' + studentId + '-mobile') {
                    const isHidden = el.classList.contains('hidden');
                    el.classList.toggle('hidden');
                    if (isHidden) {
                        // Scroll to the parent card
                        setTimeout(() => {
                            const card = el.closest('[data-student-name]');
                            if (card) card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 80);
                    }
                } else {
                    el.classList.add('hidden');
                }
            });
        }

        // Cabinets act as accordion too
        function toggleCabinet(studentId) {
            document.querySelectorAll('.cabinet-body').forEach(cb => {
                if (cb.id !== 'cabinet-' + studentId) cb.classList.add('hidden');
            });
            const ele = document.getElementById('cabinet-' + studentId);
            if (ele) ele.classList.toggle('hidden');
        }
        
        document.getElementById('studentSearch')?.addEventListener('input', function() {
            const q = (this.value || '').trim().toLowerCase();
            const matches = group => !q || group.some(item =>
                (item.getAttribute('data-student-name') || '').includes(q)
            );
            window.filterDashboardPagination(
                document.querySelector('#section-students table tbody'),
                matches
            );
            window.filterDashboardPagination(
                document.querySelector('#section-students .md\\:hidden[data-pagination-list]'),
                matches
            );
        });

        // Close cabinets on outside click (optional: keeps UI tidy)
        document.addEventListener('click', function(e){
            // don't auto-close if clicking a cabinet or its button
        });

        function showAddCompanyModal() {
            document.getElementById('addCompanyModal').classList.remove('hidden');
        }

        function closeAddCompanyModal() {
            document.getElementById('addCompanyModal').classList.add('hidden');
        }

        function showDeleteCompanyModal(id, name) {
            document.getElementById('deleteCompanyName').textContent = name;
            document.getElementById('deleteCompanyForm').action = '/delete-company/' + id;
            document.getElementById('deleteCompanyModal').classList.remove('hidden');
        }

        function closeDeleteCompanyModal() {
            document.getElementById('deleteCompanyModal').classList.add('hidden');
        }

        function showEditCompanyModal(id, name, industry, location, contactPerson, contactEmail, contactPhone) {
            document.getElementById('edit_company_name').value = name;
            document.getElementById('edit_industry').value = industry;
            document.getElementById('edit_location').value = location;
            document.getElementById('edit_contact_person').value = contactPerson;
            document.getElementById('edit_contact_email').value = contactEmail;
            document.getElementById('edit_contact_phone').value = contactPhone;
            document.getElementById('editCompanyForm').action = '/update-company/' + id;
            document.getElementById('editCompanyModal').classList.remove('hidden');
        }

        function closeEditCompanyModal() {
            document.getElementById('editCompanyModal').classList.add('hidden');
        }

        function showForceDeleteModal(id, name) {
            document.getElementById('forceDeleteCompanyName').textContent = name;
            document.getElementById('forceDeleteCompanyForm').action = '/force-delete-company/' + id;
            document.getElementById('forceDeleteCompanyModal').classList.remove('hidden');
        }

        function closeForceDeleteModal() {
            document.getElementById('forceDeleteCompanyModal').classList.add('hidden');
        }

        function toggleArchivedCompanies() {
            document.getElementById('archivedCompaniesModal').classList.remove('hidden');
        }
        function closeArchivedCompaniesModal() {
            document.getElementById('archivedCompaniesModal').classList.add('hidden');
        }
        function filterBladeArchive(inputId, rowSelector, cardSelector) {
            const q = (document.getElementById(inputId)?.value || '').toLowerCase();
            document.querySelectorAll(rowSelector).forEach(el => {
                el.style.display = (el.dataset.search || '').includes(q) ? '' : 'none';
            });
            document.querySelectorAll(cardSelector).forEach(el => {
                el.style.display = (el.dataset.search || '').includes(q) ? '' : 'none';
            });
        }

        // ============ FILE VIEWER MODAL ============
        let fvReportId = null;

        function openFileViewer(reportId, title, fileUrl, status) {
            fvReportId = reportId;
            document.getElementById('fvTitle').textContent = title;

            // Status badge
            const badge = document.getElementById('fvStatus');
            const colors = { approved: 'bg-green-500/20 text-green-300', rejected: 'bg-red-500/20 text-red-300', denied: 'bg-red-500/20 text-red-300', pending: 'bg-yellow-500/20 text-yellow-300' };
            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            badge.className = 'px-2 py-0.5 text-xs rounded-full ' + (colors[status] || colors.pending);

            // Show/hide action bar for pending only
            document.getElementById('fvActions').classList.toggle('hidden', status !== 'pending');
            document.getElementById('fvFeedback').value = '';

            // Reset preview elements
            const frame = document.getElementById('fvFrame');
            const img = document.getElementById('fvImage');
            const noPreview = document.getElementById('fvNoPreview');
            frame.classList.add('hidden'); img.classList.add('hidden'); noPreview.classList.add('hidden');

            if (!fileUrl) {
                noPreview.classList.remove('hidden');
            } else {
                const ext = fileUrl.split('?')[0].split('.').pop().toLowerCase();
                const imageExts = ['jpg','jpeg','png','gif','webp','bmp','svg'];
                const frameExts = ['pdf','txt','html','htm'];

                if (imageExts.includes(ext)) {
                    img.src = fileUrl;
                    img.classList.remove('hidden');
                } else if (frameExts.includes(ext)) {
                    frame.src = fileUrl;
                    frame.classList.remove('hidden');
                } else {
                    // Word, Excel, PPT — use Google Docs viewer
                    frame.src = 'https://docs.google.com/gview?url=' + encodeURIComponent(fileUrl) + '&embedded=true';
                    frame.classList.remove('hidden');
                }
                document.getElementById('fvDownload').href = fileUrl;
            }

            document.getElementById('fileViewerModal').classList.remove('hidden');
        }

        function closeFileViewer() {
            document.getElementById('fileViewerModal').classList.add('hidden');
            document.getElementById('fvFrame').src = '';
            document.getElementById('fvImage').src = '';
            fvReportId = null;
        }

        function toggleFullscreen() {
            const el = document.getElementById('fileViewerModal');
            if (!document.fullscreenElement) {
                el.requestFullscreen && el.requestFullscreen();
            } else {
                document.exitFullscreen && document.exitFullscreen();
            }
        }

        function submitReview(action) {
            if (!fvReportId) return;
            const feedback = document.getElementById('fvFeedback').value.trim();
            if (!feedback) {
                document.getElementById('fvFeedback').focus();
                document.getElementById('fvFeedback').style.borderColor = '#ef4444';
                return;
            }
            document.getElementById('fvFeedback').style.borderColor = '';
            const btn = event.currentTarget;
            btn.disabled = true;
            btn.textContent = 'Submitting...';

            const url = action === 'approve'
                ? `{{ url('/approve-requirement') }}/${fvReportId}`
                : `{{ url('/reject-requirement') }}/${fvReportId}`;

            const fd = new FormData();
            fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            if (feedback) fd.append('feedback', feedback);

            fetch(url, { method: 'POST', body: fd })
                .then(r => { if (r.ok) { closeFileViewer(); showSuccess(action === 'approve' ? 'Requirement approved successfully!' : 'Requirement denied successfully!', null, true); } else return Promise.reject(r); })
                .catch(() => {
                    const form = document.createElement('form');
                    form.method = 'POST'; form.action = url;
                    form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="feedback" value="${feedback}">`;
                    document.body.appendChild(form); form.submit();
                })
                .finally(() => { btn.disabled = false; });
        }

        // Close file viewer on Escape key
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeFileViewer(); });

        // ============ END FILE VIEWER ============

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

        // ===== EVALUATION SCORE MODAL =====
        @php
            try {
                $__evalData = \App\Models\StudentEvaluation::whereIn('student_id',
                    \App\Models\User::where('role','student')->pluck('id')
                )->get()->keyBy('student_id');
            } catch(\Exception $e) {
                $__evalData = collect([]);
            }
        @endphp
        const _evalData = @json($__evalData);

        function showEvalModal(studentId, studentName) {
            document.getElementById('evalModalName').textContent = studentName;
            const body = document.getElementById('evalModalBody');
            const ev = _evalData[studentId];
            if (!ev) {
                body.innerHTML = '<div class="text-center py-8"><p class="text-gray-400">No evaluation submitted yet for this student.</p></div>';
                document.getElementById('evalModal').classList.remove('hidden');
                return;
            }

            const ratingMap   = { outstanding:5, exceeds_expectations:4, meets_expectations:3, needs_improvement:2, unsatisfactory:1 };
            const ratingLabel = { outstanding:'Outstanding', exceeds_expectations:'Very Satisfactory', meets_expectations:'Satisfactory', needs_improvement:'Fair', unsatisfactory:'Poor' };
            const ratingColor = { outstanding:'text-green-400', exceeds_expectations:'text-blue-400', meets_expectations:'text-yellow-400', needs_improvement:'text-orange-400', unsatisfactory:'text-red-400' };
            const factors = [
                { key:'quality_of_work',          label:'1. Quality of Work',            weight:20 },
                { key:'quantity_of_work',         label:'2. Quantity of Work',           weight:20 },
                { key:'job_knowledge',            label:'3. Job Knowledge',              weight:20 },
                { key:'working_relationships',    label:'4. Working Relationships',      weight:20 },
                { key:'attendance_dependability', label:'5. Attendance & Dependability', weight:10 },
                { key:'specific_achievements',    label:'6. Specific Achievements',      weight:10 },
            ];

            let totalWeighted = 0, allRated = true;
            const rows = factors.map(f => {
                const rKey     = ev[f.key + '_rating'];
                const num      = ratingMap[rKey] || 0;
                const comment  = ev[f.key + '_comment'] || '';
                if (!num) allRated = false;
                const weighted = num ? ((num / 5) * f.weight).toFixed(2) : '—';
                if (num) totalWeighted += (num / 5) * f.weight;
                const col = ratingColor[rKey] || 'text-gray-500';
                return `<tr class="border-b border-slate-700/40">
                    <td class="py-2 px-3 text-gray-300 text-xs leading-tight">
                        ${f.label}
                        ${comment ? `<div class="text-gray-500 text-[10px] italic mt-0.5">${comment}</div>` : ''}
                    </td>
                    <td class="py-2 px-3 text-center">
                        <span class="font-bold text-sm ${col}">${num || '—'}</span>
                        <div class="text-[10px] text-gray-500">${ratingLabel[rKey] || ''}</div>
                    </td>
                    <td class="py-2 px-3 text-center text-gray-400 text-xs">${f.weight}%</td>
                    <td class="py-2 px-3 text-center font-bold text-blue-400 text-sm">${weighted}</td>
                </tr>`;
            }).join('');

            // Overall rating
            let overallNum = 0, overallKey = '', overallPct = '—';
            if (allRated) {
                overallPct = totalWeighted.toFixed(2) + '%';
                if      (totalWeighted >= 96) { overallNum = 5; overallKey = 'outstanding'; }
                else if (totalWeighted >= 86) { overallNum = 4; overallKey = 'exceeds_expectations'; }
                else if (totalWeighted >= 76) { overallNum = 3; overallKey = 'meets_expectations'; }
                else if (totalWeighted >= 66) { overallNum = 2; overallKey = 'needs_improvement'; }
                else                          { overallNum = 1; overallKey = 'unsatisfactory'; }
            }
            const overallCol   = ratingColor[overallKey]  || 'text-gray-400';
            const overallLbl   = ratingLabel[overallKey]  || '—';

            // Header info row
            let infoHtml = '';
            if (ev.job_title || ev.evaluation_date || ev.period_from) {
                const infoCells = [
                    ev.job_title       ? `<div><p class="text-gray-500 text-[10px]">Position</p><p class="text-gray-200 font-semibold text-xs">${ev.job_title}</p></div>` : '',
                    ev.evaluation_date ? `<div><p class="text-gray-500 text-[10px]">Eval. Date</p><p class="text-gray-200 font-semibold text-xs">${ev.evaluation_date}</p></div>` : '',
                    ev.period_from     ? `<div><p class="text-gray-500 text-[10px]">Period</p><p class="text-gray-200 font-semibold text-xs">${ev.period_from} → ${ev.period_to || '?'}</p></div>` : '',
                ].filter(Boolean).join('');
                infoHtml = `<div class="flex gap-4 flex-wrap bg-slate-800/50 rounded-xl px-4 py-3 mb-3">${infoCells}</div>`;
            }

            body.innerHTML = `
                ${infoHtml}
                <div class="rounded-xl overflow-hidden border border-slate-700 mb-3">
                    <table class="w-full text-xs">
                        <thead class="bg-slate-700/80">
                            <tr>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Factor</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Rating</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Weight</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Weighted</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                        <tfoot class="bg-slate-800/80 border-t-2 border-slate-600">
                            <tr>
                                <td colspan="2" class="py-2 px-3 font-bold text-gray-200 text-xs">Total Weighted Score</td>
                                <td class="py-2 px-3 text-center text-gray-400 text-xs font-bold">100%</td>
                                <td class="py-2 px-3 text-center font-bold text-blue-400 text-sm">${overallPct}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Overall Rating</p>
                        <p class="font-bold text-lg ${overallCol}">${overallNum ? overallNum + ' — ' + overallLbl : '—'}</p>
                        <p class="text-xs text-gray-500">${overallPct}</p>
                    </div>
                    <div class="flex gap-1">
                        ${[1,2,3,4,5].map(i => `<span class="text-2xl ${i <= overallNum ? overallCol : 'text-gray-700'}">★</span>`).join('')}
                    </div>
                </div>
                ${ev.feedback ? `<div class="mt-3 bg-slate-800/50 rounded-xl px-4 py-3"><p class="text-xs text-gray-400 mb-1">Overall Comments</p><p class="text-sm text-gray-300">${ev.feedback}</p></div>` : ''}
            `;
            document.getElementById('evalModal').classList.remove('hidden');
        }
        function closeEvalModal() { document.getElementById('evalModal').classList.add('hidden'); }
        document.getElementById('evalModal')?.addEventListener('click', e=>{ if(e.target===document.getElementById('evalModal')) closeEvalModal(); });
        // ===== END EVALUATION SCORE MODAL =====

        // ===== PHOTO POPUP =====
        function openPhotoPopup(url) {
            document.getElementById('photoPopupImg').src = url;
            document.getElementById('photoPopupModal').classList.remove('hidden');
        }
        function closePhotoPopup() {
            document.getElementById('photoPopupModal').classList.add('hidden');
            document.getElementById('photoPopupImg').src = '';
        }
        document.getElementById('photoPopupModal')?.addEventListener('click', function(e){ if(e.target===this) closePhotoPopup(); });
        // ===== END PHOTO POPUP =====
    </script>
    <!-- Photo Popup Modal -->
    <div id="photoPopupModal" class="hidden fixed inset-0 z-[90] flex items-center justify-center bg-black/80 p-4">
        <div class="relative max-w-lg w-full">
            <button onclick="closePhotoPopup()" class="absolute -top-3 -right-3 w-8 h-8 bg-slate-700 hover:bg-slate-600 text-white rounded-full flex items-center justify-center z-10">✕</button>
            <img id="photoPopupImg" src="" alt="Time-in Photo" class="w-full rounded-xl object-contain max-h-[80vh]">
        </div>
    </div>

    <!-- Evaluation Rating Modal -->
    <div id="evalModal" class="hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-2xl">
            <div class="flex justify-between items-center px-5 py-4 border-b border-slate-700">
                <h3 class="text-base font-bold text-white">Evaluation Rating — <span id="evalModalName"></span></h3>
                <button onclick="closeEvalModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white">✕</button>
            </div>
            <div id="evalModalBody" class="px-5 py-4">
                <p class="text-gray-400 text-sm text-center py-6">Loading...</p>
            </div>
        </div>
    </div>
    <!-- Page loader overlay -->
    <div id="pageLoader" class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-6"
         style="background:rgba(5,13,46,0.95);backdrop-filter:blur(8px);">
        <div class="relative">
            <svg class="animate-spin" style="width:64px;height:64px;" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="rgba(249,115,22,0.2)" stroke-width="3"/>
                <path d="M4 12a8 8 0 018-8" stroke="#fb923c" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-orange-500/30 rounded-full animate-pulse"></div>
            </div>
        </div>
        <p id="pageLoaderMsg" style="color:#fdba74;font-size:16px;font-weight:600;font-family:sans-serif;letter-spacing:.05em;">Please wait…</p>
    </div>

</body>
</html>
