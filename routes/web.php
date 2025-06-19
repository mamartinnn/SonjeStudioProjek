<?php
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

// Home & Product
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductSearchController::class, 'index'])->name('products.search');

// External Shop Redirects
Route::get('/products/{product}/shopee', [ShopRedirectController::class, 'shopee'])->name('product.shopee');
Route::get('/products/{product}/tiktok', [ShopRedirectController::class, 'tiktok'])->name('product.tiktok');

// Auth
Route::post('/login', [LoginController::class, 'store'])->name('login');
require __DIR__.'/auth.php'; 



// Account Area
Route::middleware('auth')->group(function () {
    Route::get('/account/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');

    // Bookmark
    Route::post('/products/{product}/bookmark', [BookmarkReviewController::class, 'storeBookmark'])->name('bookmark.store');
    Route::delete('/products/{product}/bookmark', [BookmarkReviewController::class, 'destroyBookmark'])->name('bookmark.destroy');
    Route::get('/account/bookmarks', [BookmarkReviewController::class, 'index'])->name('bookmarks.index');





    
    // Review
    Route::post('/products/{product}/reviews', [BookmarkReviewController::class, 'storeReview'])->name('review.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
