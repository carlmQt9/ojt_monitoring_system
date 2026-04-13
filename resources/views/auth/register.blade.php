<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: linear-gradient(135deg, #0a0e2e 0%, #0d1b4b 40%, #0a2a6e 70%, #0d3b8e 100%); transition: background 0.3s; }
        .dot-pattern { background-image: radial-gradient(circle, rgba(99,179,237,0.15) 1px, transparent 1px); background-size: 24px 24px; }
        .card { background: rgba(10, 26, 92, 0.6); backdrop-filter: blur(16px); border: 1px solid rgba(59,130,246,0.2); transition: background 0.3s; }
        .input-field { background: rgba(255,255,255,0.05); border: 1px solid rgba(59,130,246,0.25); color: white; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .input-field::placeholder { color: rgba(147,197,253,0.4); }
        .input-field option { background: #0d1b4b; color: white; }
        .glow-btn { box-shadow: 0 0 20px rgba(59,130,246,0.4); }
        select.appearance-none { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
        select option { background: #0a1a5c; color: #fff; padding: 8px; }
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { visibility: hidden; display: none !important; pointer-events: none; }
        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg, #b8cef0 0%, #a0bce8 40%, #b8d4f5 70%, #cce0fa 100%); color: #0f2460; }
        body.light .text-white,body.light .text-gray-100,body.light .text-gray-200 { color: #0f2460 !important; }
        body.light .text-gray-300 { color: #1e3a5f !important; }
        body.light .text-gray-400 { color: #2d4f7a !important; }
        body.light .text-gray-500 { color: #3d5f8a !important; }
        body.light .text-blue-100,body.light .text-blue-200 { color: #1e40af !important; }
        body.light .text-blue-300 { color: #1d4ed8 !important; }
        body.light .text-blue-400 { color: #1a3fcc !important; }
        body.light .text-blue-500,body.light .text-blue-600 { color: #1e3a8a !important; }
        body.light .text-blue-200\/70 { color: #1e3a8a !important; }
        body.light .text-green-100,body.light .text-green-200,body.light .text-green-300 { color: #166534 !important; }
        body.light .text-green-400 { color: #15803d !important; }
        body.light .text-red-100,body.light .text-red-200,body.light .text-red-300 { color: #991b1b !important; }
        body.light .text-red-400 { color: #b91c1c !important; }
        body.light .text-yellow-100,body.light .text-yellow-200,body.light .text-yellow-300 { color: #92400e !important; }
        body.light .text-yellow-400 { color: #b45309 !important; }
        body.light .text-orange-100,body.light .text-orange-200,body.light .text-orange-300 { color: #9a3412 !important; }
        body.light .text-orange-400 { color: #c2410c !important; }
        body.light .text-purple-100,body.light .text-purple-200,body.light .text-purple-300 { color: #5b21b6 !important; }
        body.light .text-purple-400 { color: #6d28d9 !important; }
        body.light .text-cyan-300,body.light .text-cyan-400 { color: #0369a1 !important; }
        body.light .text-green-300\/60 { color: #166534 !important; }
        body.light .text-purple-300\/60 { color: #5b21b6 !important; }
        body.light .text-orange-300\/60 { color: #9a3412 !important; }
        body.light .text-red-300\/60 { color: #991b1b !important; }
        body.light .card { background: rgba(220,235,255,0.95) !important; border-color: #6a9fd0 !important; }
        body.light .input-field { background: rgba(255,255,255,0.95) !important; border-color: #6a9fd0 !important; color: #0f2460 !important; }
        body.light .input-field::placeholder { color: #7aaad4 !important; }
        body.light .input-field option { background: #fff; color: #0f2460; }
        body.light [style*="background:linear-gradient(135deg,#050d2e"] { background: linear-gradient(135deg,#a8c4e8,#93b8e0,#bdd4f0) !important; }
        body.light [style*="border:1px solid rgba(59,130,246,0.2)"] { border-color: #6a9fd0 !important; }
        body.light .bg-green-900\/30 { background: rgba(187,247,208,0.6) !important; }
        body.light .bg-purple-900\/30 { background: rgba(233,213,255,0.6) !important; }
        body.light .bg-orange-900\/30 { background: rgba(254,215,170,0.6) !important; }
        body.light .bg-red-900\/30 { background: rgba(254,202,202,0.6) !important; }
        body.light .border-green-700\/40 { border-color: rgba(21,128,61,0.5) !important; }
        body.light .border-purple-700\/40 { border-color: rgba(109,40,217,0.5) !important; }
        body.light .border-orange-700\/40 { border-color: rgba(194,65,12,0.5) !important; }
        body.light .border-red-700\/40 { border-color: rgba(185,28,28,0.5) !important; }
        /* Navbar light mode */
        body.light nav { background: rgba(220,235,255,0.97) !important; border-color: #7aaad4 !important; }
        body.light nav span,body.light nav a,body.light nav p,body.light nav button { color: #0f2460 !important; }
        body.light nav .text-blue-400 { color: #1d4ed8 !important; }
        body.light nav a[class*="bg-blue-6"] { color: #fff !important; }
        body.light nav a[class*="border-blue-5"] { color: #1e3a8a !important; }
        /* Mobile menu */
        body.light #mobileMenu { background: rgba(220,235,255,0.99) !important; }
        body.light #mobileMenu a { color: #0f2460 !important; }
        body.light #mobileMenu a:hover { background: rgba(100,150,210,0.2) !important; }
        /* Role / Company / School Year dropdown menus */
        body.light #roleDropdownMenu,
        body.light #companyDropdownMenu,
        body.light #schoolYearDropdownMenu { background: #fff !important; border-color: #7aaad4 !important; box-shadow: 0 8px 32px rgba(30,58,138,0.12) !important; }
        body.light #roleDropdownMenu button,
        body.light #companyDropdownMenu button,
        body.light #schoolYearDropdownMenu button { color: #0f2460 !important; border-color: rgba(100,150,210,0.3) !important; }
        body.light #roleDropdownMenu button:hover,
        body.light #companyDropdownMenu button:hover,
        body.light #schoolYearDropdownMenu button:hover { background: rgba(59,130,246,0.08) !important; }
        body.light #roleDropdownMenu button div,
        body.light #roleDropdownMenu button span,
        body.light #companyDropdownMenu button span,
        body.light #schoolYearDropdownMenu button div,
        body.light #schoolYearDropdownMenu button span { color: #0f2460 !important; }
        body.light #roleDropdownMenu button .text-xs { color: #4a6080 !important; }
        /* Pending notice */
        body.light #pendingNotice { background: rgba(254,243,199,0.8) !important; border-color: rgba(180,130,0,0.5) !important; }
        body.light #pendingNotice p,body.light #pendingNotice span { color: #78350f !important; }
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-4 pt-20 relative overflow-auto">
    <div class="dot-pattern absolute inset-0 opacity-40"></div>
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-800 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-800 rounded-full blur-3xl opacity-20"></div>

    <!-- Landing page navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-blue-900/50" style="background:rgba(5,13,46,0.92);backdrop-filter:blur(12px)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14 sm:h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg object-cover">
                <span class="font-bold text-white text-xs sm:text-sm leading-tight">PRMSU <span class="text-blue-400">OJT</span> Monitoring System</span>
            </div>
            <!-- Desktop links -->
            <div class="hidden md:flex items-center gap-8 text-sm text-blue-200">
                <a href="/" class="hover:text-white transition-colors">Home</a>
                <a href="/#about" class="hover:text-white transition-colors">About</a>
                <a href="/#features" class="hover:text-white transition-colors">Features</a>
                <a href="/#contact" class="hover:text-white transition-colors">Contact</a>
            </div>
            <!-- Right side -->
            <div class="flex items-center gap-2">
                <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center border border-blue-500/50 text-blue-300 hover:text-white hover:border-blue-400 transition-all" style="background:rgba(10,26,92,0.7)">
                    <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                </button>
                <!-- Desktop auth buttons -->
                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-4 py-1.5 border border-blue-500 text-blue-300 hover:text-white hover:border-blue-400 rounded-full text-sm font-semibold transition-all">Log in</a>
                <a href="{{ route('register') }}" class="hidden sm:inline-flex px-4 py-1.5 bg-blue-600 hover:bg-blue-500 rounded-full text-sm font-semibold transition-all">Register</a>
                <!-- Mobile hamburger -->
                <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden w-8 h-8 flex items-center justify-center text-blue-300 hover:text-white transition-colors">
                    <svg id="hamburgerIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="closeIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <!-- Mobile dropdown menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-blue-900/50 px-4 py-3 space-y-1" style="background:rgba(5,13,46,0.97)">
            <a href="/" class="block px-3 py-2 rounded-lg text-sm text-blue-200 hover:text-white hover:bg-blue-800/40 transition-colors">Home</a>
            <a href="/#about" class="block px-3 py-2 rounded-lg text-sm text-blue-200 hover:text-white hover:bg-blue-800/40 transition-colors">About</a>
            <a href="/#features" class="block px-3 py-2 rounded-lg text-sm text-blue-200 hover:text-white hover:bg-blue-800/40 transition-colors">Features</a>
            <a href="/#contact" class="block px-3 py-2 rounded-lg text-sm text-blue-200 hover:text-white hover:bg-blue-800/40 transition-colors">Contact</a>
            <div class="flex gap-2 pt-2 border-t border-blue-900/50">
                <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2 border border-blue-500 text-blue-300 hover:text-white rounded-full text-sm font-semibold transition-all">Log in</a>
                <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-full text-sm font-semibold transition-all">Register</a>
            </div>
        </div>
    </nav>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const ham  = document.getElementById('hamburgerIcon');
            const cls  = document.getElementById('closeIcon');
            const open = menu.classList.toggle('hidden');
            ham.classList.toggle('hidden', !open);
            cls.classList.toggle('hidden', open);
        }
    </script>

    @include('partials.success-popup')

    <div class="relative w-full max-w-5xl flex flex-col md:flex-row rounded-3xl overflow-hidden shadow-2xl my-6" style="border:1px solid rgba(59,130,246,0.2)">

        <!-- Left Panel — hidden on mobile -->
        <div class="hidden md:flex w-full md:w-5/12 flex-col items-center justify-center p-10 md:p-12 relative overflow-hidden" style="background:linear-gradient(135deg,#050d2e,#0a1a5c,#0d2d8a)">
            <div class="absolute top-0 left-0 w-full h-full dot-pattern opacity-30"></div>
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-500 rounded-full blur-3xl opacity-20"></div>
            <div class="relative z-10 text-center space-y-5">
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-12 h-12 rounded-lg overflow-hidden" style="box-shadow:0 0 30px rgba(59,130,246,0.4)">
                        <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-full h-full object-cover">
                    </div>
                    <span class="font-bold text-white text-xl leading-tight">PRMSU <span class="text-blue-400">OJT</span> System</span>
                </div>
                <p class="text-blue-200/70 text-sm max-w-xs mx-auto hidden md:block">
                    Join the platform to track your internship journey with ease.
                </p>
                <div class="hidden md:flex justify-center gap-5 pt-2 text-xs text-blue-400">
                    <div class="text-center"><div class="text-xl font-bold text-white">600</div>OJT Hours</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">DTR</div>Reports</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">Live</div>Tracking</div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-7/12 p-5 sm:p-8 md:p-10 flex flex-col justify-center card">

            <!-- Mobile-only logo header -->
            <div class="flex items-center gap-3 mb-5 md:hidden">
                <div class="w-9 h-9 rounded-lg overflow-hidden shrink-0">
                    <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-full h-full object-cover">
                </div>
                <span class="font-bold text-white text-base leading-tight">PRMSU <span class="text-blue-400">OJT</span> System</span>
            </div>

            <div class="mb-4">
                <h2 class="text-xl sm:text-2xl font-bold text-white">Create Account</h2>
                <p class="text-blue-300 text-sm mt-1">Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Sign in</a></p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Full Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="John Doe" maxlength="100" minlength="2">
                        @error('name')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="your@email.com" maxlength="255">
                        @error('email')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Role</label>
                    {{-- Hidden real input for form submission --}}
                    <input type="hidden" name="role" id="role" value="{{ old('role') }}">
                    {{-- Custom dropdown --}}
                    <div class="relative" id="roleDropdown">
                        <button type="button" onclick="toggleRoleDropdown()"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm flex items-center justify-between gap-2 text-left"
                            id="roleDropdownBtn">
                            <span id="roleDropdownLabel" class="flex items-center gap-2.5">
                                <span id="roleDropdownIcon" class="text-base">👤</span>
                                <span id="roleDropdownText" class="text-blue-300/60">Select a role</span>
                            </span>
                            <svg id="roleDropdownArrow" class="w-4 h-4 text-blue-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="roleDropdownMenu"
                            class="hidden absolute z-50 w-full mt-1.5 rounded-xl overflow-hidden shadow-2xl"
                            style="background:rgba(8,20,70,0.98);border:1px solid rgba(59,130,246,0.35);backdrop-filter:blur(16px)">
                            @php
                            $roleOptions = [
                                ['value'=>'student',     'icon'=>'🎓', 'label'=>'Student',     'sub'=>'Track OJT hours & submit requirements'],
                                ['value'=>'supervisor',  'icon'=>'👔', 'label'=>'Supervisor',   'sub'=>'Monitor & evaluate assigned interns'],
                                ['value'=>'coordinator', 'icon'=>'📋', 'label'=>'Coordinator',  'sub'=>'Oversee all students & manage companies'],
                                ['value'=>'ccit_head',   'icon'=>'🏫', 'label'=>'CCIT Head',    'sub'=>'Full system administration & analytics'],
                            ];
                            @endphp
                            @foreach($roleOptions as $opt)
                            <button type="button"
                                onclick="selectRole('{{ $opt['value'] }}','{{ $opt['icon'] }}','{{ $opt['label'] }}')"
                                class="role-option w-full flex items-center gap-3 px-4 py-3 text-left transition-all hover:bg-blue-600/20 border-b border-blue-900/40 last:border-0
                                    {{ old('role') == $opt['value'] ? 'bg-blue-600/20' : '' }}"
                                data-value="{{ $opt['value'] }}">
                                <span class="text-xl shrink-0">{{ $opt['icon'] }}</span>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-white">{{ $opt['label'] }}</div>
                                    <div class="text-xs text-blue-400/70 truncate">{{ $opt['sub'] }}</div>
                                </div>
                                <svg class="role-check w-4 h-4 text-blue-400 ml-auto shrink-0 {{ old('role') == $opt['value'] ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @error('role')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div id="companySection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Company / Organization</label>
                    <input type="hidden" name="company_id" id="company_id" value="{{ old('company_id') }}">
                    <div class="relative" id="companyDropdown">
                        <button type="button" onclick="toggleDropdown('companyDropdown')"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm flex items-center justify-between gap-2 text-left">
                            <span id="companyDropdownLabel" class="flex items-center gap-2.5">
                                <span class="text-base">🏢</span>
                                <span id="companyDropdownText" class="text-blue-300/60">Select your company</span>
                            </span>
                            <svg id="companyDropdownArrow" class="w-4 h-4 text-blue-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="companyDropdownMenu"
                            class="hidden absolute z-50 w-full mt-1.5 rounded-xl overflow-hidden shadow-2xl max-h-52 overflow-y-auto"
                            style="background:rgba(8,20,70,0.98);border:1px solid rgba(59,130,246,0.35);backdrop-filter:blur(16px)">
                            <?php $companies = \App\Models\Company::orderBy('name')->get(); ?>
                            @if($companies->isEmpty())
                                <div class="px-4 py-3 text-sm text-blue-400/60 text-center">No companies available</div>
                            @else
                                @foreach($companies as $company)
                                <button type="button"
                                    onclick="selectDropdown('companyDropdown','company_id','{{ $company->id }}','🏢','{{ addslashes($company->name) }}')"
                                    class="custom-option w-full flex items-center gap-3 px-4 py-2.5 text-left transition-all hover:bg-blue-600/20 border-b border-blue-900/40 last:border-0 {{ old('company_id') == $company->id ? 'bg-blue-600/20' : '' }}"
                                    data-value="{{ $company->id }}">
                                    <span class="text-lg shrink-0">🏢</span>
                                    <span class="text-sm text-white truncate">{{ $company->name }}</span>
                                    <svg class="option-check w-4 h-4 text-blue-400 ml-auto shrink-0 {{ old('company_id') == $company->id ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @error('company_id')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <?php $schoolYears = \App\Models\SchoolYear::orderBy('label', 'desc')->get(); ?>
                @if($schoolYears->isNotEmpty())
                <div id="schoolYearSection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">School Year</label>
                    <input type="hidden" name="school_year" id="school_year" value="{{ old('school_year', $schoolYears->firstWhere('is_active', true)?->label ?? '') }}">
                    <div class="relative" id="schoolYearDropdown">
                        <button type="button" onclick="toggleDropdown('schoolYearDropdown')"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm flex items-center justify-between gap-2 text-left">
                            <span id="schoolYearDropdownLabel" class="flex items-center gap-2.5">
                                <span class="text-base">📅</span>
                                <span id="schoolYearDropdownText" class="text-blue-300/60">Select school year</span>
                            </span>
                            <svg id="schoolYearDropdownArrow" class="w-4 h-4 text-blue-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="schoolYearDropdownMenu"
                            class="hidden absolute z-50 w-full mt-1.5 rounded-xl overflow-hidden shadow-2xl"
                            style="background:rgba(8,20,70,0.98);border:1px solid rgba(59,130,246,0.35);backdrop-filter:blur(16px)">
                            @foreach($schoolYears as $sy)
                            <button type="button"
                                onclick="selectDropdown('schoolYearDropdown','school_year','{{ $sy->label }}','📅','{{ $sy->label }}{{ $sy->is_active ? ' ★' : '' }}')"
                                class="custom-option w-full flex items-center gap-3 px-4 py-2.5 text-left transition-all hover:bg-blue-600/20 border-b border-blue-900/40 last:border-0 {{ (old('school_year', $schoolYears->firstWhere('is_active',true)?->label) == $sy->label) ? 'bg-blue-600/20' : '' }}"
                                data-value="{{ $sy->label }}">
                                <span class="text-lg shrink-0">📅</span>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-white">{{ $sy->label }}</div>
                                    @if($sy->is_active)<div class="text-xs text-green-400">★ Active Year</div>@endif
                                </div>
                                <svg class="option-check w-4 h-4 text-blue-400 ml-auto shrink-0 {{ (old('school_year', $schoolYears->firstWhere('is_active',true)?->label) == $sy->label) ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @error('school_year')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>
                @endif

                <div id="schoolIdSection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">School ID Number</label>
                    <input type="text" name="school_id_number" id="school_id_number"
                        value="{{ old('school_id_number') }}"
                        class="input-field w-full px-4 py-2.5 rounded-xl text-sm font-mono"
                        placeholder="e.g. 23-1-2-0001" maxlength="20">
                    @error('school_id_number')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="reg_password" required
                                class="input-field w-full px-4 py-2.5 pr-11 rounded-xl text-sm"
                                placeholder="••••••••" minlength="8" maxlength="128"
                                oninput="checkPasswordStrength(this.value)">
                            <button type="button" onclick="togglePw('reg_password','eyeReg1')" tabindex="-1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-200 transition-colors">
                                <svg id="eyeReg1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Strength meter -->
                        <div class="mt-1.5 space-y-1">
                            <div class="flex gap-1">
                                <div id="ps1" class="h-1 flex-1 rounded-full bg-slate-600 transition-colors"></div>
                                <div id="ps2" class="h-1 flex-1 rounded-full bg-slate-600 transition-colors"></div>
                                <div id="ps3" class="h-1 flex-1 rounded-full bg-slate-600 transition-colors"></div>
                                <div id="ps4" class="h-1 flex-1 rounded-full bg-slate-600 transition-colors"></div>
                            </div>
                            <p id="ps_label" class="text-xs text-gray-500">Min 8 chars · A-Z · a-z · 0-9 · symbol (!@#$%^&*)</p>
                        </div>
                        @error('password')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="reg_password_confirmation" required
                                class="input-field w-full px-4 py-2.5 pr-11 rounded-xl text-sm"
                                placeholder="••••••••" minlength="8" maxlength="128"
                                oninput="checkPasswordMatch()">
                            <button type="button" onclick="togglePw('reg_password_confirmation','eyeReg2')" tabindex="-1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-200 transition-colors">
                                <svg id="eyeReg2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        <p id="pw_match" class="text-xs mt-1 hidden"></p>
                    </div>
                </div>

                <div class="flex items-start gap-2">
                    <input type="checkbox" name="terms" id="terms" required
                        class="w-4 h-4 mt-0.5 rounded border-blue-700 bg-blue-900/50 text-blue-500 cursor-pointer">
                    <label for="terms" class="text-sm text-blue-300">
                        I agree to the <button type="button" onclick="openTermsModal()" class="text-blue-400 hover:text-blue-300 underline font-semibold">Terms of Service &amp; Privacy Policy</button>
                    </label>
                    @error('terms')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div id="pendingNotice" class="hidden items-start gap-2 px-4 py-3 rounded-xl bg-yellow-500/10 border border-yellow-500/40">
                    <span class="text-yellow-400 text-lg leading-none mt-0.5">⏳</span>
                    <p class="text-yellow-300 text-xs">As a <strong id="pendingRoleLabel"></strong>, your account will require approval from the CCIT Head before you can log in. You will be notified once approved.</p>
                </div>


                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-400 hover:to-blue-600 text-white font-bold rounded-xl transition-all glow-btn transform hover:scale-[1.02] active:scale-[0.98]">
                    Create Account
                </button>

                <div class="text-center">
                </div>
            </form>
        </div>
    </div>
    </div>{{-- end centering wrapper --}}

    <script>
        // Custom role dropdown
        function toggleRoleDropdown() { toggleDropdown('roleDropdown'); }
        function selectRole(value, icon, label) {
            document.getElementById('role').value = value;
            document.getElementById('roleDropdownIcon').textContent = icon;
            document.getElementById('roleDropdownText').textContent = label;
            document.getElementById('roleDropdownText').classList.remove('text-blue-300/60');
            document.getElementById('roleDropdownText').classList.add('text-white');
            // update checkmarks
            document.querySelectorAll('.role-option').forEach(btn => {
                const check = btn.querySelector('.role-check');
                if (btn.dataset.value === value) {
                    btn.classList.add('bg-blue-600/20');
                    check.classList.remove('hidden');
                } else {
                    btn.classList.remove('bg-blue-600/20');
                    check.classList.add('hidden');
                }
            });
            toggleRoleDropdown();
            updateFormVisibility();
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            ['roleDropdown','companyDropdown','schoolYearDropdown'].forEach(id => {
                const dd = document.getElementById(id);
                if (dd && !dd.contains(e.target)) {
                    const menu = document.getElementById(id + 'Menu');
                    const arrow = document.getElementById(id + 'Arrow');
                    if (menu) menu.classList.add('hidden');
                    if (arrow) arrow.style.transform = '';
                }
            });
        });

        // Generic dropdown toggle
        function toggleDropdown(id) {
            const menu = document.getElementById(id + 'Menu');
            const arrow = document.getElementById(id + 'Arrow');
            // close all others first
            ['roleDropdown','companyDropdown','schoolYearDropdown'].forEach(other => {
                if (other !== id) {
                    const m = document.getElementById(other + 'Menu');
                    const a = document.getElementById(other + 'Arrow');
                    if (m) m.classList.add('hidden');
                    if (a) a.style.transform = '';
                }
            });
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden', isOpen);
            arrow.style.transform = isOpen ? '' : 'rotate(180deg)';
        }

        // Generic option select
        function selectDropdown(dropdownId, inputId, value, icon, label) {
            document.getElementById(inputId).value = value;
            document.getElementById(dropdownId + 'Text').textContent = label;
            document.getElementById(dropdownId + 'Text').classList.remove('text-blue-300/60');
            document.getElementById(dropdownId + 'Text').classList.add('text-white');
            // update checkmarks within this dropdown
            const menu = document.getElementById(dropdownId + 'Menu');
            menu.querySelectorAll('.custom-option').forEach(btn => {
                const check = btn.querySelector('.option-check');
                if (btn.dataset.value == value) {
                    btn.classList.add('bg-blue-600/20');
                    check.classList.remove('hidden');
                } else {
                    btn.classList.remove('bg-blue-600/20');
                    check.classList.add('hidden');
                }
            });
            toggleDropdown(dropdownId);
        }
        // Init label if old value exists
        (function() {
            const oldRole = document.getElementById('role').value;
            if (oldRole) {
                const map = {student:['🎓','Student'],supervisor:['👔','Supervisor'],coordinator:['📋','Coordinator'],ccit_head:['🏫','CCIT Head']};
                if (map[oldRole]) selectRole(oldRole, map[oldRole][0], map[oldRole][1]);
            }
            // Init school year label
            const syInput = document.getElementById('school_year');
            if (syInput && syInput.value) {
                const syText = document.getElementById('schoolYearDropdownText');
                if (syText) {
                    syText.textContent = syInput.value;
                    syText.classList.remove('text-blue-300/60');
                    syText.classList.add('text-white');
                }
            }
            // Init company label
            const coInput = document.getElementById('company_id');
            if (coInput && coInput.value) {
                const btn = document.querySelector(`#companyDropdownMenu [data-value="${coInput.value}"]`);
                if (btn) {
                    const name = btn.querySelector('span.text-sm')?.textContent?.trim();
                    if (name) {
                        const t = document.getElementById('companyDropdownText');
                        t.textContent = name; t.classList.remove('text-blue-300/60'); t.classList.add('text-white');
                    }
                }
            }
        })();

        function togglePw(id, iconId) {
            const input = document.getElementById(id);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = document.getElementById(iconId);
            icon.innerHTML = show
                ? '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>';
        }
        function checkPasswordStrength(val) {
            const bars = [document.getElementById('ps1'),document.getElementById('ps2'),document.getElementById('ps3'),document.getElementById('ps4')];
            const label = document.getElementById('ps_label');
            let score = 0;
            const checks = [
                val.length >= 8,
                /[A-Z]/.test(val) && /[a-z]/.test(val),
                /\d/.test(val),
                /[\W_]/.test(val)
            ];
            checks.forEach(c => { if(c) score++; });
            const colors = ['bg-slate-600','bg-red-500','bg-orange-400','bg-yellow-400','bg-green-500'];
            const labels = ['','Weak — add uppercase, number & symbol','Fair — add number & symbol','Good — add a symbol','Strong ✓'];
            const labelColors = ['text-gray-500','text-red-400','text-orange-400','text-yellow-400','text-green-400'];
            bars.forEach((b,i) => {
                b.className = 'h-1 flex-1 rounded-full transition-colors ' + (i < score ? colors[score] : 'bg-slate-600');
            });
            label.textContent = val.length === 0 ? 'Min 8 chars · A-Z · a-z · 0-9 · symbol (!@#$%^&*)' : labels[score];
            label.className = 'text-xs ' + (val.length === 0 ? 'text-gray-500' : labelColors[score]);
        }
        function checkPasswordMatch() {
            const pw = document.getElementById('reg_password').value;
            const cf = document.getElementById('reg_password_confirmation').value;
            const el = document.getElementById('pw_match');
            if (!cf) { el.classList.add('hidden'); return; }
            el.classList.remove('hidden');
            if (pw === cf) { el.textContent = '✓ Passwords match'; el.className = 'text-xs mt-1 text-green-400'; }
            else { el.textContent = '✗ Passwords do not match'; el.className = 'text-xs mt-1 text-red-400'; }
        }
    </script>
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
    <script>
        function updateFormVisibility() {
            const role = document.getElementById('role').value;
            const companySection = document.getElementById('companySection');
            const companyInput = document.getElementById('company_id');
            const schoolYearSection = document.getElementById('schoolYearSection');
            const schoolYearInput = document.getElementById('school_year');
            const schoolIdSection = document.getElementById('schoolIdSection');
            const schoolIdInput = document.getElementById('school_id_number');
            const pendingNotice = document.getElementById('pendingNotice');
            const pendingRoleLabel = document.getElementById('pendingRoleLabel');

            if (role === 'student' || role === 'supervisor') {
                companySection.classList.remove('hidden');
                companyInput.required = true;
            } else {
                companySection.classList.add('hidden');
                companyInput.required = false;
                companyInput.value = '';
                const ct = document.getElementById('companyDropdownText');
                if (ct) { ct.textContent = 'Select your company'; ct.classList.add('text-blue-300/60'); ct.classList.remove('text-white'); }
            }

            if (schoolYearSection) {
                if (role === 'student' || role === 'supervisor' || role === 'coordinator' || role === 'ccit_head') {
                    schoolYearSection.classList.remove('hidden');
                } else {
                    schoolYearSection.classList.add('hidden');
                    if (schoolYearInput) schoolYearInput.value = '';
                    const st = document.getElementById('schoolYearDropdownText');
                    if (st) { st.textContent = 'Select school year'; st.classList.add('text-blue-300/60'); st.classList.remove('text-white'); }
                }
            }

            if (schoolIdSection) {
                if (role === 'student') {
                    schoolIdSection.classList.remove('hidden');
                    schoolIdInput.required = true;
                } else {
                    schoolIdSection.classList.add('hidden');
                    schoolIdInput.required = false;
                    schoolIdInput.value = '';
                }
            }

            const needsApproval = ['supervisor', 'coordinator', 'ccit_head'].includes(role);
            if (needsApproval) {
                pendingNotice.classList.remove('hidden');
                pendingNotice.classList.add('flex');
                pendingRoleLabel.textContent = role.replace('_', ' ');
            } else {
                pendingNotice.classList.add('hidden');
                pendingNotice.classList.remove('flex');
            }
        }
        document.addEventListener('DOMContentLoaded', updateFormVisibility);
    </script>

    <!-- Terms & Privacy Modal -->
    <div id="termsModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-slate-900 border border-blue-700/50 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-blue-800/50 shrink-0">
                <h2 class="text-lg font-bold text-white">📋 Terms of Service &amp; Privacy Policy</h2>
                <button onclick="closeTermsModal()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-300 hover:text-white text-lg">&times;</button>
            </div>
            <!-- Content -->
            <div class="flex-1 overflow-y-auto px-6 py-4 text-sm text-gray-300 space-y-5">

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">1. Acceptance of Terms</h3>
                    <p>By registering and using the PRMSU Sta. Cruz OJT Monitoring System, you agree to comply with and be bound by these Terms of Service. If you do not agree, please do not use this system.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">2. Purpose of the System</h3>
                    <p>This system is developed exclusively for the <strong class="text-white">PRMSU Sta. Cruz Campus — BSCS Program</strong> to digitize and manage On-the-Job Training (OJT) activities including time-in/out tracking, daily logs, requirements submission, supervisor evaluations, and DTR generation.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">3. User Responsibilities</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>You must provide accurate and truthful information during registration.</li>
                        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                        <li>You must not share your account with others.</li>
                        <li>You must not use this system for any unauthorized or illegal purposes.</li>
                        <li>Students must only record their own attendance and submissions.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">4. Camera &amp; Photo Usage</h3>
                    <p>This system requires camera access for time-in/out verification. Photos captured are stored securely and used solely for attendance verification purposes. By using the time-in feature, you consent to your photo being captured and stored.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">5. Account Approval</h3>
                    <p>All accounts require approval from the CCIT Head or Coordinator before access is granted. The system administrators reserve the right to deny or revoke access at any time.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">6. Prohibited Activities</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Falsifying attendance records or time logs.</li>
                        <li>Uploading inappropriate, offensive, or irrelevant files.</li>
                        <li>Attempting to access other users' accounts or data.</li>
                        <li>Tampering with or manipulating system data.</li>
                    </ul>
                </div>

                <hr class="border-blue-800/50">

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">🔒 Privacy Policy — Data Privacy Act of 2012 (R.A. 10173)</h3>
                    <p>In compliance with the <strong class="text-white">Republic Act No. 10173</strong>, also known as the <strong class="text-white">Data Privacy Act of 2012</strong> of the Philippines, we are committed to protecting your personal information.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">7. Data We Collect</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Full name, email address, and school ID number</li>
                        <li>Company/organization assignment</li>
                        <li>Time-in/out records and attendance photos</li>
                        <li>Daily task logs and OJT hours</li>
                        <li>Uploaded requirement documents</li>
                        <li>Supervisor evaluations and feedback</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">8. How We Use Your Data</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>To monitor and track OJT progress and attendance</li>
                        <li>To generate Daily Time Records (DTR)</li>
                        <li>To facilitate communication between students, supervisors, and coordinators</li>
                        <li>To comply with PRMSU academic requirements</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">9. Data Protection</h3>
                    <p>Your personal data is stored securely and accessed only by authorized personnel (Coordinators and CCIT Head). We implement appropriate technical and organizational measures to protect your data against unauthorized access, alteration, or disclosure.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">10. Your Rights Under R.A. 10173</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong class="text-white">Right to be informed</strong> — You have the right to know how your data is collected and used.</li>
                        <li><strong class="text-white">Right to access</strong> — You may request access to your personal data.</li>
                        <li><strong class="text-white">Right to correction</strong> — You may request correction of inaccurate data.</li>
                        <li><strong class="text-white">Right to erasure</strong> — You may request deletion of your data after OJT completion.</li>
                        <li><strong class="text-white">Right to data portability</strong> — You may request a copy of your data.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">11. Data Retention</h3>
                    <p>Personal data collected through this system will be retained for the duration of the OJT program and for a reasonable period thereafter as required by PRMSU academic records policy.</p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-bold text-base mb-2">12. Contact</h3>
                    <p>For concerns regarding your personal data or these terms, please contact the <strong class="text-white">CCIT Department — PRMSU Sta. Cruz Campus</strong>.</p>
                </div>

                <div class="bg-blue-900/20 border border-blue-700/40 rounded-lg p-3 text-xs text-blue-300">
                    <p>📅 Last updated: {{ date('F Y') }} &nbsp;|&nbsp; PRMSU Sta. Cruz Campus — BSCS OJT Monitoring System</p>
                </div>

            </div>
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-blue-800/50 shrink-0 flex gap-3">
                <button onclick="closeTermsModal()" class="flex-1 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-semibold transition-all">Close</button>
                <button onclick="acceptTerms()" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all">✓ I Accept</button>
            </div>
        </div>
    </div>

    <script>
        function openTermsModal() {
            document.getElementById('termsModal').classList.remove('hidden');
        }
        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }
        function acceptTerms() {
            document.getElementById('terms').checked = true;
            closeTermsModal();
        }
        document.getElementById('termsModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeTermsModal();
        });

        // Show loader on register submit
        document.querySelector('form[action*="register"]').addEventListener('submit', function() {
            document.getElementById('pageLoader').classList.remove('hidden');
        });
    </script>

    <!-- Page loader overlay -->
    <div id="pageLoader" class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center gap-5"
         style="background:rgba(5,13,46,0.92);backdrop-filter:blur(6px);">
        <svg class="animate-spin" style="width:52px;height:52px;" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="rgba(59,130,246,0.25)" stroke-width="4"/>
            <path d="M4 12a8 8 0 018-8" stroke="#3b82f6" stroke-width="4" stroke-linecap="round"/>
        </svg>
        <p style="color:#93c5fd;font-size:15px;font-weight:600;font-family:sans-serif;letter-spacing:.03em;">Creating your account, please wait…</p>
    </div>

</body>
</html>
