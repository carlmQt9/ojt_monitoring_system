<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
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
        /* LIGHT MODE - Beautiful soft design */
        body.light { background: #ffffff !important; color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) { background: rgba(255,255,255,0.95) !important; border-color: #d8d0f0 !important; box-shadow: 0 2px 8px rgba(124,58,237,0.08) !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-purple"] { color: #fff !important; }
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
        body.light a[class*="bg-blue-6"],body.light a[class*="bg-purple-6"] { color: #fff !important; }
        body.light button.bg-indigo-600,body.light button.bg-indigo-700,
        body.light button.bg-red-600,body.light button.bg-red-700,
        body.light button.bg-blue-600,body.light button.bg-blue-700,
        body.light button.bg-green-600,body.light button.bg-green-700,
        body.light button.bg-orange-600,body.light button.bg-orange-700,
        body.light button.bg-purple-600,body.light button.bg-purple-700 { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: linear-gradient(135deg, #faf9fc 0%, #f5f3f9 100%) !important; }
        body.light [class*="bg-slate-800"] { background: rgba(255,255,255,0.85) !important; box-shadow: 0 1px 3px rgba(124,58,237,0.08) !important; }
        body.light [class*="bg-slate-700"] { background: rgba(250,249,252,0.9) !important; }
        body.light [class*="bg-slate-6"] { background: #f5f3f9 !important; }
        body.light [class*="border-slate-7"] { border-color: #d8d0f0 !important; }
        body.light [class*="border-slate-6"] { border-color: #d8d0f0 !important; }
        body.light [class*="divide-slate-7"] > * { border-color: #d8d0f0 !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.95) !important; border-color: #c4b5e8 !important; color: #1e3a5f !important; box-shadow: 0 1px 2px rgba(124,58,237,0.05) !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #8a7ab8 !important; }
        body.light input:focus,body.light textarea:focus,body.light select:focus { border-color: #7c3aed !important; box-shadow: 0 0 0 3px rgba(124,58,237,0.1) !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(245,243,255,0.8) 100%) !important; border-color: #c4b5fd !important; border-left: 4px solid #7c3aed !important; box-shadow: 0 4px 12px rgba(124,58,237,0.08) !important; }
        body.light .header-info-card h1 { color: #1e3a5f !important; }
        body.light .header-info-card .subtitle { color: #5a7a9f !important; }
        body.light .header-info-card .stat-label { color: #5a7a9f !important; }
        body.light .header-info-card .stat-value-white { color: #1e3a5f !important; }
        body.light .header-info-card .stat-value-purple { color: #7c3aed !important; }
        body.light .header-info-card .stat-value-indigo { color: #4f46e5 !important; }
        body.light .header-info-card .divider { background: #d8d0f0 !important; }
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
            <button onclick="showSection('certificates')" data-section="certificates"
                class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 transition-all cursor-pointer">
                <span class="nav-icon text-lg shrink-0">🏅</span>
                <span class="nav-label">Certificates</span>
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

    <!-- Certificate Confirmation Modal -->
    <div id="certConfirmModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-800 border border-yellow-500/40 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-5">
                <div class="text-5xl mb-3" id="certConfirmIcon">🏅</div>
                <h3 id="certConfirmTitle" class="text-lg font-bold text-white mb-2">Award Certificate?</h3>
                <p id="certConfirmMsg" class="text-gray-400 text-sm leading-relaxed"></p>
            </div>
            <div class="flex gap-3">
                <button onclick="closeCertConfirm()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <button id="certConfirmBtn" onclick="executeCertAward()"
                    class="flex-1 px-4 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-semibold transition-all">
                    Confirm
                </button>
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
                    ->when($activeSchoolYear, fn($q) => $q->where(function($inner) use ($activeSchoolYear) {
                        $inner->where('school_year', $activeSchoolYear)->orWhereNull('school_year');
                    }))
                    ->get();

                $totalStudents = $supervisorStudents->count();
                $completedStudents = 0;
                $inProgressStudents = 0;
                $totalProgress = 0;

                foreach($supervisorStudents as $student) {
                    $studentHours = \App\Models\StudentHours::where('student_id', $student->id)->first();
                    $displayHours = $studentHours->hours_completed ?? 0;
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
                $_done3 = $_sh3 ? ($_sh3->hours_completed ?? 0) : 0;
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
                $d=\Carbon\Carbon::now('Asia/Manila')->subDays($i);
                $_tiLabels[]=$d->format('D');
                $q=\App\Models\TimeInRecord::whereDate('date',$d->toDateString())->whereHas('student');
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
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <h2 class="text-2xl font-bold text-white">👥 Interns Management & Progress Tracking</h2>
                <div class="w-full sm:max-w-sm">
                    <div class="flex items-center gap-2 px-3 py-2.5 bg-slate-700/50 border border-slate-600 rounded-xl focus-within:border-purple-500 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                        <input type="search" id="internSearch" placeholder="Search intern by name or email..."
                            class="flex-1 bg-transparent text-white text-sm placeholder-gray-400 focus:outline-none"
                            oninput="filterInterns(this.value)">
                    </div>
                </div>
            </div>
            
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
                    $progressPercentage = ($studentHours->total_hours_required ?? 600) > 0
                        ? ($studentHours->hours_completed / ($studentHours->total_hours_required ?? 600)) * 100
                        : 0;
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
                    $hasTimeOutPhotoCol = \Illuminate\Support\Facades\Schema::hasColumn('time_in_records', 'time_out_photo_path');
                    $taskLogs = \App\Models\TimeInRecord::where('student_id', $student->id)
                        ->where(function($q) use ($hasTimeOutPhotoCol) {
                            $q->whereNotNull('photo_path');
                            if ($hasTimeOutPhotoCol) {
                                $q->orWhereNotNull('time_out_photo_path');
                            }
                        })
                        ->orderBy('date', 'desc')
                        ->orderBy('session', 'asc')
                        ->get();
                    $canEvaluate = $studentHours->hours_completed >= ($studentHours->total_hours_required ?? 600);
                    ?>
                    <div class="student-card bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-purple-500/50 transition-colors" data-student-id="{{ $student->id }}" data-intern="{{ strtolower($student->name . ' ' . $student->email) }}">
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
                                    <p class="text-gray-400 text-xs mb-1">📋 Evaluation</p>
                                    @php $hasNewEval = $evaluation && !empty($evaluation->quality_of_work_rating); @endphp
                                    <p class="text-sm font-bold @if($hasNewEval) text-green-400 @elseif($evaluation) text-yellow-400 @else text-gray-500 @endif">
                                        @if($hasNewEval) ✅ Done
                                        @elseif($evaluation) ⚠️ Needs Update
                                        @else Not yet
                                        @endif
                                    </p>
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
                            <!-- Tabs — single navigation, no redundant buttons -->
                            <div class="border-b border-slate-600 mb-4 mt-4">
                                <div class="flex flex-wrap gap-1">
                                    <button class="tab-button px-3 py-2 border-b-2 border-purple-500 text-purple-400 font-semibold text-xs sm:text-sm" data-tab="daily-logs-{{ $student->id }}">📅 Daily Logs</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm" data-tab="time-records-{{ $student->id }}">
                                        ⏱️ Time Edits @if($pendingTimeEdits > 0)<span class="ml-1 px-1.5 py-0.5 bg-orange-500 text-white text-[10px] rounded-full">{{ $pendingTimeEdits }}</span>@endif
                                    </button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm" data-tab="task-logs-{{ $student->id }}">📸 Task Logs</button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm" data-tab="requirements-{{ $student->id }}">
                                        📋 Requirements @if($pendingRequirements > 0)<span class="ml-1 px-1.5 py-0.5 bg-indigo-500 text-white text-[10px] rounded-full">{{ $pendingRequirements }}</span>@endif
                                    </button>
                                    <button class="tab-button px-3 py-2 border-b-2 border-transparent text-gray-400 hover:text-white text-xs sm:text-sm" data-tab="evaluation-{{ $student->id }}">⭐ Evaluation</button>
                                    <button onclick="openSupDtrModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="ml-auto px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold transition-colors">
                                        📄 DTR
                                    </button>
                                </div>
                            </div>

                            <!-- Daily Logs Tab -->
                            <div id="daily-logs-{{ $student->id }}" class="tab-content">
                                @if($dailyLogs->isNotEmpty())
                                <div class="overflow-y-auto rounded-lg border border-slate-700/50" style="max-height:260px">
                                    <table class="w-full text-sm">
                                        <thead class="sticky top-0 bg-slate-800 z-10">
                                            <tr class="text-xs text-gray-400 border-b border-slate-700/50">
                                                <th class="py-2 px-3 text-left font-semibold">Date</th>
                                                <th class="py-2 px-2 text-left font-semibold">Hours</th>
                                                <th class="py-2 px-2 text-center font-semibold">Type</th>
                                                <th class="py-2 px-2 text-center font-semibold">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-700/30">
                                        @foreach($dailyLogs as $log)
                                        <tr class="hover:bg-slate-700/20 transition-colors">
                                            <td class="py-2 px-3 text-gray-200 text-xs whitespace-nowrap">{{ $log->log_date->format('M d, Y') }}</td>
                                            <td class="py-2 px-2 text-purple-400 font-semibold text-xs whitespace-nowrap">
                                                @php $supHours = number_format($log->hours_logged, 2); @endphp
                                                {{ $log->hours_logged >= 0 ? '+' : '' }}{{ $supHours }}h
                                            </td>
                                            <td class="py-2 px-2 text-center">
                                                @if($log->is_overtime)
                                                <span class="px-2 py-0.5 bg-red-500/20 text-red-300 text-xs rounded-full">OT</span>
                                                @else
                                                <span class="text-gray-500 text-xs">—</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-2 text-center">
                                                <span class="px-2 py-0.5 text-xs rounded-full
                                                    @if($log->status === 'approved') bg-green-500/20 text-green-300
                                                    @elseif($log->status === 'denied') bg-red-500/20 text-red-300
                                                    @else bg-yellow-500/20 text-yellow-300 @endif">
                                                    {{ ucfirst($log->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No daily logs yet</p>
                                @endif
                            </div>

                            <!-- Time Edits Tab -->
                            <div id="time-records-{{ $student->id }}" class="tab-content hidden">
                                @if($timeInRecords->isNotEmpty())
                                @php
                                    // Show approve all if there are pending records that have timed out
                                    $_pendingTimedOut = $timeInRecords->filter(fn($r) => $r->status === 'pending' && $r->time_out);
                                @endphp
                                @if($_pendingTimedOut->count() >= 2)
                                <div class="flex gap-2 mb-3">
                                    <form method="POST" action="{{ url('/approve-all-time-in/'.$student->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded font-semibold">✅ Approve All ({{ $_pendingTimedOut->count() }})</button>
                                    </form>
                                    <button onclick="showDenyAllTimeEditModal({{ $student->id }})" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded font-semibold">❌ Deny All ({{ $_pendingTimedOut->count() }})</button>
                                </div>
                                @endif
                                <!-- Date search filter -->
                                <div class="flex items-center gap-2 px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg mb-2 focus-within:border-purple-500 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <input type="text" placeholder="Filter by date (e.g. Apr 22)…"
                                        class="flex-1 bg-transparent text-white text-xs placeholder-gray-400 focus:outline-none"
                                        oninput="filterTimeEdits(this, {{ $student->id }})">
                                </div>
                                <div class="overflow-y-auto rounded-lg border border-slate-700/50" style="max-height:260px">
                                    <table class="w-full text-sm" id="timeEditsTable-{{ $student->id }}">
                                        <thead class="sticky top-0 bg-slate-800 z-10">
                                            <tr class="text-xs text-gray-400 border-b border-slate-700/50">
                                                <th class="py-2 px-3 text-left font-semibold">Date / Session</th>
                                                <th class="py-2 px-2 text-left font-semibold hidden sm:table-cell">Time</th>
                                                <th class="py-2 px-2 text-center font-semibold">Status</th>
                                                <th class="py-2 px-2 text-right font-semibold">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-700/30">
                                        @foreach($timeInRecords as $record)
                                        @php
                                            $_hasActiveSession = \App\Models\TimeInRecord::where('student_id', $student->id)
                                                ->whereDate('date', $record->date)
                                                ->where('session', $record->session) // only block same session
                                                ->whereNull('time_out')
                                                ->where('id', '!=', $record->id)
                                                ->exists();
                                        @endphp
                                        <tr class="hover:bg-slate-700/20 transition-colors time-edit-row" data-date="{{ strtolower($record->date->format('M d, Y')) }}">
                                            <td class="py-2 px-3">
                                                <p class="text-gray-200 text-xs font-medium whitespace-nowrap">{{ $record->date->format('M d, Y') }}</p>
                                                @if($record->session)
                                                <p class="text-gray-500 text-xs">{{ ucfirst($record->session) }}</p>
                                                @endif
                                                @if(floatval($record->ot_hours ?? 0) > 0)
                                                <p class="text-yellow-400 text-xs">⏰ {{ number_format($record->regular_hours ?? 0,2) }}h + {{ number_format($record->ot_hours,2) }}h OT</p>
                                                @endif
                                            </td>
                                            <td class="py-2 px-2 text-gray-400 text-xs whitespace-nowrap hidden sm:table-cell">
                                                {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                                                @if($record->time_out) – {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }} @endif
                                            </td>
                                            <td class="py-2 px-2 text-center">
                                                <span class="px-2 py-0.5 text-xs rounded-full whitespace-nowrap
                                                    @if($record->status === 'approved') bg-green-500/20 text-green-300
                                                    @elseif($record->status === 'denied') bg-red-500/20 text-red-300
                                                    @else bg-yellow-500/20 text-yellow-300 @endif">
                                                    {{ ucfirst($record->status) }}
                                                </span>
                                                @if($record->status === 'denied' && $record->denial_reason && str_contains($record->denial_reason, 'did not time out'))
                                                <p class="text-red-400 text-[10px] mt-0.5">⚠️ No time-out</p>
                                                @endif
                                            </td>
                                            <td class="py-2 px-2 text-right">
                                                @if($record->status === 'pending')
                                                    @if(!$record->time_out || $_hasActiveSession)
                                                    <span class="text-blue-300 text-xs">⏳</span>
                                                    @elseif($record->denial_reason === 'undone')
                                                    {{-- Was undone — show Redo only --}}
                                                    <form method="POST" action="{{ route('approve-time-in', $record->id) }}" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded font-semibold">↻ Redo</button>
                                                    </form>
                                                    @else
                                                    <div class="flex items-center justify-end gap-1">
                                                        <form method="POST" action="{{ route('approve-time-in', $record->id) }}" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">✓</button>
                                                        </form>
                                                        <button onclick="showDenyTimeEditModal({{ $record->id }})" class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">✕</button>
                                                    </div>
                                                    @endif
                                                @elseif($record->status === 'approved')
                                                    <button onclick="confirmUndoApproval({{ $record->id }}, '{{ $record->date->format('M d, Y') }}', '{{ ucfirst($record->session ?? '') }}')"
                                                        class="px-2 py-1 bg-orange-500 hover:bg-orange-600 text-white text-xs rounded transition-colors" title="Undo approval">
                                                        ↩ Undo
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p class="text-gray-400 text-sm">No time-in records yet</p>
                                @endif
                            </div>

                            <!-- Task Logs Tab -->
                            <div id="task-logs-{{ $student->id }}" class="tab-content hidden">
                                @php
                                    // Group task logs by date
                                    $taskLogsByDate = $taskLogs->groupBy(fn($r) => $r->date->format('Y-m-d'));
                                @endphp
                                @if($taskLogsByDate->isNotEmpty())
                                <div class="space-y-4 overflow-y-auto" style="max-height:300px">
                                    @foreach($taskLogsByDate as $logDate => $dayLogs)
                                    @php
                                        $displayLogDate = \Carbon\Carbon::parse($logDate)->format('M d, Y');
                                        $dayStatus = $dayLogs->first()->status ?? 'pending';
                                        // Check if afternoon session has no time_out (forgot to time out)
                                        // Exclude records with time_out = '00:00' — those are real midnight time-outs
                                        $hasIncomplete = \App\Models\TimeInRecord::where('student_id', $student->id)
                                            ->whereDate('date', $logDate)
                                            ->where('session', 'afternoon')
                                            ->whereNull('time_out')
                                            ->where('status', '!=', 'denied')
                                            ->exists();
                                        $allApproved = $dayLogs->every(fn($r) => $r->status === 'approved');
                                        $allDenied   = $dayLogs->every(fn($r) => $r->status === 'denied');
                                        $anyPending  = $dayLogs->contains(fn($r) => $r->status === 'pending');
                                    @endphp
                                    <div class="bg-slate-700/20 rounded-xl border border-slate-700/50 overflow-hidden">
                                        {{-- Day header --}}
                                        <div class="flex items-center justify-between px-3 py-2 bg-slate-700/40 border-b border-slate-700/50">
                                            <div class="flex items-center gap-2">
                                                <p class="text-gray-200 text-xs font-semibold">{{ $displayLogDate }}</p>
                                                @if($hasIncomplete)
                                                <span class="px-1.5 py-0.5 bg-red-500/20 text-red-400 text-[10px] rounded-full font-semibold">⚠️ Not Finished</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                @if($allApproved)
                                                <span class="px-2 py-0.5 bg-green-500/20 text-green-300 text-[10px] rounded-full">Approved</span>
                                                @elseif($allDenied)
                                                <span class="px-2 py-0.5 bg-red-500/20 text-red-300 text-[10px] rounded-full">Denied</span>
                                                @elseif($hasIncomplete)
                                                {{-- Afternoon session still open — student has not timed out yet --}}
                                                <span class="px-2 py-0.5 bg-yellow-500/20 text-yellow-300 text-[10px] rounded-full font-semibold">⏳ Not Finished</span>
                                                @elseif($anyPending)
                                                {{-- All sessions timed out and pending — show approve/deny --}}
                                                <form method="POST" action="{{ url('/approve-all-time-in/'.$student->id) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="date" value="{{ $logDate }}">
                                                    <button type="submit" class="px-2 py-0.5 bg-green-600 hover:bg-green-700 text-white text-[10px] rounded font-semibold">✓ Approve Day</button>
                                                </form>
                                                <button onclick="showDenyAllTimeEditModal({{ $student->id }})" class="px-2 py-0.5 bg-red-600 hover:bg-red-700 text-white text-[10px] rounded font-semibold">✕ Deny Day</button>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Photos grid --}}
                                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 p-2">
                                            @foreach($dayLogs as $record)
                                            @if($record->photo_path)
                                            <div class="relative rounded-lg overflow-hidden">
                                                <button type="button" onclick="openMediaPopup('{{ asset('storage/' . $record->photo_path) }}','{{ $displayLogDate }} — {{ ucfirst($record->session ?? '') }}')" class="relative group block w-full">
                                                    <img src="{{ asset('storage/' . $record->photo_path) }}" alt="Photo"
                                                        class="w-full h-20 object-cover hover:opacity-80 transition-opacity rounded-lg">
                                                    <span class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity text-xs text-white font-semibold">View</span>
                                                </button>
                                                <div class="absolute bottom-0 left-0 right-0 px-1 py-0.5 bg-black/60 text-center">
                                                    <span class="text-[9px] text-gray-300">{{ ucfirst($record->session ?? 'in') }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            @if(isset($record->time_out_photo_path) && $record->time_out_photo_path)
                                            <div class="relative rounded-lg overflow-hidden">
                                                <button type="button" onclick="openMediaPopup('{{ asset('storage/' . $record->time_out_photo_path) }}','{{ $displayLogDate }} — {{ ucfirst($record->session ?? '') }} Out')" class="relative group block w-full">
                                                    <img src="{{ asset('storage/' . $record->time_out_photo_path) }}" alt="Out Photo"
                                                        class="w-full h-20 object-cover hover:opacity-80 transition-opacity rounded-lg border-2 border-orange-500/40">
                                                    <span class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity text-xs text-white font-semibold">View</span>
                                                </button>
                                                <div class="absolute bottom-0 left-0 right-0 px-1 py-0.5 bg-black/60 text-center">
                                                    <span class="text-[9px] text-orange-300">{{ ucfirst($record->session ?? 'out') }} out</span>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
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
                                @php
                                    $_pendingReqsCount = $requirements->where('status','pending')->count();
                                @endphp
                                @if($_pendingReqsCount >= 2)
                                <div class="flex gap-2 mb-3">
                                    <button onclick="showApproveAllRequirementsModal({{ $student->id }}, '{{ $student->email }}')" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded font-semibold">✅ Approve All ({{ $_pendingReqsCount }})</button>
                                    <button onclick="showDenyAllRequirementsModal({{ $student->id }})" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded font-semibold">❌ Deny All ({{ $_pendingReqsCount }})</button>
                                </div>
                                @endif
                                @php
                                    $_studentStillActive = \App\Models\TimeInRecord::where('student_id', $student->id)
                                        ->whereDate('date', today())->whereNull('time_out')->exists();
                                @endphp
                                <!-- Scrollable compact table -->
                                <div class="overflow-y-auto rounded-lg border border-slate-700/50" style="max-height:260px">
                                    <table class="w-full text-sm">
                                        <thead class="sticky top-0 bg-slate-800 z-10">
                                            <tr class="text-xs text-gray-400 border-b border-slate-700/50">
                                                <th class="py-2 px-3 text-left font-semibold">Title</th>
                                                <th class="py-2 px-2 text-left font-semibold hidden sm:table-cell">Date</th>
                                                <th class="py-2 px-2 text-center font-semibold">Status</th>
                                                <th class="py-2 px-2 text-right font-semibold">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-700/30">
                                        @foreach($requirements as $req)
                                        @php
                                            $_isOtLetter = stripos($req->title, 'OT') !== false
                                                || stripos($req->title, 'overtime') !== false
                                                || stripos($req->title, 'over time') !== false;
                                        @endphp
                                        <tr class="hover:bg-slate-700/20 transition-colors">
                                            <td class="py-2 px-3">
                                                <p class="text-gray-200 font-medium leading-tight">{{ $req->title }}</p>
                                                @if($req->description)
                                                <p class="text-gray-500 text-xs mt-0.5 truncate max-w-[160px]" title="{{ $req->description }}">{{ $req->description }}</p>
                                                @endif
                                            </td>
                                            <td class="py-2 px-2 text-gray-500 text-xs whitespace-nowrap hidden sm:table-cell">
                                                {{ $req->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-2 px-2 text-center">
                                                <span class="px-2 py-0.5 text-xs rounded-full whitespace-nowrap
                                                    @if($req->status === 'approved') bg-green-500/20 text-green-300
                                                    @elseif($req->status === 'denied') bg-red-500/20 text-red-300
                                                    @else bg-yellow-500/20 text-yellow-300 @endif">
                                                    {{ ucfirst($req->status) }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-2">
                                                <div class="flex items-center justify-end gap-1 flex-wrap">
                                                    @if($req->file_path)
                                                    <button type="button" onclick="openMediaPopup('{{ asset('storage/' . $req->file_path) }}','{{ addslashes($req->title) }}')"
                                                        class="px-2 py-1 bg-blue-600/80 hover:bg-blue-600 text-white text-xs rounded whitespace-nowrap">📎 View</button>
                                                    @endif
                                                    @if($req->status === 'pending')
                                                        @if($_isOtLetter && $_studentStillActive)
                                                        <span class="text-blue-300 text-xs">⏳ Active</span>
                                                        @else
                                                        <button onclick="showApproveRequirementModal({{ $req->id }}, '{{ $student->email }}')"
                                                            class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">✓</button>
                                                        <button onclick="showDenyRequirementModal({{ $req->id }})"
                                                            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">✕</button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
                                    <p class="text-green-400 text-sm font-semibold">✅ Evaluation submitted on {{ $evaluation->created_at->format('M d, Y') }}</p>
                                    @php
                                    $ratingLabels = [
                                        'outstanding'=>'Outstanding','exceeds_expectations'=>'Exceeds Expectations',
                                        'meets_expectations'=>'Meets Expectations','needs_improvement'=>'Needs Improvement',
                                        'unsatisfactory'=>'Unsatisfactory'
                                    ];
                                    $evalFactors = [
                                        'quality_of_work'=>'Quality of Work','quantity_of_work'=>'Quantity of Work',
                                        'job_knowledge'=>'Job Knowledge','working_relationships'=>'Working Relationships',
                                        'attendance_dependability'=>'Attendance/Dependability','specific_achievements'=>'Specific Achievements',
                                    ];
                                    @endphp
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        @foreach($evalFactors as $fKey => $fLabel)
                                        <div class="bg-slate-800/50 p-2 rounded">
                                            <p class="text-gray-400">{{ $fLabel }}</p>
                                            <p class="text-white font-semibold mt-0.5">{{ $ratingLabels[$evaluation->{$fKey.'_rating'}] ?? '—' }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button
                                        data-student-id="{{ $student->id }}"
                                        data-student-name="{{ addslashes($student->name) }}"
                                        data-is-evaluated="0"
                                        data-eval='{!! json_encode(['evaluation_date'=>$evaluation->evaluation_date,'period_from'=>$evaluation->period_from,'period_to'=>$evaluation->period_to,'job_title'=>$evaluation->job_title,'quality_of_work_rating'=>$evaluation->quality_of_work_rating,'quality_of_work_comment'=>$evaluation->quality_of_work_comment,'quantity_of_work_rating'=>$evaluation->quantity_of_work_rating,'quantity_of_work_comment'=>$evaluation->quantity_of_work_comment,'job_knowledge_rating'=>$evaluation->job_knowledge_rating,'job_knowledge_comment'=>$evaluation->job_knowledge_comment,'working_relationships_rating'=>$evaluation->working_relationships_rating,'working_relationships_comment'=>$evaluation->working_relationships_comment,'attendance_dependability_rating'=>$evaluation->attendance_dependability_rating,'attendance_dependability_comment'=>$evaluation->attendance_dependability_comment,'specific_achievements_rating'=>$evaluation->specific_achievements_rating,'specific_achievements_comment'=>$evaluation->specific_achievements_comment]) !!}'
                                        onclick="openEvalFromBtn(this)"
                                        class="w-full mt-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded text-sm transition-colors">Update Evaluation
                                    </button>
                                </div>
                                @else
                                <p class="text-gray-400 text-sm mb-4">No evaluation yet</p>
                                <button onclick="showEvaluationModal({{ $student->id }}, '{{ $student->name }}')" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded text-sm transition-colors">Add Evaluation</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        </section><!-- end interns -->

        <!-- Certificates Section -->
        <section id="section-certificates" class="dash-section hidden">
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-2">🏅 OJT Completion Certificates</h2>
            <p class="text-gray-400 text-sm mb-6">Upload each intern's physical certificate image. Students can then view, print, and download it from their dashboard.</p>

            @php
                $certStudents = $supervisorStudents->map(function($s) {
                    $sh = \App\Models\StudentHours::where('student_id', $s->id)->first();
                    $s->_hours    = round($sh->hours_completed ?? 0, 2);
                    $s->_required = $sh->total_hours_required ?? 600;
                    $s->_done     = $s->_hours >= $s->_required;
                    return $s;
                });
                $completedCert = $certStudents->filter(fn($s) => $s->_done);
                $notDone       = $certStudents->filter(fn($s) => !$s->_done);
            @endphp

            @if($completedCert->isEmpty() && $notDone->isEmpty())
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                    <p class="text-gray-400">No interns assigned yet.</p>
                </div>
            @else
                @if($completedCert->isNotEmpty())
                <h3 class="text-sm font-semibold text-green-400 uppercase tracking-wider mb-3">✅ Completed — Ready for Certificate</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                    @foreach($completedCert as $s)
                    <div class="bg-slate-800/50 border border-green-500/40 rounded-xl p-5">
                        <!-- Student info row -->
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="min-w-0">
                                <p class="text-white font-semibold truncate">{{ $s->name }}</p>
                                <p class="text-gray-400 text-xs truncate">{{ $s->company->name ?? '' }}</p>
                                <p class="text-green-400 text-xs mt-1 font-semibold">{{ number_format($s->_hours, 2) }} / {{ $s->_required }} hrs</p>
                            </div>
                            @if($s->certificate_awarded_at)
                            <span class="shrink-0 px-2 py-1 bg-green-500/20 text-green-300 text-xs rounded-full whitespace-nowrap">
                                🏅 {{ $s->certificate_awarded_at->format('M d, Y') }}
                            </span>
                            @endif
                        </div>

                        @if($s->certificate_image_path)
                        <!-- Thumbnail preview -->
                        <div class="mb-3 rounded-lg overflow-hidden border border-slate-600 bg-slate-900/50 flex items-center justify-center cursor-pointer"
                             style="height:130px;"
                             onclick="openCertImageModal('{{ asset('storage/' . $s->certificate_image_path) }}', '{{ addslashes($s->name) }}')">
                            <img src="{{ asset('storage/' . $s->certificate_image_path) }}"
                                 alt="Certificate preview"
                                 class="max-h-full max-w-full object-contain hover:opacity-80 transition-opacity">
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openCertImageModal('{{ asset('storage/' . $s->certificate_image_path) }}', '{{ addslashes($s->name) }}')"
                                class="flex-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded-lg font-semibold">👁 View</button>
                            <label class="flex-1 px-3 py-1.5 bg-slate-600 hover:bg-slate-500 text-white text-xs rounded-lg font-semibold text-center cursor-pointer">
                                🔄 Replace
                                <input type="file" class="hidden" accept="image/*,application/pdf"
                                       onchange="uploadCertificate({{ $s->id }}, this)">
                            </label>
                        </div>
                        @else
                        <!-- Drop / upload zone -->
                        <label class="block w-full border-2 border-dashed border-slate-600 hover:border-yellow-500/70 rounded-xl p-6 text-center cursor-pointer transition-colors"
                               ondragover="event.preventDefault();this.classList.add('!border-yellow-500')"
                               ondragleave="this.classList.remove('!border-yellow-500')"
                               ondrop="handleCertDrop(event,{{ $s->id }})">
                            <div class="text-3xl mb-2">📄</div>
                            <p class="text-gray-300 text-sm font-semibold">Click or drag to upload</p>
                            <p class="text-gray-500 text-xs mt-1">JPG, PNG or PDF · max 10 MB</p>
                            <input type="file" class="hidden" accept="image/*,application/pdf"
                                   onchange="uploadCertificate({{ $s->id }}, this)">
                        </label>
                        <div id="cert-progress-{{ $s->id }}" class="hidden mt-2 flex items-center gap-2 text-xs text-gray-400">
                            <svg class="animate-spin w-4 h-4 text-yellow-400 shrink-0" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Uploading…
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                @if($notDone->isNotEmpty())
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">⏳ In Progress</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($notDone as $s)
                    <div class="bg-slate-800/30 border border-slate-700 rounded-xl p-5 flex items-center justify-between gap-4 opacity-60">
                        <div class="min-w-0">
                            <p class="text-white font-semibold truncate">{{ $s->name }}</p>
                            <p class="text-gray-400 text-xs truncate">{{ $s->company->name ?? '' }}</p>
                            <div class="mt-2 w-full bg-slate-700 rounded-full h-1.5">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width:{{ min(100, round(($s->_hours/$s->_required)*100)) }}%"></div>
                            </div>
                            <p class="text-gray-500 text-xs mt-1">{{ number_format($s->_hours, 2) }} / {{ $s->_required }} hrs ({{ round(($s->_hours/$s->_required)*100) }}%)</p>
                        </div>
                        <span class="shrink-0 px-3 py-1 bg-slate-700 text-gray-400 text-xs rounded-full">Not yet eligible</span>
                    </div>
                    @endforeach
                </div>
                @endif
            @endif
        </div>
        </section><!-- end certificates -->
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

    <!-- Deny All Time Edits Modal -->
    <div id="denyAllTimeEditModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">❌ Deny All Time Edits</h3>
            <form id="denyAllTimeEditForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial</label>
                    <textarea name="reason" required rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none" placeholder="Explain why you're denying all..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyAllTimeEditModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">Deny All</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Approve All Requirements Modal -->
    <div id="approveAllRequirementsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">✅ Approve All Requirements</h3>
            <form id="approveAllRequirementsForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feedback <span class="text-red-400">*</span></label>
                    <textarea name="feedback" required rows="3" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-green-500 focus:outline-none" placeholder="Feedback for all requirements..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeApproveAllRequirementsModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-semibold">Approve All</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Deny All Requirements Modal -->
    <div id="denyAllRequirementsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-white mb-6">❌ Deny All Requirements</h3>
            <form id="denyAllRequirementsForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason for Denial <span class="text-red-400">*</span></label>
                    <textarea name="feedback" required rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none" placeholder="Explain why you're denying all..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyAllRequirementsModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">Deny All</button>
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
                    <textarea name="feedback" required rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-red-500 focus:outline-none" placeholder="Explain why..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeDenyRequirementModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-semibold">Deny</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Evaluation Modal (PRMSU Student Performance Evaluation) -->
    <div id="evaluationModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 modal-backdrop p-0 sm:p-4">
        <div class="bg-white w-full sm:rounded-xl sm:max-w-2xl mx-auto max-h-screen sm:max-h-[95vh] flex flex-col shadow-2xl">
            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 shrink-0 bg-blue-700 sm:rounded-t-xl">
                <div class="min-w-0">
                    <p class="text-xs text-blue-200 font-medium">Student Performance Evaluation</p>
                    <p class="text-sm font-bold text-white truncate">PRMSU &mdash; <span id="evalStudentName"></span></p>
                </div>
                <button onclick="closeEvaluationModal()" class="w-8 h-8 shrink-0 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white text-lg font-bold ml-2">&times;</button>
            </div>
            <div class="flex-1 overflow-y-auto">
            <form id="evaluationForm" method="POST">
                @csrf
                <input type="hidden" name="supervisor_id" value="{{ $user->id }}">
                <input type="hidden" name="rating" id="ratingInput" value="0">
                <!-- Info Fields -->
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 space-y-2 text-sm">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Evaluation Date</label>
                            <input type="date" name="evaluation_date" id="eval_evaluation_date" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-gray-800 text-xs focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Job Title</label>
                            <input type="text" name="job_title" id="eval_job_title" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-gray-800 text-xs focus:outline-none focus:border-blue-500" placeholder="e.g. IT Intern">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Period From</label>
                            <input type="date" name="period_from" id="eval_period_from" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-gray-800 text-xs focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Period To</label>
                            <input type="date" name="period_to" id="eval_period_to" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-gray-800 text-xs focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Student</label>
                            <input type="text" id="eval_student_name_field" readonly class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-gray-700 text-xs bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-0.5">Supervisor</label>
                            <input type="text" value="{{ $user->name }}" readonly class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-gray-700 text-xs bg-gray-100">
                        </div>
                    </div>
                </div>
                <!-- Performance Factors stacked cards -->
                <div class="px-4 py-3 space-y-3">
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Performance Factors</p>
                    @php
                    $perfFactors = [
                        'quality_of_work'          => ['label'=>'1. Quality of Work',          'desc'=>'Competence, accuracy, neatness, thoroughness.'],
                        'quantity_of_work'         => ['label'=>'2. Quantity of Work',         'desc'=>'Use of time, volume of work, ability to meet schedules.'],
                        'job_knowledge'            => ['label'=>'3. Job Knowledge',            'desc'=>'Technical knowledge, understanding of job procedures.'],
                        'working_relationships'    => ['label'=>'4. Working Relationships',    'desc'=>'Cooperation and ability to work with others.'],
                        'attendance_dependability' => ['label'=>'5. Attendance/Dependability', 'desc'=>'Reports as scheduled, seldom absent or tardy.'],
                        'specific_achievements'    => ['label'=>'6. Specific Achievements',    'desc'=>''],
                    ];
                    $ratingOptions = [
                        'outstanding'          => 'Outstanding',
                        'exceeds_expectations' => 'Exceeds Expectations',
                        'meets_expectations'   => 'Meets Expectations',
                        'needs_improvement'    => 'Needs Improvement',
                        'unsatisfactory'       => 'Unsatisfactory',
                    ];
                    @endphp
                    @foreach($perfFactors as $key => $factor)
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                        <p class="text-sm font-bold text-gray-800">{{ $factor['label'] }}</p>
                        @if($factor['desc'])<p class="text-xs text-gray-500 mt-0.5 mb-2">{{ $factor['desc'] }}</p>@else<div class="mb-2"></div>@endif
                        <div class="grid grid-cols-2 gap-1 mb-2">
                            @foreach($ratingOptions as $val => $rLabel)
                            <label class="flex items-center gap-2 cursor-pointer bg-white border border-gray-200 rounded-lg px-2 py-1.5 hover:border-blue-400 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <input type="radio" name="{{ $key }}_rating" value="{{ $val }}" class="w-4 h-4 accent-blue-600 prmsu-radio shrink-0">
                                <span class="text-xs text-gray-700 leading-tight">{{ $rLabel }}</span>
                            </label>
                            @endforeach
                        </div>
                        <textarea name="{{ $key }}_comment" rows="2" class="w-full text-xs text-gray-800 bg-white border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none focus:border-blue-400 resize-none" placeholder="Comments (optional)..."></textarea>
                    </div>
                    @endforeach
                </div>
                <!-- Definitions collapsible -->
                <div class="px-4 pb-3">
                    <details class="bg-gray-50 border border-gray-200 rounded-xl">
                        <summary class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wide cursor-pointer select-none">Rating Definitions</summary>
                        <div class="px-3 pb-3 space-y-1.5 text-xs">
                            @foreach(['Outstanding'=>'Exceeded all performance expectations and made many significant contributions.','Exceeds Expectations'=>'Regularly works beyond majority of expectations and made significant contributions.','Meets Expectations'=>'Met performance expectations and contributed to the organization.','Needs Improvement'=>'Failed to meet one or more significant performance expectations.','Unsatisfactory'=>'Failed to meet the performance expectations for this factor.'] as $term => $def)
                            <div class="flex gap-2"><span class="font-bold text-gray-700 whitespace-nowrap">{{ $term }} &mdash;</span><span class="text-gray-600">{{ $def }}</span></div>
                            @endforeach
                        </div>
                    </details>
                </div>
                <!-- Signature -->
                <div class="px-4 pb-4 flex justify-between items-end gap-4 border-t border-gray-100 pt-3">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 mb-1">Supervisor's Signature</p>
                        <div class="border-b border-gray-400 h-5"></div>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->name }}</p>
                    </div>
                    <div class="w-32">
                        <p class="text-xs text-gray-500 mb-1">Date:</p>
                        <div class="border-b border-gray-400 h-5"></div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex gap-3 px-4 pb-5">
                    <button type="button" onclick="closeEvaluationModal()" class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl transition-colors font-semibold text-sm">Cancel</button>
                    <button type="submit" id="evalSubmitBtn" class="flex-1 px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-colors font-semibold text-sm">Submit Evaluation</button>
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
        // Global error handler to prevent navigation breaking
        window.addEventListener('error', function(e) {
            console.error('Global error caught:', e.error);
            return false;
        });

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
            interns: '👥 Interns',
            certificates: '🏅 Certificates'
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
                sessionStorage.setItem('supervisor_activeSection', name);
                
                // trigger section-specific initialization
                if (name === 'interns') {
                    setTimeout(() => {
                        if (typeof loadInternData === 'function') {
                            loadInternData();
                        }
                    }, 100);
                } else if (name === 'certificates') {
                    setTimeout(() => {
                        if (typeof loadCertificateData === 'function') {
                            loadCertificateData();
                        }
                    }, 100);
                }
                
                // Debug logging
                console.log('Supervisor section switched to:', name, 'Target found:', !!target);
            } catch (error) {
                console.error('Error in showSection:', error);
                // Try to recover by showing overview
                setTimeout(() => {
                    const overview = document.getElementById('section-overview');
                    if (overview) {
                        overview.classList.remove('hidden');
                        console.log('Supervisor recovered to overview section');
                    }
                }, 100);
            }
        }

        (function() {
            try {
                showSection(sessionStorage.getItem('supervisor_activeSection') || 'overview');
                if (localStorage.getItem('sidebarCollapsed') === '1' && window.innerWidth >= 1024) {
                    sidebarCollapsed = true;
                    if (sidebar) sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('sidebar-collapsed');
                    if (topHeader) topHeader.style.left = '64px';
                }
            } catch (error) {
                console.error('Error during supervisor initialization:', error);
                // Fallback to overview section
                showSection('overview');
            }
        })();
        // ===== END SIDEBAR LOGIC =====

        // Toggle student card expansion — collapse others first
        function filterInterns(q) {
            q = q.toLowerCase();
            document.querySelectorAll('.student-card').forEach(card => {
                const match = (card.dataset.intern || '').includes(q);
                card.style.display = match ? '' : 'none';
            });
        }

        function filterTimeEdits(input, studentId) {
            const q = input.value.toLowerCase();
            document.querySelectorAll(`#timeEditsTable-${studentId} .time-edit-row`).forEach(row => {
                row.style.display = (row.dataset.date || '').includes(q) ? '' : 'none';
            });
        }

        function confirmUndoApproval(recordId, date, session) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[200] flex items-center justify-center bg-black/70 p-4';
            modal.innerHTML = `
                <div class="bg-slate-800 border border-orange-500/50 rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                    <div class="text-center mb-4">
                        <div class="text-4xl mb-3">↩️</div>
                        <h3 class="text-lg font-bold text-white mb-2">Undo Approval?</h3>
                        <p class="text-gray-300 text-sm">This will <strong class="text-orange-400">revert the approval</strong> for:</p>
                        <p class="text-white font-semibold mt-1">${date} ${session ? '— ' + session : ''}</p>
                        <div class="mt-3 bg-orange-500/10 border border-orange-500/30 rounded-lg px-4 py-3 text-left">
                            <p class="text-orange-300 text-xs font-semibold">⚠️ Hours will be deducted</p>
                            <p class="text-gray-400 text-xs mt-1">The credited hours for this session will be removed from the student's progress and the record will return to Pending status.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                        <button onclick="submitUndoApproval(${recordId}, this)" class="flex-1 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold transition-all">Yes, Undo</button>
                    </div>
                </div>`;
            document.body.appendChild(modal);
        }

        async function submitUndoApproval(recordId, btn) {
            btn.disabled = true;
            btn.textContent = 'Undoing…';
            try {
                const res = await fetch(`/api/time-records/${recordId}/undo-approval`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const data = await res.json();
                btn.closest('.fixed').remove();
                if (data.success) {
                    showToast('Approval Undone', 'Hours deducted and record set back to Pending.', 'orange');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showToast('Error', data.message || 'Failed to undo approval.', 'red');
                }
            } catch(e) {
                btn.closest('.fixed').remove();
                showToast('Error', 'Network error. Please try again.', 'red');
            }
        }

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

        // Deny All Time Edits Modal
        function showDenyAllTimeEditModal(studentId) {
            document.getElementById('denyAllTimeEditForm').action = `{{ url('/deny-all-time-in') }}/${studentId}`;
            document.getElementById('denyAllTimeEditModal').classList.remove('hidden');
        }
        function closeDenyAllTimeEditModal() {
            document.getElementById('denyAllTimeEditModal').classList.add('hidden');
        }

        // Approve All Requirements Modal
        function showApproveAllRequirementsModal(studentId, studentEmail) {
            document.getElementById('approveAllRequirementsForm').action = `{{ url('/approve-all-requirements') }}/${studentId}`;
            document.getElementById('approveAllRequirementsModal').classList.remove('hidden');
        }
        function closeApproveAllRequirementsModal() {
            document.getElementById('approveAllRequirementsModal').classList.add('hidden');
        }

        // Deny All Requirements Modal
        function showDenyAllRequirementsModal(studentId) {
            document.getElementById('denyAllRequirementsForm').action = `{{ url('/deny-all-requirements') }}/${studentId}`;
            document.getElementById('denyAllRequirementsModal').classList.remove('hidden');
        }
        function closeDenyAllRequirementsModal() {
            document.getElementById('denyAllRequirementsModal').classList.add('hidden');
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
            document.getElementById('denyRequirementForm').dataset.requirementId = requirementId;
            document.getElementById('denyRequirementForm').querySelector('textarea').value = '';
            document.getElementById('denyRequirementModal').classList.remove('hidden');
        }

        function closeDenyRequirementModal() {
            document.getElementById('denyRequirementModal').classList.add('hidden');
        }

        document.getElementById('denyRequirementForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // prevent pixel-loader auto-attach
            const requirementId = this.dataset.requirementId;
            const feedback = this.querySelector('textarea[name="feedback"]').value.trim();
            if (!feedback) return;
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true; btn.textContent = 'Denying...';
            if (typeof showPixelLoader === 'function') showPixelLoader('DENYING');
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('feedback', feedback);
            try {
                const res = await fetch(`{{ url('/reject-requirement') }}/${requirementId}`, { method: 'POST', body: fd });
                const data = await res.json().catch(() => ({}));
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                if (res.ok && data.success) {
                    closeDenyRequirementModal();
                    if (typeof showSuccess === 'function') {
                        showSuccess('Requirement denied successfully!', null, true);
                    } else {
                        location.reload();
                    }
                } else {
                    alert(data.message || 'Failed to deny requirement. Please try again.');
                    btn.disabled = false; btn.textContent = 'Deny';
                }
            } catch(err) {
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                alert('Network error. Please try again.');
                btn.disabled = false; btn.textContent = 'Deny';
            }
        }, true); // capture phase — runs before pixel-loader listener

        function openEvalFromBtn(btn) {
            const studentId   = btn.dataset.studentId;
            const studentName = btn.dataset.studentName;
            const isEvaluated = btn.dataset.isEvaluated === '1';
            const evalData    = JSON.parse(btn.dataset.eval || 'null');
            showEvaluationModal(studentId, studentName, isEvaluated, evalData);
        }

        // Evaluation Modal (PRMSU)
        function showEvaluationModal(studentId, studentName, isEvaluated = false, existingData = null) {
            document.getElementById('evalStudentName').textContent = studentName;
            document.getElementById('eval_student_name_field').value = studentName;
            const form = document.getElementById('evaluationForm');
            form.action = `{{ url('/save-evaluation') }}/${studentId}`;
            // 1. Reset
            form.querySelectorAll('.prmsu-radio').forEach(r => { r.checked = false; r.style.pointerEvents = ''; r.disabled = false; });
            form.querySelectorAll('textarea').forEach(t => { t.value = ''; t.readOnly = false; t.style.pointerEvents = ''; });
            form.querySelectorAll('input[type="date"],input[type="text"]').forEach(el => { if (!el.hasAttribute('readonly')) { el.value = ''; el.disabled = false; } });
            document.getElementById('ratingInput').value = 0;
            // 2. Populate before disabling
            if (existingData) {
                if (existingData.evaluation_date) document.getElementById('eval_evaluation_date').value = existingData.evaluation_date;
                if (existingData.period_from)     document.getElementById('eval_period_from').value    = existingData.period_from;
                if (existingData.period_to)       document.getElementById('eval_period_to').value      = existingData.period_to;
                if (existingData.job_title)       document.getElementById('eval_job_title').value      = existingData.job_title;
                ['quality_of_work','quantity_of_work','job_knowledge','working_relationships','attendance_dependability','specific_achievements'].forEach(f => {
                    const rVal = existingData[f + '_rating'];
                    if (rVal) { const r = form.querySelector(`input[name="${f}_rating"][value="${rVal}"]`); if (r) r.checked = true; }
                    const cVal = existingData[f + '_comment'];
                    const ta = form.querySelector(`textarea[name="${f}_comment"]`);
                    if (ta && cVal) ta.value = cVal;
                });
            }
            // 3. Lock if already evaluated
            const submitBtn = document.getElementById('evalSubmitBtn');
            if (isEvaluated) {
                submitBtn.disabled = true;
                submitBtn.textContent = '✅ Already Submitted';
                submitBtn.className = submitBtn.className.replace('bg-blue-700 hover:bg-blue-800','bg-gray-400 cursor-not-allowed');
                form.querySelectorAll('.prmsu-radio').forEach(r => r.style.pointerEvents = 'none');
                form.querySelectorAll('textarea').forEach(t => { t.readOnly = true; t.style.pointerEvents = 'none'; });
                form.querySelectorAll('input[type="date"],input[type="text"]').forEach(el => { if (!el.hasAttribute('readonly')) el.disabled = true; });
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Evaluation';
                submitBtn.className = submitBtn.className.replace('bg-gray-400 cursor-not-allowed','bg-blue-700 hover:bg-blue-800');
            }
            document.getElementById('evaluationModal').classList.remove('hidden');
        }

        function closeEvaluationModal() {
            document.getElementById('evaluationModal').classList.add('hidden');
        }

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
            e.stopImmediatePropagation();
            const form = this;
            const factors = ['quality_of_work','quantity_of_work','job_knowledge','working_relationships','attendance_dependability','specific_achievements'];
            for (const f of factors) {
                if (!form.querySelector(`input[name="${f}_rating"]:checked`)) {
                    alert(`Please select a rating for all performance factors.`);
                    return;
                }
            }
            // Derive overall rating from radio selections (map to 1-5)
            const ratingMap = {outstanding:5,exceeds_expectations:4,meets_expectations:3,needs_improvement:2,unsatisfactory:1};
            const scores = factors.map(f => ratingMap[form.querySelector(`input[name="${f}_rating"]:checked`)?.value] || 0);
            const avg = Math.round(scores.reduce((a,b)=>a+b,0)/scores.length);
            document.getElementById('ratingInput').value = avg;

            const submitBtn = document.getElementById('evalSubmitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            if (typeof showPixelLoader === 'function') showPixelLoader('SAVING');

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(r => { if (!r.ok) throw new Error('Server error ' + r.status); return r.json(); })
            .then(data => {
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                if (data.success) {
                    closeEvaluationModal();
                    if (typeof showSuccess === 'function') showSuccess('Evaluation submitted successfully!');
                    setTimeout(() => { _allowLeave = true; window.location.reload(); }, 3500);
                } else {
                    alert('Failed to submit. Please try again.');
                    submitBtn.disabled = false; submitBtn.textContent = 'Submit Evaluation';
                }
            })
            .catch(err => {
                if (typeof hidePixelLoader === 'function') hidePixelLoader();
                alert('Submission failed: ' + err.message);
                submitBtn.disabled = false; submitBtn.textContent = 'Submit Evaluation';
            });
        }, true);

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
                icon.innerHTML = '<svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>';
                icon.className = 'inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/20 mb-4';
                title.textContent = 'Logout?';
                msg.textContent = 'You will be signed out of your account.';
                btn.textContent = 'Yes, Logout'; btn.href = '/logout';
                btn.className = 'flex-1 px-5 py-3 text-center text-white rounded-xl font-semibold transition-all bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:scale-105 transform';
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

        // ── Certificate ──────────────────────────────────────────────────
        let _certStudentId = null;

        function awardCertificate(studentId, studentName, isUpdate = false) {
            _certStudentId = studentId;
            const modal = document.getElementById('certConfirmModal');
            document.getElementById('certConfirmIcon').textContent = isUpdate ? '🔄' : '🏅';
            document.getElementById('certConfirmTitle').textContent = isUpdate ? 'Re-issue Certificate?' : 'Award Certificate?';
            document.getElementById('certConfirmMsg').textContent = isUpdate
                ? `Re-issue the OJT Completion Certificate for ${studentName}? The award date will be updated to today.`
                : `Award the OJT Completion Certificate to ${studentName}? This will be visible on their dashboard.`;
            document.getElementById('certConfirmBtn').textContent = isUpdate ? '🔄 Re-issue' : '🏅 Award';
            modal.classList.remove('hidden');
        }

        function closeCertConfirm() {
            document.getElementById('certConfirmModal').classList.add('hidden');
            _certStudentId = null;
        }

        function executeCertAward() {
            if (!_certStudentId) return;
            const btn = document.getElementById('certConfirmBtn');
            btn.disabled = true;
            btn.textContent = 'Processing…';
            fetch(`/award-certificate/${_certStudentId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                closeCertConfirm();
                if (data.success) {
                    showToast('🏅 Certificate Awarded!', data.message || 'Certificate successfully issued.', 'green');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    btn.disabled = false;
                    btn.textContent = 'Confirm';
                    showToast('Error', data.message || 'Failed to award certificate.', 'red');
                }
            })
            .catch(() => {
                closeCertConfirm();
                showToast('Network Error', 'Please try again.', 'red');
            });
        }
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

    <!-- ===== CERTIFICATE IMAGE MODAL ===== -->
    <div id="certImageModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/85 p-4"
         onclick="if(event.target===this)closeCertImageModal()">
        <div class="bg-slate-900 border border-yellow-500/30 rounded-2xl shadow-2xl flex flex-col"
             style="max-width:960px;width:100%;max-height:92vh;">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span id="certImageModalTitle" class="text-sm font-semibold text-yellow-300">🏅 OJT Certificate of Completion</span>
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
        _certImageUrl = url;
        _certImageName = name;
        document.getElementById('certImageEl').src = url;
        document.getElementById('certImageModalTitle').textContent = '🏅 ' + name + ' — Certificate';
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
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // Upload certificate image via AJAX
    function uploadCertificate(studentId, input) {
        const file = input.files[0];
        if (!file) return;
        const progress = document.getElementById('cert-progress-' + studentId);

        // Show uploading overlay
        showUploadingOverlay('Uploading certificate…');

        const fd = new FormData();
        fd.append('certificate_image', file);
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('/upload-certificate/' + studentId, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                hideUploadingOverlay();
                if (data.success) {
                    showToast('✅ Certificate Uploaded!', 'The certificate is now visible to the student.', 'green');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (progress) progress.classList.add('hidden');
                    showToast('Upload Failed', data.message || 'Please try again.', 'red');
                }
            })
            .catch(() => {
                hideUploadingOverlay();
                if (progress) progress.classList.add('hidden');
                showToast('Network Error', 'Please try again.', 'red');
            });
    }

    // Uploading overlay helpers
    function showUploadingOverlay(msg) {
        let el = document.getElementById('_uploadOverlay');
        if (!el) {
            el = document.createElement('div');
            el.id = '_uploadOverlay';
            el.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;';
            el.innerHTML = `
                <svg class="animate-spin" style="width:48px;height:48px;color:#fbbf24;" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <p id="_uploadOverlayMsg" style="color:#fff;font-size:15px;font-weight:600;font-family:sans-serif;"></p>
            `;
            document.body.appendChild(el);
        }
        document.getElementById('_uploadOverlayMsg').textContent = msg || 'Uploading…';
        el.style.display = 'flex';
    }
    function hideUploadingOverlay() {
        const el = document.getElementById('_uploadOverlay');
        if (el) el.style.display = 'none';
    }
    function handleCertDrop(event, studentId) {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        if (!file) return;
        const fakeInput = { files: [file] };
        uploadCertificate(studentId, fakeInput);
    }

    function showToast(title, message, color) {
        const colors = {
            green: 'linear-gradient(135deg,#16a34a,#15803d)',
            red:   'linear-gradient(135deg,#dc2626,#b91c1c)',
            blue:  'linear-gradient(135deg,#2563eb,#1d4ed8)'
        };
        const n = document.createElement('div');
        n.className = 'fixed bottom-6 right-6 z-[300] flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white text-sm font-medium';
        n.style.cssText = `background:${colors[color]||colors.green};border:1px solid rgba(255,255,255,0.2);animation:slideInRight .3s ease`;
        n.innerHTML = `
            <div><div class="font-semibold">${title}</div><div class="text-xs opacity-80">${message}</div></div>
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100 text-lg leading-none">&times;</button>
        `;
        document.body.appendChild(n);
        setTimeout(() => { n.style.animation='slideOutRight .3s ease forwards'; setTimeout(()=>n.remove(),300); }, 4000);
    }
    </script>

    <!-- Page loader overlay -->
    <div id="pageLoader" class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-6"
         style="background:rgba(5,13,46,0.95);backdrop-filter:blur(8px);">
        <div class="relative">
            <svg class="animate-spin" style="width:64px;height:64px;" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="rgba(139,92,246,0.2)" stroke-width="3"/>
                <path d="M4 12a8 8 0 018-8" stroke="#a78bfa" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-purple-500/30 rounded-full animate-pulse"></div>
            </div>
        </div>
        <p id="pageLoaderMsg" style="color:#c4b5fd;font-size:16px;font-weight:600;font-family:sans-serif;letter-spacing:.05em;">Please wait…</p>
    </div>

</body>
</html>