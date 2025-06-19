<?php

// Mengimpor controller yang berkaitan dengan otentikasi dan verifikasi
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

// Rute khusus untuk pengguna yang belum login (guest)
Route::middleware('guest')->group(function () {
    // Halaman registrasi dan proses penyimpanan akun baru
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Halaman login dan proses autentikasi
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Halaman permintaan reset password dan kirim email reset
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Halaman untuk mengisi password baru dari link reset
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // Halaman akun pribadi untuk pengguna setelah login (dibungkus di dalam guest — mungkin perlu dipindah ke bawah)
    Route::middleware(['auth'])->group(function () {
        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::post('/account', [AccountController::class, 'update'])->name('account.update');
    });
});

// Rute khusus untuk pengguna yang sudah login (auth)
Route::middleware('auth')->group(function () {
    // Halaman prompt untuk verifikasi email
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');

    // Proses verifikasi email dengan token dan validasi tanda tangan URL
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1']) // membatasi 6 kali per menit
        ->name('verification.verify');

    // Kirim ulang email verifikasi
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Form konfirmasi password sebelum akses halaman sensitif
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Proses update password akun
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Proses logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});