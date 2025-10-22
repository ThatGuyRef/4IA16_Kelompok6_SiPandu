<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // If an account with role 'warga' attempts to login via the admin/email form,
        // force them to use the NIK login instead.
        $user = $request->user();
        if ($user && $user->role === 'warga') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('warga.login.form')->withErrors(['nik' => 'Gunakan login khusus warga dengan NIK dan password yang diberikan oleh admin.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // capture role before logging out so we can redirect to the appropriate login
        $user = $request->user();
        $role = $user?->role;

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // if the user was a warga, send them to the warga login form; otherwise send to admin/login
        if ($role === 'warga') {
            return redirect()->route('warga.login.form');
        }

        return redirect()->route('login');
    }
}
