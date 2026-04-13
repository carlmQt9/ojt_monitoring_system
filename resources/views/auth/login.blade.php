<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body { background: linear-gradient(135deg, #0a0e2e 0%, #0d1b4b 40%, #0a2a6e 70%, #0d3b8e 100%); transition: background 0.3s; }
        .dot-pattern { background-image: radial-gradient(circle, rgba(99,179,237,0.15) 1px, transparent 1px); background-size: 24px 24px; }
        .card { background: rgba(10, 26, 92, 0.6); backdrop-filter: blur(16px); border: 1px solid rgba(59,130,246,0.2); transition: background 0.3s; }
        .input-field { background: rgba(255,255,255,0.05); border: 1px solid rgba(59,130,246,0.25); color: white; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .input-field::placeholder { color: rgba(147,197,253,0.4); }
        .glow-btn { box-shadow: 0 0 20px rgba(59,130,246,0.4); }
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
        body.light .text-blue-200\/70 { color: #1e40af !important; }
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
        body.light [style*="background:linear-gradient(135deg,#050d2e"] { background: linear-gradient(135deg,#a8c4e8,#93b8e0,#bdd4f0) !important; }
        body.light [style*="background:#0a1a5c"] { background: #b8d0f0 !important; }
        body.light [style*="border:1px solid rgba(59,130,246,0.2)"] { border-color: #6a9fd0 !important; }
        body.light .bg-black\/80 { background: rgba(0,0,0,0.5) !important; }
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
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-4 pt-20 relative overflow-hidden">
    <div class="dot-pattern absolute inset-0 opacity-40"></div>
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

    <div class="relative w-full max-w-5xl flex flex-col md:flex-row rounded-3xl overflow-hidden shadow-2xl" style="border:1px solid rgba(59,130,246,0.2)">

        <!-- Left Panel -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-10 md:p-14 relative overflow-hidden" style="background:linear-gradient(135deg,#050d2e,#0a1a5c,#0d2d8a)">
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
                    Track internship hours, submit tasks, and get evaluated — all in one place.
                </p>
                <div class="hidden md:flex justify-center gap-6 pt-2 text-xs text-blue-400">
                    <div class="text-center"><div class="text-xl font-bold text-white">4</div>Roles</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">DTR</div>Reports</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">Live</div>Tracking</div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center card">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
                <p class="text-blue-300 text-sm mt-1">Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Sign up</a></p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                @if($errors->any())
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-500/15 border border-red-500/40">
                    <span class="text-red-400 text-lg leading-none mt-0.5">⚠️</span>
                    <div>
                        @foreach($errors->all() as $error)
                        <p class="text-red-400 text-sm font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required
                        class="input-field w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="name@university.edu" maxlength="255">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="input-field w-full px-4 py-3 pr-11 rounded-xl text-sm"
                            placeholder="••••••••" maxlength="128">
                        <button type="button" onclick="togglePw('password','eyeLogin')" tabindex="-1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-200 transition-colors">
                            <svg id="eyeLogin" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-blue-300 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-blue-700 bg-blue-900/50 text-blue-500">
                        Keep me logged in
                    </label>
                    <button type="button" onclick="showForgotPasswordModal()" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                        Forgot Password?
                    </button>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-400 hover:to-blue-600 text-white font-bold rounded-xl transition-all glow-btn transform hover:scale-[1.02] active:scale-[0.98]">
                    Sign In
                </button>

                <div class="text-center pt-1">
                </div>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-6">
        <div class="rounded-2xl p-8 max-w-sm w-full shadow-2xl" style="background:#0a1a5c;border:1px solid rgba(59,130,246,0.3)">
            <h3 class="text-lg font-bold text-white mb-1">Password Recovery</h3>
            <p class="text-blue-300 text-sm mb-6">Enter your email and we'll send a reset link.</p>
            <form method="POST" action="{{ route('forgot-password') }}" class="space-y-4">
                @csrf
                <input type="email" name="email" required
                    class="input-field w-full px-4 py-2.5 rounded-lg text-sm"
                    placeholder="email@example.com" maxlength="255">
                <div class="flex gap-3">
                    <button type="button" onclick="closeForgotPasswordModal()" class="flex-1 px-4 py-2 rounded-lg text-sm text-blue-300 transition-colors" style="background:rgba(255,255,255,0.05);border:1px solid rgba(59,130,246,0.2)">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-semibold text-sm transition-colors">Send</button>
                </div>
            </form>
        </div>
    </div>

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
        function showForgotPasswordModal() { document.getElementById('forgotPasswordModal').classList.remove('hidden'); }
        function closeForgotPasswordModal() { document.getElementById('forgotPasswordModal').classList.add('hidden'); }
        function togglePw(id, iconId) {
            const input = document.getElementById(id);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = document.getElementById(iconId);
            // show=true means we just revealed → show open eye
            // show=false means we just hid → show slashed eye
            icon.innerHTML = show
                ? '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>';
        }

        // Show loader on login submit
        document.querySelector('form').addEventListener('submit', function() {
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
        <p style="color:#93c5fd;font-size:15px;font-weight:600;font-family:sans-serif;letter-spacing:.03em;">Signing in, please wait…</p>
    </div>
</body>
</html>
