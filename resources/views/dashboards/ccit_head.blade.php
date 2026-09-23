@php
    // ── CCIT Head nav badge counts (computed before sidebar renders) ──────
    // Users badge: non-student accounts awaiting approval
    $_navBadgeUsers = \App\Models\User::where('is_approved', false)
        ->where('role', '!=', 'student')
        ->whereNull('deleted_at')
        ->count();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="current-user-id" content="{{ session('user_id') }}">
    <title>CCIT Head Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/docx@8.5.0/build/index.min.js"></script>
    <style>
        /* LIGHT MODE - Beautiful soft design */
        /* ===== SECTION VISIBILITY CONTROL ===== */
        .dash-section.hidden {
            display: none !important;
        }
        .dash-section:not(.hidden) {
            display: block !important;
        }
        /* ===== END SECTION VISIBILITY ===== */

        body.light { background: #ffffff !important; color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) { background: rgba(255,255,255,0.95) !important; border-color: #fecaca !important; box-shadow: 0 2px 8px rgba(220,38,38,0.08) !important; }
        body.light nav:not(#sidebar nav) span, body.light nav:not(#sidebar nav) a, body.light nav:not(#sidebar nav) p { color: #1e3a5f !important; }
        body.light nav:not(#sidebar nav) a[class*="bg-red"] { color: #fff !important; }
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
        body.light button[class*="bg-purple-6"],
        body.light a[class*="bg-red-6"],body.light a[class*="bg-blue-6"],
        body.light a[class*="bg-indigo-6"],body.light a[class*="bg-green-6"] { color: #fff !important; }
        body.light button[class*="bg-green-6"] span,body.light button[class*="bg-blue-6"] span,
        body.light button[class*="bg-red-6"] span,body.light button[class*="bg-orange-6"] span,
        body.light button[class*="bg-yellow-6"] span,body.light button[class*="bg-indigo-6"] span,
        body.light button[class*="bg-purple-6"] span { color: #fff !important; }
        body.light button.bg-indigo-600,body.light button.bg-indigo-700,
        body.light button.bg-red-600,body.light button.bg-red-700,
        body.light button.bg-red-800,body.light button.bg-red-900,
        body.light button.bg-blue-600,body.light button.bg-blue-700,
        body.light button.bg-green-600,body.light button.bg-green-700,
        body.light button.bg-orange-600,body.light button.bg-orange-700,
        body.light button.bg-purple-600,body.light button.bg-purple-700 { color: #fff !important; }
        body.light [class*="bg-slate-900"] { background: linear-gradient(135deg, #fffafa 0%, #fef2f2 100%) !important; }
        body.light [class*="bg-slate-800"] { background: rgba(255,255,255,0.85) !important; box-shadow: 0 1px 3px rgba(220,38,38,0.08) !important; }
        body.light [class*="bg-slate-700"] { background: rgba(255,250,250,0.9) !important; }
        body.light [class*="bg-slate-6"] { background: #fef2f2 !important; }
        body.light [class*="bg-gray-9"] { background: #fef2f2 !important; }
        body.light [class*="border-slate-7"] { border-color: #fecaca !important; }
        body.light [class*="border-slate-6"] { border-color: #fecaca !important; }
        body.light [class*="divide-slate-7"] > * { border-color: #fecaca !important; }
        body.light .bg-red-900 { background: rgba(254,226,226,0.6) !important; }
        body.light .bg-green-900 { background: rgba(220,252,231,0.6) !important; }
        body.light .bg-blue-900 { background: rgba(224,242,254,0.6) !important; }
        body.light input,body.light textarea,body.light select { background: rgba(255,255,255,0.95) !important; border-color: #fca5a5 !important; color: #1e3a5f !important; box-shadow: 0 1px 2px rgba(220,38,38,0.05) !important; }
        body.light input::placeholder,body.light textarea::placeholder { color: #b87a7a !important; }
        body.light input:focus,body.light textarea:focus,body.light select:focus { border-color: #dc2626 !important; box-shadow: 0 0 0 3px rgba(220,38,38,0.1) !important; }
        /* Header info card in light mode */
        body.light .header-info-card { background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(254,242,242,0.8) 100%) !important; border-color: #fca5a5 !important; border-left: 4px solid #dc2626 !important; box-shadow: 0 4px 12px rgba(220,38,38,0.08) !important; }
        body.light .header-info-card h1 { color: #1e3a5f !important; }
        body.light .header-info-card .subtitle { color: #5a7a9f !important; }
        body.light .header-info-card .stat-label { color: #5a7a9f !important; }
        body.light .header-info-card .stat-value-white { color: #1e3a5f !important; }
        body.light .header-info-card .stat-value-red { color: #dc2626 !important; }
        body.light .header-info-card .divider { background: #fecaca !important; }

        /* SIDEBAR */
        #sidebar { position:fixed; top:0; left:0; height:100%; min-height:100vh; width:16rem; background:#1e3a5f; z-index:40; display:flex; flex-direction:column; transition:width .3s,transform .3s; overflow:hidden; }
        #sidebar.collapsed { width:4rem; }
        #sidebar.mobile-hidden { transform:translateX(-100%); }
        #top-header { position:fixed; top:0; left:0; right:0; height:3.5rem; background:rgba(15,23,42,0.95); backdrop-filter:blur(8px); border-bottom:1px solid rgba(239,68,68,0.3); z-index:30; display:flex; align-items:center; padding:0 1rem; gap:.75rem; }
        @media(min-width:1024px){ #top-header { left:16rem; transition:left .3s; } #sidebar.collapsed ~ * #top-header, body.sidebar-collapsed #top-header { left:4rem; } #sidebar { transform:none !important; } #hamburger { display:none; } }
        #main-content { padding-top:3.5rem; }
        @media(min-width:1024px){ #main-content { margin-left:16rem; transition:margin-left .3s; } body.sidebar-collapsed #main-content { margin-left:4rem; } }
        .nav-item { display:flex; align-items:center; gap:.75rem; padding:.65rem .75rem; border-radius:.5rem; cursor:pointer; transition:background .2s; color:#cbd5e1; white-space:nowrap; border:none; background:none; width:100%; text-align:left; }
        @media(max-width:1023px){ .nav-item { padding:.5rem .75rem; } }
        .nav-item:hover { background:rgba(239,68,68,0.15); color:#fff; }
        .nav-item.active { background:rgba(239,68,68,0.38); color:#f87171; }
        .nav-icon { font-size:1.1rem; flex-shrink:0; width:1.5rem; text-align:center; }
        .nav-label { font-size:.875rem; font-weight:500; }
        @media(max-width:1023px){ .nav-label { font-size:.8rem; } }
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
        /* Search bar light mode */
        body.light #studentDropdownWrapper .flex { background: #fff !important; border-color: #7aaad4 !important; }
        body.light #studentDropdownWrapper .flex:focus-within { border-color: #b91c1c !important; box-shadow: 0 0 0 3px rgba(185,28,28,0.12) !important; }
        body.light #studentSearchInput { color: #1a2a4a !important; }
        body.light #studentSearchInput::placeholder { color: #7a9abf !important; }
        body.light #studentDropdownList { background: #fff !important; border-color: #c0d4ec !important; box-shadow: 0 8px 32px rgba(30,58,138,0.12) !important; }
        body.light #studentDropdownOptions button { color: #1a2a4a !important; }
        body.light #studentDropdownOptions button:hover { background: rgba(185,28,28,0.07) !important; }
        @keyframes slideInRight { from{opacity:0;transform:translateX(60px)} to{opacity:1;transform:translateX(0)} }
        @keyframes slideOutRight { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(60px)} }

        /* MODERN LOADING SYSTEM */
        @keyframes spinGlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.95); }
        }
        @keyframes dotPulse {
            0%, 80%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }
        
        /* PIXEL LOADING - Modernized */
        #pixelLoader { font-family: system-ui, -apple-system, sans-serif; }
        .pixel-bar-wrap { display:flex; gap:6px; align-items:center; }
        .pixel-cell { 
            width:32px; height:32px; 
            border-radius:8px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border:2px solid #334155;
            transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .pixel-cell::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .pixel-cell.filled::before { opacity: 1; }
        .pixel-cell.filled { 
            border-color: #22c55e;
            box-shadow: 0 0 20px rgba(74,222,128,0.4), inset 0 2px 4px rgba(255,255,255,0.2);
        }
        
        @keyframes pixelDots { 
            0%{content:'.'} 
            33%{content:'..'} 
            66%{content:'...'} 
            100%{content:'.'} 
        }
        #pixelDots::after { content:'.'; animation:pixelDots 1.2s steps(1) infinite; }
        
        /* SUCCESS CHECKMARK - Modernized */
        @keyframes popIn { 
            0%{transform:scale(0) rotate(-20deg);opacity:0} 
            70%{transform:scale(1.15) rotate(5deg)} 
            100%{transform:scale(1) rotate(0);opacity:1} 
        }
        @keyframes fadeUp { 
            from{opacity:0;transform:translateY(15px)} 
            to{opacity:1;transform:translateY(0)} 
        }
        @keyframes checkGlow {
            0%, 100% { filter: drop-shadow(0 0 8px rgba(74,222,128,0.6)); }
            50% { filter: drop-shadow(0 0 16px rgba(74,222,128,0.9)); }
        }
        
        .pixel-check { 
            font-size:4rem; 
            animation:popIn .6s cubic-bezier(.36,.07,.19,.97) forwards, checkGlow 2s ease-in-out infinite;
            filter: drop-shadow(0 0 12px rgba(74,222,128,0.7));
        }
        .pixel-success-text { 
            animation:fadeUp .5s .3s ease forwards; 
            opacity:0;
            font-weight: 600;
            letter-spacing: 0.1em;
        }
        
        /* Hide browser native password reveal icons (Edge, IE, Chrome) */
        .hide-pwd-reveal::-ms-reveal,
        .hide-pwd-reveal::-ms-clear { display: none !important; }
        .hide-pwd-reveal::-webkit-credentials-auto-fill-button { display: none !important; }
        .hide-pwd-reveal::-webkit-textfield-decoration-container { display: none !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    @include('partials.dashboard-skeleton')

    @include('partials.success-popup')

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="mobile-hidden">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-4 py-3 border-b border-white/10">
            <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-9 h-9 rounded-lg object-cover shrink-0">
            <div class="min-w-0">
                <div class="sidebar-title text-sm font-bold text-white truncate">OJT Monitoring System</div>
                <div class="sidebar-subtitle text-xs text-red-300 truncate">CCIT Head</div>
            </div>
        </div>
        <!-- Nav -->
        <nav class="flex-1 overflow-hidden px-2 py-2 space-y-0.5 min-h-0">
            <button class="nav-item active" onclick="showSection('overview'); closeSidebar();" data-section="overview">
                <span class="nav-icon">📊</span><span class="nav-label">Overview</span>
            </button>
            <button class="nav-item" onclick="showSection('users'); closeSidebar();" data-section="users">
                <span class="nav-icon">👥</span>
                <span class="nav-label">Users</span>
                @if($_navBadgeUsers > 0)
                    <span class="nav-badge min-w-[1.25rem] h-5 px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold leading-none">{{ $_navBadgeUsers }}</span>
                @endif
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
            <button class="nav-item" onclick="showSection('manage-requirements'); closeSidebar();" data-section="manage-requirements">
                <span class="nav-icon">📋</span><span class="nav-label">Manage Requirements</span>
            </button>
            <button class="nav-item" onclick="showSection('settings'); closeSidebar();" data-section="settings">
                <span class="nav-icon">⚙️</span><span class="nav-label">Settings</span>
            </button>
        </nav>
        <!-- Footer — always visible at bottom -->
        <div class="px-2 py-3 border-t border-white/10 shrink-0">
            <button class="nav-item group text-red-400 hover:text-white hover:bg-gradient-to-r hover:from-red-600 hover:to-red-700 font-semibold shadow-lg hover:shadow-red-500/30 transform hover:scale-[1.02]" onclick="showConfirm('logout')">
                <svg class="nav-icon w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="nav-label">Logout</span>
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
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">👥 User Management</h2>
                        <p class="text-gray-400 text-sm">Manage all students, supervisors, and coordinators</p>
                    </div>
                    <button onclick="openArchivedUsersModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm transition-colors">🗑 Archive Trash</button>
                </div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="mb-4 grid grid-cols-2 sm:flex sm:flex-wrap gap-2">
                    <button onclick="showAddUserForm()" class="col-span-2 sm:col-span-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">+ Add User</button>
                    <button onclick="approveAll()" id="approveAllBtn" class="hidden col-span-2 sm:col-span-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold">✓ Approve All Pending</button>
                    <select id="roleFilter" onchange="applyFilters()" class="px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg text-sm focus:outline-none focus:border-red-500">
                        <option value="">All Roles</option>
                        <option value="ccit_head">CCIT Head</option>
                        <option value="coordinator">Coordinator</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="student">Student</option>
                    </select>
                    <select id="approvalFilter" onchange="applyFilters()" class="px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg text-sm focus:outline-none focus:border-red-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </select>
                    <input type="text" id="userSearch" placeholder="Search users..." oninput="applyFilters()" class="col-span-2 sm:col-span-auto flex-1 min-w-[160px] px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500 text-sm">
                </div>
                <!-- Desktop table -->
                <div class="hidden md:block">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs text-gray-400 bg-slate-700/50 uppercase tracking-wide">
                            <tr>
                                <th class="px-3 py-3">Name</th>
                                <th class="px-3 py-3">Email</th>
                                <th class="px-3 py-3">Role</th>
                                <th class="px-3 py-3">School ID</th>
                                <th class="px-3 py-3">Company</th>
                                <th class="px-3 py-3 whitespace-nowrap">School Year</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTable" class="divide-y divide-slate-700/50">
                            <tr><td colspan="8" class="px-4 py-4 text-center text-gray-400">Loading users...</td></tr>
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
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <!-- Searchable Student Filter -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Select Student</label>
                    <div class="relative" id="studentDropdownWrapper">
                        <div class="flex items-center gap-2 px-4 py-3 bg-slate-700 border-2 border-slate-600 rounded-2xl focus-within:border-red-500 focus-within:bg-slate-700/80 transition-all shadow-inner">
                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                            <input type="text" id="studentSearchInput" placeholder="Search student name…"
                                class="flex-1 bg-transparent text-white text-sm placeholder-slate-400 focus:outline-none font-medium"
                                autocomplete="off"
                                oninput="filterStudentDropdown()"
                                onfocus="openStudentDropdown()">
                            <button type="button" id="clearStudentBtn" onclick="clearStudentFilter()" class="hidden w-5 h-5 rounded-full bg-slate-500 hover:bg-slate-400 text-white flex items-center justify-center text-xs transition-colors shrink-0">✕</button>
                        </div>
                        <div id="studentDropdownList" class="hidden absolute z-30 w-full mt-2 bg-slate-800 border border-slate-600/80 rounded-2xl shadow-2xl max-h-60 overflow-y-auto" style="backdrop-filter:blur(8px)">
                            <div id="studentDropdownOptions"></div>
                        </div>
                    </div>
                    <select id="analyticsStudentSelect" class="hidden"><option value="">All Students</option></select>
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
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">🗓️ School Years</h2>
                    <p class="text-gray-400 text-sm">Manage school years and assign students per batch</p>
                </div>
                <button onclick="openArchivedSchoolYearsModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm transition-colors">🗑 Archive Trash</button>
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
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">🪪 Student School IDs</h2>
                    <p class="text-gray-400 text-sm">Manage approved school ID numbers for student registration</p>
                </div>
                <button onclick="openArchivedSchoolIdsModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm transition-colors">🗑 Archive Trash</button>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <p class="text-gray-400 text-sm mb-4">Only students with an approved School ID (e.g. <span class="text-red-300 font-mono">23-1-2-0001</span>) can register.</p>
                <div class="flex flex-wrap gap-2 mb-2">
                    <input id="newSchoolIdInput" type="text" placeholder="e.g. 23-1-2-0001"
                        class="flex-1 min-w-[160px] px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm font-mono">
                    <button onclick="addSchoolId()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Add</button>
                </div>
                <p id="sidError" class="text-red-400 text-xs mb-3 hidden"></p>
                <details class="mb-4">
                    <summary class="text-sm text-gray-400 hover:text-white cursor-pointer select-none mb-2">📋 Bulk Import (paste multiple IDs)</summary>
                    <div class="mt-3 space-y-2">
                        <textarea id="bulkSchoolIdInput" rows="5"
                            class="w-full px-3 py-2 bg-slate-700 border border-slate-600 text-white rounded-lg focus:outline-none focus:border-red-500 text-sm font-mono resize-y"
                            placeholder="Paste one ID per line, e.g.:&#10;22-1-2-0500&#10;22-1-2-0401"></textarea>
                        <p class="text-gray-500 text-xs">One ID per line. Duplicates and invalid formats are skipped automatically.</p>
                        <p id="bulkSidError" class="text-red-400 text-xs hidden"></p>
                        <button onclick="bulkAddSchoolIds()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold">Import All</button>
                    </div>
                </details>
                <div class="flex items-center gap-2 px-3 py-2 bg-slate-700 border border-slate-600 rounded-lg mb-3 focus-within:border-red-500 transition-colors">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    <input type="text" id="schoolIdSearch" placeholder="Search school IDs…"
                        class="flex-1 bg-transparent text-white text-sm placeholder-gray-400 focus:outline-none font-mono"
                        oninput="filterSchoolIdList(this.value)">
                </div>
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
                            <input type="checkbox" name="email_notifications" id="emailNotifCheck" class="w-4 h-4 rounded bg-slate-700 border-slate-600 text-red-600" checked>
                            <span class="ml-2 text-gray-300">Enable email notifications</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-2 ml-6">When unchecked, no emails will be sent via Gmail for any system events.</p>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">Save Settings</button>
                    </div>
                </form>
            </div>
        </section><!-- /section-settings -->

        <!-- SECTION: Manage Requirements -->
        <section id="section-manage-requirements" class="dash-section hidden">
        <?php
            $reqTemplates = \App\Models\RequirementTemplate::orderBy('category')->orderBy('sort_order')->orderBy('name')->get();
            $archivedTemplates = \App\Models\RequirementTemplate::onlyTrashed()->orderBy('deleted_at','desc')->get();
            $onboardingCount = \App\Models\RequirementTemplate::where('category','onboarding')->count();
            $dailyCount = \App\Models\RequirementTemplate::where('category','daily')->count();
        ?>
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                <h2 class="text-2xl font-bold text-white">Manage Requirements</h2>
                <div class="flex gap-2 flex-wrap">
                    <button onclick="toggleArchivedTemplates()" id="archivedTemplatesBtn" class="px-3 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm transition-colors">🗑 Archive Trash</button>
                    <button onclick="showAddTemplateModal()" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">+ Add Requirement</button>
                </div>
            </div>

            <!-- Onboarding Requirements -->
            <div class="mb-6 bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <h3 class="text-lg font-bold text-white mb-4">📂 Onboarding Requirements</h3>
                @php $onboardingTpls = $reqTemplates->where('category','onboarding'); @endphp
                @if($onboardingTpls->isNotEmpty())
                {{-- Desktop table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Name</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Description</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Max Files</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Order</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onboardingTpls as $tpl)
                            <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 transition-colors">
                                <td class="py-3 px-3 text-gray-200 font-medium">{{ $tpl->name }}</td>
                                <td class="py-3 px-3 text-gray-400 text-sm">{{ $tpl->description ?? '-' }}</td>
                                <td class="py-3 px-3 text-center"><span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-sm">{{ $tpl->max_files }}</span></td>
                                <td class="py-3 px-3 text-center text-gray-400 text-sm">{{ $tpl->sort_order }}</td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="showEditTemplateModal({{ $tpl->id }},'{{ addslashes($tpl->name) }}','{{ $tpl->category }}','{{ addslashes($tpl->description ?? '') }}',{{ $tpl->max_files }},{{ $tpl->sort_order }},{{ $tpl->category === 'onboarding' ? $onboardingCount : $dailyCount }})" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">Edit</button>
                                        <button onclick="showArchiveTemplateModal({{ $tpl->id }},'{{ addslashes($tpl->name) }}')" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Archive</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Mobile card list --}}
                <div class="sm:hidden space-y-3">
                    @foreach($onboardingTpls as $tpl)
                    <div class="bg-slate-700/30 border border-slate-600/50 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <p class="text-gray-200 font-semibold text-sm leading-tight">{{ $tpl->name }}</p>
                            <span class="shrink-0 px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs font-semibold">{{ $tpl->max_files }} file{{ $tpl->max_files != 1 ? 's' : '' }}</span>
                        </div>
                        @if($tpl->description)
                        <p class="text-gray-400 text-xs mb-2">{{ $tpl->description }}</p>
                        @endif
                        <p class="text-gray-500 text-xs mb-3">Order: {{ $tpl->sort_order }}</p>
                        <div class="flex gap-2">
                            <button onclick="showEditTemplateModal({{ $tpl->id }},'{{ addslashes($tpl->name) }}','{{ $tpl->category }}','{{ addslashes($tpl->description ?? '') }}',{{ $tpl->max_files }},{{ $tpl->sort_order }},{{ $tpl->category === 'onboarding' ? $onboardingCount : $dailyCount }})"
                                class="flex-1 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-colors">✏️ Edit</button>
                            <button onclick="showArchiveTemplateModal({{ $tpl->id }},'{{ addslashes($tpl->name) }}')"
                                class="flex-1 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-colors">🗑 Archive</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-6">No onboarding requirements yet.</p>
                @endif
            </div>

            <!-- Daily Requirements — static Daily Narrative, cannot be archived or deleted -->
            <div class="mb-6 bg-slate-800/50 border border-slate-700 rounded-xl p-4 sm:p-6">
                <h3 class="text-lg font-bold text-white mb-1">📋 Daily Submission Requirements</h3>
                <p class="text-gray-400 text-xs mb-4">This section is system-defined and cannot be archived or deleted.</p>
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Name</th>
                                <th class="text-left py-2 px-3 text-gray-300 font-semibold">Description</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Type</th>
                                <th class="text-center py-2 px-3 text-gray-300 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 px-3 text-gray-200 font-medium">Daily Narrative Report</td>
                                <td class="py-3 px-3 text-gray-400 text-sm">Student's daily OJT journal entry with optional photo, auto-numbered per day.</td>
                                <td class="py-3 px-3 text-center"><span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-xs font-semibold">System-Defined</span></td>
                                <td class="py-3 px-3 text-center"><span class="text-gray-500 text-xs italic">Cannot be archived</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- Mobile card --}}
                <div class="sm:hidden">
                    <div class="bg-slate-700/30 border border-slate-600/50 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <p class="text-gray-200 font-semibold text-sm leading-tight">Daily Narrative Report</p>
                            <span class="shrink-0 px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs font-semibold">System-Defined</span>
                        </div>
                        <p class="text-gray-400 text-xs mb-2">Student's daily OJT journal entry with optional photo, auto-numbered per day.</p>
                        <p class="text-gray-500 text-xs italic">Cannot be archived or deleted.</p>
                    </div>
                </div>
            </div>

            <!-- Archive Trash -->
        </div>
        </section><!-- /section-manage-requirements -->

        </div><!-- /max-w-7xl -->
    </div><!-- /main-content -->

    <!-- Archived School Years Modal -->
    <div id="archivedSchoolYearsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg w-full max-w-lg max-h-[80vh] flex flex-col shadow-xl border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🗑</span>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Archived School Years</h3>
                </div>
                <button onclick="closeArchivedSchoolYearsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-light">×</button>
            </div>
            <div class="overflow-auto flex-1 p-6">
                <div id="archivedSchoolYearsList"><p class="text-gray-500 dark:text-gray-400 text-center py-8">Loading...</p></div>
            </div>
        </div>
    </div>

    <!-- Archived School IDs Modal -->
    <div id="archivedSchoolIdsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg w-full max-w-2xl max-h-[80vh] flex flex-col shadow-xl border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🗑</span>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Archived School IDs</h3>
                </div>
                <button onclick="closeArchivedSchoolIdsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-light">×</button>
            </div>
            <div class="overflow-auto flex-1 p-6">
                <div id="archivedSchoolIdsList"><p class="text-gray-500 dark:text-gray-400 text-center py-8">Loading...</p></div>
            </div>
        </div>
    </div>

    <!-- Archived Requirements Modal -->
    <div id="archivedTemplatesModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg w-full max-w-3xl max-h-[85vh] flex flex-col shadow-xl border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🗑</span>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Archived Requirements</h3>
                </div>
                <button onclick="closeArchivedTemplatesModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-light">×</button>
            </div>
            <div class="overflow-auto flex-1 p-6">
                <div id="archivedTemplatesList">
                @if($archivedTemplates->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">No archived requirements.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">Name</th>
                                <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">Category</th>
                                <th class="text-center py-2 px-3 text-gray-500 dark:text-gray-400">Archived On</th>
                                <th class="text-center py-2 px-3 text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($archivedTemplates as $at)
                            <tr class="border-b border-gray-100 dark:border-slate-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/20">
                                <td class="py-3 px-3 text-gray-500 dark:text-gray-400 line-through">{{ $at->name }}</td>
                                <td class="py-3 px-3 text-gray-400 dark:text-gray-500 capitalize">{{ $at->category ?? '—' }}</td>
                                <td class="py-3 px-3 text-center text-gray-400 dark:text-gray-500 text-xs">{{ $at->deleted_at->format('M d, Y') }}</td>
                                <td class="py-3 px-3 text-center">
                                    <form method="POST" action="/requirement-templates/{{ $at->id }}/restore" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded font-semibold">Restore</button>
                                    </form>
                                    <button type="button" onclick="showForceDeleteTemplateModal({{ $at->id }}, '{{ addslashes($at->name) }}')" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded font-semibold ml-1">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
            </div>
        </div>
    </div>
            </div>
    <!-- Add Requirement Template Modal -->
    <div id="addTemplateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-xl max-w-md w-full border border-slate-700">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-xl">
                <h2 class="text-xl font-bold text-white">Add Requirement</h2>
            </div>
            <form action="{{ route('requirement-templates.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name *</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none" placeholder="e.g. Medical Certificate">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                        <option value="onboarding">Onboarding</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none" placeholder="Optional description"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max Files</label>
                        <input type="number" name="max_files" value="1" min="1" max="20" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="" min="1" placeholder="Auto" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAddTemplateModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Requirement Template Modal -->
    <div id="editTemplateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-xl max-w-md w-full border border-slate-700">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-xl">
                <h2 class="text-xl font-bold text-white">Edit Requirement</h2>
            </div>
            <form id="editTemplateForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name *</label>
                    <input type="text" name="name" id="edit_tpl_name" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category" id="edit_tpl_category" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                        <option value="onboarding">Onboarding</option>
                    </select>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="edit_tpl_description" rows="2" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max Files</label>
                        <input type="number" name="max_files" id="edit_tpl_max_files" min="1" max="20" required class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="edit_tpl_sort_order" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-indigo-500 focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Range: 1 to <span id="edit_tpl_max_hint">—</span></p>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEditTemplateModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Archive Requirement Template Modal -->
    <div id="archiveTemplateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-white mb-4">Archive Requirement</h3>
            <p class="text-gray-300 mb-6">Archive <span id="archiveTemplateName" class="text-yellow-400 font-semibold"></span>? It will be hidden from students but can be restored.</p>
            <form id="archiveTemplateForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeArchiveTemplateModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">Archive</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Force Delete Requirement Template Modal -->
    <div id="forceDeleteTemplateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-white mb-4">Permanently Delete Requirement</h3>
            <p class="text-gray-300 mb-6">This will <span class="text-red-400 font-semibold">permanently delete</span> <span id="forceDeleteTemplateName" class="text-red-400 font-semibold"></span>. Cannot be undone.</p>
            <form id="forceDeleteTemplateForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeForceDeleteTemplateModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-800 hover:bg-red-900 text-white rounded-lg font-semibold">Delete Forever</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Generic Confirm Modal -->
    <div id="genericConfirmModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-[300] p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <div class="text-center mb-6">
                <div id="genericConfirmIcon" class="text-5xl mb-3">⚠️</div>
                <h3 id="genericConfirmTitle" class="text-xl font-bold text-white mb-2"></h3>
                <p id="genericConfirmMessage" class="text-gray-300 text-sm"></p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeGenericConfirm()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <button type="button" id="genericConfirmOkBtn" class="flex-1 px-4 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-xl font-semibold transition-all">Confirm</button>
            </div>
        </div>
    </div>

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
                        <div id="passwordFields">
                        <div>
                            <label class="block text-gray-300 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="addUserPassword" required
                                    class="w-full px-4 py-2 pr-10 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500 hide-pwd-reveal">
                                <button type="button" onclick="togglePwd('addUserPassword','eyeIcon1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none" tabindex="-1">
                                    <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="addUserPasswordConf" required
                                    class="w-full px-4 py-2 pr-10 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500 hide-pwd-reveal">
                                <button type="button" onclick="togglePwd('addUserPasswordConf','eyeIcon2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none" tabindex="-1">
                                    <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>
                        </div>{{-- end passwordFields --}}
                        <div>
                            <label class="block text-gray-300 mb-2">Role</label>
                            <select name="role" required class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Select Role</option>
                                <option value="ccit_head">CCIT Head</option>
                                <option value="coordinator">Coordinator</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                        <div id="companyField">
                            <label class="block text-gray-300 mb-2">Company</label>
                            <select name="company_id" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500">
                                <option value="">Select Company</option>
                            </select>
                        </div>
                        <div id="schoolIdNumberField" class="hidden">
                            <label class="block text-gray-300 mb-2">Student ID Number</label>
                            <input type="text" name="school_id_number" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 focus:outline-none focus:border-red-500" placeholder="e.g. 2021-00123">
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
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Select Student</label>
                        <div class="flex items-center gap-2 px-3 py-2.5 bg-slate-700 border border-slate-600 rounded-xl focus-within:border-red-500 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                            <input type="text" id="analyticsStudentSelect" placeholder="Search student name…"
                                class="flex-1 bg-transparent text-white text-sm placeholder-gray-400 focus:outline-none"
                                autocomplete="off">
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
                                    <input type="checkbox" name="email_notifications" class="w-4 h-4 rounded bg-slate-700 border-slate-600 text-red-600" checked>
                                    <span class="ml-2 text-gray-300">Enable email notifications</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-6">When unchecked, no emails will be sent via Gmail for any system events.</p>
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
    <div id="pixelLoader" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-slate-600/50 rounded-2xl px-12 py-10 flex flex-col items-center gap-6 shadow-2xl">
            <div class="pixel-bar-wrap" id="pixelBarCells"></div>
            <div class="text-green-400 text-base font-semibold tracking-wider" id="pixelLoaderLabel">LOADING<span id="pixelDots"></span></div>
        </div>
    </div>

    <!-- Pixel Success Overlay -->
    <div id="pixelSuccess" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-green-500/50 rounded-2xl px-14 py-10 flex flex-col items-center gap-5 shadow-2xl" style="box-shadow:0 0 60px rgba(74,222,128,0.3)">
            <div class="pixel-check">✅</div>
            <div class="pixel-success-text text-green-400 text-base tracking-wider text-center" id="pixelSuccessMsg">SUCCESS!</div>
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
        // Global error handler to prevent navigation breaking
        window.addEventListener('error', function(e) {
            console.error('Global error caught:', e.error);
            return false;
        });

        // Global: ensure all fetch calls to /api/* include Accept: application/json
        // so Laravel returns JSON errors instead of HTML redirects
        const _origFetch = window.fetch;
        window.fetch = function(url, opts = {}) {
            if (typeof url === 'string' && url.includes('/api/')) {
                opts.headers = Object.assign({ 'Accept': 'application/json' }, opts.headers || {});
            }
            return _origFetch(url, opts);
        };

        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input) return;
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            // isHidden=true means we just revealed — show open-eye
            // isHidden=false means we just hid — show closed-eye
            icon.innerHTML = isHidden
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        }
        let allUsers = [];
        const CURRENT_USER_ID = parseInt(document.querySelector('meta[name="current-user-id"]')?.content || '0', 10);
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
                // hide password fields when editing — privacy
                const pwdFields = document.getElementById('passwordFields');
                if (pwdFields) pwdFields.classList.add('hidden');
                if (pwd) { pwd.removeAttribute('required'); pwd.value = ''; }
                if (pwdConf) { pwdConf.removeAttribute('required'); pwdConf.value = ''; }
            } else {
                title.textContent = 'Add New User';
                submitBtn.textContent = 'Add User';
                // show password fields when adding
                const pwdFields = document.getElementById('passwordFields');
                if (pwdFields) pwdFields.classList.remove('hidden');
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
                if (form.school_id_number) form.school_id_number.value = user.school_id_number || '';
                // leave password blank to keep existing password
                form.password.value = '';
                form.password_confirmation.value = '';
            } else {
                document.getElementById('addUserForm').reset();
            }

            // show/hide & require company based on role
            function updateCompanyField() {
                const needsCompany = roleSelect.value === 'student' || roleSelect.value === 'supervisor';
                const isStudent = roleSelect.value === 'student';
                const field = document.getElementById('companyField');
                const idField = document.getElementById('schoolIdNumberField');
                if (field) field.classList.toggle('hidden', !needsCompany);
                if (idField) idField.classList.toggle('hidden', !isStudent);
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
                                <button onclick="deleteSchoolYear(${sy.id})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Archive</button>
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
            document.getElementById('deleteSchoolYearModal').dataset.syId = id;
            document.getElementById('deleteSchoolYearModal').classList.remove('hidden');
        }
        function closeDeleteSchoolYearModal() {
            document.getElementById('deleteSchoolYearModal').classList.add('hidden');
        }
        function confirmDeleteSchoolYear() {
            const id = document.getElementById('deleteSchoolYearModal').dataset.syId;
            closeDeleteSchoolYearModal();
            pixelAction('ARCHIVING', () =>
                fetch(`/api/school-years/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(r => r.json()).then(data => {
                    if (data.success) { loadSchoolYearList(); loadSchoolYearSelector(); }
                })
            , 'SCHOOL YEAR ARCHIVED!');
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
                const roleOrder = { ccit_head: 1, coordinator: 2, supervisor: 3, student: 4 };
                // sort: pending first, then by your custom role priority
                const sorted = [...users].sort((a, b) => {
                    // Logged-in user always first
                    if (a.id === CURRENT_USER_ID) return -1;
                    if (b.id === CURRENT_USER_ID) return 1;

                    const aPending = !a.is_approved && a.role !== 'student';
                    const bPending = !b.is_approved && b.role !== 'student';
                    if (bPending !== aPending) return bPending - aPending;

                    const aRoleRank = roleOrder[a.role] ?? 99;
                    const bRoleRank = roleOrder[b.role] ?? 99;
                    if (aRoleRank !== bRoleRank) return aRoleRank - bRoleRank;

                    return (a.name || '').localeCompare(b.name || '');
                });
                sorted.forEach(user => {
                    const isPending = !user.is_approved && user.role !== 'student';
                    const statusBadge = isPending
                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-1 bg-yellow-500/15 text-yellow-300 text-xs rounded-full font-semibold border border-yellow-500/30 whitespace-nowrap">⏳ Pending</span>'
                        : '<span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-500/15 text-green-400 text-xs rounded-full font-semibold border border-green-500/30 whitespace-nowrap">✓ Approved</span>';
                    const actions = isPending
                        ? `<div class="flex gap-1">
                               <button onclick="approveUser(${user.id})" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold whitespace-nowrap">Approve</button>
                               <button onclick="denyUser(${user.id}, '${user.name}')" class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold whitespace-nowrap">Deny</button>
                           </div>`
                        : user.id === CURRENT_USER_ID
                        ? `<span class="px-2 py-1 text-gray-400 text-xs italic whitespace-nowrap">You</span>`
                        : `<div class="flex gap-1">
                               <button onclick="editUser(${user.id})" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs whitespace-nowrap">Edit</button>
                               <button onclick="removeUser(${user.id})" class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs whitespace-nowrap">Archive</button>
                           </div>`;
                    // Desktop table row
                    tableBody.innerHTML += `
                        <tr class="${isPending ? 'bg-yellow-900/10 border-l-2 border-yellow-500/50' : ''} hover:bg-slate-700/30 border-b border-slate-700/40">
                            <td class="px-3 py-2.5 font-medium text-white max-w-[120px]"><div class="truncate" title="${user.name}">${user.name}</div></td>
                            <td class="px-3 py-2.5 text-gray-300 max-w-[160px]"><div class="truncate text-xs" title="${user.email}">${user.email}</div></td>
                            <td class="px-3 py-2.5"><span class="inline-flex items-center px-2 py-0.5 bg-red-500/20 text-red-300 rounded-full text-xs font-semibold whitespace-nowrap">${user.role}</span></td>
                            <td class="px-3 py-2.5 font-mono text-xs text-gray-300 whitespace-nowrap">${user.school_id_number || '<span class="text-gray-500">—</span>'}</td>
                            <td class="px-3 py-2.5 max-w-[110px]"><div class="truncate text-gray-300 text-xs" title="${user.company || ''}">${user.company || '<span class="text-gray-500">—</span>'}</div></td>
                            <td class="px-3 py-2.5 text-gray-300 text-xs whitespace-nowrap">${user.school_year || '<span class="text-gray-500">—</span>'}</td>
                            <td class="px-3 py-2.5">${statusBadge}</td>
                            <td class="px-3 py-2.5">${actions}</td>
                        </tr>
                    `;
                    // Mobile card
                    if (mobileContainer) {
                        const mobileActions = isPending
                            ? `<div class="grid grid-cols-2 gap-2 mt-3">
                                   <button onclick="approveUser(${user.id})" class="py-2 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold">Approve</button>
                                   <button onclick="denyUser(${user.id}, '${user.name}')" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Deny</button>
                               </div>`
                            : user.id === CURRENT_USER_ID
                            ? `<p class="text-gray-400 text-xs italic text-center mt-3">You</p>`
                            : `<div class="grid grid-cols-2 gap-2 mt-3">
                                   <button onclick="editUser(${user.id})" class="py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Edit</button>
                                   <button onclick="removeUser(${user.id})" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Archive</button>
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
            return action().then(() => {
                hidePixelLoader();
                showPixelSuccess(successMsg);
            }).catch(() => {
                hidePixelLoader();
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
            showGenericConfirm({
                icon: '✅',
                title: 'Approve All Pending?',
                message: `This will approve all ${pending.length} pending user(s).`,
                confirmText: 'Approve All',
                confirmClass: 'bg-green-700 hover:bg-green-800',
                onConfirm: () => pixelAction('APPROVING', () =>
                    Promise.all(pending.map(u =>
                        fetch(`/api/users/${u.id}/approve`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        }).then(r => r.json())
                    )).then(() => loadUsers())
                , `ALL ${pending.length} APPROVED!`)
            });
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
            const user = allUsers.find(u => u.id === userId);
            const name = user ? user.name : 'this user';
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteUserModal').dataset.userId = userId;
            document.getElementById('deleteUserModal').classList.remove('hidden');
        }
        function closeDeleteUserModal() {
            document.getElementById('deleteUserModal').classList.add('hidden');
        }
        function confirmDeleteUser() {
            const userId = document.getElementById('deleteUserModal').dataset.userId;
            closeDeleteUserModal();
            pixelAction('ARCHIVING', () =>
                fetch(`/api/users/${userId}`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                    }).then(async response => {
                        if (response.status === 419) { showToast('Session Expired', 'Please reload.', 'red'); return; }
                        const data = await response.json().catch(()=>({}));
                        if (response.ok) return loadUsers();
                        else showToast('Error', data.message || 'Failed to archive user', 'red');
                    })
                , 'USER ARCHIVED!');
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
                    // Populate hidden select for compatibility
                    const studentSelect = document.getElementById('analyticsStudentSelect');
                    if (studentSelect && studentSelect.tagName === 'SELECT') {
                        studentSelect.innerHTML = '<option value="">All Students</option>';
                        if (data.students) {
                            data.students.forEach(student => {
                                studentSelect.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                            });
                        }
                        studentSelect.onchange = function() {
                            const id = this.value;
                            renderAnalytics(id ? analyticsData.filter(a => a.student_id == id) : analyticsData);
                        };
                    }
                    // Populate custom dropdown options
                    if (data.students) {
                        _analyticsStudents = data.students;
                        buildStudentDropdown(data.students);
                    }
                    renderAnalytics(analyticsData);
                });
        }

        // ===== Searchable student dropdown =====
        let _analyticsStudents = [];
        let _selectedStudentId = '';

        function buildStudentDropdown(students) {
            const opts = document.getElementById('studentDropdownOptions');
            if (!opts) return;
            opts.innerHTML = '';
            // All option
            const allBtn = document.createElement('button');
            allBtn.type = 'button';
            allBtn.className = 'w-full text-left px-4 py-3 text-sm text-gray-300 hover:bg-slate-700/80 transition-colors flex items-center gap-3 border-b border-slate-700/60 rounded-t-2xl';
            allBtn.innerHTML = '<span class="w-7 h-7 rounded-full bg-slate-600 text-gray-300 flex items-center justify-center text-xs shrink-0">👥</span><span class="font-medium">All Students</span>';
            allBtn.onclick = () => selectStudent('', 'All Students');
            opts.appendChild(allBtn);
            students.forEach((s, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                const isLast = i === students.length - 1;
                btn.className = `w-full text-left px-4 py-3 text-sm text-gray-200 hover:bg-red-600/10 hover:text-white transition-colors flex items-center gap-3 ${isLast ? 'rounded-b-2xl' : 'border-b border-slate-700/40'}`;
                btn.dataset.id = s.id;
                btn.dataset.name = s.name.toLowerCase();
                const initials = s.name.split(' ').map(w => w[0]).slice(0,2).join('').toUpperCase();
                btn.innerHTML = `<span class="w-7 h-7 rounded-full bg-gradient-to-br from-red-600 to-red-800 text-white flex items-center justify-center text-xs font-bold shrink-0">${initials}</span><span class="truncate font-medium">${s.name}</span>`;
                btn.onclick = () => selectStudent(s.id, s.name);
                opts.appendChild(btn);
            });
        }

        function filterStudentDropdown() {
            const q = (document.getElementById('studentSearchInput')?.value || '').toLowerCase();
            const opts = document.querySelectorAll('#studentDropdownOptions button[data-id]');
            opts.forEach(btn => {
                btn.style.display = btn.dataset.name.includes(q) ? '' : 'none';
            });
            openStudentDropdown();
        }

        function openStudentDropdown() {
            const list = document.getElementById('studentDropdownList');
            if (list) list.classList.remove('hidden');
        }

        function selectStudent(id, name) {
            _selectedStudentId = id;
            const input = document.getElementById('studentSearchInput');
            const clearBtn = document.getElementById('clearStudentBtn');
            if (input) input.value = id ? name : '';
            if (clearBtn) clearBtn.classList.toggle('hidden', !id);
            document.getElementById('studentDropdownList')?.classList.add('hidden');
            renderAnalytics(id ? analyticsData.filter(a => a.student_id == id) : analyticsData);
        }

        function clearStudentFilter() {
            selectStudent('', '');
            document.getElementById('studentSearchInput')?.focus();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('studentDropdownWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('studentDropdownList')?.classList.add('hidden');
            }
        });
        // ===== End searchable student dropdown =====


        function generateSystemReport() { exportReport('system','pdf'); }
        function generateStudentReport() { exportReport('students','pdf'); }
        function generateAttendanceReport() { exportReport('attendance','pdf'); }

        async function exportReport(type, format) {
            const sy = currentSchoolYear || 'All Years';
            const date = new Date().toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' });

            /* ── fetch data ── */
            let rows = [], columns = [], title = '', subtitle = '';
            const roleOrder = { ccit_head: 1, coordinator: 2, supervisor: 3, student: 4 };
            if (type === 'system') {
                title = 'OJT Monitoring System — System Report';
                subtitle = 'All registered users and their roles';
                const res = await fetch(currentSchoolYear ? `/api/users?school_year=${encodeURIComponent(currentSchoolYear)}` : '/api/users').then(r=>r.json());
                columns = ['Name','Email','Role','Company','School Year'];
                rows = (res.users||[])
                    .slice()
                    .sort((a,b)=> {
                        const aRank = roleOrder[a.role] ?? 99;
                        const bRank = roleOrder[b.role] ?? 99;
                        if (aRank !== bRank) return aRank - bRank;
                        return (a.name || '').localeCompare(b.name || '');
                    })
                    .map(u=>[u.name, u.email, u.role, u.company||'—', u.school_year||'—']);
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
                rows = (res.records||[])
                    .filter(r => r && r.status === 'approved' && r.time_in && r.time_out && r.time_out !== '—' && r.time_out !== '00:00:00')
                    .map(r=>[r.student_name, r.date, r.time_in||'—', r.time_out||'—', r.hours||'—']);
            }

            if (format === 'pdf') {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
                const W = doc.internal.pageSize.getWidth();

                /* header bar */
                doc.setFillColor(96,165,250);
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
                    headStyles: { fillColor:[96,165,250], textColor:255, fontStyle:'bold', fontSize:9 },
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
        // ===== SEARCH / FILTER HELPERS =====
        function filterSchoolIdList(q) {
            q = q.toLowerCase();
            document.querySelectorAll('#schoolIdList [data-sid]').forEach(el => {
                el.style.display = el.dataset.sid.toLowerCase().includes(q) ? '' : 'none';
            });
        }
        // Filter JS-rendered archive lists (school years, school IDs, users)
        function filterArchiveList(containerId, q) {
            q = q.toLowerCase();
            const container = document.getElementById(containerId);
            if (!container) return;
            // Filter table rows
            container.querySelectorAll('tr[data-search]').forEach(el => {
                el.style.display = el.dataset.search.includes(q) ? '' : 'none';
            });
            // Filter mobile cards
            container.querySelectorAll('div[data-search]').forEach(el => {
                el.style.display = el.dataset.search.includes(q) ? '' : 'none';
            });
        }
        // Filter Blade-rendered archive lists (companies, requirements)
        function filterBladeArchive(inputId, rowSelector, cardSelector) {
            const q = (document.getElementById(inputId)?.value || '').toLowerCase();
            document.querySelectorAll(rowSelector).forEach(el => {
                el.style.display = (el.dataset.search || '').includes(q) ? '' : 'none';
            });
            document.querySelectorAll(cardSelector).forEach(el => {
                el.style.display = (el.dataset.search || '').includes(q) ? '' : 'none';
            });
        }
        // ===== END SEARCH / FILTER HELPERS =====

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
                                <tr class="bg-slate-800/50 hover:bg-slate-700/50" data-sid="${sid.school_id_number} ${sid.school_year || ''}">
                                    <td class="px-4 py-2 font-mono font-semibold text-white">${sid.school_id_number}</td>
                                    <td class="px-4 py-2">${sid.school_year || '<span class="text-gray-500">—</span>'}</td>
                                    <td class="px-4 py-2">${sid.is_used
                                        ? '<span class="px-2 py-0.5 bg-green-600/30 text-green-300 text-xs rounded-full">Used</span>'
                                        : '<span class="px-2 py-0.5 bg-yellow-600/30 text-yellow-300 text-xs rounded-full">Available</span>'}</td>
                                    <td class="px-4 py-2 text-gray-400 text-xs">${sid.created_at ? new Date(sid.created_at).toLocaleDateString() : '—'}</td>
                                    <td class="px-4 py-2"><div class="flex gap-1">
                                            <button onclick="editSchoolId(${sid.id}, '${sid.school_id_number}', '${sid.school_year || ''}')" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">Edit</button>
                                            <button onclick="deleteSchoolId(${sid.id})" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Archive</button>
                                          </div></td>
                                </tr>`).join('')}
                            </tbody>
                        </table>
                        </div>
                        <div class="md:hidden space-y-3">
                            ${ids.map(sid => `
                            <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-700" data-sid="${sid.school_id_number} ${sid.school_year || ''}">
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
                                    <button onclick="deleteSchoolId(${sid.id})" class="py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Archive</button>
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
            if (!val) {
                errEl.textContent = 'Please enter a School ID number.';
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
                    if (data.success) {
                        input.value = '';
                        loadSchoolIdList();
                    } else {
                        // Show error — do NOT show success
                        errEl.textContent = data.message || 'Failed to add School ID';
                        errEl.classList.remove('hidden');
                        // Throw so pixelAction doesn't show success screen
                        throw new Error(data.message || 'duplicate');
                    }
                })
            , 'SCHOOL ID ADDED!');
        }

        async function bulkAddSchoolIds() {
            const textarea = document.getElementById('bulkSchoolIdInput');
            const errEl = document.getElementById('bulkSidError');
            errEl.classList.add('hidden');
            const lines = textarea.value.split('\n').map(l => l.trim()).filter(l => l.length > 0);
            const valid = [...new Set(lines.filter(l => l.length >= 4))];
            if (valid.length === 0) {
                errEl.textContent = 'No IDs found. Paste one ID per line.';
                errEl.classList.remove('hidden');
                return;
            }

            // Show loading overlay
            const overlay = document.createElement('div');
            overlay.id = 'bulkImportOverlay';
            overlay.className = 'fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-4';
            overlay.style.cssText = 'background:rgba(5,13,46,0.92);backdrop-filter:blur(6px)';
            overlay.innerHTML = `
                <svg class="animate-spin" style="width:48px;height:48px" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="rgba(239,68,68,0.25)" stroke-width="4"/>
                    <path d="M4 12a8 8 0 018-8" stroke="#f87171" stroke-width="4" stroke-linecap="round"/>
                </svg>
                <p id="bulkImportMsg" style="color:#fca5a5;font-size:15px;font-weight:600;font-family:sans-serif;letter-spacing:.03em;">
                    Importing 0 / ${valid.length}…
                </p>
                <div class="w-64 bg-slate-700 rounded-full h-2 overflow-hidden">
                    <div id="bulkImportBar" class="bg-red-500 h-2 rounded-full transition-all duration-200" style="width:0%"></div>
                </div>`;
            document.body.appendChild(overlay);

            let added = 0, skipped = 0;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            for (let i = 0; i < valid.length; i++) {
                const sid = valid[i];
                try {
                    const res = await fetch('/api/school-ids', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({ school_id_number: sid, school_year: currentSchoolYear || null })
                    });
                    const data = await res.json();
                    if (data.success) added++; else skipped++;
                } catch { skipped++; }

                // Update progress
                const pct = Math.round(((i + 1) / valid.length) * 100);
                const msgEl = document.getElementById('bulkImportMsg');
                const barEl = document.getElementById('bulkImportBar');
                if (msgEl) msgEl.textContent = `Importing ${i + 1} / ${valid.length}…`;
                if (barEl) barEl.style.width = pct + '%';
            }

            // Remove overlay
            overlay.remove();
            textarea.value = '';
            loadSchoolIdList();

            const color = skipped > 0 ? 'yellow' : 'green';
            const msg = `✅ Added ${added} IDs.${skipped > 0 ? ` ${skipped} skipped (already exist).` : ''}`;
            showToast('Bulk Import Complete', msg, color);
        }
        function deleteSchoolId(id) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[200] flex items-center justify-center bg-black/70 p-4';
            modal.innerHTML = `
                <div class="bg-slate-800 border border-red-500/50 rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                    <div class="text-center mb-4">
                        <div class="text-5xl mb-3">🪹</div>
                        <h3 class="text-lg font-bold text-white mb-2">Archive School ID?</h3>
                        <p class="text-gray-300 text-sm mb-2">Are you sure you want to archive this School ID?</p>
                        <div class="bg-red-500/10 border border-red-500/30 rounded-lg px-4 py-3 mt-3 text-left">
                            <p class="text-red-400 text-xs font-semibold">⚠️ This action cannot be undone.</p>
                            <p class="text-gray-400 text-xs mt-1">The student who used this ID will no longer be able to register with it.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                        <button id="confirmDeleteSidBtn" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">Yes, Archive</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('#confirmDeleteSidBtn').addEventListener('click', function () {
                modal.remove();
                pixelAction('ARCHIVING', () =>
                    fetch(`/api/school-ids/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(r => r.json()).then(data => { if (data.success) loadSchoolIdList(); })
                , 'SCHOOL ID ARCHIVED!');
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
            if (!nameVal) { showToast('Validation Error', 'Name is required.', 'red'); form.name.focus(); return; }
            if (!emailVal) { showToast('Validation Error', 'Email is required.', 'red'); form.email.focus(); return; }
            if (!roleVal) { showToast('Validation Error', 'Role is required.', 'red'); form.role.focus(); return; }

            // School ID required and must exist for students (client-side pre-check)
            if (roleVal === 'student' && !editingUserId) {
                const sidVal = (form.school_id_number?.value || '').trim();
                if (!sidVal) { showToast('Validation Error', 'School ID number is required for students.', 'red'); form.school_id_number?.focus(); return; }
            }

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

            const label = editingUserId ? 'UPDATING' : 'SAVING';
            const successMsg = editingUserId ? 'USER UPDATED!' : 'USER ADDED!';
            showPixelLoader(label);
            fetch(url, {
                method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            }).then(async response => {
                hidePixelLoader();
                if (response.status === 419) { showToast('Session Expired', 'Please reload and try again.', 'red'); return; }
                const text = await response.text();
                let data = {};
                try { data = JSON.parse(text); } catch(e) { showToast('Server Error', text.substring(0, 100), 'red'); return; }
                if (response.ok && data.success) {
                    showPixelSuccess(successMsg);
                    closeAddUserModal(); loadUsers(); form.reset();
                    editingUserId = null;
                } else if (response.status === 422 && data.errors) {
                    const msgs = Object.values(data.errors).flat().join(' ');
                    showToast('Validation Error', msgs, 'red');
                } else {
                    showToast('Error', data.message || `Error (${response.status}): Please check all fields and try again.`, 'red');
                }
            }).catch(err => { hidePixelLoader(); showToast('Network Error', err.message, 'red'); });
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
                    if (response.status === 419) { showToast('Session Expired', 'Please reload and try again.', 'red'); return; }
                    const json = await response.json().catch(() => ({}));
                    if (response.ok && json.success) {
                        refreshDashboardStats();
                    } else {
                        if (json.errors) {
                            showToast('Validation Error', Object.values(json.errors).flat().join(' '), 'red');
                        } else {
                            showToast('Error', json.message || 'Failed to save settings', 'red');
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

        // ── Sidebar JS ───────────────────────────────────────────────
        function toggleSidebar() {
            try {
                const sb = document.getElementById('sidebar');
                const ov = document.getElementById('sidebarOverlay');
                if (sb && ov) {
                    sb.classList.toggle('mobile-hidden');
                    ov.classList.toggle('active');
                }
            } catch (error) {
                console.error('Error toggling sidebar:', error);
            }
        }
        function closeSidebar() {
            try {
                const sb = document.getElementById('sidebar');
                const ov = document.getElementById('sidebarOverlay');
                if (sb) sb.classList.add('mobile-hidden');
                if (ov) ov.classList.remove('active');
            } catch (error) {
                console.error('Error closing sidebar:', error);
            }
        }
        function toggleSidebarCollapse() {
            try {
                const sb = document.getElementById('sidebar');
                if (!sb) return;
                const collapsed = sb.classList.toggle('collapsed');
                document.body.classList.toggle('sidebar-collapsed', collapsed);
                const mc = document.getElementById('main-content');
                if (mc) mc.style.marginLeft = collapsed ? '4rem' : '16rem';
                const th = document.getElementById('top-header');
                if (th) th.style.left = collapsed ? '4rem' : '16rem';
                localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
            } catch (error) {
                console.error('Error toggling sidebar collapse:', error);
            }
        }
        const sectionTitles = {
            overview: 'Overview', users: 'User Management', analytics: 'Analytics',
            schoolyears: 'School Years', schoolids: 'School IDs',
            reports: 'Reports', settings: 'Settings',
            'manage-requirements': '📝 Manage Requirements'
        };
        function showSection(name) {
            try {
                if (typeof showDashboardSkeleton === 'function') showDashboardSkeleton(name);

                // Hide ALL sections first
                document.querySelectorAll('.dash-section').forEach(s => {
                    s.classList.add('hidden');
                    s.style.display = 'none';
                });
                
                // Force hide all archived modals
                ['archivedSchoolYearsModal','archivedSchoolIdsModal','archivedUsersModal','archivedTemplatesModal'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.classList.add('hidden'); el.style.display = 'none'; }
                });
                
                // Show target section
                const target = document.getElementById('section-' + name);
                if (target) {
                    target.classList.remove('hidden');
                    target.style.display = 'block';
                } else {
                    console.warn('Section not found:', 'section-' + name);
                    return;
                }
                
                // Update active nav
                document.querySelectorAll('.nav-item[data-section]').forEach(b => {
                    b.classList.toggle('active', b.getAttribute('data-section') === name);
                });
                
                // Update header title
                const ht = document.getElementById('headerTitle');
                if (ht) ht.textContent = sectionTitles[name] || name;
                
                // Persist
                sessionStorage.setItem('ccitSection', name);
                
                if (typeof closeSidebar === 'function') closeSidebar();
                
                // Load section data
                setTimeout(() => {
                    try {
                        if (name === 'users' && typeof loadUsers === 'function') loadUsers();
                        else if (name === 'analytics' && typeof loadAnalytics === 'function') loadAnalytics();
                        else if (name === 'schoolyears' && typeof loadSchoolYearList === 'function') loadSchoolYearList();
                        else if (name === 'schoolids' && typeof loadSchoolIdList === 'function') loadSchoolIdList();
                        else if (name === 'settings') {
                            fetch('/api/settings').then(r => r.json()).then(json => {
                                const form = document.getElementById('settingsForm');
                                if (form) {
                                    if (form.required_hours) form.required_hours.value = json.required_hours || '';
                                    if (form.email_notifications) form.email_notifications.checked = !!json.email_notifications;
                                }
                            }).catch(() => {});
                        }
                    } catch (e) { console.error('Section data load error:', e); }
                }, 100);
                
            } catch (error) {
                console.error('showSection error:', error);
                setTimeout(() => {
                    const overview = document.getElementById('section-overview');
                    if (overview) {
                        document.querySelectorAll('.dash-section').forEach(s => { s.classList.add('hidden'); s.style.display = 'none'; });
                        overview.classList.remove('hidden');
                        overview.style.display = 'block';
                    }
                }, 100);
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Hide all sections first
                document.querySelectorAll('.dash-section').forEach(section => {
                    section.classList.add('hidden');
                    section.style.display = 'none';
                });
                
                // Force hide all archived modals
                ['archivedSchoolYearsModal','archivedSchoolIdsModal','archivedUsersModal','archivedTemplatesModal'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) { el.classList.add('hidden'); el.style.display = 'none'; }
                });
                
                /* restore sidebar collapse */
                if (localStorage.getItem('sidebarCollapsed') === '1') {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) sidebar.classList.add('collapsed');
                    document.body.classList.add('sidebar-collapsed');
                    const mc = document.getElementById('main-content');
                    if (mc) mc.style.marginLeft = '4rem';
                    const th = document.getElementById('top-header');
                    if (th) th.style.left = '4rem';
                }
                
                /* restore section */
                const saved = sessionStorage.getItem('ccitSection') || 'overview';
                setTimeout(() => { showSection(saved); }, 50);
                
            } catch (error) {
                console.error('CCIT init error:', error);
                setTimeout(() => { showSection('overview'); }, 200);
            }
        });

        // ===== LEAVE PAGE CONFIRMATION =====
        let _allowLeave = true;
        // ===== END LEAVE PAGE CONFIRMATION =====

        // ===== REQUIREMENT TEMPLATES =====
        function showAddTemplateModal() {
            document.getElementById('addTemplateModal').classList.remove('hidden');
        }
        function closeAddTemplateModal() {
            document.getElementById('addTemplateModal').classList.add('hidden');
        }
        function showEditTemplateModal(id, name, category, description, maxFiles, sortOrder, categoryCount) {
            document.getElementById('edit_tpl_name').value = name;
            document.getElementById('edit_tpl_category').value = category;
            document.getElementById('edit_tpl_description').value = description;
            document.getElementById('edit_tpl_max_files').value = maxFiles;
            const orderInput = document.getElementById('edit_tpl_sort_order');
            orderInput.value = sortOrder;
            orderInput.min = 1;
            orderInput.max = categoryCount;
            orderInput.setAttribute('max', categoryCount);
            orderInput.title = 'Enter a number between 1 and ' + categoryCount;
            document.getElementById('edit_tpl_max_hint').textContent = categoryCount;
            // store for submit validation
            orderInput.dataset.maxAllowed = categoryCount;
            document.getElementById('editTemplateForm').action = '/requirement-templates/' + id;
            document.getElementById('editTemplateModal').classList.remove('hidden');
        }

        document.getElementById('editTemplateForm').addEventListener('submit', function(e) {
            const orderInput = document.getElementById('edit_tpl_sort_order');
            const val = parseInt(orderInput.value);
            const max = parseInt(orderInput.dataset.maxAllowed || orderInput.max);
            if (isNaN(val) || val < 1 || val > max) {
                e.preventDefault();
                alert('Sort order must be between 1 and ' + max + '.');
                orderInput.focus();
            }
        });
        function closeEditTemplateModal() {
            document.getElementById('editTemplateModal').classList.add('hidden');
        }
        function showArchiveTemplateModal(id, name) {
            document.getElementById('archiveTemplateName').textContent = name;
            document.getElementById('archiveTemplateForm').action = '/requirement-templates/' + id;
            document.getElementById('archiveTemplateModal').classList.remove('hidden');
        }
        function closeArchiveTemplateModal() {
            document.getElementById('archiveTemplateModal').classList.add('hidden');
        }
        function showForceDeleteTemplateModal(id, name) {
            document.getElementById('forceDeleteTemplateName').textContent = name;
            document.getElementById('forceDeleteTemplateForm').action = '/requirement-templates/' + id + '/force';
            document.getElementById('forceDeleteTemplateModal').classList.remove('hidden');
        }
        function closeForceDeleteTemplateModal() {
            document.getElementById('forceDeleteTemplateModal').classList.add('hidden');
        }

        // ── Generic Confirm Modal ─────────────────────────────────────
        let _genericConfirmCallback = null;
        function showGenericConfirm({ icon = '⚠️', title = 'Are you sure?', message = '', confirmText = 'Confirm', confirmClass = 'bg-red-700 hover:bg-red-800', onConfirm }) {
            document.getElementById('genericConfirmIcon').textContent = icon;
            document.getElementById('genericConfirmTitle').textContent = title;
            document.getElementById('genericConfirmMessage').textContent = message;
            const btn = document.getElementById('genericConfirmOkBtn');
            btn.textContent = confirmText;
            btn.className = `flex-1 px-4 py-2.5 ${confirmClass} text-white rounded-xl font-semibold transition-all`;
            _genericConfirmCallback = onConfirm;
            document.getElementById('genericConfirmModal').classList.remove('hidden');
        }
        function closeGenericConfirm() {
            document.getElementById('genericConfirmModal').classList.add('hidden');
            _genericConfirmCallback = null;
        }
        document.getElementById('genericConfirmOkBtn').addEventListener('click', function () {
            closeGenericConfirm();
            if (typeof _genericConfirmCallback === 'function') _genericConfirmCallback();
        });
        document.getElementById('genericConfirmModal').addEventListener('click', function (e) {
            if (e.target === this) closeGenericConfirm();
        });
        function toggleArchivedTemplates() {
            const modal = document.getElementById('archivedTemplatesModal');
            modal.classList.remove('hidden');
            modal.style.display = '';
        }
        function closeArchivedTemplatesModal() {
            const modal = document.getElementById('archivedTemplatesModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        // ===== ARCHIVED SCHOOL YEARS =====
        function openArchivedSchoolYearsModal() {
            const modal = document.getElementById('archivedSchoolYearsModal');
            modal.classList.remove('hidden');
            modal.style.display = '';
            loadArchivedSchoolYears();
        }
        function closeArchivedSchoolYearsModal() {
            const modal = document.getElementById('archivedSchoolYearsModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        function loadArchivedSchoolYears() {
            fetch('/api/school-years/archived')
                .then(r => r.json())
                .then(data => {
                    const el = document.getElementById('archivedSchoolYearsList');
                    if (!data.school_years.length) {
                        el.innerHTML = '<p class="text-gray-400 text-center py-8">No archived school years.</p>';
                        return;
                    }
                    const rows = data.school_years.map(sy => {
                        const date = new Date(sy.deleted_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
                        return { id: sy.id, label: sy.label, date };
                    });
                    el.innerHTML = `
                        <!-- Desktop table -->
                        <div class="hidden sm:block">
                            <table class="w-full"><thead><tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300">Label</th>
                                <th class="text-center py-2 px-3 text-gray-300">Archived On</th>
                                <th class="text-center py-2 px-3 text-gray-300">Actions</th>
                            </tr></thead><tbody>${rows.map(r => `
                                <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 opacity-80" data-search="${r.label.toLowerCase()} ${r.date.toLowerCase()}">
                                    <td class="py-3 px-3 text-gray-400 line-through">${r.label}</td>
                                    <td class="py-3 px-3 text-center text-gray-500 text-sm">${r.date}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="restoreSchoolYear(${r.id})" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Restore</button>
                                            <button onclick="forceDeleteSchoolYear(${r.id})" class="px-3 py-1 bg-red-800 hover:bg-red-900 text-white rounded text-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>`).join('')}</tbody></table>
                        </div>
                        <!-- Mobile cards -->
                        <div class="sm:hidden space-y-3">${rows.map(r => `
                            <div style="background:rgba(51,65,85,0.5);border:1px solid rgba(71,85,105,0.5)" class="rounded-xl p-4" data-search="${r.label.toLowerCase()} ${r.date.toLowerCase()}">
                                <p class="text-gray-400 line-through font-semibold text-sm mb-1">${r.label}</p>
                                <p class="text-gray-500 text-xs mb-3">Archived: ${r.date}</p>
                                <div class="flex gap-2">
                                    <button onclick="restoreSchoolYear(${r.id})" class="flex-1 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold">♻️ Restore</button>
                                    <button onclick="forceDeleteSchoolYear(${r.id})" class="flex-1 py-1.5 bg-red-800 hover:bg-red-900 text-white rounded-lg text-xs font-semibold">🗑 Delete</button>
                                </div>
                            </div>`).join('')}
                        </div>`;
                });
        }
        function restoreSchoolYear(id) {
            pixelAction('RESTORING', () =>
                fetch(`/api/school-years/${id}/restore`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(r => r.json()).then(d => { if (d.success) { loadArchivedSchoolYears(); loadSchoolYearList(); loadSchoolYearSelector(); } })
            , 'SCHOOL YEAR RESTORED!');
        }
        function forceDeleteSchoolYear(id) {
            showGenericConfirm({
                icon: '🗑️',
                title: 'Delete School Year?',
                message: 'This will permanently delete this school year. This cannot be undone.',
                confirmText: 'Delete Forever',
                onConfirm: () => fetch(`/api/school-years/${id}/force`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(r => r.json()).then(d => { if (d.success) loadArchivedSchoolYears(); })
            });
        }

        // ===== ARCHIVED SCHOOL IDs =====
        function openArchivedSchoolIdsModal() {
            const modal = document.getElementById('archivedSchoolIdsModal');
            modal.classList.remove('hidden');
            modal.style.display = '';
            loadArchivedSchoolIds();
        }
        function closeArchivedSchoolIdsModal() {
            const modal = document.getElementById('archivedSchoolIdsModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        function loadArchivedSchoolIds() {
            fetch('/api/school-ids/archived')
                .then(r => r.json())
                .then(data => {
                    const el = document.getElementById('archivedSchoolIdsList');
                    if (!data.school_ids.length) {
                        el.innerHTML = '<p class="text-gray-400 text-center py-8">No archived school IDs.</p>';
                        return;
                    }
                    const rows = data.school_ids.map(sid => ({
                        id: sid.id,
                        number: sid.school_id_number,
                        year: sid.school_year || '-',
                        date: new Date(sid.deleted_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})
                    }));
                    el.innerHTML = `
                        <!-- Desktop table -->
                        <div class="hidden sm:block">
                            <table class="w-full"><thead><tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300">School ID</th>
                                <th class="text-left py-2 px-3 text-gray-300">School Year</th>
                                <th class="text-center py-2 px-3 text-gray-300">Archived On</th>
                                <th class="text-center py-2 px-3 text-gray-300">Actions</th>
                            </tr></thead><tbody>${rows.map(r => `
                                <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 opacity-80" data-search="${r.number.toLowerCase()} ${r.year.toLowerCase()} ${r.date.toLowerCase()}">
                                    <td class="py-3 px-3 text-gray-400 line-through font-mono">${r.number}</td>
                                    <td class="py-3 px-3 text-gray-500 text-sm">${r.year}</td>
                                    <td class="py-3 px-3 text-center text-gray-500 text-sm">${r.date}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="restoreSchoolId(${r.id})" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Restore</button>
                                            <button onclick="forceDeleteSchoolId(${r.id})" class="px-3 py-1 bg-red-800 hover:bg-red-900 text-white rounded text-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>`).join('')}</tbody></table>
                        </div>
                        <!-- Mobile cards -->
                        <div class="sm:hidden space-y-3">${rows.map(r => `
                            <div style="background:rgba(51,65,85,0.5);border:1px solid rgba(71,85,105,0.5)" class="rounded-xl p-4" data-search="${r.number.toLowerCase()} ${r.year.toLowerCase()} ${r.date.toLowerCase()}">
                                <p class="text-gray-400 line-through font-mono font-semibold text-sm mb-0.5">${r.number}</p>
                                <p class="text-gray-500 text-xs mb-0.5">${r.year}</p>
                                <p class="text-gray-500 text-xs mb-3">Archived: ${r.date}</p>
                                <div class="flex gap-2">
                                    <button onclick="restoreSchoolId(${r.id})" class="flex-1 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold">♻️ Restore</button>
                                    <button onclick="forceDeleteSchoolId(${r.id})" class="flex-1 py-1.5 bg-red-800 hover:bg-red-900 text-white rounded-lg text-xs font-semibold">🗑 Delete</button>
                                </div>
                            </div>`).join('')}
                        </div>`;
                });
        }
        function restoreSchoolId(id) {
            pixelAction('RESTORING', () =>
                fetch(`/api/school-ids/${id}/restore`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(r => r.json()).then(d => { if (d.success) { loadArchivedSchoolIds(); loadSchoolIdList(); } })
            , 'SCHOOL ID RESTORED!');
        }

        // ===== ARCHIVED USERS =====
        function openArchivedUsersModal() {
            const modal = document.getElementById('archivedUsersModal');
            modal.classList.remove('hidden');
            modal.style.display = '';
            loadArchivedUsers();
        }
        function closeArchivedUsersModal() {
            const modal = document.getElementById('archivedUsersModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        function loadArchivedUsers() {
            fetch('/api/users/archived')
                .then(r => r.json())
                .then(data => {
                    const el = document.getElementById('archivedUsersList');
                    if (!data.users.length) {
                        el.innerHTML = '<p class="text-gray-400 text-center py-8">No archived users.</p>';
                        return;
                    }
                    const rows = data.users.map(u => ({
                        id: u.id,
                        name: u.name,
                        email: u.email,
                        role: u.role,
                        sid: u.school_id_number || '—',
                        date: u.deleted_at,
                        safeName: u.name.replace(/'/g,"\\'")
                    }));
                    el.innerHTML = `
                        <!-- Desktop table -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-xs"><thead><tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-3 text-gray-300">Name</th>
                                <th class="text-left py-2 px-3 text-gray-300">Email</th>
                                <th class="text-left py-2 px-3 text-gray-300">Role</th>
                                <th class="text-left py-2 px-3 text-gray-300">School ID</th>
                                <th class="text-center py-2 px-3 text-gray-300">Archived On</th>
                                <th class="text-center py-2 px-3 text-gray-300">Actions</th>
                            </tr></thead><tbody>${rows.map(r => `
                                <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 opacity-80" data-search="${r.name.toLowerCase()} ${r.email.toLowerCase()} ${r.role.toLowerCase()} ${r.sid.toLowerCase()}">
                                    <td class="py-2 px-3 text-gray-400 line-through">${r.name}</td>
                                    <td class="py-2 px-3 text-gray-500">${r.email}</td>
                                    <td class="py-2 px-3 text-gray-500 capitalize">${r.role}</td>
                                    <td class="py-2 px-3 text-gray-500 font-mono">${r.sid}</td>
                                    <td class="py-2 px-3 text-center text-gray-500">${r.date}</td>
                                    <td class="py-2 px-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="restoreUser(${r.id})" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Restore</button>
                                            <button onclick="forceDeleteUser(${r.id},'${r.safeName}')" class="px-3 py-1 bg-red-800 hover:bg-red-900 text-white rounded text-xs">Delete</button>
                                        </div>
                                    </td>
                                </tr>`).join('')}</tbody></table>
                        </div>
                        <!-- Mobile cards -->
                        <div class="sm:hidden space-y-3">${rows.map(r => `
                            <div style="background:rgba(51,65,85,0.5);border:1px solid rgba(71,85,105,0.5)" class="rounded-xl p-4" data-search="${r.name.toLowerCase()} ${r.email.toLowerCase()} ${r.role.toLowerCase()} ${r.sid.toLowerCase()}">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <p class="text-gray-400 line-through font-semibold text-sm">${r.name}</p>
                                    <span class="text-gray-500 text-xs capitalize shrink-0">${r.role}</span>
                                </div>
                                <p class="text-gray-500 text-xs">${r.email}</p>
                                ${r.sid !== '—' ? `<p class="text-gray-500 text-xs font-mono">ID: ${r.sid}</p>` : ''}
                                <p class="text-gray-500 text-xs mb-3">Archived: ${r.date}</p>
                                <div class="flex gap-2">
                                    <button onclick="restoreUser(${r.id})" class="flex-1 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold">♻️ Restore</button>
                                    <button onclick="forceDeleteUser(${r.id},'${r.safeName}')" class="flex-1 py-1.5 bg-red-800 hover:bg-red-900 text-white rounded-lg text-xs font-semibold">🗑 Delete</button>
                                </div>
                            </div>`).join('')}
                        </div>`;
                });
        }
        function restoreUser(id) {
            pixelAction('RESTORING', () =>
                fetch(`/api/users/${id}/restore`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(r => r.json()).then(d => { if (d.success) { loadArchivedUsers(); loadUsers(); } })
            , 'USER RESTORED!');
        }
        function forceDeleteUser(id, name) {
            showGenericConfirm({
                icon: '🗑️',
                title: 'Delete User?',
                message: `Permanently delete "${name}"? This cannot be undone.`,
                confirmText: 'Delete Forever',
                onConfirm: () => pixelAction('DELETING', () =>
                    fetch(`/api/users/${id}/force`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                        .then(r => r.json()).then(d => { if (d.success) loadArchivedUsers(); })
                , 'USER DELETED!')
            });
        }
        function forceDeleteSchoolId(id) {
            showGenericConfirm({
                icon: '🗑️',
                title: 'Delete School ID?',
                message: 'This will permanently delete this school ID. This cannot be undone.',
                confirmText: 'Delete Forever',
                onConfirm: () => fetch(`/api/school-ids/${id}/force`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(r => r.json()).then(d => { if (d.success) loadArchivedSchoolIds(); })
            });
        }

        // ── Theme toggle ─────────────────────────────────────────────
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

    <!-- Delete School Year Confirmation Modal -->
    <div id="deleteSchoolYearModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-800 border border-red-500/50 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-4">
                <div class="text-5xl mb-3">📅</div>
                <h3 class="text-lg font-bold text-white mb-2">Archive School Year?</h3>
                <p class="text-gray-300 text-sm">Are you sure you want to archive this school year?</p>
                <div class="mt-3 bg-red-500/10 border border-red-500/30 rounded-lg px-4 py-3">
                    <p class="text-red-400 text-xs font-semibold">⚠️ This action cannot be undone.</p>
                    <p class="text-gray-400 text-xs mt-1">Students and records linked to this school year will remain but the school year will no longer be selectable.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-5">
                <button onclick="closeDeleteSchoolYearModal()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <button onclick="confirmDeleteSchoolYear()" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">Yes, Archive</button>
            </div>
        </div>
    </div>

    <!-- Archived Users Modal -->
    <div id="archivedUsersModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[110] p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg w-full max-w-3xl max-h-[80vh] flex flex-col shadow-xl border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🗑</span>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Archived Users</h3>
                </div>
                <button onclick="closeArchivedUsersModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-light">×</button>
            </div>
            <div class="px-6 py-3 border-b border-gray-100 dark:border-slate-700">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" placeholder="Search users..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                        oninput="filterArchiveList('archivedUsersList', this.value)">
                </div>
            </div>
            <div class="overflow-auto flex-1 p-6">
                <div id="archivedUsersList"><p class="text-gray-500 dark:text-gray-400 text-center py-8">Loading...</p></div>
            </div>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <div id="deleteUserModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-800 border border-red-500/50 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-4">
                <div class="text-5xl mb-3">⚠️</div>
                <h3 class="text-lg font-bold text-white mb-2">Archive User?</h3>
                <p class="text-gray-300 text-sm">You are about to archive <span id="deleteUserName" class="text-red-400 font-semibold"></span>.</p>
                <div class="mt-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg px-4 py-3">
                    <p class="text-yellow-400 text-xs font-semibold">ℹ️ Records are preserved.</p>
                    <p class="text-gray-400 text-xs mt-1">The user and their records will be hidden but not deleted. You can restore them from Archive Trash.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-5">
                <button onclick="closeDeleteUserModal()" class="flex-1 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition-all">Cancel</button>
                <button onclick="confirmDeleteUser()" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">Yes, Archive</button>
            </div>
        </div>
    </div>
    <!-- Page loader overlay -->
    <div id="pageLoader" class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-6"
         style="background:rgba(5,13,46,0.95);backdrop-filter:blur(8px);">
        <div class="relative">
            <svg class="animate-spin" style="width:64px;height:64px;" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="rgba(239,68,68,0.2)" stroke-width="3"/>
                <path d="M4 12a8 8 0 018-8" stroke="#f87171" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-red-500/30 rounded-full animate-pulse"></div>
            </div>
        </div>
        <p id="pageLoaderMsg" style="color:#fca5a5;font-size:16px;font-weight:600;font-family:sans-serif;letter-spacing:.05em;">Please wait…</p>
    </div>

</body>
</html>
