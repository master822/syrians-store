<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();
        
        $stats = [
            'total_products' => $products->count(),
            'active_products' => $products->where('status', 'active')->count(),
            'total_views' => $products->sum('views'),
            'total_ratings' => Rating::where('merchant_id', $user->id)->count(),
            'average_rating' => Rating::where('merchant_id', $user->id)->avg('rating') ?? 0,
        ];
        
        return view('merchant.dashboard', compact('user', 'products', 'stats'));
    }

    public function myProducts()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->get();
        
        return view('merchant.products', compact('user', 'products'));
    }

    public function merchantsList(Request $request)
    {
        $category = $request->get('category');
        
        $query = User::where('user_type', 'merchant')
                    ->where('is_active', true)
                    ->withCount(['products' => function($query) {
                        $query->where('status', 'active');
                    }])
                    ->with(['ratings']);

        // تصفية حسب نوع المتجر إذا كان محدد
        if ($category && in_array($category, ['clothes', 'electronics', 'home', 'grocery'])) {
            $query->where('store_category', $category);
        }

        $merchants = $query->paginate(12);

        return view('merchants.index', compact('merchants', 'category'));
    }

    public function show($id)
    {
        $merchant = User::where('id', $id)
                        ->where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->withCount(['products' => function($query) {
                            $query->where('status', 'active');
                        }])
                        ->with(['ratings'])
                        ->firstOrFail();

        // حساب متوسط التقييم
        $averageRating = $merchant->ratings->avg('rating') ?? 0;
        $totalRatings = $merchant->ratings->count();

        $products = Product::where('user_id', $id)
                          ->where('status', 'active')
                          ->with('category')
                          ->paginate(12);

        return view('merchants.show', compact('merchant', 'products', 'averageRating', 'totalRatings'));
    }

    // دالة لعرض تجار نوع معين
    public function byCategory($category)
    {
        $merchants = User::where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->where('store_category', $category)
                        ->withCount(['products' => function($query) {
                            $query->where('status', 'active');
                        }])
                        ->with(['ratings'])
                        ->paginate(12);

        $categoryName = $this->getCategoryName($category);

        return view('merchants.by-category', compact('merchants', 'category', 'categoryName'));
    }

    private function getCategoryName($categorySlug)
    {
        $categories = [
            'clothes' => 'ملابس',
            'electronics' => 'إلكترونيات',
            'home' => 'أدوات منزلية',
            'grocery' => 'بقالة'
        ];

        return $categories[$categorySlug] ?? 'غير معروف';
    }
}
