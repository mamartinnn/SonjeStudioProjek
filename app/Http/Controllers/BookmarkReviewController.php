<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkReviewController extends Controller
{
    /**
     * Menyimpan produk sebagai bookmark untuk user yang sedang login.
     */
    public function storeBookmark(Product $product)
    {
        $user = Auth::user();

        // Cegah duplikasi bookmark jika sudah pernah di-bookmark
        if ($user->bookmarkedProducts()->where('product_id', $product->id)->exists()) {
            return back()->with('info', 'Product already bookmarked.');
        }

        // Simpan relasi bookmark ke tabel pivot
        $user->bookmarkedProducts()->attach($product->id);

        return back()->with('success', 'Product bookmarked successfully.');
    }

    /**
     * Menghapus bookmark produk untuk user yang sedang login.
     */
    public function destroyBookmark(Product $product)
    {
        $user = Auth::user();

        // Hapus relasi bookmark dari tabel pivot
        $user->bookmarkedProducts()->detach($product->id);

        return back()->with('success', 'Bookmark removed successfully.');
    }

    /**
     * Menyimpan review produk dari user.
     */
    public function storeReview(Request $request, Product $product)
    {
        // Validasi input review
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Simpan review ke database dengan relasi ke produk dan user
        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    /**
     * Menampilkan halaman bookmark user yang sedang login.
     */
    public function index()
    {
        // Ambil semua produk yang sudah di-bookmark oleh user beserta kategorinya
        $bookmarkedProducts = Auth::user()
            ->bookmarkedProducts()
            ->with('categories')
            ->get();

        // Tampilkan view dengan data bookmark
        return view('layouts.account.bookmarks', compact('bookmarkedProducts'));
    }
}
