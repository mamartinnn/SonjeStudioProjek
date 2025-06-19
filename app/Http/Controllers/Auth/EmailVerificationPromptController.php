<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Menampilkan halaman permintaan verifikasi email.
     * Jika pengguna sudah verifikasi email, diarahkan ke dashboard.
     * Jika belum, ditampilkan halaman verifikasi email.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false)) // Arahkan ke dashboard jika email sudah diverifikasi
                    : view('auth.verify-email'); // Tampilkan view permintaan verifikasi jika belum
    }
}
