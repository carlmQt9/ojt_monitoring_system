<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - OJT Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
    @include('partials.success-popup')
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 backdrop-blur-md bg-slate-900/80 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">OMS</span>
                    </div>
                    <span class="text-lg font-bold text-white">Dashboard</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/" class="px-6 py-2 text-gray-300 hover:text-white transition-colors duration-200">
                        Home
                    </a>
                    <a href="#" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Welcome to Dashboard</h1>
            <p class="text-gray-400">Manage your OJT monitoring system</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">Total Trainees</div>
                <div class="text-3xl font-bold text-white">0</div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">Active Programs</div>
                <div class="text-3xl font-bold text-white">0</div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">Completion Rate</div>
                <div class="text-3xl font-bold text-white">0%</div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                <div class="text-gray-400 text-sm font-medium mb-2">Last Updated</div>
                <div class="text-lg font-semibold text-blue-400">{{ now()->format('M d, Y') }}</div>
            </div>
        </div>

        <!-- Features Coming Soon -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-xl font-semibold text-white mb-2">Analytics</h3>
                <p class="text-gray-400">View detailed progress reports and analytics</p>
            </div>
            
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-xl font-semibold text-white mb-2">User Management</h3>
                <p class="text-gray-400">Manage trainees, mentors, and administrators</p>
            </div>

            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                <div class="text-4xl mb-4">📝</div>
                <h3 class="text-xl font-semibold text-white mb-2">Reports</h3>
                <p class="text-gray-400">Generate and export detailed reports</p>
            </div>

            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8 text-center">
                <div class="text-4xl mb-4">⚙️</div>
                <h3 class="text-xl font-semibold text-white mb-2">Settings</h3>
                <p class="text-gray-400">Configure system settings and preferences</p>
            </div>
        </div>
    </div>
</body>
</html>
