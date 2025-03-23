<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products and categories.
     */
    public function index()
    {
        $featuredProducts = Product::where('status', 'published')
            ->latest()
            ->take(8)
            ->get();
        
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();
        
        return view('home', compact('featuredProducts', 'categories'));
    }
}