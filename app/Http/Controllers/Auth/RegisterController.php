<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Rules\ReCaptcha;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:student,supervisor,coordinator,ccit_head',
            'company_id' => 'nullable|exists:companies,id',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required|accepted',
            'g-recaptcha-response' => [new ReCaptcha()],
        ]);

        // Additional validation for company_id based on role
        if (in_array($request->role, ['student', 'supervisor']) && empty($request->company_id)) {
            return back()->withErrors(['company_id' => 'Company selection is required for students and supervisors.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_id' => $request->company_id,
        ]);

        // Store user in session
        session([
            'user_id' => $user->id,
            'user' => $user,
        ]);

        return redirect()->route('dashboard');
    }
}
