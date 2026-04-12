<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpeg" href="/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container {
            animation: fadeInUp 0.6s ease-out;
        }
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { visibility: hidden; display: none !important; pointer-events: none; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100 min-h-screen flex items-center justify-center">
    @include('partials.success-popup')
    <div class="w-full max-w-md mx-auto p-6 form-container">
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 backdrop-blur">
            <!-- Logo -->
            <div class="flex items-center justify-center mb-8">
                <div class="w-12 h-12 rounded-lg overflow-hidden">
                    <img src="/8ae598d6-2434-4785-90dc-c0e59f0596a3.jpg" alt="OJT Logo" class="w-full h-full object-cover">
                </div>
            </div>

            <h1 class="text-2xl font-bold text-white mb-2 text-center">Reset Password</h1>
            <p class="text-gray-400 text-center mb-8">Enter your new password below</p>

            <form method="POST" action="{{ route('reset-password') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? request('token') }}">
                <input type="hidden" name="email" value="{{ $email ?? request('email') }}">
                @error('token')
                <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-2 pr-11 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePw('password','eyeRp1')" tabindex="-1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors">
                            <svg id="eyeRp1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-2 pr-11 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePw('password_confirmation','eyeRp2')" tabindex="-1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors">
                            <svg id="eyeRp2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Reset Button -->
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 mt-6">
                    Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-300 text-sm">← Back to Login</a>
            </div>
        </div>
    </div>
    <script>
        function togglePw(id, iconId) {
            const input = document.getElementById(id);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = document.getElementById(iconId);
            icon.innerHTML = show
                ? '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.084-3.416M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.411M3 3l18 18"/>';
        }
    </script>
</body>
</html>
