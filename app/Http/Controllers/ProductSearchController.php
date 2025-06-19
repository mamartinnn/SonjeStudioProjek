<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by name
        if ($request->filled('q')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->q) . '%']);
        }

        // Filter by category
        if ($request->filled('category')) {
    $query->whereHas('categories', function ($q) use ($request) {
        $q->where('categories.id', $request->category);
    });
}


        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('layouts.products.search', compact('products', 'categories'));
    }
}

