<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
        /* LIGHT MODE */
        body.light { background: linear-gradient(135deg, #b8cef0 0%, #a0bce8 40%, #b8d4f5 70%, #cce0fa 100%); }
        body.light .text-white { color: #0f2460 !important; }
        body.light .text-blue-300 { color: #1d4ed8 !important; }
        body.light .text-blue-400 { color: #1a3fcc !important; }
        body.light .text-blue-200\/70 { color: #1e3a8a !important; }
        body.light .text-blue-600 { color: #1e3a8a !important; }
        body.light .card { background: rgba(220,235,255,0.95) !important; border-color: #6a9fd0 !important; }
        body.light .input-field { background: rgba(255,255,255,0.95) !important; border-color: #6a9fd0 !important; color: #0f2460 !important; }
        body.light .input-field::placeholder { color: #7aaad4 !important; }
        body.light .input-field option { background: #fff; color: #0f2460; }
        body.light [style*="background:linear-gradient(135deg,#050d2e"] { background: linear-gradient(135deg,#a8c4e8,#93b8e0,#bdd4f0) !important; }
        body.light [style*="border:1px solid rgba(59,130,246,0.2)"] { border-color: #6a9fd0 !important; }
        body.light .text-green-400 { color: #15803d !important; }
        body.light .text-purple-400 { color: #6d28d9 !important; }
        body.light .text-orange-400 { color: #c2410c !important; }
        body.light .text-red-400 { color: #b91c1c !important; }
        body.light .text-green-300\/60 { color: #166534 !important; }
        body.light .text-purple-300\/60 { color: #5b21b6 !important; }
        body.light .text-orange-300\/60 { color: #9a3412 !important; }
        body.light .text-red-300\/60 { color: #991b1b !important; }
        body.light .bg-green-900\/30 { background: rgba(187,247,208,0.6) !important; }
        body.light .bg-purple-900\/30 { background: rgba(233,213,255,0.6) !important; }
        body.light .bg-orange-900\/30 { background: rgba(254,215,170,0.6) !important; }
        body.light .bg-red-900\/30 { background: rgba(254,202,202,0.6) !important; }
        body.light .border-green-700\/40 { border-color: rgba(21,128,61,0.5) !important; }
        body.light .border-purple-700\/40 { border-color: rgba(109,40,217,0.5) !important; }
        body.light .border-orange-700\/40 { border-color: rgba(194,65,12,0.5) !important; }
        body.light .border-red-700\/40 { border-color: rgba(185,28,28,0.5) !important; }
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-4 relative overflow-auto">
    <div class="dot-pattern absolute inset-0 opacity-40"></div>
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-800 rounded-full blur-3xl opacity-20"></div>

    <div class="fixed top-4 right-4 z-50">
        <button id="themeToggle" onclick="toggleTheme()" title="Toggle light/dark mode"
            class="w-9 h-9 rounded-full flex items-center justify-center border border-blue-500/50 text-blue-300 hover:text-white hover:border-blue-400 transition-all" style="background:rgba(10,26,92,0.7);backdrop-filter:blur(8px)">
            <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg id="iconSun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
        </button>
    </div>

    @include('partials.success-popup')

    <div class="relative w-full max-w-5xl flex flex-col md:flex-row rounded-3xl overflow-hidden shadow-2xl my-6" style="border:1px solid rgba(59,130,246,0.2)">

        <!-- Left Panel -->
        <div class="w-full md:w-5/12 flex flex-col items-center justify-center p-10 md:p-12 relative overflow-hidden" style="background:linear-gradient(135deg,#050d2e,#0a1a5c,#0d2d8a)">
            <div class="absolute top-0 left-0 w-full h-full dot-pattern opacity-30"></div>
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-500 rounded-full blur-3xl opacity-20"></div>
            <div class="relative z-10 text-center space-y-5">
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-400 to-blue-700 flex items-center justify-center" style="box-shadow:0 0 30px rgba(59,130,246,0.4)">
                        <span class="text-white font-bold text-sm">OMS</span>
                    </div>
                    <span class="font-bold text-white text-xl leading-tight">PRMSU <span class="text-blue-400">OJT</span> System</span>
                </div>
                <p class="text-blue-200/70 text-sm max-w-xs mx-auto hidden md:block" style="color: inherit;">
                    Join the platform to track your internship journey with ease.
                </p>
                <div class="hidden md:flex justify-center gap-5 pt-2 text-xs text-blue-600">
                    <div class="text-center"><div class="text-xl font-bold text-white">600</div>OJT Hours</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">DTR</div>Reports</div>
                    <div class="text-center"><div class="text-xl font-bold text-white">Live</div>Tracking</div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-7/12 p-8 md:p-10 flex flex-col justify-center card">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white">Create Account</h2>
                <p class="text-blue-300 text-sm mt-1">Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Sign in</a></p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="John Doe" maxlength="100" minlength="2">
                        @error('name')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="your@email.com" maxlength="255">
                        @error('email')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Role</label>
                    <select name="role" id="role" required onchange="updateFormVisibility()"
                        class="input-field w-full px-4 py-2.5 rounded-xl text-sm">
                        <option value="">Select a role</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                        <option value="ccit_head" {{ old('role') == 'ccit_head' ? 'selected' : '' }}>CCIT Head</option>
                    </select>
                    @error('role')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div id="companySection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Company / Organization</label>
                    <select name="company_id" id="company_id"
                        class="input-field w-full px-4 py-2.5 rounded-xl text-sm">
                        <option value="">Select your company</option>
                        <?php
                        $companies = \App\Models\Company::all();
                        foreach($companies as $company) {
                            $selected = old('company_id') == $company->id ? 'selected' : '';
                            echo "<option value=\"{$company->id}\" {$selected}>{$company->name}</option>";
                        }
                        ?>
                    </select>
                    @error('company_id')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <?php $schoolYears = \App\Models\SchoolYear::orderBy('label', 'desc')->get(); ?>
                @if($schoolYears->isNotEmpty())
                <div id="schoolYearSection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">School Year</label>
                    <select name="school_year" id="school_year"
                        class="input-field w-full px-4 py-2.5 rounded-xl text-sm">
                        <option value="">Select school year</option>
                        @foreach($schoolYears as $sy)
                            <option value="{{ $sy->label }}" {{ (old('school_year') == $sy->label || ($sy->is_active && !old('school_year'))) ? 'selected' : '' }}>
                                {{ $sy->label }}{{ $sy->is_active ? ' (Active)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_year')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>
                @endif

                <div id="schoolIdSection" class="hidden">
                    <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">School ID Number</label>
                    <input type="text" name="school_id_number" id="school_id_number"
                        value="{{ old('school_id_number') }}"
                        class="input-field w-full px-4 py-2.5 rounded-xl text-sm font-mono"
                        placeholder="e.g. 23-1-2-0001" maxlength="20">
                    @error('school_id_number')<span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" name="password" id="reg_password" required
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="••••••••" minlength="8" maxlength="128"
                            oninput="checkPasswordStrength(this.value)">
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
                        <label class="block text-xs font-semibold text-blue-300 uppercase tracking-wider mb-1.5">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="reg_password_confirmation" required
                            class="input-field w-full px-4 py-2.5 rounded-xl text-sm"
                            placeholder="••••••••" minlength="8" maxlength="128"
                            oninput="checkPasswordMatch()">
                        <p id="pw_match" class="text-xs mt-1 hidden"></p>
                    </div>
                </div>

                <div class="flex items-start gap-2">
                    <input type="checkbox" name="terms" id="terms" required
                        class="w-4 h-4 mt-0.5 rounded border-blue-700 bg-blue-900/50 text-blue-500 cursor-pointer">
                    <label for="terms" class="text-sm text-blue-300">
                        I agree to the <a href="#" class="text-blue-400 hover:text-blue-300">Terms of Service</a>
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
                    <a href="/" class="text-blue-500/60 hover:text-blue-400 text-xs transition-colors">← Return to website</a>
                </div>
            </form>
        </div>
    </div>

    <script>
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
            }

            if (schoolYearSection) {
                if (role === 'student' || role === 'supervisor' || role === 'coordinator' || role === 'ccit_head') {
                    schoolYearSection.classList.remove('hidden');
                } else {
                    schoolYearSection.classList.add('hidden');
                    if (schoolYearInput) schoolYearInput.value = '';
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

</body>
</html>
