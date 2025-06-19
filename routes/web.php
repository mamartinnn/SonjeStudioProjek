<?php
// Mengimpor berbagai class controller yang digunakan dalam routing
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopRedirectController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookmarkReviewController;
use App\Http\Controllers\ProductSearchController;

// ==============================
// Halaman Utama & Produk
// ==============================

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail produk berdasarkan slug
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Pencarian produk
Route::get('/search', [ProductSearchController::class, 'index'])->name('products.search');

// ==============================
// Redirect ke Toko Eksternal (Shopee, TikTok)
// ==============================

// Redirect ke Shopee jika produk memiliki URL Shopee
Route::get('/products/{product}/shopee', [ShopRedirectController::class, 'shopee'])->name('product.shopee');

// Redirect ke TikTok Shop jika produk memiliki URL TikTok
Route::get('/products/{product}/tiktok', [ShopRedirectController::class, 'tiktok'])->name('product.tiktok');

// ==============================
// Autentikasi
// ==============================

// Proses login pengguna
Route::post('/login', [LoginController::class, 'store'])->name('login');

// Mengimpor file auth bawaan Laravel (login, register, reset password, dll)
require __DIR__.'/auth.php'; 

// ==============================
// Area Akun (Hanya untuk pengguna terautentikasi)
// ==============================

Route::middleware('auth')->group(function () {

    // Dashboard pengguna
    Route::get('/account/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');

    // ------------------------------
    // Bookmark Produk
    // ------------------------------

    // Tambah bookmark ke produk
    Route::post('/products/{product}/bookmark', [BookmarkReviewController::class, 'storeBookmark'])->name('bookmark.store');

    // Hapus bookmark dari produk
    Route::delete('/products/{product}/bookmark', [BookmarkReviewController::class, 'destroyBookmark'])->name('bookmark.destroy');

    // Tampilkan daftar produk yang dibookmark oleh user
    Route::get('/account/bookmarks', [BookmarkReviewController::class, 'index'])->name('bookmarks.index');

    // ------------------------------
    // Review Produk
    // ------------------------------

    // Kirim ulasan/review untuk suatu produk
    Route::post('/products/{product}/reviews', [BookmarkReviewController::class, 'storeReview'])->name('review.store');

    // ------------------------------
    // Profil Pengguna
    // ------------------------------

    // Form edit profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});