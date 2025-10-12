<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class MerchantDiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createDiscount()
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $products = Auth::user()->products()->where('is_active', true)->get();
        
        return view('merchant.discounts-create', compact('products'));
    }

    public function storeDiscount(Request $request)
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'discount_duration' => 'required|integer|min:0',
            'discount_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $userProducts = Auth::user()->products()->pluck('id')->toArray();
        $invalidProducts = array_diff($request->products, $userProducts);
        
        if (count($invalidProducts) > 0) {
            return back()->with('error', 'بعض المنتجات المحددة غير موجودة أو لا تنتمي إليك.');
        }

        $discountImages = [];
        if ($request->hasFile('discount_images')) {
            foreach ($request->file('discount_images') as $image) {
                $path = $image->store('discounts', 'public');
                $discountImages[] = $path;
            }
            $discountImages = array_slice($discountImages, 0, 3);
        }

        Product::whereIn('id', $request->products)
               ->update([
                   'discount_percentage' => $request->discount_percentage,
                   'discount_images' => !empty($discountImages) ? json_encode($discountImages) : null,
                   'updated_at' => now()
               ]);

        return redirect('/merchant/discounts')->with('success', 'تم تطبيق التخفيض بنجاح على ' . count($request->products) . ' منتج!');
    }

    public function showDiscounts()
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $products = Auth::user()->products()
            ->where('discount_percentage', '>', 0)
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('merchant.discounts', compact('products'));
    }

    public function editDiscount($id)
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $product = Auth::user()->products()
            ->where('id', $id)
            ->where('discount_percentage', '>', 0)
            ->firstOrFail();

        return view('merchant.discounts-edit', compact('product'));
    }

    public function updateDiscount(Request $request, $id)
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $product = Auth::user()->products()
            ->where('id', $id)
            ->where('discount_percentage', '>', 0)
            ->firstOrFail();

        $request->validate([
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'discount_duration' => 'required|integer|min:0',
            'discount_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $discountImages = json_decode($product->discount_images, true) ?? [];

        // حذف الصور القديمة إذا طلب المستخدم
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imagePath) {
                if (($key = array_search($imagePath, $discountImages)) !== false) {
                    Storage::disk('public')->delete($imagePath);
                    unset($discountImages[$key]);
                }
            }
            $discountImages = array_values($discountImages);
        }

        // إضافة الصور الجديدة
        if ($request->hasFile('discount_images')) {
            foreach ($request->file('discount_images') as $image) {
                if (count($discountImages) < 3) {
                    $path = $image->store('discounts', 'public');
                    $discountImages[] = $path;
                }
            }
        }

        $product->update([
            'discount_percentage' => $request->discount_percentage,
            'discount_images' => !empty($discountImages) ? json_encode($discountImages) : null,
        ]);

        return redirect('/merchant/discounts')->with('success', 'تم تحديث التخفيض بنجاح!');
    }

    public function removeDiscount($id)
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $product = Auth::user()->products()
            ->where('id', $id)
            ->where('discount_percentage', '>', 0)
            ->firstOrFail();

        $product->update([
            'discount_percentage' => 0,
            'discount_images' => null
        ]);

        return redirect('/merchant/discounts')->with('success', 'تم إزالة التخفيض بنجاح!');
    }
}
