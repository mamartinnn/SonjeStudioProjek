<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ShopRedirectController extends Controller
{
    // Redirect ke URL Shopee jika tersedia, jika tidak kembali dengan pesan error
    public function shopee(Product $product): RedirectResponse
    {
        // Cek apakah produk memiliki URL Shopee
        if ($product->shopee_url) {
            // Redirect ke halaman Shopee eksternal
            return redirect()->away($product->shopee_url);
        }

        // Kembali ke halaman sebelumnya jika tidak ada URL Shopee
        return back()->with('error', 'Shopee link not available.');
    }

    // Redirect ke URL TikTok Shop jika tersedia, jika tidak kembali dengan pesan error
    public function tiktok(Product $product): RedirectResponse
    {
        // Cek apakah produk memiliki URL TikTok
        if ($product->tiktok_url) {
            // Redirect ke halaman TikTok Shop eksternal
            return redirect()->away($product->tiktok_url);
        }

        // Kembali ke halaman sebelumnya jika tidak ada URL TikTok
        return back()->with('error', 'TikTok Shop link not available.');
    }
}
