<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['user', 'ratings.user'])
            ->where('is_active', true)
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function discounts()
    {
        $products = Product::with('user')
            ->where('is_active', true)
            ->where('discount_percentage', '>', 0)
            ->latest()
            ->paginate(12);

        return view('discounts', compact('products'));
    }

    public function addRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $product = Product::findOrFail($id);

        // التحقق إذا كان المستخدم قد قيم هذا المنتج من قبل
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);
        }

        return back()->with('success', 'تم إضافة التقييم بنجاح');
    }

    public function contactMerchant(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $product = Product::with('user')->findOrFail($id);
        
        // هنا يمكنك إضافة منطق إرسال الرسالة للتاجر
        // مثلاً حفظ في جدول المحادثات أو إرسال إيميل

        return back()->with('success', 'تم إرسال رسالتك إلى التاجر: ' . $product->user->name);
    }
}
