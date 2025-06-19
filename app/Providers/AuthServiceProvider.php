<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan layanan autentikasi dan otorisasi.
     */
    public function boot(): void
    {
        // Mendefinisikan gate 'access-admin-panel' untuk membatasi akses ke panel admin
        Gate::define('access-admin-panel', function (User $user) {
            // Hanya izinkan jika user adalah admin
            return $user->is_admin; 
        });
    }
}