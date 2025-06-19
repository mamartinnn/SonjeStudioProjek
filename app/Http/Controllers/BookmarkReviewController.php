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
     * Store a new bookmark.
     */
    public function storeBookmark(Product $product)
    {
        $user = Auth::user();

        // Prevent duplicate bookmarks
        if ($user->bookmarkedProducts()->where('product_id', $product->id)->exists()) {
            return back()->with('info', 'Product already bookmarked.');
        }

        $user->bookmarkedProducts()->attach($product->id);

        return back()->with('success', 'Product bookmarked successfully.');
    }

    /**
     * Remove a bookmark.
     */
    public function destroyBookmark(Product $product)
    {
        $user = Auth::user();

        $user->bookmarkedProducts()->detach($product->id);

        return back()->with('success', 'Bookmark removed successfully.');
    }

    /**
     * Store a product review.
     */
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

        public function index()
    {
        $bookmarkedProducts = Auth::user()->bookmarkedProducts()->with('categories')->get();

        return view('layouts.account.bookmarks', compact('bookmarkedProducts'));
    }

}
