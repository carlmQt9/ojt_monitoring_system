<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PRMSU Sta.Cruz OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* DARK MODE (default) */
        body { background: linear-gradient(135deg, #0a0e2e 0%, #0d1b4b 40%, #0a2a6e 70%, #0d3b8e 100%); min-height: 100vh; transition: background 0.3s; }
        .hero-bg { background: linear-gradient(135deg, #050d2e 0%, #0a1a5c 50%, #0d2d8a 100%); transition: background 0.3s; }
        .dot-pattern { background-image: radial-gradient(circle, rgba(99,179,237,0.15) 1px, transparent 1px); background-size: 24px 24px; }
        .glow-blue { box-shadow: 0 0 30px rgba(59,130,246,0.4); }
        .glow-btn { box-shadow: 0 0 20px rgba(59,130,246,0.5); }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .float { animation: float 4s ease-in-out infinite; }
        .fade-up { animation: fadeUp 0.7s ease-out forwards; }
        .delay-1 { animation-delay: 0.15s; opacity:0; }
        .delay-2 { animation-delay: 0.3s; opacity:0; }
        .delay-3 { animation-delay: 0.45s; opacity:0; }
        .nav-link { position:relative; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#3b82f6; transition:width 0.3s; }
        .nav-link:hover::after { width:100%; }
        .screen-mockup { background: linear-gradient(145deg, #0f1f5c, #1a3a8f); border: 2px solid rgba(99,179,237,0.3); border-radius: 12px; }
        .screen-bar { background: linear-gradient(90deg, #1e3a8a, #1d4ed8); }

        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg, #b8cef0 0%, #a0bce8 40%, #b8d4f5 70%, #cce0fa 100%); color: #0f2460; }
        body.light .hero-bg { background: linear-gradient(135deg, #a8c4e8 0%, #93b8e0 50%, #bdd4f0 100%); }
        body.light nav { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light nav span, body.light nav a { color: #0f2460 !important; }
        body.light nav .text-blue-400 { color: #1d4ed8 !important; }
        body.light .text-white { color: #0f2460 !important; }
        body.light .text-blue-200 { color: #1e40af !important; }
        body.light .text-blue-300 { color: #1d4ed8 !important; }
        body.light .text-blue-400 { color: #1a3fcc !important; }
        body.light .text-blue-500 { color: #1a3fcc !important; }
        body.light .text-blue-600 { color: #1e3a8a !important; }
        body.light .text-gray-300 { color: #1e293b !important; }
        body.light .text-cyan-400 { color: #0369a1 !important; }
        body.light .text-green-400 { color: #15803d !important; }
        body.light .text-green-300\/70 { color: #166534 !important; }
        body.light .text-purple-400 { color: #6d28d9 !important; }
        body.light .text-purple-300\/70 { color: #5b21b6 !important; }
        body.light .text-orange-400 { color: #c2410c !important; }
        body.light .text-orange-300\/70 { color: #9a3412 !important; }
        body.light .text-red-400 { color: #b91c1c !important; }
        body.light .text-red-300\/70 { color: #991b1b !important; }
        body.light .bg-blue-900\/20 { background: rgba(180,210,245,0.7) !important; }
        body.light .bg-blue-900\/30 { background: rgba(160,195,235,0.8) !important; }
        body.light .border-blue-800\/40 { border-color: rgba(100,150,210,0.7) !important; }
        body.light .border-blue-800\/50 { border-color: rgba(100,150,210,0.8) !important; }
        body.light .border-blue-900\/40 { border-color: #7aaad4 !important; }
        body.light .screen-mockup { background: linear-gradient(145deg, #b8d0f0, #9abce0); border-color: rgba(59,130,246,0.5); }
        body.light .screen-bar { background: linear-gradient(90deg, #2563eb, #1d4ed8); }
        body.light .bg-blue-950\/80 { background: rgba(200,225,250,0.95) !important; }
        body.light .bg-blue-900 { background: #b8d0f0 !important; }
        body.light .bg-blue-800\/40 { background: rgba(180,210,245,0.85) !important; }
        body.light [style*="background:linear-gradient(180deg,#0a1a5c"] { background: linear-gradient(180deg,#b8d0f0,#cce0fa) !important; }
        body.light [style*="background:#050d2e"] { background: #c4d8f2 !important; }
        body.light [style*="background:linear-gradient(135deg,#0a1a5c"] { background: linear-gradient(135deg,#b0cce8,#9abce0) !important; }
        body.light [style*="background:#030a1e"] { background: #a8c4e0 !important; }
        body.light .bg-blue-600\/30 { background: rgba(160,195,235,0.85) !important; }
        body.light .inline-flex.bg-blue-900\/50 { background: rgba(160,195,235,0.85) !important; border-color: #6a9fd0 !important; }
        body.light .border-blue-700\/50 { border-color: #6a9fd0 !important; }
        body.light footer { background: #a8c4e0 !important; }
        body.light .bg-green-900\/20 { background: rgba(187,247,208,0.5) !important; }
        body.light .bg-purple-900\/20 { background: rgba(233,213,255,0.5) !important; }
        body.light .bg-orange-900\/20 { background: rgba(254,215,170,0.5) !important; }
        body.light .bg-red-900\/20 { background: rgba(254,202,202,0.5) !important; }
        body.light .border-green-700\/40 { border-color: rgba(21,128,61,0.4) !important; }
        body.light .border-purple-700\/40 { border-color: rgba(109,40,217,0.4) !important; }
        body.light .border-orange-700\/40 { border-color: rgba(194,65,12,0.4) !important; }
        body.light .border-red-700\/40 { border-color: rgba(185,28,28,0.4) !important; }
        /* Contact section light mode */
        body.light #contact { background: linear-gradient(180deg,#ddeaf8,#cce0f5) !important; }
        body.light #contact h2,
        body.light #contact h3 { color: #0f2460 !important; }
        body.light #contact p,
        body.light #contact .text-blue-300 { color: #1e3a6e !important; }
        body.light #contact .text-blue-400 { color: #1d4ed8 !important; }
        body.light #contact .bg-blue-900\/20 { background: rgba(255,255,255,0.85) !important; border-color: #93b8dc !important; }
        body.light #contact .text-white { color: #0f2460 !important; }
    </style>
</head>
<body class="text-white">

    <!-- NAV -->
    <nav class="sticky top-0 z-50 border-b border-blue-900/50" style="background:rgba(5,13,46,0.92);backdrop-filter:blur(12px)">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-400 to-blue-700 flex items-center justify-center glow-blue">
                    <span class="text-white font-bold text-xs">OMS</span>
                </div>
                <span class="font-bold text-white text-sm hidden sm:block leading-tight">PRMSU <span class="text-blue-400">OJT</span> Monitoring System</span>
            </div>

            <!-- Links -->
            <div class="hidden md:flex items-center gap-8 text-sm text-blue-200">
                <a href="#" class="nav-link hover:text-white transition-colors">Home</a>
                <a href="#about" class="nav-link hover:text-white transition-colors">About</a>
                <a href="#features" class="nav-link hover:text-white transition-colors">Features</a>
                <a href="#contact" class="nav-link hover:text-white transition-colors">Contact</a>
            </div>

            <!-- Auth + Theme Toggle -->
            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                    class="w-9 h-9 rounded-full flex items-center justify-center border border-blue-500/50 text-blue-300 hover:text-white hover:border-blue-400 transition-all">
                    <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                </button>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 rounded-full text-sm font-semibold transition-all glow-btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 border border-blue-500 text-blue-300 hover:text-white hover:border-blue-400 rounded-full text-sm font-semibold transition-all">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 rounded-full text-sm font-semibold transition-all glow-btn">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-bg relative overflow-hidden sm:min-h-screen flex items-center">
        <!-- dot pattern -->
        <div class="dot-pattern absolute inset-0 opacity-40"></div>
        <!-- glow orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-800 rounded-full blur-3xl opacity-25"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">

            <!-- Left -->
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 bg-blue-900/50 border border-blue-700/50 rounded-full px-4 py-1.5 text-xs text-blue-300 fade-up">
                    <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                    PRMSU Sta. Cruz Campus — BSCS Program
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight fade-up delay-1">
                    Track Your OJT<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600">Progress With Us</span>
                </h1>

                <p class="text-blue-200 text-lg leading-relaxed max-w-md fade-up delay-2">
                    A complete On-the-Job Training monitoring platform for students, supervisors, coordinators, and CCIT Head — with camera time-in/out, DTR generation, and real-time progress tracking.
                </p>

                <div class="flex flex-wrap gap-4 fade-up delay-3">
                    <a href="{{ route('register') }}" class="px-7 py-3 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-400 hover:to-blue-600 rounded-full font-semibold text-white transition-all glow-btn transform hover:scale-105">
                        Get Started
                    </a>
                    <a href="#features" class="px-7 py-3 border border-blue-500/60 text-blue-200 hover:text-white hover:border-blue-400 rounded-full font-semibold transition-all">
                        Learn More
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 sm:flex sm:gap-8 gap-4 pt-4 fade-up delay-3">
                    <div>
                        <div class="text-2xl font-bold text-white">4</div>
                        <div class="text-xs text-blue-400">User Roles</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-8">
                        <div class="text-2xl font-bold text-white">600</div>
                        <div class="text-xs text-blue-400">Required Hours</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-8">
                        <div class="text-2xl font-bold text-white">DTR</div>
                        <div class="text-xs text-blue-400">Auto-Generated</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-8">
                        <div class="text-2xl font-bold text-white">📷</div>
                        <div class="text-xs text-blue-400">Camera Time-In</div>
                    </div>
                </div>
            </div>

            <!-- Right — Dashboard Mockup -->
            <div class="hidden lg:flex justify-center lg:justify-end fade-up delay-2">
                <div class="float w-full max-w-md">
                    <!-- Laptop frame -->
                    <div class="screen-mockup p-3 glow-blue">
                        <!-- Top bar -->
                        <div class="screen-bar rounded-t-lg px-3 py-2 flex items-center gap-2 mb-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                            <div class="flex-1 mx-3 bg-blue-900/60 rounded text-xs text-blue-300 px-2 py-0.5 text-center">OJT Monitoring System</div>
                        </div>
                        <!-- Mock content -->
                        <div class="bg-blue-950/80 rounded-lg p-4 space-y-3">
                            <!-- Header row -->
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-semibold text-blue-300">Student Overview</div>
                                <div class="text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full">● Active</div>
                            </div>
                            <!-- Progress bars -->
                            <div class="space-y-2">
                                <div>
                                    <div class="flex justify-between text-xs text-blue-400 mb-1"><span>Hours Completed</span><span>420/600</span></div>
                                    <div class="h-2 bg-blue-900 rounded-full"><div class="h-2 bg-gradient-to-r from-green-400 to-cyan-400 rounded-full" style="width:70%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs text-blue-400 mb-1"><span>Requirements</span><span>3/5 approved</span></div>
                                    <div class="h-2 bg-blue-900 rounded-full"><div class="h-2 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full" style="width:60%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs text-blue-400 mb-1"><span>Days Attended</span><span>42 days</span></div>
                                    <div class="h-2 bg-blue-900 rounded-full"><div class="h-2 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full" style="width:80%"></div></div>
                                </div>
                            </div>
                            <!-- Cards row -->
                            <div class="grid grid-cols-3 gap-2 pt-1">
                                <div class="bg-blue-800/40 rounded-lg p-2 text-center">
                                    <div class="text-lg font-bold text-green-300">70%</div>
                                    <div class="text-xs text-blue-500">Progress</div>
                                </div>
                                <div class="bg-blue-800/40 rounded-lg p-2 text-center">
                                    <div class="text-lg font-bold text-cyan-300">DTR</div>
                                    <div class="text-xs text-blue-500">Auto-gen</div>
                                </div>
                                <div class="bg-blue-800/40 rounded-lg p-2 text-center">
                                    <div class="text-lg font-bold text-yellow-300">Live</div>
                                    <div class="text-xs text-blue-500">Tracking</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Laptop base -->
                    <div class="mx-auto mt-1 h-3 bg-gradient-to-b from-blue-900 to-blue-950 rounded-b-xl" style="width:90%"></div>
                    <div class="mx-auto h-1.5 bg-blue-950 rounded-b-xl" style="width:70%"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="py-20 border-t border-blue-900/40" style="background:linear-gradient(180deg,#0a1a5c,#050d2e)">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-3">About the System</div>
                <h2 class="text-3xl font-bold text-white mb-4">Built for PRMSU Sta. Cruz<br>CCIT OJT Program</h2>
                <p class="text-blue-200 leading-relaxed mb-6">
                    Designed to fully digitize the OJT process — camera-based time-in/out with photo capture, daily task logging, requirements &amp; report submission, supervisor evaluations, DTR auto-generation, and full coordinator &amp; CCIT Head oversight.
                </p>
                <ul class="space-y-3 text-blue-200 text-sm">
                    <li class="flex items-center gap-3"><span class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center text-green-400 text-xs">✓</span> <span><span class="text-green-400 font-semibold">Students</span> — camera time-in/out, OJT hours tracking, task logs, requirements &amp; report uploads, DTR view</span></li>
                    <li class="flex items-center gap-3"><span class="w-6 h-6 bg-purple-500/20 rounded-full flex items-center justify-center text-purple-400 text-xs">✓</span> <span><span class="text-purple-400 font-semibold">Supervisors</span> — monitor assigned interns, approve/reject requirements &amp; reports, view attendance</span></li>
                    <li class="flex items-center gap-3"><span class="w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 text-xs">✓</span> <span><span class="text-orange-400 font-semibold">Coordinators</span> — oversee all students, view &amp; export DTR, manage companies, review reports</span></li>
                    <li class="flex items-center gap-3"><span class="w-6 h-6 bg-red-500/20 rounded-full flex items-center justify-center text-red-400 text-xs">✓</span> <span><span class="text-red-400 font-semibold">CCIT Head</span> — full analytics, user management, approve accounts, manage school years &amp; school IDs</span></li>
                </ul>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-900/20 border border-green-700/40 rounded-xl p-5 hover:border-green-500 transition-colors">
                    <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center text-green-400 text-sm">🎓</span></div>
                    <div class="text-xl font-bold text-green-400 mb-1">Student</div>
                    <div class="text-xs text-green-300/70">Camera Time-In · Hours · Tasks · DTR · Reports</div>
                </div>
                <div class="bg-purple-900/20 border border-purple-700/40 rounded-xl p-5 hover:border-purple-500 transition-colors">
                    <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center text-purple-400 text-sm">👔</span></div>
                    <div class="text-xl font-bold text-purple-400 mb-1">Supervisor</div>
                    <div class="text-xs text-purple-300/70">Intern monitoring · Approve/Reject submissions</div>
                </div>
                <div class="bg-orange-900/20 border border-orange-700/40 rounded-xl p-5 hover:border-orange-500 transition-colors">
                    <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center text-orange-400 text-sm">📋</span></div>
                    <div class="text-xl font-bold text-orange-400 mb-1">Coordinator</div>
                    <div class="text-xs text-orange-300/70">All students · DTR export · Companies · Reports</div>
                </div>
                <div class="bg-red-900/20 border border-red-700/40 rounded-xl p-5 hover:border-red-500 transition-colors">
                    <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center text-red-400 text-sm">🏫</span></div>
                    <div class="text-xl font-bold text-red-400 mb-1">CCIT Head</div>
                    <div class="text-xs text-red-300/70">Analytics · Users · School IDs · School Years</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="py-20 border-t border-blue-900/40" style="background:#050d2e">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <div class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-3">Features</div>
                <h2 class="text-3xl font-bold text-white">Everything You Need</h2>
                <p class="text-blue-300 mt-2">Manage the full OJT lifecycle in one platform</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z','title'=>'Camera Time-In / Out','desc'=>'Students clock in and out using their device camera. A photo is captured and stored with each attendance record for verification.','color'=>'cyan'],
                    ['icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','title'=>'OJT Hours & Progress Tracking','desc'=>'Real-time tracking of completed OJT hours against the 600-hour requirement, with visual progress bars and completion status per student.','color'=>'blue'],
                    ['icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','title'=>'Requirements & Report Submission','desc'=>'Students upload onboarding requirements and daily/weekly reports (PDF, Word, Excel, images). Supervisors and coordinators review and approve or reject each submission.','color'=>'green'],
                    ['icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','title'=>'Analytics Dashboard','desc'=>'Role-based dashboards with charts for student progress, completion rates, attendance trends, report statuses, and top companies.','color'=>'purple'],
                    ['icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','title'=>'DTR Auto-Generation','desc'=>'Daily Time Records are automatically generated from attendance logs. Coordinators and CCIT Head can view DTR inline or export as a Word document per student.','color'=>'yellow'],
                    ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','title'=>'School Year, IDs & User Management','desc'=>'CCIT Head manages school years, required OJT hours, approved school ID numbers, company assignments, and all user accounts with approval workflow.','color'=>'red'],
                ];
                $colors = ['blue'=>'from-blue-500 to-blue-700','cyan'=>'from-cyan-500 to-blue-600','purple'=>'from-purple-500 to-blue-600','green'=>'from-green-500 to-cyan-600','yellow'=>'from-yellow-500 to-orange-500','red'=>'from-red-500 to-pink-600'];
                @endphp
                @foreach($features as $f)
                <div class="bg-blue-900/20 border border-blue-800/40 rounded-xl p-6 hover:border-blue-500/60 hover:bg-blue-900/30 transition-all group">
                    <div class="w-11 h-11 rounded-lg bg-gradient-to-br {{ $colors[$f['color']] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">{{ $f['title'] }}</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

   
    <!-- CONTACT -->
    <section id="contact" class="py-20 border-t border-blue-900/40" style="background:linear-gradient(180deg,#050d2e,#030a1e)">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <div class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-3">Contact</div>
                <h2 class="text-3xl font-bold text-white">Get in Touch</h2>
                <p class="text-blue-300 mt-2">For concerns, issues, or inquiries about the OJT Monitoring System</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-blue-900/20 border border-blue-800/40 rounded-xl p-6 text-center hover:border-blue-500/60 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Location</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">PRMSU Sta. Cruz Campus<br>Sta. Cruz, Zambales<br>Philippines</p>
                </div>
                <div class="bg-blue-900/20 border border-blue-800/40 rounded-xl p-6 text-center hover:border-blue-500/60 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Department</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">College of Computing &amp;<br>Information Technology<br><span class="text-blue-400 font-medium">(CCIT Department)</span></p>
                </div>
                <div class="bg-blue-900/20 border border-blue-800/40 rounded-xl p-6 text-center hover:border-blue-500/60 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">System Support</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">For account issues &amp; technical concerns, contact your<br><span class="text-blue-400 font-medium">OJT Coordinator</span> or<br><span class="text-blue-400 font-medium">CCIT Head</span></p>
                </div>
            </div>
            <div class="mt-10 max-w-2xl mx-auto bg-blue-900/20 border border-blue-800/40 rounded-xl p-5 text-center">
                <p class="text-blue-300 text-sm">📌 This system is exclusively for <span class="text-white font-semibold">PRMSU Sta. Cruz Campus — CCIT students and faculty</span>. Registration requires a valid school-issued ID number provided by the CCIT department.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 border-t border-blue-900/40 relative overflow-hidden" style="background:linear-gradient(135deg,#0a1a5c,#0d2d8a)">
        <div class="dot-pattern absolute inset-0 opacity-30"></div>
        <div class="relative max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
            <p class="text-blue-200 mb-8">Register with your school-issued ID number, select your role, and start tracking your OJT journey. Accounts require CCIT Head approval. Secured with strong password protection.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-400 hover:to-blue-600 rounded-full font-semibold text-white transition-all glow-btn transform hover:scale-105">
                    Create Account
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3 border border-blue-400/60 text-blue-200 hover:text-white hover:border-blue-300 rounded-full font-semibold transition-all">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-blue-900/40 py-10" style="background:#030a1e">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-400 to-blue-700 flex items-center justify-center">
                    <span class="text-white font-bold text-xs">OMS</span>
                </div>
                <span class="text-blue-200 text-sm font-semibold">PRMSU Sta. Cruz — OJT Monitoring System</span>
            </div>
            <div class="flex gap-6 text-sm text-blue-400">
                <a href="#" class="hover:text-white transition-colors">Home</a>
                <a href="#about" class="hover:text-white transition-colors">About</a>
                <a href="#features" class="hover:text-white transition-colors">Features</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
            </div>
            <p class="text-blue-600 text-xs">&copy; {{ date('Y') }} PRMSU Sta. Cruz Campus. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleTheme() {
            const isLight = document.body.classList.toggle('light');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            document.getElementById('iconMoon').classList.toggle('hidden', isLight);
            document.getElementById('iconSun').classList.toggle('hidden', !isLight);
        }
        (function() {
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light');
                document.getElementById('iconMoon').classList.add('hidden');
                document.getElementById('iconSun').classList.remove('hidden');
            }
        })();
    </script>
</body>
</html>
