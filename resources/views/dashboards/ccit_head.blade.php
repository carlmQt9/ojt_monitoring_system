<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CCIT Head Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/docx@8.5.0/build/index.min.js"></script>
    <style>
        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg,#dde8f5,#c8daf0,#d8eaf8) !important; color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1a2a4a !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-red"] { color: #fff !important; }
        body.light h1,body.light h2,body.light h3,body.light h4,
        body.light p,body.light span,body.light label,body.light div,
        body.light td,body.light th,body.light li,body.light small { color: #1a2a4a; }
        body.light .text-white,body.light .text-gray-100,body.light .text-gray-200 { color: #1a2a4a !important; }
        body.light .text-gray-300 { color: #2d3f5a !important; }
        body.light .text-gray-400 { color: #3d5070 !important; }
        body.light .text-gray-500 { color: #4a6080 !important; }
        body.light .text-green-400,body.light .text-green-300,body.light .text-green-200 { color: #15803d !important; }
        body.light .text-blue-400,body.light .text-blue-300,body.light .text-blue-200 { color: #1d4ed8 !important; }
        body.light .text-red-400,body.light .text-red-300,body.light .text-red-200 { color: #b91c1c !important; }
        body.light .text-yellow-400,body.light .text-yellow-300 { color: #92400e !important; }
        body.light .text-purple-400,body.light .text-purple-300 { color: #6d28d9 !important; }
        body.light button[class*="bg-green-6"],body.light button[class*="bg-blue-6"],
        body.light button[class*="bg-red-6"],body.light button[class*="bg-orange-6"],
        body.light button[class*="bg-yellow-6"],body.light button[class*="bg-indigo-6"],
        body.light a[class*="bg-red-6"],body.light a[class*="bg-blue-6"] { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: #c8daf0 !important; }
        body.light [class*="bg-slate-800"] { background: #d0e4f8 !important; }
        body.light [class*="bg-slate-700"] { background: #bdd4ec !important; }
        body.light [class*="bg-slate-6"] { background: #aac4e0 !important; }
        body.light [class*="bg-gray-9"] { background: #c8daf0 !important; }
        body.light [class*="border-slate-7"] { border-color: #7aaad4 !important; }
        body.light [class*="border-slate-6"] { border-color: #8ab8dc !important; }
        body.light [class*="divide-slate-7"] > * { border-color: #7aaad4 !important; }
        body.light .bg-red-900 { background: rgba(254,202,202,0.5) !important; }
        body.light .bg-green-900 { background: rgba(187,247,208,0.5) !important; }
        body.light .bg-blue-900 { background: rgba(219,234,254,0.5) !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.9) !important; border-color: #7aaad4 !important; color: #1a2a4a !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #5a7a9a !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: #fff !important; border-color: #b91c1c !important; border-left: 4px solid #b91c1c !important; }
        body.light .header-info-card h1 { color: #1a2a4a !important; }
        body.light .header-info-card .subtitle { color: #4a6080 !important; }
        body.light .header-info-card .stat-label { color: #4a6080 !important; }
        body.light .header-info-card .stat-value-white { color: #1a2a4a !important; }
        body.light .header-info-card .stat-value-red { color: #b91c1c !important; }
        body.light .header-info-card .divider { background: #cbd5e1 !important; }

        /* SIDEBAR */
        #sidebar { position:fixed; top:0; left:0; height:100%; min-height:100vh; width:16rem; background:#1e3a5f; z-index:40; display:flex; flex-direction:column; transition:width .3s,transform .3s; overflow:hidden; }
        #sidebar.collapsed { width:4rem; }
        #sidebar.mobile-hidden { transform:translateX(-100%); }
        #top-header { position:fixed; top:0; left:0; right:0; height:3.5rem; background:rgba(15,23,42,0.95); backdrop-filter:blur(8px); border-bottom:1px solid rgba(239,68,68,0.3); z-index:30; display:flex; align-items:center; padding:0 1rem; gap:.75rem; }
        @media(min-width:1024px){ #top-header { left:16rem; transition:left .3s; } #sidebar.collapsed ~ * #top-header, body.sidebar-collapsed #top-header { left:4rem; } #sidebar { transform:none !important; } #hamburger { display:none; } }
        #main-content { padding-top:3.5rem; }
        @media(min-width:1024px){ #main-content { margin-left:16rem; transition:margin-left .3s; } body.sidebar-collapsed #main-content { margin-left:4rem; } }
        .nav-item { display:flex; align-items:center; gap:.75rem; padding:.65rem .75rem; border-radius:.5rem; cursor:pointer; transition:background .2s; color:#cbd5e1; white-space:nowrap; border:none; background:none; width:100%; text-align:left; }
        .nav-item:hover { background:rgba(239,68,68,0.15); color:#fff; }
        .nav-item.active { background:rgba(239,68,68,0.38); color:#f87171; }
        .nav-icon { font-size:1.1rem; flex-shrink:0; width:1.5rem; text-align:center; }
        .nav-label { font-size:.875rem; font-weight:500; }
        #sidebar.collapsed .nav-label, #sidebar.collapsed .sidebar-title, #sidebar.collapsed .sidebar-subtitle { display:none; }
        .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:35; }
        .sidebar-overlay.active { display:block; }
        .dash-section { animation:fadeIn .25s ease; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
        body.light #sidebar,
        body.light #sidebar [class*="bg-slate"],
        body.light #sidebar [class*="bg-gray"] { background: #1e3a5f !important; }
        body.light #sidebar .nav-label,
        body.light #sidebar .nav-icon,
        body.light #sidebar .sidebar-title,
        body.light #sidebar .sidebar-subtitle,
        body.light #sidebar nav button,
        body.light #sidebar nav button span,
        body.light #sidebar > div p,
        body.light #sidebar > div span { color: #e2eaf5 !important; }
        body.light #sidebar .nav-item.active { background: rgba(239,68,68,0.25) !important; }
        body.light #sidebar .nav-item.active .nav-label,
        body.light #sidebar .nav-item.active .nav-icon { color: #fca5a5 !important; }
        body.light #sidebar .nav-item:not(.active):hover { background: rgba(255,255,255,0.08) !important; }
        body.light #top-header { background:rgba(220,235,255,0.97); border-color:#7aaad4; }
        @keyframes slideInRight { from{opacity:0;transform:translateX(60px)} to{opacity:1;transform:translateX(0)} }
        @keyframes slideOutRight { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(60px)} }

        /* PIXEL LOADING */
        @font-face {
            font-family: 'Press Start 2P';
            src: url('https://fonts.gstatic.com/s/pressstart2p/v15/e3t4euO8T-267oIAQAu6jDQyK3nVivM.woff2') format('woff2');
        }
        #pixelLoader { font-family: 'Press Start 2P', monospace; }
        .pixel-bar-wrap { display:flex; gap:4px; align-items:center; }
        .pixel-cell { width:28px; height:28px; border:3px solid #1a1a1a; image-rendering:pixelated; transition:background .1s; }
        .pixel-cell.filled { background:#4ade80; box-shadow:inset -4px -4px 0 #16a34a, inset 4px 4px 0 #86efac; }
        .pixel-cell.empty  { background:#d1d5db; box-shadow:inset -4px -4px 0 #9ca3af, inset 4px 4px 0 #f3f4f6; }
        .pixel-cell.cap-l  { border-radius:6px 0 0 6px; }
        .pixel-cell.cap-r  { border-radius:0 6px 6px 0; }
        @keyframes pixelDots { 0%{content:'.'} 25%{content:'..'} 50%{content:'...'} 75%{content:'....'} 100%{content:'.'} }
        #pixelDots::after { content:'.'; animation:pixelDots 1s steps(1) infinite; }
        /* SUCCESS CHECKMARK */
        @keyframes popIn { 0%{transform:scale(0) rotate(-20deg);opacity:0} 70%{transform:scale(1.2) rotate(5deg)} 100%{transform:scale(1) rotate(0);opacity:1} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .pixel-check { image-rendering:pixelated; font-size:3rem; animation:popIn .5s cubic-bezier(.36,.07,.19,.97) forwards; }
        .pixel-success-text { animation:fadeUp .4s .3s ease forwards; opacity:0; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    @include('partials.success-popup')

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="mobile-hidden">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-4 py-4 border-b border-white/10">
            <div class="w-9 h-9 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21a12.083 12.083 0 01-6.16-10.422L12 14z"/></svg>
            </div>
            <div class="min-w-0">
                <div class="sidebar-title text-sm font-bold text-white truncate">OJT Monitoring System</div>
                <div class="sidebar-subtitle text-xs text-red-300 truncate">CCIT Head</div>
            </div>
        </div>
        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-2 py-3 space-y-1 min-h-0">
            <button class="nav-item active" onclick="showSection('overview'); closeSidebar();" data-section="overview">
                <span class="nav-icon">📊</span><span class="nav-label">Overview</span>
            </button>
            <button class="nav-item" onclick="showSection('users'); closeSidebar();" data-section="users">
                <span class="nav-icon">👥</span><span class="nav-label">Users</span>
            </button>
            <button class="nav-item" onclick="showSection('analytics'); closeSidebar();" data-section="analytics">
                <span class="nav-icon">📈</span><span class="nav-label">Analytics</span>
            </button>
            <button class="nav-item" onclick="showSection('schoolyears'); closeSidebar();" data-section="schoolyears">
                <span class="nav-icon">🗓️</span><span class="nav-label">School Years</span>
            </button>
            <button class="nav-item" onclick="showSection('schoolids'); closeSidebar();" data-section="schoolids">
                <span class="nav-icon">🪪</span><span class="nav-label">School IDs</span>
            </button>
            <button class="nav-item" onclick="showSection('reports'); closeSidebar();" data-section="reports">
                <span class="nav-icon">📝</span><span class="nav-label">Reports</span>
            </button>
            <button class="nav-item" onclick="showSection('settings'); closeSidebar();" data-section="settings">
                <span class="nav-icon">⚙️</span><span class="nav-label">Settings</span>
            </button>
        </nav>
        <!-- Footer — always visible at bottom -->
        <div class="px-2 py-3 border-t border-white/10 shrink-0">
            <button class="nav-item text-red-400 hover:bg-red-500/10" onclick="showConfirm('logout')">
                <span class="nav-icon">🚪</span><span class="nav-label font-semibold">Logout</span>
            </button>
        </div>
    </aside>

    <!-- Top Header -->
    <header id="top-header">
        <button id="hamburger" onclick="toggleSidebar()" class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 lg:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <button onclick="toggleSidebarCollapse()" class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 hidden lg:block">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span id="headerTitle" class="text-white font-semibold text-sm flex-1">Overview</span>
        <div class="flex items-center gap-2">
            <label class="text-gray-400 text-xs hidden sm:block">SY:</label>
            <select id="globalSchoolYear" class="px-2 py-1.5 bg-slate-700 border border-slate-600 text-white rounded-lg text-xs focus:outline-none focus:border-red-500">
                <option value="">All Years</option>
            </select>
            <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                class="w-8 h-8 rounded-full flex items-center justify-center transition-all"
                style="background:rgba(185,28,28,0.8);border:1px solid rgba(252,165,165,0.4)">
                <svg id="iconMoon" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg id="iconSun" class="w-4 h-4 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            </button>
        </div>
    </header>

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
                <a id="confirmBtn" href="#" class="flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-red-600 hover:bg-red-700">Confirm</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="pt-14 lg:ml-64">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @php
            $_activeSY = \App\Models\SchoolYear::where('is_active', true)->first();
        @endphp

        <!-- SECTION: Overview -->
        <section id="section-overview" class="dash-section">

        <!-- Header Info Card -->
        <div class="header-info-card mb-6 bg-gradient-to-r from-slate-800/50 to-red-900/30 border border-slate-700 rounded-xl p-4 sm:p-6">
            <h1 class="text-2xl sm:text-4xl font-bold text-white mb-1">CCIT Head Dashboard</h1>
            <p class="subtitle text-gray-400 mb-4 text-sm">Oversee all OJT monitoring and system coordination</p>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                <div>
                    <span class="stat-label text-xs text-gray-400">👤 CCIT Head:</span>
                    <p class="stat-value-white text-base font-semibold text-white">{{ $user->name }}</p>
                </div>
                @if($_activeSY)
                <div class="divider h-6 w-px bg-slate-600 hidden sm:block"></div>
                <div>
                    <span class="stat-label text-xs text-gray-400">📅 School Year:</span>
                    <p class="stat-value-red text-base font-semibold text-red-400">{{ $_activeSY->label }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Head Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">👥 Total Users</div>
                <div class="text-3xl font-bold text-white" id="totalUsers">0</div>
                <p class="text-xs text-gray-500 mt-2">All system users</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">🎓 Total Students</div>
                <div class="text-3xl font-bold text-white" id="totalStudents">0</div>
                <p class="text-xs text-gray-500 mt-2">Currently registered</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">📋 Active Programs</div>
                <div class="text-3xl font-bold text-white" id="activePrograms">0</div>
                <p class="text-xs text-gray-500 mt-2">Ongoing OJT programs</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">✅ Completion Rate</div>
                <div class="text-3xl font-bold text-white" id="completionRate">0%</div>
                <p class="text-xs text-gray-500 mt-2">Overall system</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <!-- Donut: Completion Rate -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6 flex flex-col items-center">
                <h3 class="text-sm font-semibold text-gray-400 mb-4 self-start">✅ Completion Status</h3>
                <div class="relative w-36 h-36">
                    <canvas id="chartCompletion"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span id="chartCompletionLabel" class="text-2xl font-bold text-white">0%</span>
                    </div>
                </div>
                <div class="flex flex-col gap-1 mt-3 text-xs">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span><span id="completedCountLabel">0 completed</span></span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span><span id="inProgressCountLabel">0 in progress</span></span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-500 inline-block"></span><span id="notStartedCountLabel">0 not started</span></span>
                </div>
            </div>
            <!-- Bar: Users by Role -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">👥 Users by Role</h3>
                <canvas id="chartRoles" height="160"></canvas>
            </div>
            <!-- Line: Student Registration Trend -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-4">📈 Student Trend (6 months)</h3>
                <canvas id="chartTrend" height="160"></canvas>
            </div>
        </div>

        </section><!-- /section-overview -->

        <!-- SECTION: Users -->
        <section id="section-users" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">👥 User Management</h2>
                <p class="text-gray-400 text-sm">Manage all students, supervisors, and coordinators</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="mb-4 grid grid-cols-2 sm:flex sm:flex-wrap gap-2">
                    <button onclick="showAddUserForm()" class="col-span-2 sm:col-span-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">+ Add User</button>
                    <button onclick="approveAll()" id="approveAllBtn" class="hidden col-span-2 sm:col-span-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold">✓ Approve All Pending</button>
                    <select id="roleFilter" onchange="applyFilters()" class="px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg text-sm focus:outline-none focus:border-red-500">
                        <option value="">All Roles</option>
                        <option value="student">Student</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="coordinator">Coordinator</option>
                        <option value="ccit_head">CCIT Head</option>
                    </select>
                    <select id="approvalFilter" onchange="applyFilters()" class="px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg text-sm focus:outline-none focus:border-red-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </select>
                    <input type="text" id="userSearch" placeholder="Search users..." oninput="applyFilters()" class="col-span-2 sm:col-span-auto flex-1 min-w-[160px] px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500 text-sm">
                </div>
                <!-- Desktop table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs text-gray-400 bg-slate-700/50">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">School ID</th>
                                <th class="px-4 py-2">Company</th>
                                <th class="px-4 py-2">School Year</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTable" class="divide-y divide-slate-700">
                            <tr class="bg-slate-800/50"><td colspan="8" class="px-4 py-4 text-center text-gray-400">Loading users...</td></tr>
                        </tbody>
                    </table>
                </div>
                <!-- Mobile cards -->
                <div class="md:hidden" id="userTableMobile">
                    <p class="text-gray-400 text-sm text-center py-4">Loading users...</p>
                </div>
            </div>
        </section><!-- /section-users -->

        <!-- SECTION: Analytics -->
        <section id="section-analytics" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">📈 Student Analytics</h2>
                <p class="text-gray-400 text-sm">View comprehensive system analytics and reports</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="bg-slate-700/50 rounded-lg p-4">
                        <h4 class="text-gray-300 mb-2">Select Student</h4>
                        <select id="analyticsStudentSelect" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                            <option value="">Choose a student...</option>
                        </select>
                    </div>
                    <div class="bg-slate-700/50 rounded-lg p-4">
                        <h4 class="text-gray-300 mb-2">Report Period</h4>
                        <select id="reportPeriod" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                            <option value="all">All Time</option>
                            <option value="month">This Month</option>
                            <option value="week">This Week</option>
                        </select>
                    </div>
                </div>
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs text-gray-400 bg-slate-700/50">
                            <tr>
                                <th class="px-4 py-2">Student Name</th>
                                <th class="px-4 py-2">Hours Completed</th>
                                <th class="px-4 py-2">Progress</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="analyticsTable" class="divide-y divide-slate-700">
                            <tr class="bg-slate-800/50"><td colspan="5" class="px-4 py-4 text-center text-gray-400">Loading analytics...</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="md:hidden" id="analyticsTableMobile">
                    <p class="text-gray-400 text-sm text-center py-4">Loading analytics...</p>
                </div>
            </div>
        </section><!-- /section-analytics -->

        <!-- SECTION: School Years -->
        <section id="section-schoolyears" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">🗓️ School Years</h2>
                <p class="text-gray-400 text-sm">Manage school years and assign students per batch</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="flex gap-2 mb-4">
                    <input id="newSchoolYearInput" type="text" placeholder="e.g. 2025-2026"
                        class="flex-1 px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm">
                    <button onclick="addSchoolYear()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Add</button>
                </div>
                <p id="syError" class="text-red-400 text-xs mb-3 hidden"></p>
                <div id="schoolYearList" class="space-y-2 overflow-y-auto">
                    <p class="text-gray-400 text-sm text-center py-4">Loading...</p>
                </div>
            </div>
        </section><!-- /section-schoolyears -->

        <!-- SECTION: School IDs -->
        <section id="section-schoolids" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">🪪 Student School IDs</h2>
                <p class="text-gray-400 text-sm">Manage approved school ID numbers for student registration</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <p class="text-gray-400 text-sm mb-4">Only students with an approved School ID (e.g. <span class="text-red-300 font-mono">23-1-2-0001</span>) can register.</p>
                <div class="flex flex-wrap gap-2 mb-2">
                    <input id="newSchoolIdInput" type="text" placeholder="e.g. 23-1-2-0001"
                        class="flex-1 min-w-[160px] px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm font-mono">
                    <button onclick="addSchoolId()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Add</button>
                </div>
                <p id="sidError" class="text-red-400 text-xs mb-3 hidden"></p>
                <div id="schoolIdList" class="space-y-2 overflow-y-auto">
                    <p class="text-gray-400 text-sm text-center py-4">Loading...</p>
                </div>
            </div>
        </section><!-- /section-schoolids -->

        <!-- SECTION: Reports -->
        <section id="section-reports" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">📝 System Reports</h2>
                <p class="text-gray-400 text-sm">Generate and export detailed system-wide reports</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- System Report -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col">
                    <div class="text-3xl mb-3">📊</div>
                    <h4 class="text-white font-semibold text-lg mb-1">System Report</h4>
                    <p class="text-gray-400 text-sm mb-6 flex-1">All users, students, and OJT progress overview</p>
                    <div class="flex gap-2">
                        <button onclick="exportReport('system','pdf')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 17v-1h8v1H8zm0-3v-1h8v1H8zm0-3V10h5v1H8z"/></svg>
                            Export PDF
                        </button>
                    </div>
                </div>
                <!-- Student Progress Report -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col">
                    <div class="text-3xl mb-3">🎓</div>
                    <h4 class="text-white font-semibold text-lg mb-1">Student Progress</h4>
                    <p class="text-gray-400 text-sm mb-6 flex-1">Detailed OJT hours, completion status per student</p>
                    <div class="flex gap-2">
                        <button onclick="exportReport('students','pdf')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 17v-1h8v1H8zm0-3v-1h8v1H8zm0-3V10h5v1H8z"/></svg>
                            Export PDF
                        </button>
                    </div>
                </div>
                <!-- Attendance Report -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 flex flex-col">
                    <div class="text-3xl mb-3">📋</div>
                    <h4 class="text-white font-semibold text-lg mb-1">Attendance Report</h4>
                    <p class="text-gray-400 text-sm mb-6 flex-1">System-wide time-in/out and attendance records</p>
                    <div class="flex gap-2">
                        <button onclick="exportReport('attendance','pdf')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 17v-1h8v1H8zm0-3v-1h8v1H8zm0-3V10h5v1H8z"/></svg>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </section><!-- /section-reports -->

        <!-- SECTION: Settings -->
        <section id="section-settings" class="dash-section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">⚙️ System Settings</h2>
                <p class="text-gray-400 text-sm">Configure system-wide settings and preferences</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <form id="settingsForm" class="space-y-6">
                    <div class="border-b border-slate-700 pb-6">
                        <h4 class="text-lg font-semibold text-white mb-4">OJT Requirements</h4>
                        <div>
                            <label class="block text-gray-300 mb-2">Required Hours</label>
                            <input type="number" name="required_hours" value="600" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                        </div>
                    </div>
                    <div class="border-b border-slate-700 pb-6">
                        <h4 class="text-lg font-semibold text-white mb-4">Email Settings</h4>
                        <label class="flex items-center">
                            <input type="checkbox" name="email_notifications" class="w-4 h-4 rounded bg-slate-700 border-slate-600 text-red-600">
                            <span class="ml-2 text-gray-300">Enable email notifications</span>
                        </label>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Save Settings</button>
                    </div>
                </form>
            </div>
        </section><!-- /section-settings -->

        </div><!-- /max-w-7xl -->
    </div><!-- /main-content -->

    <!-- School Year Modal -->
    <div id="schoolYearModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">Manage School Years</h3>
                        <button onclick="closeSchoolYearModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <div class="flex gap-2 mb-4">
                        <input id="newSchoolYearInput" type="text" placeholder="e.g. 2025-2026"
                            class="flex-1 px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm">
                        <button onclick="addSchoolYear()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Add</button>
                    </div>
                    <p id="syError" class="text-red-400 text-xs mb-3 hidden"></p>
                    <div id="schoolYearList" class="space-y-2 max-h-72 overflow-y-auto">
                        <p class="text-gray-400 text-sm text-center py-4">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Modal -->
    <div id="userModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">User Management</h3>
                        <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <div class="mb-4 flex space-x-2">
                        <button onclick="showAddUserForm()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">+ Add User</button>
                        <input type="text" id="userSearch" placeholder="Search users..." class="flex-1 px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs text-gray-400 bg-slate-700/50">
                                <tr>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Company</th>
                                    <th class="px-4 py-2">School Year</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTable" class="divide-y divide-slate-700">
                                <tr class="bg-slate-800/50">
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-400">Loading users...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Form Modal -->
    <div id="addUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">Add New User</h3>
                        <button onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <form id="addUserForm" class="space-y-4">
                        <div>
                            <label class="block text-gray-300 mb-2">Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Role</label>
                            <select name="role" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Select Role</option>
                                <option value="student">Student</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="coordinator">Coordinator</option>
                            </select>
                        </div>
                        <div id="companyField">
                            <label class="block text-gray-300 mb-2">Company</label>
                            <select name="company_id" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Select Company</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">School Year</label>
                            <select name="school_year" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Select School Year</option>
                            </select>
                        </div>
                        <div class="flex space-x-4 pt-4">
                            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Add User</button>
                            <button type="button" onclick="closeAddUserModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Modal -->
    <div id="analyticsModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">Student Analytics Reports</h3>
                        <button onclick="closeAnalyticsModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-slate-700/50 rounded-lg p-4">
                            <h4 class="text-gray-300 mb-2">Select Student</h4>
                            <select id="analyticsStudentSelect" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Choose a student...</option>
                            </select>
                        </div>
                        <div class="bg-slate-700/50 rounded-lg p-4">
                            <h4 class="text-gray-300 mb-2">Report Period</h4>
                            <select id="reportPeriod" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="all">All Time</option>
                                <option value="month">This Month</option>
                                <option value="week">This Week</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs text-gray-400 bg-slate-700/50">
                                <tr>
                                    <th class="px-4 py-2">Student Name</th>
                                    <th class="px-4 py-2">Hours Completed</th>
                                    <th class="px-4 py-2">Progress</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="analyticsTable" class="divide-y divide-slate-700">
                                <tr class="bg-slate-800/50">
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-400">Loading analytics...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">System Settings</h3>
                        <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <form id="settingsForm" class="space-y-6">
                        <div class="border-b border-slate-700 pb-6">
                            <h4 class="text-lg font-semibold text-white mb-4">OJT Requirements</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-300 mb-2">Required Hours</label>
                                    <input type="number" name="required_hours" value="600" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-slate-700 pb-6">
                            <h4 class="text-lg font-semibold text-white mb-4">Email Settings</h4>
                            <div class="space-y-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="email_notifications" class="w-4 h-4 rounded bg-slate-700 border-slate-600 text-red-600">
                                    <span class="ml-2 text-gray-300">Enable email notifications</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Save Settings</button>
                            <button type="button" onclick="closeSettingsModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Modal -->
    <div id="reportsModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">Generate and Export System Reports</h3>
                        <button onclick="closeReportsModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-slate-700/50 rounded-lg p-4">
                            <h4 class="text-white font-semibold mb-2">📊 Comprehensive System Report</h4>
                            <p class="text-gray-400 text-sm mb-4">Export all system data including users, students, and progress</p>
                            <button onclick="generateSystemReport()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Export as PDF</button>
                        </div>
                        <div class="bg-slate-700/50 rounded-lg p-4">
                            <h4 class="text-white font-semibold mb-2">📈 Student Progress Report</h4>
                            <p class="text-gray-400 text-sm mb-4">Detailed student progress with hours and completion status</p>
                            <button onclick="generateStudentReport()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Export as CSV</button>
                        </div>
                        <div class="bg-slate-700/50 rounded-lg p-4">
                            <h4 class="text-white font-semibold mb-2">📋 Attendance Report</h4>
                            <p class="text-gray-400 text-sm mb-4">System-wide attendance and time-in records</p>
                            <button onclick="generateAttendanceReport()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Export as Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- School ID Modal -->
    <div id="schoolIdModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">Manage Student School IDs</h3>
                        <button onclick="closeSchoolIdModal()" class="text-gray-400 hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Only students with an approved School ID (e.g. <span class="text-red-300 font-mono">23-1-2-0001</span>) can register.</p>
                    <div class="flex gap-2 mb-2">
                        <input id="newSchoolIdInput" type="text" placeholder="e.g. 23-1-2-0001"
                            class="flex-1 px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm font-mono">
                        <button onclick="addSchoolId()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Add</button>
                    </div>
                    <p id="sidError" class="text-red-400 text-xs mb-3 hidden"></p>
                    <div id="schoolIdList" class="space-y-2 max-h-72 overflow-y-auto">
                        <p class="text-gray-400 text-sm text-center py-4">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pixel Loader Overlay -->
    <div id="pixelLoader" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80">
        <div class="bg-slate-900 border-4 border-slate-600 rounded-2xl px-10 py-8 flex flex-col items-center gap-5" style="box-shadow:0 0 40px rgba(74,222,128,0.3)">
            <div class="pixel-bar-wrap" id="pixelBarCells"></div>
            <div class="text-green-400 text-sm tracking-widest" id="pixelLoaderLabel">LOADING<span id="pixelDots"></span></div>
        </div>
    </div>

    <!-- Pixel Success Overlay -->
    <div id="pixelSuccess" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80">
        <div class="bg-slate-900 border-4 border-green-500 rounded-2xl px-12 py-8 flex flex-col items-center gap-4" style="box-shadow:0 0 40px rgba(74,222,128,0.4)">
            <div class="pixel-check">✅</div>
            <div class="pixel-success-text text-green-400 text-sm tracking-widest text-center" id="pixelSuccessMsg">SUCCESS!</div>
        </div>
    </div>

    <!-- Edit School ID Modal -->
    <div id="editSchoolIdModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 w-full max-w-sm shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-white">Edit School ID</h3>
                <button onclick="closeEditSchoolIdModal()" class="text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <form id="editSchoolIdForm" class="space-y-4">
                <input type="hidden" id="editSidId">
                <div>
                    <label class="block text-gray-300 text-sm mb-1">School ID Number</label>
                    <input type="text" id="editSidNumber" class="w-full px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 font-mono text-sm" placeholder="e.g. 23-1-2-0001">
                    <p id="editSidError" class="text-red-400 text-xs mt-1 hidden"></p>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm mb-1">School Year</label>
                    <select id="editSidYear" class="w-full px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm">
                        <option value="">No School Year</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all">Save</button>
                    <button type="button" onclick="closeEditSchoolIdModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let allUsers = [];
        let editingUserId = null;
        let currentSchoolYear = '';

        // ── School Year selector in nav ──────────────────────────────────
        function loadSchoolYearSelector() {
            fetch('/api/school-years')
                .then(r => r.json())
                .then(data => {
                    const sel = document.getElementById('globalSchoolYear');
                    sel.innerHTML = '<option value="">All Years</option>';
                    (data.school_years || []).forEach(sy => {
                        const opt = document.createElement('option');
                        opt.value = sy.label;
                        opt.textContent = sy.label + (sy.is_active ? ' ★' : '');
                        if (sy.is_active && !currentSchoolYear) {
                            opt.selected = true;
                            currentSchoolYear = sy.label;
                        }
                        sel.appendChild(opt);
                    });
                    if (currentSchoolYear) sel.value = currentSchoolYear;
                    // reload active section data now that SY is known
                    const active = document.querySelector('.dash-section:not(.hidden)');
                    if (active?.id === 'section-users') loadUsers();
                    if (active?.id === 'section-analytics') loadAnalytics();
                    if (active?.id === 'section-schoolids') loadSchoolIdList();
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            loadSchoolYearSelector();
            document.getElementById('globalSchoolYear').addEventListener('change', function () {
                currentSchoolYear = this.value;
                refreshDashboardStats();
                // reload whichever section is currently visible
                const active = document.querySelector('.dash-section:not(.hidden)');
                if (active?.id === 'section-schoolids') loadSchoolIdList();
                if (active?.id === 'section-users') loadUsers();
                if (active?.id === 'section-analytics') loadAnalytics();
                const label = this.options[this.selectedIndex].text;
                showToast('School Year Switched', 'Now viewing: ' + (currentSchoolYear ? label : 'All Years'), 'blue');
            });
        });

        function openUserModal() {
            document.getElementById('userModal').classList.remove('hidden');
            loadUsers();
        }

        
        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }
        
        function showAddUserForm(user = null) {
            // if user object is passed, we're editing
            editingUserId = user ? user.id : null;
            const title = document.querySelector('#addUserModal h3');
            const submitBtn = document.querySelector('#addUserForm button[type="submit"]');
            const pwd = document.querySelector('input[name="password"]');
            const pwdConf = document.querySelector('input[name="password_confirmation"]');
            const roleSelect = document.querySelector('select[name="role"]');
            const companySelect = document.querySelector('select[name="company_id"]');

            if (editingUserId) {
                title.textContent = 'Edit User';
                submitBtn.textContent = 'Save Changes';
                // make password optional when editing
                if (pwd) pwd.removeAttribute('required');
                if (pwdConf) pwdConf.removeAttribute('required');
            } else {
                title.textContent = 'Add New User';
                submitBtn.textContent = 'Add User';
                if (pwd) pwd.setAttribute('required', '');
                if (pwdConf) pwdConf.setAttribute('required', '');
            }

            // populate fields when editing
            if (user) {
                const form = document.getElementById('addUserForm');
                form.name.value = user.name;
                form.email.value = user.email;
                form.role.value = user.role;
                form.company_id.value = user.company_id || '';
                // leave password blank to keep existing password
                form.password.value = '';
                form.password_confirmation.value = '';
            } else {
                document.getElementById('addUserForm').reset();
            }

            // show/hide & require company based on role
            function updateCompanyField() {
                const needsCompany = roleSelect.value === 'student' || roleSelect.value === 'supervisor';
                const field = document.getElementById('companyField');
                if (field) field.classList.toggle('hidden', !needsCompany);
                if (needsCompany) {
                    companySelect?.setAttribute('required', '');
                } else {
                    companySelect?.removeAttribute('required');
                    if (companySelect) companySelect.value = '';
                }
            }
            updateCompanyField();
            roleSelect?.addEventListener('change', updateCompanyField);

            loadCompanies().then(() => {
                if (editingUserId && user) {
                    if (user.company_id) document.querySelector('select[name="company_id"]').value = user.company_id;
                    if (user.school_year) document.querySelector('select[name="school_year"]').value = user.school_year;
                }
                document.getElementById('addUserModal').classList.remove('hidden');
            });
        }

        function loadCompanies() {
            const syFetch = fetch('/api/school-years').then(r => r.json()).then(data => {
                const sel = document.querySelector('select[name="school_year"]');
                if (sel) {
                    sel.innerHTML = '<option value="">Select School Year</option>';
                    (data.school_years || []).forEach(sy => {
                        sel.innerHTML += `<option value="${sy.label}">${sy.label}${sy.is_active ? ' ★' : ''}</option>`;
                    });
                    if (currentSchoolYear) sel.value = currentSchoolYear;
                }
            });
            const coFetch = fetch('/api/companies')
                .then(response => response.json())
                .then(data => {
                    const select = document.querySelector('select[name="company_id"]');
                    select.innerHTML = '<option value="">Select Company</option>';
                    if (data.companies && data.companies.length > 0) {
                        data.companies.forEach(company => {
                            select.innerHTML += `<option value="${company.id}">${company.name}</option>`;
                        });
                    }
                })
                .catch(error => console.error('Error loading companies:', error));
            return Promise.all([coFetch, syFetch]);
        }
        
        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
            editingUserId = null; // reset
            const form = document.getElementById('addUserForm');
            if (form) form.reset();
            // restore default title/button
            const title = document.querySelector('#addUserModal h3');
            const submitBtn = document.querySelector('#addUserForm button[type="submit"]');
            if (title) title.textContent = 'Add New User';
            if (submitBtn) submitBtn.textContent = 'Add User';
        }

        
        function openSchoolYearModal() {
            document.getElementById('schoolYearModal').classList.remove('hidden');
            loadSchoolYearList();
        }

        function closeSchoolYearModal() {
            document.getElementById('schoolYearModal').classList.add('hidden');
        }

        function loadSchoolYearList() {
            fetch('/api/school-years')
                .then(r => r.json())
                .then(data => {
                    const list = document.getElementById('schoolYearList');
                    const years = data.school_years || [];
                    if (!years.length) {
                        list.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">No school years added yet.</p>';
                        return;
                    }
                    list.innerHTML = years.map(sy => `
                        <div class="flex items-center justify-between bg-slate-700/50 rounded-lg px-4 py-3">
                            <div>
                                <span class="text-white font-semibold">${sy.label}</span>
                                ${sy.is_active ? '<span class="ml-2 px-2 py-0.5 bg-green-600/30 text-green-300 text-xs rounded-full">Active</span>' : ''}
                            </div>
                            <div class="flex gap-2">
                                ${!sy.is_active ? `<button onclick="activateSchoolYear(${sy.id})" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Set Active</button>` : ''}
                                <button onclick="deleteSchoolYear(${sy.id})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Remove</button>
                            </div>
                        </div>
                    `).join('');
                });
        }

        function addSchoolYear() {
            const input = document.getElementById('newSchoolYearInput');
            const errEl = document.getElementById('syError');
            const label = input.value.trim();
            if (!/^\d{4}-\d{4}$/.test(label)) {
                errEl.textContent = 'Format must be YYYY-YYYY (e.g. 2025-2026)';
                errEl.classList.remove('hidden');
                return;
            }
            errEl.classList.add('hidden');
            pixelAction('SAVING', () =>
                fetch('/api/school-years', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ label })
                }).then(r => r.json()).then(data => {
                    if (data.success) { input.value = ''; loadSchoolYearList(); loadSchoolYearSelector(); }
                    else { errEl.textContent = data.message || 'Failed to add school year'; errEl.classList.remove('hidden'); }
                })
            , 'SCHOOL YEAR ADDED!');
        }

        function activateSchoolYear(id) {
            pixelAction('ACTIVATING', () =>
                fetch(`/api/school-years/${id}/activate`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(r => r.json()).then(data => {
                    if (data.success) { loadSchoolYearList(); loadSchoolYearSelector(); }
                })
            , 'SET AS ACTIVE!');
        }

        function deleteSchoolYear(id) {
            if (!confirm('Remove this school year?')) return;
            pixelAction('DELETING', () =>
                fetch(`/api/school-years/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(r => r.json()).then(data => {
                    if (data.success) { loadSchoolYearList(); loadSchoolYearSelector(); }
                })
            , 'SCHOOL YEAR REMOVED!');
        }

        function openAnalyticsModal() {
            document.getElementById('analyticsModal').classList.remove('hidden');
            loadAnalytics();
        }
        
        function closeAnalyticsModal() {
            document.getElementById('analyticsModal').classList.add('hidden');
        }
        
        function openSettingsModal() {
            // load current settings before showing
            fetch('/api/settings')
                .then(resp => resp.json())
                .then(json => {
                    const form = document.getElementById('settingsForm');
                    if (form) {
                        form.required_hours.value = json.required_hours || '';
                        form.email_notifications.checked = !!json.email_notifications;
                    }
                })
                .catch(err => console.error('failed to load settings', err))
                .finally(() => {
                    document.getElementById('settingsModal').classList.remove('hidden');
                });
        }
        
        function closeSettingsModal() {
            document.getElementById('settingsModal').classList.add('hidden');
        }
        
        function openReportsModal() {
            document.getElementById('reportsModal').classList.remove('hidden');
        }
        
        function closeReportsModal() {
            document.getElementById('reportsModal').classList.add('hidden');
        }

        function renderUsers(users) {
            const tableBody = document.getElementById('userTable');
            const mobileContainer = document.getElementById('userTableMobile');
            tableBody.innerHTML = '';
            if (mobileContainer) mobileContainer.innerHTML = '';
            // show/hide approve all button
            const pendingCount = users.filter(u => !u.is_approved && u.role !== 'student').length;
            const approveAllBtn = document.getElementById('approveAllBtn');
            if (approveAllBtn) {
                approveAllBtn.classList.toggle('hidden', pendingCount === 0);
                approveAllBtn.textContent = `✓ Approve All Pending (${pendingCount})`;
            }
            if (users.length > 0) {
                // sort: pending first
                const sorted = [...users].sort((a, b) => {
                    const aPending = !a.is_approved && a.role !== 'student';
                    const bPending = !b.is_approved && b.role !== 'student';
                    return bPending - aPending;
                });
                sorted.forEach(user => {
                    const isPending = !user.is_approved && user.role !== 'student';
                    const statusBadge = isPending
                        ? '<span class="px-2 py-0.5 bg-yellow-600/30 text-yellow-300 text-xs rounded-full font-semibold">⏳ Pending</span>'
                        : '<span class="px-2 py-0.5 bg-green-600/30 text-green-300 text-xs rounded-full">✓ Approved</span>';
                    const actions = isPending
                        ? `<div class="flex gap-1">
                               <button onclick="approveUser(${user.id})" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold">Approve</button>
                               <button onclick="denyUser(${user.id}, '${user.name}')" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Deny</button>
                           </div>`
                        : `<div class="flex gap-1">
                               <button onclick="editUser(${user.id})" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">Edit</button>
                               <button onclick="removeUser(${user.id})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Remove</button>
                           </div>`;
                    // Desktop table row
                    tableBody.innerHTML += `
                        <tr class="${isPending ? 'bg-yellow-900/10 border-l-2 border-yellow-500/50' : 'bg-slate-800/50'} hover:bg-slate-700/50">
                            <td class="px-4 py-2 font-medium">${user.name}</td>
                            <td class="px-4 py-2 text-gray-300">${user.email}</td>
                            <td class="px-4 py-2"><span class="px-2 py-1 bg-red-900 text-red-200 rounded text-xs">${user.role}</span></td>
                            <td class="px-4 py-2 font-mono text-xs">${user.school_id_number || '<span class="text-gray-500">—</span>'}</td>
                            <td class="px-4 py-2">${user.company || '<span class="text-gray-500">—</span>'}</td>
                            <td class="px-4 py-2">${user.school_year || '<span class="text-gray-500">—</span>'}</td>
                            <td class="px-4 py-2">${statusBadge}</td>
                            <td class="px-4 py-2">${actions}</td>
                        </tr>
                    `;
                    // Mobile card
                    if (mobileContainer) {
                        const mobileActions = isPending
                            ? `<div class="grid grid-cols-2 gap-2 mt-3">
                                   <button onclick="approveUser(${user.id})" class="py-2 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold">Approve</button>
                                   <button onclick="denyUser(${user.id}, '${user.name}')" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Deny</button>
                               </div>`
                            : `<div class="grid grid-cols-2 gap-2 mt-3">
                                   <button onclick="editUser(${user.id})" class="py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Edit</button>
                                   <button onclick="removeUser(${user.id})" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Remove</button>
                               </div>`;
                        mobileContainer.innerHTML += `
                            <div class="${isPending ? 'border-l-2 border-yellow-500/50 bg-yellow-900/10' : 'bg-slate-700/30'} rounded-xl p-4 mb-3 border border-slate-700">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="min-w-0">
                                        <p class="text-white font-semibold">${user.name}</p>
                                        <p class="text-gray-400 text-xs truncate">${user.email}</p>
                                    </div>
                                    ${statusBadge}
                                </div>
                                <div class="flex flex-wrap gap-2 text-xs text-gray-400">
                                    <span class="px-2 py-0.5 bg-red-900 text-red-200 rounded">${user.role}</span>
                                    ${user.company ? `<span>${user.company}</span>` : ''}
                                    ${user.school_year ? `<span>${user.school_year}</span>` : ''}
                                </div>
                                ${mobileActions}
                            </div>
                        `;
                    }
                });
            } else {
                tableBody.innerHTML = '<tr class="bg-slate-800/50"><td colspan="8" class="px-4 py-4 text-center text-gray-400">No users found</td></tr>';
                if (mobileContainer) mobileContainer.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">No users found</p>';
            }
        }

        function loadUsers() {
            const sy = currentSchoolYear;
            const url = sy ? `/api/users?school_year=${encodeURIComponent(sy)}` : '/api/users';
            return fetch(url)
                .then(response => response.json())
                .then(data => {
                    allUsers = data.users || [];
                    applyFilters();
                });
        }

        function applyFilters() {
            const term = (document.getElementById('userSearch')?.value || '').toLowerCase();
            const role = document.getElementById('roleFilter')?.value || '';
            const approval = document.getElementById('approvalFilter')?.value || '';
            const filtered = allUsers.filter(u => {
                const matchesRole = !role || u.role === role;
                const matchesSearch = !term || u.name.toLowerCase().includes(term) || u.email.toLowerCase().includes(term);
                const matchesApproval = !approval
                    || (approval === 'pending' && !u.is_approved && u.role !== 'student')
                    || (approval === 'approved' && (u.is_approved || u.role === 'student'));
                return matchesRole && matchesSearch && matchesApproval;
            });
            renderUsers(filtered);
        }

        // ── Pixel Loader ─────────────────────────────────────────────
        const TOTAL_CELLS = 8;
        let _loaderInterval = null;
        function showPixelLoader(label = 'LOADING') {
            const wrap = document.getElementById('pixelBarCells');
            document.getElementById('pixelLoaderLabel').firstChild.textContent = label;
            wrap.innerHTML = '';
            for (let i = 0; i < TOTAL_CELLS; i++) {
                const d = document.createElement('div');
                d.className = 'pixel-cell empty' + (i===0?' cap-l':'') + (i===TOTAL_CELLS-1?' cap-r':'');
                wrap.appendChild(d);
            }
            document.getElementById('pixelLoader').classList.remove('hidden');
            let filled = 0;
            _loaderInterval = setInterval(() => {
                const cells = wrap.querySelectorAll('.pixel-cell');
                if (filled < TOTAL_CELLS) {
                    cells[filled].classList.replace('empty','filled');
                    filled++;
                } else {
                    // reset
                    cells.forEach(c => c.classList.replace('filled','empty'));
                    filled = 0;
                }
            }, 120);
        }
        function hidePixelLoader() {
            clearInterval(_loaderInterval);
            document.getElementById('pixelLoader').classList.add('hidden');
        }
        function showPixelSuccess(msg = 'SUCCESS!', duration = 1400) {
            const el = document.getElementById('pixelSuccess');
            document.getElementById('pixelSuccessMsg').textContent = msg;
            // reset animations
            const check = el.querySelector('.pixel-check');
            const txt = el.querySelector('.pixel-success-text');
            check.style.animation = 'none'; txt.style.animation = 'none';
            el.classList.remove('hidden');
            requestAnimationFrame(() => {
                check.style.animation = ''; txt.style.animation = '';
            });
            setTimeout(() => el.classList.add('hidden'), duration);
        }
        function pixelAction(label, action, successMsg) {
            showPixelLoader(label);
            return action().finally(() => {
                hidePixelLoader();
                showPixelSuccess(successMsg);
            });
        }

        function approveUser(id) {
            pixelAction('APPROVING', () =>
                fetch(`/api/users/${id}/approve`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(r => r.json()).then(data => { if (data.success) loadUsers(); })
            , 'APPROVED!');
        }

        function approveAll() {
            const pending = allUsers.filter(u => !u.is_approved && u.role !== 'student');
            if (!pending.length) return;
            if (!confirm(`Approve all ${pending.length} pending user(s)?`)) return;
            pixelAction('APPROVING', () =>
                Promise.all(pending.map(u =>
                    fetch(`/api/users/${u.id}/approve`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(r => r.json())
                )).then(() => loadUsers())
            , `ALL ${pending.length} APPROVED!`);
        }

        function denyUser(id, name) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[200] flex items-center justify-center bg-black/70 p-4';
            modal.innerHTML = `
                <div class="bg-slate-800 border border-red-500/50 rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                    <div class="text-center mb-4">
                        <div class="text-5xl mb-3">⚠️</div>
                        <h3 class="text-lg font-bold text-white mb-2">Deny & Delete Account?</h3>
                        <p class="text-gray-300 text-sm">Denying <span class="text-white font-semibold">${name}</span> will permanently delete their account.</p>
                        <p class="text-red-400 text-xs font-semibold bg-red-900/30 border border-red-700/40 rounded-lg px-3 py-2 mt-3">⛔ This cannot be undone.</p>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold">Cancel</button>
                        <button id="confirmDenyBtn" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold">Yes, Deny</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('#confirmDenyBtn').addEventListener('click', function () {
                modal.remove();
                pixelAction('DENYING', () =>
                    fetch(`/api/users/${id}/deny`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(r => r.json()).then(data => { if (data.success) loadUsers(); })
                , 'ACCOUNT DENIED!');
            });
        }

        // debounce util
        function debounce(fn, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        // simple client-side search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearch');
            if (searchInput) {
                searchInput.addEventListener('input', () => applyFilters());
            }
        });
        function editUser(userId) {
            const user = allUsers.find(u => u.id === userId);
            if (!user) return;
            showAddUserForm(user);
        }

        function removeUser(userId) {
            if (confirm('Are you sure you want to remove this user?')) {
                pixelAction('DELETING', () =>
                    fetch(`/api/users/${userId}`, {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                    }).then(async response => {
                        if (response.status === 419) { alert('Session expired. Please reload.'); return; }
                        const data = await response.json().catch(()=>({}));
                        if (response.ok) return loadUsers();
                        else alert(data.message || 'Failed to remove user');
                    })
                , 'USER REMOVED!');
            }
        }

        function renderAnalytics(items) {
            const tableBody = document.getElementById('analyticsTable');
            const mobile = document.getElementById('analyticsTableMobile');
            tableBody.innerHTML = '';
            if (mobile) mobile.innerHTML = '';
            if (items.length > 0) {
                items.forEach(item => {
                    const req = item.hours_required || 600;
                    const completed = parseFloat(item.hours_completed) || 0;
                    const progress = req > 0 ? Math.min((completed / req) * 100, 100).toFixed(2) : '0.00';
                    const statusColor = item.status === 'Completed' ? 'bg-green-900 text-green-200' : 'bg-blue-900 text-blue-200';
                    tableBody.innerHTML += `
                        <tr class="bg-slate-800/50 hover:bg-slate-700/50">
                            <td class="px-4 py-2">${item.student_name}</td>
                            <td class="px-4 py-2">${completed.toFixed(4)}/${req}</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-slate-700 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width:${progress}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-300">${progress}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs ${statusColor}">${item.status}</span></td>
                            <td class="px-4 py-2"><button onclick="viewStudentReport(${item.student_id})" class="text-blue-400 hover:text-blue-300 text-sm">View DTR</button></td>
                        </tr>
                    `;
                    if (mobile) {
                        mobile.innerHTML += `
                            <div class="bg-slate-700/30 rounded-xl p-4 mb-3 border border-slate-700">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-white font-semibold">${item.student_name}</p>
                                    <span class="px-2 py-0.5 rounded text-xs ${statusColor}">${item.status}</span>
                                </div>
                                <div class="mb-2">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>${completed.toFixed(2)} / ${req} hrs</span>
                                        <span>${progress}%</span>
                                    </div>
                                    <div class="w-full bg-slate-700 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width:${progress}%"></div>
                                    </div>
                                </div>
                                <button onclick="viewStudentReport(${item.student_id})" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">View DTR</button>
                            </div>
                        `;
                    }
                });
            } else {
                tableBody.innerHTML = '<tr class="bg-slate-800/50"><td colspan="5" class="px-4 py-4 text-center text-gray-400">No analytics data available</td></tr>';
                if (mobile) mobile.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">No analytics data available</p>';
            }
        }
        function loadAnalytics() {
            const sy = currentSchoolYear;
            const url = sy ? `/api/analytics?school_year=${encodeURIComponent(sy)}` : '/api/analytics';
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    analyticsData = data.analytics || [];
                    const studentSelect = document.getElementById('analyticsStudentSelect');
                    if (data.students) {
                        studentSelect.innerHTML = '<option value="">Choose a student...</option>';
                        data.students.forEach(student => {
                            studentSelect.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                        });
                    }
                    renderAnalytics(analyticsData);
                    studentSelect.onchange = function() {
                        const id = this.value;
                        renderAnalytics(id ? analyticsData.filter(a => a.student_id == id) : analyticsData);
                    };
                });
        }


        function generateSystemReport() { exportReport('system','pdf'); }
        function generateStudentReport() { exportReport('students','pdf'); }
        function generateAttendanceReport() { exportReport('attendance','pdf'); }

        async function exportReport(type, format) {
            const sy = currentSchoolYear || 'All Years';
            const date = new Date().toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' });

            /* ── fetch data ── */
            let rows = [], columns = [], title = '', subtitle = '';
            if (type === 'system') {
                title = 'OJT Monitoring System — System Report';
                subtitle = 'All registered users and their roles';
                const res = await fetch(currentSchoolYear ? `/api/users?school_year=${encodeURIComponent(currentSchoolYear)}` : '/api/users').then(r=>r.json());
                columns = ['Name','Email','Role','Company','School Year'];
                rows = (res.users||[]).map(u=>[u.name, u.email, u.role, u.company||'—', u.school_year||'—']);
            } else if (type === 'students') {
                title = 'OJT Monitoring System — Student Progress Report';
                subtitle = 'OJT hours completed and status per student';
                const res = await fetch(currentSchoolYear ? `/api/analytics?school_year=${encodeURIComponent(currentSchoolYear)}` : '/api/analytics').then(r=>r.json());
                columns = ['Student','Hours Completed','Required','Progress %','Status'];
                rows = (res.analytics||[]).map(a=>{
                    const req = a.hours_required||600;
                    const done = parseFloat(a.hours_completed)||0;
                    const pct = req>0 ? Math.min((done/req)*100,100).toFixed(1)+'%' : '0%';
                    return [a.student_name, done.toFixed(2), req, pct, a.status];
                });
            } else {
                title = 'OJT Monitoring System — Attendance Report';
                subtitle = 'System-wide time-in/out records';
                const res = await fetch('/api/reports/attendance-data').then(r=>r.json()).catch(()=>({records:[]}));
                columns = ['Student','Date','Time In','Time Out','Hours'];
                rows = (res.records||[]).map(r=>[r.student_name, r.date, r.time_in||'—', r.time_out||'—', r.hours||'—']);
            }

            if (format === 'pdf') {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
                const W = doc.internal.pageSize.getWidth();

                /* header bar */
                doc.setFillColor(185,28,28);
                doc.rect(0,0,W,28,'F');
                doc.setTextColor(255,255,255);
                doc.setFontSize(16); doc.setFont('helvetica','bold');
                doc.text('OJT Monitoring System', 14, 12);
                doc.setFontSize(10); doc.setFont('helvetica','normal');
                doc.text('CCIT Head Dashboard', 14, 20);
                doc.text(date, W-14, 20, {align:'right'});

                /* title block */
                doc.setTextColor(30,30,30);
                doc.setFontSize(14); doc.setFont('helvetica','bold');
                doc.text(title.replace('OJT Monitoring System — ',''), 14, 40);
                doc.setFontSize(9); doc.setFont('helvetica','normal');
                doc.setTextColor(100,100,100);
                doc.text(subtitle, 14, 47);
                doc.text('School Year: ' + sy, 14, 53);

                /* table */
                doc.autoTable({
                    startY: 60,
                    head: [columns],
                    body: rows.length ? rows : [Array(columns.length).fill('No data available')],
                    headStyles: { fillColor:[185,28,28], textColor:255, fontStyle:'bold', fontSize:9 },
                    bodyStyles: { fontSize:8, textColor:[30,30,30] },
                    alternateRowStyles: { fillColor:[248,248,248] },
                    styles: { cellPadding:3, lineColor:[220,220,220], lineWidth:0.2 },
                    margin: { left:14, right:14 },
                    didDrawPage: (d) => {
                        /* footer */
                        const pg = doc.internal.getCurrentPageInfo().pageNumber;
                        const total = doc.internal.getNumberOfPages();
                        doc.setFontSize(8); doc.setTextColor(150,150,150);
                        doc.text(`Page ${pg} of ${total}`, W/2, doc.internal.pageSize.getHeight()-8, {align:'center'});
                        doc.text('Generated by OJT Monitoring System', 14, doc.internal.pageSize.getHeight()-8);
                    }
                });

                doc.save(`${type}-report-${new Date().toISOString().slice(0,10)}.pdf`);
                showDownloadNotification(type);

            }
        }

        function showDownloadNotification(type) {
            const labels = { system:'System Report', students:'Student Progress Report', attendance:'Attendance Report' };
            showToast('Download Successful!', (labels[type]||type) + ' saved as PDF', 'green');
        }

        function showToast(title, message, color) {
            const colors = {
                green: 'linear-gradient(135deg,#16a34a,#15803d)',
                red:   'linear-gradient(135deg,#dc2626,#b91c1c)',
                blue:  'linear-gradient(135deg,#2563eb,#1d4ed8)'
            };
            const n = document.createElement('div');
            n.className = 'fixed bottom-6 right-6 z-[200] flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white text-sm font-medium';
            n.style.cssText = `background:${colors[color]||colors.green};border:1px solid rgba(255,255,255,0.2);animation:slideInRight .3s ease`;
            n.innerHTML = `
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div><div class="font-semibold">${title}</div><div class="text-xs opacity-80">${message}</div></div>
                <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100 text-lg leading-none">&times;</button>
            `;
            document.body.appendChild(n);
            setTimeout(() => { n.style.animation='slideOutRight .3s ease forwards'; setTimeout(()=>n.remove(), 300); }, 4000);
        }

        // ── School ID Management ─────────────────────────────────────────
        function openSchoolIdModal() {
            document.getElementById('schoolIdModal').classList.remove('hidden');
            loadSchoolIdList();
        }
        function closeSchoolIdModal() {
            document.getElementById('schoolIdModal').classList.add('hidden');
        }
        function loadSchoolIdList() {
            const sy = currentSchoolYear;
            const url = sy ? `/api/school-ids?school_year=${encodeURIComponent(sy)}` : '/api/school-ids';
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    const list = document.getElementById('schoolIdList');
                    const ids = data.school_ids || [];
                    if (!ids.length) {
                        list.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">No school IDs found.</p>';
                        return;
                    }
                    list.innerHTML = `
                        <div class="hidden md:block">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs text-gray-400 bg-slate-700/50">
                                <tr>
                                    <th class="px-4 py-2">School ID</th>
                                    <th class="px-4 py-2">School Year</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Added</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                ${ids.map(sid => `
                                <tr class="bg-slate-800/50 hover:bg-slate-700/50">
                                    <td class="px-4 py-2 font-mono font-semibold text-white">${sid.school_id_number}</td>
                                    <td class="px-4 py-2">${sid.school_year || '<span class="text-gray-500">—</span>'}</td>
                                    <td class="px-4 py-2">${sid.is_used
                                        ? '<span class="px-2 py-0.5 bg-green-600/30 text-green-300 text-xs rounded-full">Used</span>'
                                        : '<span class="px-2 py-0.5 bg-yellow-600/30 text-yellow-300 text-xs rounded-full">Available</span>'}</td>
                                    <td class="px-4 py-2 text-gray-400 text-xs">${sid.created_at ? new Date(sid.created_at).toLocaleDateString() : '—'}</td>
                                    <td class="px-4 py-2"><div class="flex gap-1">
                                            <button onclick="editSchoolId(${sid.id}, '${sid.school_id_number}', '${sid.school_year || ''}')" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">Edit</button>
                                            <button onclick="deleteSchoolId(${sid.id})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                                          </div></td>
                                </tr>`).join('')}
                            </tbody>
                        </table>
                        </div>
                        <div class="md:hidden space-y-3">
                            ${ids.map(sid => `
                            <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-700">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="font-mono font-semibold text-white">${sid.school_id_number}</p>
                                    ${sid.is_used
                                        ? '<span class="px-2 py-0.5 bg-green-600/30 text-green-300 text-xs rounded-full">Used</span>'
                                        : '<span class="px-2 py-0.5 bg-yellow-600/30 text-yellow-300 text-xs rounded-full">Available</span>'}
                                </div>
                                <div class="flex gap-2 text-xs text-gray-400 mb-3">
                                    ${sid.school_year ? `<span>${sid.school_year}</span>` : ''}
                                    ${sid.created_at ? `<span>Added: ${new Date(sid.created_at).toLocaleDateString()}</span>` : ''}
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="editSchoolId(${sid.id}, '${sid.school_id_number}', '${sid.school_year || ''}')" class="py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Edit</button>
                                    <button onclick="deleteSchoolId(${sid.id})" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Delete</button>
                                </div>
                            </div>`).join('')}
                        </div>
                    `;
                });
        }
        function addSchoolId() {
            const input = document.getElementById('newSchoolIdInput');
            const errEl = document.getElementById('sidError');
            const val = input.value.trim();
            if (!/^\d{2}-\d{1}-\d{1}-\d{4}$/.test(val)) {
                errEl.textContent = 'Format must be YY-N-N-NNNN (e.g. 23-1-2-0001)';
                errEl.classList.remove('hidden');
                return;
            }
            errEl.classList.add('hidden');
            pixelAction('SAVING', () =>
                fetch('/api/school-ids', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ school_id_number: val, school_year: currentSchoolYear || null })
                }).then(r => r.json()).then(data => {
                    if (data.success) { input.value = ''; loadSchoolIdList(); }
                    else { errEl.textContent = data.message || 'Failed to add School ID'; errEl.classList.remove('hidden'); }
                })
            , 'SCHOOL ID ADDED!');
        }
        function deleteSchoolId(id) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[200] flex items-center justify-center bg-black/70 p-4';
            modal.innerHTML = `
                <div class="bg-slate-800 border border-red-500/50 rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                    <div class="text-center mb-4">
                        <div class="text-5xl mb-3">⚠️</div>
                        <h3 class="text-lg font-bold text-white mb-2">Danger: Permanent Action</h3>
                        <p class="text-gray-300 text-sm mb-2">Deleting this School ID will <span class="text-red-400 font-semibold">also permanently delete the student account</span> that used it.</p>
                        <p class="text-red-400 text-xs font-semibold bg-red-900/30 border border-red-700/40 rounded-lg px-3 py-2 mt-3">⛔ This action cannot be undone.</p>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                        <button id="confirmDeleteSidBtn" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">Yes, Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('#confirmDeleteSidBtn').addEventListener('click', function () {
                modal.remove();
                pixelAction('DELETING', () =>
                    fetch(`/api/school-ids/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(r => r.json()).then(data => { if (data.success) loadSchoolIdList(); })
                , 'SCHOOL ID DELETED!');
            });
        }

        function editSchoolId(id, number, schoolYear) {
            document.getElementById('editSidId').value = id;
            document.getElementById('editSidNumber').value = number;
            // populate school year options
            fetch('/api/school-years').then(r => r.json()).then(data => {
                const sel = document.getElementById('editSidYear');
                sel.innerHTML = '<option value="">No School Year</option>';
                (data.school_years || []).forEach(sy => {
                    sel.innerHTML += `<option value="${sy.label}">${sy.label}${sy.is_active ? ' ★' : ''}</option>`;
                });
                sel.value = schoolYear || '';
                document.getElementById('editSchoolIdModal').classList.remove('hidden');
            });
        }

        function closeEditSchoolIdModal() {
            document.getElementById('editSchoolIdModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('editSchoolIdForm')?.addEventListener('submit', function (e) {
                e.preventDefault();
                const id     = document.getElementById('editSidId').value;
                const number = document.getElementById('editSidNumber').value.trim();
                const year   = document.getElementById('editSidYear').value;
                const errEl  = document.getElementById('editSidError');
                if (!/^\d{2}-\d{1}-\d{1}-\d{4}$/.test(number)) {
                    errEl.textContent = 'Format must be YY-N-N-NNNN (e.g. 23-1-2-0001)';
                    errEl.classList.remove('hidden');
                    return;
                }
                errEl.classList.add('hidden');
                pixelAction('SAVING', () =>
                    fetch(`/api/school-ids/${id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: JSON.stringify({ school_id_number: number, school_year: year || null })
                    }).then(r => r.json()).then(data => {
                        if (data.success) { closeEditSchoolIdModal(); loadSchoolIdList(); }
                        else { errEl.textContent = data.message || 'Failed to update.'; errEl.classList.remove('hidden'); }
                    })
                , 'SCHOOL ID UPDATED!');
            });
        });

        function viewStudentReport(studentId) {
            const url = `/generate-dtr/${studentId}`;
            document.getElementById('ccitDtrFrame').src = url;
            document.getElementById('ccitDtrOpenLink').href = url;
            document.getElementById('ccitDtrModal').classList.remove('hidden');
        }
        function closeCcitDtrModal() {
            document.getElementById('ccitDtrModal').classList.add('hidden');
            document.getElementById('ccitDtrFrame').src = '';
        }

        document.getElementById('addUserForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            // simple client-side required checks
            const nameVal = form.name.value.trim();
            const emailVal = form.email.value.trim();
            const roleVal = form.role.value;
            if (!nameVal) { alert('Name is required'); form.name.focus(); return; }
            if (!emailVal) { alert('Email is required'); form.email.focus(); return; }
            if (!roleVal) { alert('Role is required'); form.role.focus(); return; }

            const formData = new FormData(form);

            // ensure essential fields are present (some browsers drop disabled/empty inputs)
            formData.set('name', nameVal);
            formData.set('email', emailVal);
            formData.set('role', roleVal);
            formData.set('company_id', form.company_id.value || '');
            formData.set('school_year', form.school_year.value || '');

            // if editing and password fields left blank, remove them so validation skips
            if (editingUserId) {
                if (!form.password.value) {
                    formData.delete('password');
                    formData.delete('password_confirmation');
                }
                // also if role changed to non-student/supervisor, clear company value
                if (form.role.value !== 'student' && form.role.value !== 'supervisor') {
                    formData.set('company_id', '');
                }
            }

            let url = '/api/users';
            let method = 'POST';
            if (editingUserId) {
                url = `/api/users/${editingUserId}`;
                // PHP/Laravel doesn't parse multipart data on PUT reliably,
                // so we spoof the method instead and send as POST.
                formData.append('_method', 'PUT');
            }

            pixelAction(editingUserId ? 'UPDATING' : 'SAVING', () =>
                fetch(url, {
                    method,
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                }).then(async response => {
                    if (response.status === 419) { alert('Session expired; please reload and try again.'); return; }
                    const data = await response.json().catch(() => ({}));
                    if (response.ok && data.success) {
                        closeAddUserModal(); loadUsers(); form.reset();
                        editingUserId = null;
                    } else {
                        const msg = data.message || `Error (${response.status})`;
                        alert(msg);
                    }
                })
            , editingUserId ? 'USER UPDATED!' : 'USER ADDED!');
        });

        document.getElementById('settingsForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const data = new FormData(form);
            // convert checkbox to boolean-like value (1/0) to satisfy server
            data.set('email_notifications', form.email_notifications.checked ? 1 : 0);

            pixelAction('SAVING', () =>
                fetch('/api/settings', {
                    method: 'POST',
                    body: data,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                }).then(async response => {
                    if (response.status === 419) { alert('Session expired; please reload and try again.'); return; }
                    const json = await response.json().catch(() => ({}));
                    if (response.ok && json.success) {
                        refreshDashboardStats();
                    } else {
                        if (json.errors) {
                            alert(Object.values(json.errors).flat().join('\n'));
                        } else {
                            alert(json.message || 'Failed to save settings');
                        }
                    }
                })
            , 'SETTINGS SAVED!');
        });

        function refreshDashboardStats() {
            const sy = currentSchoolYear;
            const url = sy ? `/api/dashboard-stats?school_year=${encodeURIComponent(sy)}` : '/api/dashboard-stats';
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalUsers').textContent = data.total_users || 0;
                    document.getElementById('totalStudents').textContent = data.total_students || 0;
                    document.getElementById('activePrograms').textContent = data.active_programs || 0;
                    document.getElementById('completionRate').textContent = data.completion_rate || '0%';
                    updateCharts(data);
                });
        }

        let chartCompletion, chartRoles, chartTrend;
        function updateCharts(data) {
            const rate = parseFloat(data.completion_rate) || 0;
            const completed = Math.round(rate);
            const completedCount = data.completed_count || 0;
            const inProgressCount = data.in_progress_count || 0;
            const totalStudents = data.total_students || 0;
            const notStarted = Math.max(0, totalStudents - completedCount - inProgressCount);

            document.getElementById('chartCompletionLabel').textContent = completed + '%';
            const completedLbl = document.getElementById('completedCountLabel');
            const inProgressLbl = document.getElementById('inProgressCountLabel');
            const notStartedLbl = document.getElementById('notStartedCountLabel');
            if (completedLbl) completedLbl.textContent = completedCount + ' completed';
            if (inProgressLbl) inProgressLbl.textContent = inProgressCount + ' in progress';
            if (notStartedLbl) notStartedLbl.textContent = notStarted + ' not started';

            const donutData = {
                datasets: [{
                    data: [completedCount, inProgressCount, notStarted],
                    backgroundColor: ['#ef4444', '#fb923c', '#475569'],
                    borderWidth: 0, hoverOffset: 4
                }]
            };
            if (chartCompletion) { chartCompletion.data = donutData; chartCompletion.update(); }
            else {
                chartCompletion = new Chart(document.getElementById('chartCompletion'), {
                    type: 'doughnut', data: donutData,
                    options: { cutout: '72%', plugins: { legend: { display: false }, tooltip: { enabled: true } }, animation: { duration: 800 } }
                });
            }

            const roles = data.users_by_role || { student: 0, supervisor: 0, coordinator: 0, ccit_head: 0 };
            const barData = {
                labels: ['Students', 'Supervisors', 'Coordinators', 'CCIT Head'],
                datasets: [{ data: [roles.student||0, roles.supervisor||0, roles.coordinator||0, roles.ccit_head||0],
                    backgroundColor: ['rgba(239,68,68,0.7)','rgba(251,146,60,0.7)','rgba(96,165,250,0.7)','rgba(167,139,250,0.7)'],
                    borderRadius: 6, borderSkipped: false }]
            };
            const barOpts = { plugins: { legend: { display: false } }, scales: { x: { ticks: { color:'#94a3b8' }, grid: { display:false } }, y: { ticks: { color:'#94a3b8', stepSize:1 }, grid: { color:'rgba(148,163,184,0.1)' }, beginAtZero:true } }, animation: { duration:800 } };
            if (chartRoles) { chartRoles.data = barData; chartRoles.update(); }
            else { chartRoles = new Chart(document.getElementById('chartRoles'), { type:'bar', data:barData, options:barOpts }); }

            const trend = data.student_trend || [0,0,0,0,0,0];
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const now = new Date().getMonth();
            const labels = Array.from({length:6}, (_,i) => months[(now-5+i+12)%12]);
            const lineData = {
                labels,
                datasets: [{ data: trend, borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', fill:true, tension:0.4, pointBackgroundColor:'#ef4444', pointRadius:4 }]
            };
            const lineOpts = { plugins: { legend: { display:false } }, scales: { x: { ticks:{color:'#94a3b8'}, grid:{display:false} }, y: { ticks:{color:'#94a3b8',stepSize:1}, grid:{color:'rgba(148,163,184,0.1)'}, beginAtZero:true } }, animation:{duration:800} };
            if (chartTrend) { chartTrend.data = lineData; chartTrend.update(); }
            else { chartTrend = new Chart(document.getElementById('chartTrend'), { type:'line', data:lineData, options:lineOpts }); }
        }

        document.addEventListener('DOMContentLoaded', function() {
            refreshDashboardStats();
        });

        function showConfirm(type) {
            const icon = document.getElementById('confirmIcon');
            const title = document.getElementById('confirmTitle');
            const msg = document.getElementById('confirmMsg');
            const btn = document.getElementById('confirmBtn');
            if (type === 'logout') {
                icon.textContent = '🚪'; title.textContent = 'Logout?';
                msg.textContent = 'You will be signed out of your account.';
                btn.textContent = 'Yes, Logout'; btn.href = '/logout';
                btn.className = 'flex-1 px-4 py-2.5 text-center text-white rounded-xl font-semibold transition-all bg-red-600 hover:bg-red-700';
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

        // ── Sidebar JS ───────────────────────────────────────────────
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebarOverlay');
            sb.classList.toggle('mobile-hidden');
            ov.classList.toggle('active');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('mobile-hidden');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
        function toggleSidebarCollapse() {
            const sb = document.getElementById('sidebar');
            const collapsed = sb.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            const mc = document.getElementById('main-content');
            if (mc) mc.style.marginLeft = collapsed ? '4rem' : '16rem';
            const th = document.getElementById('top-header');
            if (th) th.style.left = collapsed ? '4rem' : '16rem';
            localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
        }
        const sectionTitles = {
            overview: 'Overview', users: 'User Management', analytics: 'Analytics',
            schoolyears: 'School Years', schoolids: 'School IDs',
            reports: 'Reports', settings: 'Settings'
        };
        function showSection(name) {
            document.querySelectorAll('.dash-section').forEach(s => s.classList.add('hidden'));
            const target = document.getElementById('section-' + name);
            if (target) target.classList.remove('hidden');
            document.querySelectorAll('.nav-item[data-section]').forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-section') === name);
            });
            const ht = document.getElementById('headerTitle');
            if (ht) ht.textContent = sectionTitles[name] || name;
            localStorage.setItem('ccitSection', name);
            closeSidebar();
            /* load data for section */
            if (name === 'users') loadUsers();
            if (name === 'analytics') loadAnalytics();
            if (name === 'schoolyears') loadSchoolYearList();
            if (name === 'schoolids') {
                loadSchoolIdList();
            }
            if (name === 'settings') {
                fetch('/api/settings').then(r=>r.json()).then(json=>{
                    const form = document.getElementById('settingsForm');
                    if(form){ form.required_hours.value=json.required_hours||''; form.email_notifications.checked=!!json.email_notifications; }
                }).catch(()=>{});
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            /* restore sidebar collapse */
            if (localStorage.getItem('sidebarCollapsed') === '1') {
                document.getElementById('sidebar').classList.add('collapsed');
                document.body.classList.add('sidebar-collapsed');
                const mc = document.getElementById('main-content');
                if (mc) mc.style.marginLeft = '4rem';
                const th = document.getElementById('top-header');
                if (th) th.style.left = '4rem';
            }
            /* restore last section */
            const saved = localStorage.getItem('ccitSection') || 'overview';
            if (saved) showSection(saved);
        });

        // ===== LEAVE PAGE CONFIRMATION =====
        let _allowLeave = true;
        // ===== END LEAVE PAGE CONFIRMATION =====

        // ── Theme toggle ─────────────────────────────────────────────
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
    <!-- DTR Viewer Modal -->
    <div id="ccitDtrModal" class="hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/80 p-4" onclick="if(event.target===this)closeCcitDtrModal()">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col">
            <div class="flex justify-between items-center px-5 py-3 border-b border-slate-700 shrink-0">
                <span class="text-sm font-semibold text-white">DTR Record</span>
                <div class="flex items-center gap-2">
                    <a id="ccitDtrOpenLink" href="#" target="_blank" onclick="document.getElementById('ccitDtrOpenLink').href=document.getElementById('ccitDtrFrame').src" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold">↗ Open Full Page</a>
                    <button onclick="closeCcitDtrModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white">✕</button>
                </div>
            </div>
            <div class="flex-1 overflow-hidden">
                <iframe id="ccitDtrFrame" src="" class="w-full h-full border-0" style="min-height:75vh"></iframe>
            </div>
        </div>
    </div>
    <!-- End DTR Viewer Modal -->

</body>
</html>
