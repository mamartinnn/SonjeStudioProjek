<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function show($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    return view('layouts.products.show', compact('product'));

}   


}
