<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LogoutResponse;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan binding layanan ke container aplikasi.
     */
    public function register(): void
    {
        // Mengganti implementasi default LogoutResponse dari Filament
        // dengan custom LogoutResponse milik kita
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Menjalankan proses saat service provider di-boot.
     */
    public function boot(): void
    {
        // Tidak ada proses bootstrap tambahan
    }
}