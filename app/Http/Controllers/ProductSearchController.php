<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductSearchController extends Controller
{
    /**
     * Menangani pencarian dan filter produk.
     */
    public function index(Request $request)
    {
        // Mulai query produk
        $query = Product::query();

        // Filter berdasarkan nama produk (pencarian teks)
        if ($request->filled('q')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->q) . '%']);
        }

        // Filter berdasarkan kategori (ID)
        if ($request->filled('category')) {
    $query->whereHas('categories', function ($q) use ($request) {
        $q->where('categories.id', $request->category);
    });
}


        // Filter harga minimum
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter harga maksimum
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Ambil hasil pencarian dan paginasi 12 per halaman
        $products = $query->paginate(12);

        // Ambil semua kategori untuk dropdown filter di UI
        $categories = Category::all();

        // Kirim data ke view pencarian
        return view('layouts.products.search', compact('products', 'categories'));
    }
}
