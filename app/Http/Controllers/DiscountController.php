<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DiscountController extends Controller
{
    public function discounts(Request $request)
    {
        // الحصول على القسم المحدد للتصفية
        $selectedCategory = $request->get('category');
        
        // بناء الاستعلام للحصول على المنتجات المخفضة
        $productsQuery = Product::where('discount_percentage', '>', 0)
            ->where('is_active', true)
            ->with('user'); // تحميل بيانات التاجر
        
        // تطبيق التصفية حسب القسم إذا تم تحديده
        if ($selectedCategory && $selectedCategory !== 'all') {
            $productsQuery->where('category', $selectedCategory);
        }
        
        // الحصول على المنتجات مع التصنيف
        $products = $productsQuery->latest()->paginate(12);
        
        // الحصول على جميع الأقسام المتاحة
        $categories = Category::where('is_active', true)->get();
        
        return view('discounts', compact('products', 'categories', 'selectedCategory'));
    }
}
