<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan layanan ke dalam container aplikasi.
     * Digunakan untuk binding atau registrasi dependency.
     */
    public function register(): void
    {   
        // Belum ada layanan khusus yang didaftarkan
    }

    /**
     * Men-setup atau menjalankan proses saat service provider di-boot.
     * Biasanya digunakan untuk mendefinisikan route, parameter binding, dsb.
     */
    public function boot(): void
    {
        // Belum ada bootstrapping untuk routing
    }
}