<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // المنتجات الجديدة (غير المستعملة)
        $newProducts = Product::where('is_active', true)
                            ->where('is_used', false)
                            ->with('user')
                            ->latest()
                            ->take(8)
                            ->get();

        // المنتجات ذات التخفيضات
        $activeDiscounts = Product::where('is_active', true)
                                ->where('discount_percentage', '>', 0)
                                ->where('is_used', false)
                                ->with('user')
                                ->latest()
                                ->take(6)
                                ->get();

        // التجار النشطين (بدون استخدام HAVING)
        $merchants = User::where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->withCount(['products' => function($query) {
                            $query->where('is_active', true)
                                  ->where('is_used', false);
                        }])
                        ->whereHas('products', function($query) {
                            $query->where('is_active', true)
                                  ->where('is_used', false);
                        })
                        ->take(8)
                        ->get();

        return view('home', compact('newProducts', 'activeDiscounts', 'merchants'));
    }
}
