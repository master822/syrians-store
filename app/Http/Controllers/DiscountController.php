<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DiscountController extends Controller
{
    public function discounts(Request $request)
    {
        $selectedCategory = $request->get('category');
        
        $productsQuery = Product::where('discount_percentage', '>', 0)
            ->where('status', 'active')
            ->with(['user', 'category']);
        
        if ($selectedCategory && $selectedCategory !== 'all') {
            $productsQuery->whereHas('category', function($query) use ($selectedCategory) {
                $query->where('slug', $selectedCategory);
            });
        }
        
        $products = $productsQuery->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view('discounts', compact('products', 'categories', 'selectedCategory'));
    }

    public function categoryDiscounts($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $products = Product::where('discount_percentage', '>', 0)
            ->where('status', 'active')
            ->whereHas('category', function($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);
            
        $categories = Category::where('is_active', true)->get();
        $selectedCategory = $categorySlug;
        
        return view('discounts', compact('products', 'categories', 'selectedCategory', 'category'));
    }
}
