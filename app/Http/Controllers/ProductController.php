<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan detail produk berdasarkan slug.
     *
     * @param string $slug Slug dari produk
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Ambil data produk berdasarkan slug, jika tidak ditemukan maka 404
        $product = Product::where('slug', $slug)->firstOrFail();

        // Tampilkan view detail produk di layouts/products/show.blade.php
        return view('layouts.products.show', compact('product'));
    }
}
