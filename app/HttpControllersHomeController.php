<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // أحدث المنتجات مع التخفيضات
        $newProducts = Product::with('user')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // المنتجات ذات التخفيضات
        $discountedProducts = Product::with('user')
            ->where('is_active', true)
            ->where('discount_percentage', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('newProducts', 'discountedProducts'));
    }
}
