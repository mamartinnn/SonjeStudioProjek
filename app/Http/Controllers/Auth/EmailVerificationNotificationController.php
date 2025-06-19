<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Mengirim ulang email verifikasi ke pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        // Jika email pengguna sudah terverifikasi, arahkan ke dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Jika belum, kirim ulang email verifikasi
        $request->user()->sendEmailVerificationNotification();

        // Kembali ke halaman sebelumnya dengan status notifikasi berhasil dikirim
        return back()->with('status', 'verification-link-sent');
    }
}
