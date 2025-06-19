<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Menampilkan halaman form reset password.
     */
    public function create(Request $request): View
    {
        // Menampilkan form reset-password dengan membawa request (token, email)
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Menangani proses reset password yang baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input pengguna
        $request->validate([
            'token' => ['required'], // token reset yang dikirim via email
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Lakukan reset password melalui Password::reset()
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'), // data yang diperlukan
            function (User $user) use ($request) {
                // Update password dan remember_token
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Trigger event PasswordReset (opsional untuk listener log/email)
                event(new PasswordReset($user));
            }
        );

        // Redirect ke login jika berhasil, atau kembali dengan error jika gagal
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }
}
