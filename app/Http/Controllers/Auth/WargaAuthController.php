<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WargaAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.warga-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            // require exactly 16 digits for NIK
            'nik' => ['required', 'digits:16'],
            'password' => ['required','string'],
        ]);

        $user = User::where('nik', $credentials['nik'])->first();

        if (! $user) {
            return back()->withErrors(['nik' => 'NIK tidak ditemukan. Silakan hubungi kelurahan.'])->withInput();
        }

        // Ensure user has warga role
        if ($user->role !== 'warga') {
            return back()->withErrors(['nik' => 'Akun ini tidak terdaftar sebagai warga.'])->withInput();
        }

        if (! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('warga.login.form');
    }
}
