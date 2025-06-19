<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ShopRedirectController extends Controller
{
    public function shopee(Product $product): RedirectResponse
    {
        if ($product->shopee_url) {
            return redirect()->away($product->shopee_url);
        }

        return back()->with('error', 'Shopee link not available.');
    }

    public function tiktok(Product $product): RedirectResponse
    {
        if ($product->tiktok_url) {
            return redirect()->away($product->tiktok_url);
        }

        return back()->with('error', 'TikTok Shop link not available.');
    }
}
