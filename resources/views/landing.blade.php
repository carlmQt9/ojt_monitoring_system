<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PRMSU Sta.Cruz OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }

        /* DARK MODE (default) */
        body { background: linear-gradient(135deg, #0a0e2e 0%, #0d1b4b 40%, #0a2a6e 70%, #0d3b8e 100%); min-height: 100vh; transition: background 0.3s; }
        section { scroll-margin-top: 85px; }
        .hero-bg { background: linear-gradient(135deg, #050d2e 0%, #0a1a5c 50%, #0d2d8a 100%); transition: background 0.3s; }
        .dot-pattern { background-image: radial-gradient(circle, rgba(99,179,237,0.15) 1px, transparent 1px); background-size: 24px 24px; }
        .glow-blue { box-shadow: 0 0 30px rgba(59,130,246,0.4); }
        .glow-btn { box-shadow: 0 0 20px rgba(59,130,246,0.5); }
        .nav-link { position:relative; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#3b82f6; transition:width 0.3s; }
        .nav-link:hover::after { width:100%; }
        .screen-mockup { background: linear-gradient(145deg, #0f1f5c, #1a3a8f); border: 2px solid rgba(99,179,237,0.3); border-radius: 12px; }
        .screen-bar { background: linear-gradient(90deg, #1e3a8a, #1d4ed8); }

        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        @keyframes pulseGlow { 0%,100% { box-shadow: 0 0 0 rgba(59, 130, 246, 0.25); } 50% { box-shadow: 0 0 28px rgba(59, 130, 246, 0.4); } }
        @keyframes slideInLeft { from { opacity:0; transform: translate3d(-30px,0,0); } to { opacity:1; transform: translate3d(0,0,0); } }
        @keyframes slideInRight { from { opacity:0; transform: translate3d(30px,0,0); } to { opacity:1; transform: translate3d(0,0,0); } }
        @keyframes gentleOrbit { 0%,100% { transform: translate3d(0,0,0) scale(1); } 50% { transform: translate3d(0,-10px,0) scale(1.02); } }

        .float { animation: float 4s ease-in-out infinite; }
        .fade-up { animation: fadeUp 0.7s ease-out forwards; }
        .delay-1 { animation-delay: 0.15s; opacity:0; }
        .delay-2 { animation-delay: 0.3s; opacity:0; }
        .delay-3 { animation-delay: 0.45s; opacity:0; }

        .hero-shell { animation: fadeUp 0.8s cubic-bezier(.2,.8,.2,1) both; }
        .about-right, .contact-card, .feature-card, .cta-panel {
            will-change: transform, opacity;
            transform-style: preserve-3d;
        }
        .about-right { animation: slideInRight 0.9s cubic-bezier(.2,.8,.2,1) both; }
        .contact-card { animation: fadeUp 0.75s cubic-bezier(.2,.8,.2,1) both; }
        .cta-panel { animation: fadeUp 0.9s cubic-bezier(.2,.8,.2,1) both; }

        .reveal-section {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-section.is-hidden {
            opacity: 0;
            transform: translateY(32px);
        }

        .reveal-item {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.75s ease, transform 0.75s ease;
        }
        .reveal-item.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-marquee { overflow: hidden; position: relative; mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent); }
        .feature-track { display: flex; width: max-content; gap: 1.25rem; animation: marquee 26s linear infinite; }
        .feature-track:hover { animation-play-state: paused; }
        .feature-card {
            position: relative;
            width: min(22rem, calc(100vw - 3.5rem));
            min-width: 320px;
            border-radius: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1.5rem 1.3rem;
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.75), rgba(30, 41, 59, 0.82));
            backdrop-filter: blur(12px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.04), 0 16px 32px rgba(2, 6, 23, 0.18);
            transition: transform 0.32s ease, border-color 0.32s ease, box-shadow 0.32s ease, filter 0.32s ease, opacity 0.75s ease, transform 0.75s ease;
            perspective: 1200px;
            opacity: 0;
            transform: translateY(26px);
        }
        .feature-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(255,255,255,0.08), transparent 42%);
            pointer-events: none;
        }
        .feature-card.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .feature-card:hover {
            transform: translateY(-8px) rotateX(2deg) rotateY(-2deg) scale(1.01);
            border-color: rgba(96, 165, 250, 0.8);
            box-shadow: 0 20px 35px rgba(37, 99, 235, 0.18);
            filter: brightness(1.06);
        }
        .feature-card .icon-wrap {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 0 0 rgba(59, 130, 246, 0.2);
            animation: pulseGlow 4s ease-in-out infinite, gentleOrbit 5s ease-in-out infinite;
        }
        .feature-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #f8fafc; }
        .feature-card p { font-size: 0.92rem; line-height: 1.7; color: rgba(191, 219, 254, 0.9); }
        .feature-cyan .icon-wrap { background: linear-gradient(135deg, #38bdf8, #2563eb); }
        .feature-blue .icon-wrap { background: linear-gradient(135deg, #60a5fa, #1d4ed8); }
        .feature-green .icon-wrap { background: linear-gradient(135deg, #34d399, #0f766e); }
        .feature-purple .icon-wrap { background: linear-gradient(135deg, #a78bfa, #7c3aed); }
        .feature-yellow .icon-wrap { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
        .feature-red .icon-wrap { background: linear-gradient(135deg, #f87171, #dc2626); }

        .about-shell {
            align-items: center;
        }
        .about-copy {
            padding-right: 1rem;
        }
        .role-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            gap: 1rem;
            width: 100%;
        }
        .flip-card {
            width: 100%;
            height: 100%;
            min-height: 180px;
            perspective: 1400px;
            cursor: pointer;
            border: none;
            background: transparent;
            text-align: left;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 180px;
            transition: transform 0.7s cubic-bezier(.2,.8,.2,1);
            transform-style: preserve-3d;
        }
        .flip-card.is-flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-face {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            border-radius: 1rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .flip-card-front {
            border: 1px solid rgba(74, 222, 128, 0.45);
            background: rgba(22, 101, 52, 0.18);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
        }
        .flip-card-back {
            border: 1px solid rgba(96, 165, 250, 0.45);
            background: rgba(30, 64, 175, 0.2);
            transform: rotateY(180deg);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
        }
        .flip-card:hover .flip-card-front,
        .flip-card:hover .flip-card-back {
            box-shadow: 0 14px 28px rgba(37,99,235,0.18);
        }
        .flip-card-front .title,
        .flip-card-back .title {
            font-weight: 700;
            margin-top: 0.75rem;
            margin-bottom: 0.5rem;
        }
        .flip-card-back p {
            font-size: 0.74rem;
            line-height: 1.5;
            color: rgba(224, 242, 254, 0.92);
        }
        .flip-card-back .label {
            font-size: 0.62rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(147, 197, 253, 0.9);
        }
        .flip-hint {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.6rem;
            border-radius: 999px;
            border: 1px solid rgba(96, 165, 250, 0.4);
            background: rgba(15, 118, 110, 0.12);
            color: rgba(186, 230, 253, 0.9);
            font-size: 0.62rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .site-footer { background: linear-gradient(180deg, rgba(2, 11, 32, 0.92), rgba(3, 10, 30, 0.98)); border-top: 1px solid rgba(96,165,250,0.2); }

        /* LIGHT MODE */
        body.light { background: #ffffff; color: #0f2460; }
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
        body.light footer { background: #6a90b0 !important; }
        body.light .light-footer { background: #7da8cb !important; }
        body.light footer span, body.light footer a, body.light footer p { color: #0f2460 !important; }
        body.light footer a:hover { color: #1e3a8a !important; }
        body.light .bg-green-900\/20 { background: rgba(187,247,208,0.5) !important; }
        body.light .bg-purple-900\/20 { background: rgba(233,213,255,0.5) !important; }
        body.light .bg-orange-900\/20 { background: rgba(254,215,170,0.5) !important; }
        body.light .bg-red-900\/20 { background: rgba(254,202,202,0.5) !important; }
        body.light .border-green-700\/40 { border-color: rgba(21,128,61,0.4) !important; }
        body.light .border-purple-700\/40 { border-color: rgba(109,40,217,0.4) !important; }
        body.light .border-orange-700\/40 { border-color: rgba(194,65,12,0.4) !important; }
        body.light .border-red-700\/40 { border-color: rgba(185,28,28,0.4) !important; }
        body.light .flip-card-front,
        body.light .flip-card-back {
            color: #0f2460 !important;
            background: rgba(255,255,255,0.72) !important;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6), 0 10px 20px rgba(15,36,96,0.08);
        }
        body.light .flip-card-back {
            background: rgba(255,255,255,0.82) !important;
            border-color: rgba(96,165,250,0.55) !important;
        }
        body.light .flip-card-front .title,
        body.light .flip-card-back .title,
        body.light .flip-card-back .label,
        body.light .flip-card-back p,
        body.light .flip-card-front .text-green-300\/70,
        body.light .flip-card-front .text-purple-300\/70,
        body.light .flip-card-front .text-orange-300\/70,
        body.light .flip-card-front .text-red-300\/70 {
            color: #0f2460 !important;
        }
        body.light .flip-card-front .text-green-400,
        body.light .flip-card-front .text-purple-400,
        body.light .flip-card-front .text-orange-400,
        body.light .flip-card-front .text-red-400 {
            color: #102a63 !important;
        }
        body.light #contact { background: linear-gradient(180deg,#ddeaf8,#cce0f5) !important; }
        body.light #contact h2,
        body.light #contact h3 { color: #0f2460 !important; }
        body.light #contact p,
        body.light #contact .text-blue-300 { color: #1e3a6e !important; }
        body.light #contact .text-blue-400 { color: #1d4ed8 !important; }
        body.light #contact .bg-blue-900\/20 { background: rgba(255,255,255,0.85) !important; border-color: #93b8dc !important; }
        body.light #contact .text-white { color: #0f2460 !important; }

        @media (max-width: 767px) {
            .hero-shell {
                gap: 1.25rem !important;
                padding-top: 2.5rem !important;
                padding-bottom: 2.25rem !important;
            }

            .hero-bg {
                min-height: auto !important;
            }

            .flip-card {
                min-height: 160px;
            }

            .grid.grid-cols-2 {
                gap: 0.75rem !important;
            }
        }
    </style>
</head>
<body class="text-white">

    <!-- NAV -->
    <nav class="sticky top-0 z-50 border-b border-blue-900/50" style="background:rgba(5,13,46,0.92);backdrop-filter:blur(12px)">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-9 h-9 rounded-lg object-cover glow-blue">
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
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Theme Toggle -->
                <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
                    class="w-9 h-9 rounded-full flex items-center justify-center border border-blue-500/50 text-blue-300 hover:text-white hover:border-blue-400 hover:bg-blue-500/10 transition-all">
                    <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                </button>
                @auth
                    <a href="{{ url('/dashboard') }}" class="group relative px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-full text-sm font-semibold text-white transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transform">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 border-2 border-blue-500/60 text-blue-300 hover:text-white hover:border-blue-400 hover:bg-blue-500/10 rounded-full text-sm font-semibold transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Log in
                    </a>
                    <a href="{{ route('login') }}" class="group relative px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-full text-sm font-semibold text-white transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transform">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            <span class="hidden sm:inline">Sign In</span>
                            <span class="sm:hidden">Sign Up</span>
                        </span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-bg relative overflow-hidden min-h-screen flex items-center reveal-section is-visible">
        <!-- dot pattern -->
        <div class="dot-pattern absolute inset-0 opacity-40"></div>
        <!-- glow orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-800 rounded-full blur-3xl opacity-25"></div>

        <div class="hero-shell relative max-w-7xl mx-auto px-4 sm:px-6 py-12 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center w-full">

            <!-- Left -->
            <div class="space-y-3 text-center lg:text-left mx-auto lg:mx-0 max-w-full lg:max-w-xl hero-copy">
                <div class="inline-flex items-center gap-2 bg-blue-900/50 border border-blue-700/50 rounded-full px-4 py-1.5 text-xs text-blue-300 fade-up">
                    <svg class="w-3.5 h-3.5 text-blue-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2.75a7.25 7.25 0 015.07 12.38l-5.07 7.12-5.07-7.12A7.25 7.25 0 0112 2.75zm0 3.5a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
                    </svg>
                    PRMSU Sta. Cruz Campus — BSCS Program
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-[4.1rem] xl:text-[4.6rem] font-extrabold leading-[0.92] tracking-[-0.05em] fade-up delay-1 mt-1">
                    Track Your OJT<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600">Progress With Us</span>
                </h1>

                <p class="text-blue-200 text-base sm:text-lg lg:text-[1.3rem] leading-relaxed max-w-[720px] fade-up delay-2 mt-1">
                    A complete On-the-Job Training monitoring platform for students, supervisors, coordinators, and CCIT Head — with camera time-in/out, DTR generation, and real-time progress tracking.
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-3 fade-up delay-3 mt-1">
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-500 hover:via-blue-600 hover:to-blue-700 rounded-2xl font-bold text-white transition-all shadow-2xl shadow-blue-500/40 hover:shadow-blue-500/60 transform hover:scale-105 hover:-translate-y-1">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Get Started Free
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#features" class="group inline-flex items-center gap-2 px-6 py-3 border-2 border-blue-500/60 bg-blue-500/5 hover:bg-blue-500/10 text-blue-200 hover:text-white hover:border-blue-400 rounded-2xl font-semibold transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Learn More
                        <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 sm:flex sm:justify-center lg:justify-start sm:gap-6 gap-3 pt-2 fade-up delay-3">
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-white">4</div>
                        <div class="text-xs text-blue-400">User Roles</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-6">
                        <div class="text-xl sm:text-2xl font-bold text-white">600</div>
                        <div class="text-xs text-blue-400">Required Hours</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-6">
                        <div class="text-xl sm:text-2xl font-bold text-white">DTR</div>
                        <div class="text-xs text-blue-400">Auto-Generated</div>
                    </div>
                    <div class="sm:border-l sm:border-blue-800 sm:pl-6">
                        <div class="text-xl sm:text-2xl font-bold text-white">📷</div>
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
    <section id="about" class="min-h-screen py-16 border-t border-blue-900/40 flex items-center reveal-section" style="background:linear-gradient(180deg,#0a1a5c,#050d2e)">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-[1.1fr_1.2fr] gap-8 md:gap-10 about-shell w-full">
            <div class="about-copy max-w-2xl">
                <div class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-3">About the System</div>
                <h2 class="fade-up text-[2.6rem] sm:text-[3.4rem] lg:text-[4rem] xl:text-[4.2rem] font-black text-white leading-[0.96] tracking-[-0.05em] mb-4 whitespace-normal max-w-[700px]">
                    Built for PRMSU Sta. Cruz CCIT OJT Program
                </h2>
                <p class="fade-up delay-1 text-blue-200 text-base lg:text-[1.12rem] leading-relaxed mb-6 max-w-[680px]">
                    A streamlined digital platform for managing OJT attendance, student requirements, evaluations, and approvals in one place.
                </p>
            </div>
            <div class="w-full">
                <div class="role-header">
                    <span class="text-blue-300 text-xs font-semibold uppercase tracking-widest">Role overview</span>
                    <span class="flip-hint">Tap to flip</span>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <button type="button" class="flip-card" data-flip-card>
                        <div class="flip-card-inner">
                            <div class="flip-card-face flip-card-front bg-green-900/20 border border-green-700/40">
                                <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center text-green-400 text-sm">🎓</span></div>
                                <div class="title text-lg sm:text-xl font-bold text-green-400">Student</div>
                                <div class="text-[10px] sm:text-xs text-green-300/70">Attendance · Hours · Reports</div>
                            </div>
                            <div class="flip-card-face flip-card-back">
                                <div class="label">Student</div>
                                <p>Tracks time-in, OJT hours, requirement uploads, and daily reports for timely progress monitoring.</p>
                            </div>
                        </div>
                    </button>

                    <button type="button" class="flip-card" data-flip-card>
                        <div class="flip-card-inner">
                            <div class="flip-card-face flip-card-front bg-purple-900/20 border border-purple-700/40">
                                <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center text-purple-400 text-sm">👔</span></div>
                                <div class="title text-lg sm:text-xl font-bold text-purple-400">Supervisor</div>
                                <div class="text-[10px] sm:text-xs text-purple-300/70">Review · Approve · Evaluate</div>
                            </div>
                            <div class="flip-card-face flip-card-back">
                                <div class="label">Supervisor</div>
                                <p>Reviews intern records, approves submissions, and evaluates performance and completion status.</p>
                            </div>
                        </div>
                    </button>

                    <button type="button" class="flip-card" data-flip-card>
                        <div class="flip-card-inner">
                            <div class="flip-card-face flip-card-front bg-orange-900/20 border border-orange-700/40">
                                <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center text-orange-400 text-sm">📋</span></div>
                                <div class="title text-lg sm:text-xl font-bold text-orange-400">Coordinator</div>
                                <div class="text-[10px] sm:text-xs text-orange-300/70">Monitor · Approve · Export</div>
                            </div>
                            <div class="flip-card-face flip-card-back">
                                <div class="label">Coordinator</div>
                                <p>Oversees all student records, approves requirements, and manages attendance and DTR output.</p>
                            </div>
                        </div>
                    </button>

                    <button type="button" class="flip-card" data-flip-card>
                        <div class="flip-card-inner">
                            <div class="flip-card-face flip-card-front bg-red-900/20 border border-red-700/40">
                                <div class="flex items-center gap-2 mb-2"><span class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center text-red-400 text-sm">🏫</span></div>
                                <div class="title text-lg sm:text-xl font-bold text-red-400">CCIT Head</div>
                                <div class="text-[10px] sm:text-xs text-red-300/70">Manage · Analyze · Report</div>
                            </div>
                            <div class="flip-card-face flip-card-back">
                                <div class="label">CCIT Head</div>
                                <p>Manages users, school IDs, reports, and system-wide OJT tracking and analytics.</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="min-h-screen py-16 border-t border-blue-900/40 flex items-center reveal-section" style="background:#050d2e">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="text-center mb-10 reveal-item">
                <div class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-3">Features</div>
                <h2 class="text-3xl font-bold text-white">Everything You Need</h2>
                <p class="text-blue-300 mt-2">Manage the full OJT lifecycle in one platform</p>
            </div>

            @php
            $features = [
                ['icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z','title'=>'Camera Time-In / Out','desc'=>'Students clock in and out using their device camera. A photo is captured and stored with each attendance record for verification.','color'=>'cyan'],
                ['icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','title'=>'OJT Hours & Progress Tracking','desc'=>'Real-time tracking of completed OJT hours against the 600-hour requirement, with visual progress bars and completion status per student.','color'=>'blue'],
                ['icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','title'=>'Requirements & Report Submission','desc'=>'Students upload onboarding requirements and daily/weekly reports (PDF, Word, Excel, images). Supervisors and coordinators review and approve or reject each submission.','color'=>'green'],
                ['icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','title'=>'Analytics Dashboard','desc'=>'Role-based dashboards with charts for student progress, completion rates, attendance trends, report statuses, and top companies.','color'=>'purple'],
                ['icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','title'=>'DTR Auto-Generation','desc'=>'Daily Time Records are automatically generated from attendance logs. Coordinators and CCIT Head can view DTR inline or export as a Word document per student.','color'=>'yellow'],
                ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','title'=>'School Year, IDs & User Management','desc'=>'CCIT Head manages school years, required OJT hours, approved school ID numbers, company assignments, and all user accounts with approval workflow.','color'=>'red'],
                ['icon'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z','title'=>'Role-Based Access Control (RBAC)','desc'=>'Every route and feature is protected by role-based middleware. Students, Supervisors, Coordinators, and the CCIT Head each access only their designated portal — preventing unauthorized actions across all user boundaries.','color'=>'purple'],
            ];
            @endphp

            <div class="feature-marquee reveal-item">
                <div class="feature-track">
                    @foreach($features as $f)
                        <article class="feature-card reveal-item feature-{{ $f['color'] }}">
                            <div class="icon-wrap">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"></path>
                                </svg>
                            </div>
                            <h3>{{ $f['title'] }}</h3>
                            <p>{{ $f['desc'] }}</p>
                        </article>
                    @endforeach
                    @foreach($features as $f)
                        <article class="feature-card reveal-item feature-{{ $f['color'] }}">
                            <div class="icon-wrap">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"></path>
                                </svg>
                            </div>
                            <h3>{{ $f['title'] }}</h3>
                            <p>{{ $f['desc'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

   
    <!-- CONTACT -->
    <section id="contact" class="min-h-screen py-16 border-t border-blue-900/40 relative overflow-hidden flex items-center reveal-section" style="background:linear-gradient(180deg,#050d2e,#030a1e)">
        <!-- Background elements -->
        <div class="dot-pattern absolute inset-0 opacity-20"></div>
        
        <div class="relative max-w-6xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="text-blue-400 text-xs font-semibold uppercase tracking-widest mb-2">Contact</div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Get in Touch</h2>
                <p class="text-blue-300 text-sm">For concerns, issues, or inquiries about the OJT Monitoring System</p>
            </div>

            <!-- Contact Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5 mb-8">
                <!-- Location Card -->
                <div class="group relative bg-gradient-to-br from-blue-900/40 to-blue-800/20 border border-blue-700/40 rounded-xl p-4 sm:p-5 text-center hover:border-blue-500/60 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-white mb-2">Location</h3>
                    <div class="space-y-0.5 text-[11px] sm:text-sm">
                        <p class="text-blue-200 font-medium">PRMSU Sta. Cruz Campus</p>
                        <p class="text-blue-300">Sta. Cruz, Zambales</p>
                    </div>
                </div>

                <!-- Department Card -->
                <div class="group relative bg-gradient-to-br from-cyan-900/40 to-cyan-800/20 border border-cyan-700/40 rounded-xl p-4 sm:p-5 text-center hover:border-cyan-500/60 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-white mb-2">Department</h3>
                    <div class="space-y-0.5 text-[11px] sm:text-sm">
                        <p class="text-cyan-200 font-medium">CCIT Department</p>
                        <p class="text-cyan-300">College of Communication &amp; Information Technology</p>
                    </div>
                </div>

                <!-- System Support Card -->
                <div class="group relative bg-gradient-to-br from-purple-900/40 to-purple-800/20 border border-purple-700/40 rounded-xl p-4 sm:p-5 text-center hover:border-purple-500/60 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1 col-span-2 md:col-span-1">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 shadow-lg shadow-purple-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-white mb-2">System Support</h3>
                    <div class="space-y-1 text-[11px] sm:text-sm">
                        <p class="text-purple-200">For account and technical concerns</p>
                        <p class="text-purple-300 font-semibold">OJT Coordinator</p>
                        <p class="text-purple-400">or</p>
                        <p class="text-purple-300 font-semibold">CCIT Head</p>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="max-w-3xl mx-auto">
                <div class="relative bg-gradient-to-r from-blue-900/50 via-blue-800/40 to-blue-900/50 border border-blue-600/40 rounded-xl p-4 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row items-center gap-3 text-center sm:text-left">
                        <div class="shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-blue-200 text-sm leading-relaxed">
                                📌 This system is exclusively for <span class="text-white font-semibold">PRMSU Sta. Cruz Campus — CCIT students and faculty</span>. Registration requires a valid school-issued ID number.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="min-h-screen py-12 sm:py-16 border-t border-blue-900/40 relative overflow-hidden flex items-center reveal-section cta-panel" style="background:linear-gradient(135deg,#0a1a5c,#0d2d8a)">
        <div class="dot-pattern absolute inset-0 opacity-30"></div>
        <div class="absolute top-0 left-1/4 w-80 h-80 sm:w-96 sm:h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 sm:w-96 sm:h-96 bg-cyan-600 rounded-full blur-3xl opacity-20"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-900/50 border border-blue-700/50 rounded-full px-3 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm text-blue-300 mb-4 sm:mb-6">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Free for PRMSU CCIT Students</span>
            </div>

            <h2 class="text-3xl sm:text-5xl font-extrabold text-white mb-3 sm:mb-5 leading-none">
                Ready to Track Your<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500">OJT Journey?</span>
            </h2>
            <p class="text-blue-200 text-sm sm:text-lg leading-relaxed mb-6 sm:mb-10 max-w-xl sm:max-w-2xl mx-auto">
                Register with your school-issued ID number, select your role, and start tracking your OJT journey.
            </p>

            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center gap-2 sm:gap-3 w-full sm:w-auto px-6 sm:px-10 py-3.5 sm:py-5 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-500 hover:via-blue-600 hover:to-blue-700 rounded-2xl font-bold text-base sm:text-lg text-white transition-all shadow-2xl shadow-blue-500/40 hover:shadow-blue-500/60 transform hover:scale-105 hover:-translate-y-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Create Your Account</span>
                </a>
                <a href="{{ route('login') }}" class="group inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 sm:px-10 py-3.5 sm:py-5 border-2 border-blue-400/60 bg-blue-500/5 hover:bg-blue-500/10 text-blue-200 hover:text-white hover:border-blue-300 rounded-2xl font-semibold text-base sm:text-lg transition-all backdrop-blur-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>Already Have an Account? Sign In</span>
                </a>
            </div>

            <div class="mt-8 sm:mt-12 flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-xs sm:text-sm text-blue-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Secure & Encrypted</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    <span>Real-time Updates</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>CCIT Approved</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer py-5 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4 text-center md:text-left">
            <div class="flex items-center gap-3 justify-center md:justify-start">
                <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg object-cover ring-2 ring-blue-500/40 shadow-lg shadow-blue-500/20">
                <span class="text-blue-200 text-xs sm:text-sm font-semibold">PRMSU Sta. Cruz — OJT Monitoring System</span>
            </div>
            <div class="flex flex-wrap justify-center gap-3 sm:gap-6 text-xs sm:text-sm text-blue-400">
                <a href="#" class="hover:text-white transition-colors">Home</a>
                <a href="#about" class="hover:text-white transition-colors">About</a>
                <a href="#features" class="hover:text-white transition-colors">Features</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
            </div>
            <p class="text-blue-500 text-[10px] sm:text-xs">&copy; {{ date('Y') }} PRMSU Sta. Cruz Campus. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleTheme() {
            const isLight = document.body.classList.toggle('light');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            document.getElementById('iconMoon').classList.toggle('hidden', isLight);
            document.getElementById('iconSun').classList.toggle('hidden', !isLight);
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('loaded');

            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light');
                document.getElementById('iconMoon').classList.add('hidden');
                document.getElementById('iconSun').classList.remove('hidden');
            }

            const cards = document.querySelectorAll('[data-flip-card]');
            cards.forEach((card) => {
                card.addEventListener('click', () => {
                    const isOpen = card.classList.contains('is-flipped');

                    cards.forEach((item) => item.classList.remove('is-flipped'));

                    if (!isOpen) {
                        card.classList.add('is-flipped');
                    }
                });
            });

            const revealItems = document.querySelectorAll('.reveal-section, .reveal-item, .feature-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const item = entry.target;
                    if (entry.isIntersecting) {
                        item.classList.add('is-visible');
                        item.classList.remove('is-hidden');
                    } else if (item.classList.contains('reveal-section')) {
                        item.classList.remove('is-visible');
                        item.classList.add('is-hidden');
                    }
                });
            }, { threshold: 0.18, rootMargin: '0px 0px -8% 0px' });

            revealItems.forEach((item) => observer.observe(item));
        });
    </script>
</body>
</html>
