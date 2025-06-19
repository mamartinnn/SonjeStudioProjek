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
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman home (opsional jika user berhasil login).
     */
    public function createuser(): View
    {
        return view('home');
    }

    /**
     * Menangani permintaan autentikasi login.
     * - Melakukan validasi melalui LoginRequest
     * - Login user
     * - Regenerasi session untuk keamanan
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Arahkan ke halaman yang dimaksud setelah login, default ke route 'home'
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Logout user dan hancurkan sesi.
     * - Keluar dari Auth
     * - Invalidate session
     * - Regenerasi CSRF token
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
