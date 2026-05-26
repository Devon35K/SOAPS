<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role === 'admin' || $user->role === 'super_admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return view('login', [
            'errorMessage' => session('login_error')
        ]);
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = md5('login'.Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            abort(429, 'Too many login attempts. Please try again in '.$seconds.' seconds.');
        }

        // Attempt to authenticate the user
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Check if the account is in the approvals table instead
            $pendingAccount = \App\Models\AccountApproval::where('email', $credentials['email'])
                                                         ->where('approval_status', 'pending')
                                                         ->first();
            RateLimiter::hit($throttleKey);

            if ($pendingAccount) {
                if (!Hash::check($credentials['password'], $pendingAccount->password)) {
                    return redirect()->route('login')
                        ->with('login_error', 'Incorrect password')
                        ->withInput($request->only('email'));
                }
                return redirect()->route('login')
                    ->with('login_error', 'Not yet approved')
                    ->withInput($request->only('email'));
            }

            return redirect()->route('login')
                ->with('login_error', 'Incorrect email')
                ->withInput($request->only('email'));
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey);
            return redirect()->route('login')
                ->with('login_error', 'Incorrect password')
                ->withInput($request->only('email'));
        }

        // Login successful
        Auth::login($user, $request->boolean('remember'));

        // Check if user is approved
        if (!$user->approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('login_error', 'Not yet approved');
        }

        // Check if user is archived
        if ($user->is_archived) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('login_error', 'Your account has been disabled.');
        }

        // Check if user has 2FA enabled
        if ($user->hasEnabledTwoFactorAuthentication()) {
            Auth::logout();
            
            $request->session()->put([
                'login.id' => $user->id,
                'login.remember' => $request->boolean('remember'),
            ]);
            
            return redirect()->route('two-factor.login');
        }

        // Clear the rate limiter on successful authentication
        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();
        
        // Log successful login
        \Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

        // Redirect based on user role
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
