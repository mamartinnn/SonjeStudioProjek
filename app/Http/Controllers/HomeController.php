<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Produk "Best Seller" acak
        $products = Product::whereHas('categories', function ($query) {
                $query->where('name', 'Best Seller');
            })
            ->where('is_visible', true)
            ->inRandomOrder() 
            ->take(16)
            ->get();

      
       $newArrivals = Product::where('is_visible', true)
        ->latest()
        ->take(4)
        ->get()
        ->shuffle(); 


        // Produk acak untuk "Shop Studio Now"
        $randomProducts = Product::where('is_visible', true)
            ->inRandomOrder()
            ->take(12)
            ->get();

        return view('home', compact('products', 'newArrivals', 'randomProducts'));
    }
}
