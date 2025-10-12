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
        
        return view('merchant.dashboard', compact('user', 'products'));
    }

    public function myProducts()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();
        
        return view('merchant.products', compact('user', 'products'));
    }

    public function merchantsList(Request $request)
    {
        $category = $request->get('category');
        
        $query = User::where('user_type', 'merchant')
                    ->where('is_active', true);

        // تصفية حسب نوع المتجر إذا كان محدد
        if ($category && in_array($category, ['clothes', 'electronics', 'home', 'grocery'])) {
            $query->where('store_category', $category);
        }

        $merchants = $query->paginate(12);

        $currentCategory = $category;

        return view('merchants.index', compact('merchants', 'currentCategory'));
    }

    public function show($id)
    {
        $merchant = User::where('id', $id)
                        ->where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->firstOrFail();

        $products = Product::where('user_id', $id)
                          ->where('status', 'active')
                          ->paginate(12);

        return view('merchants.show', compact('merchant', 'products'));
    }

    // دالة لعرض تجار نوع معين
    public function byCategory($category)
    {
        $merchants = User::where('user_type', 'merchant')
                        ->where('is_active', true)
                        ->where('store_category', $category)
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
