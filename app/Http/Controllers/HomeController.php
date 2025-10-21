<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // المنتجات الجديدة (غير المستعملة)
        $newProducts = Product::where('status', 'active')
                            ->where('is_used', false)
                            ->with(['user', 'category'])
                            ->orderBy('created_at', 'desc')
                            ->take(8)
                            ->get();

        // المنتجات ذات التخفيضات
        $activeDiscounts = Product::where('status', 'active')
                                ->where('discount_percentage', '>', 0)
                                ->where('is_used', false)
                                ->with(['user', 'category'])
                                ->latest()
                                ->take(6)
                                ->get();

        // التجار النشطين
        $merchants = User::where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->whereHas('products', function($query) {
                            $query->where('status', 'active')
                                  ->where('is_used', false);
                        })
                        ->withCount(['ratings'])
                        ->orderBy('ratings_count', 'desc')
                        ->take(8)
                        ->get();

        // المنتجات المستعملة الأكثر مشاهدة
        $topUsedProducts = Product::where('status', 'active')
                                ->where('is_used', true)
                                ->with(['user', 'category'])
                                ->orderBy('views', 'desc')
                                ->take(4)
                                ->get();

        return view('home', compact('newProducts', 'activeDiscounts', 'merchants', 'topUsedProducts'));
    }
}
