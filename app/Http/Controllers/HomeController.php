<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function index()
    {
        // Ambil produk dengan kategori "Best Seller" secara acak, maksimal 16 item
        $products = Product::whereHas('categories', function ($query) {
                $query->where('name', 'Best Seller');
            })
            ->where('is_visible', true) // hanya tampilkan produk yang visible
            ->inRandomOrder()
            ->take(16)
            ->get();

        // Ambil 4 produk terbaru yang visible, kemudian diacak urutannya
        $newArrivals = Product::where('is_visible', true)
            ->latest() // berdasarkan kolom created_at
            ->take(4)
            ->get()
            ->shuffle(); // acak urutan tampilnya di frontend

        // Ambil 12 produk acak untuk bagian "Shop Studio Now"
        $randomProducts = Product::where('is_visible', true)
            ->inRandomOrder()
            ->take(12)
            ->get();

        // Kirim semua data ke view home.blade.php
        return view('home', compact('products', 'newArrivals', 'randomProducts'));
    }
}
