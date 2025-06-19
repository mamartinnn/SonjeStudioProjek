<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Menampilkan form permintaan tautan reset password.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Menangani permintaan pengiriman tautan reset password.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi bahwa email terisi dan format valid
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Mengirim email tautan reset password ke pengguna
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Tampilkan status berhasil atau error sesuai hasil pengiriman
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status)) // berhasil, tampilkan notifikasi
            : back()->withInput($request->only('email')) // gagal, tampilkan kembali input + error
                ->withErrors(['email' => __($status)]);
    }
}
