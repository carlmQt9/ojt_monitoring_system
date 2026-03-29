<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100 min-h-screen flex items-center justify-center">
    @include('partials.success-popup')
    <div class="w-full max-w-md mx-auto p-6 form-container">
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 backdrop-blur">
            <!-- Logo -->
            <div class="flex items-center justify-center mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">OMS</span>
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
                    <input type="password" name="password" id="password" required 
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                        placeholder="••••••••">
                    @error('password')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-white rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                        placeholder="••••••••">
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
</body>
</html>
