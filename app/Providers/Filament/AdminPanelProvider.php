<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // Menandai panel ini sebagai panel default
            ->id('admin') // ID unik untuk panel admin
            ->path('admin') // Path URL untuk mengakses panel admin
            ->login() // Menggunakan halaman login bawaan Filament
            
            ->colors([
                'primary' => Color::Amber, // Warna utama tema panel
            ])

            // Otomatis mendeteksi resource dari folder dan namespace yang ditentukan
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')

            // Otomatis mendeteksi halaman dari folder dan namespace yang ditentukan
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')

            ->pages([
                Pages\Dashboard::class, // Halaman dashboard utama
            ])

            // Otomatis mendeteksi widget dari folder dan namespace yang ditentukan
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

            ->widgets([
                Widgets\AccountWidget::class,       // Widget akun pengguna
                Widgets\FilamentInfoWidget::class,  // Widget info sistem Filament
            ])

            // Middleware yang dijalankan untuk setiap request ke panel
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                'can:access-admin-panel' // Middleware untuk membatasi akses hanya user tertentu
            ])

            // Middleware autentikasi untuk panel
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}