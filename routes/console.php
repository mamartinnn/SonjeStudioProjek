<?php

// Mengimpor class Inspiring untuk mengakses kutipan inspirasional
use Illuminate\Foundation\Inspiring;

// Mengimpor facade Artisan untuk mendefinisikan command Artisan kustom
use Illuminate\Support\Facades\Artisan;

// Mendefinisikan command Artisan baru dengan nama 'inspire'
Artisan::command('inspire', function () {
    // Menampilkan kutipan inspirasional di console
    $this->comment(Inspiring::quote());
})

// Menetapkan tujuan (deskripsi) dari command ini dan menyetel agar dijalankan setiap jam
->purpose('Display an inspiring quote')->hourly();