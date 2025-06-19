<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified; // Event untuk menandai email terverifikasi
use Illuminate\Foundation\Auth\EmailVerificationRequest; // Request khusus verifikasi email
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Menandai bahwa alamat email pengguna telah diverifikasi.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Jika email sudah terverifikasi sebelumnya, langsung redirect ke dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Tandai email sebagai terverifikasi
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); // Trigger event Verified
        }

        // Redirect ke dashboard dengan query verified=1
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
