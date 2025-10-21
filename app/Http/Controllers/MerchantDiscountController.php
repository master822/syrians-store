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

        $products = Auth::user()->products()
            ->where('status', 'active')
            ->where('is_used', false)
            ->get();
        
        return view('merchant.discounts-create', compact('products'));
    }

    public function storeDiscount(Request $request)
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        // تحقق من وجود منتجات مختارة
        if (!$request->has('products') || empty($request->products)) {
            return back()->with('error', 'يجب اختيار منتج واحد على الأقل')->withInput();
        }

        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'discount_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // التحقق من أن المنتجات تنتمي للتاجر
        $userProducts = Auth::user()->products()->pluck('id')->toArray();
        $invalidProducts = array_diff($request->products, $userProducts);
        
        if (count($invalidProducts) > 0) {
            return back()->with('error', 'بعض المنتجات المحددة غير موجودة أو لا تنتمي إليك.')->withInput();
        }

        // معالجة الصور
        $discountImages = [];
        if ($request->hasFile('discount_images')) {
            foreach ($request->file('discount_images') as $image) {
                $path = $image->store('discounts', 'public');
                $discountImages[] = $path;
            }
            $discountImages = array_slice($discountImages, 0, 3);
        }

        // تطبيق التخفيض على المنتجات المختارة
        $updatedCount = 0;
        foreach ($request->products as $productId) {
            $product = Product::find($productId);
            if ($product && $product->user_id === Auth::id()) {
                $product->update([
                    'discount_percentage' => $request->discount_percentage,
                    'discount_images' => !empty($discountImages) ? json_encode($discountImages) : null,
                    'updated_at' => now()
                ]);
                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            return redirect('/merchant/discounts')->with('success', 'تم تطبيق التخفيض بنجاح على ' . $updatedCount . ' منتج!');
        } else {
            return back()->with('error', 'حدث خطأ أثناء تطبيق التخفيض')->withInput();
        }
    }

    public function showDiscounts()
    {
        if (Auth::user()->user_type !== 'merchant') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $products = Auth::user()->products()
            ->where('discount_percentage', '>', 0)
            ->where('status', 'active')
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

        // تحديث التخفيض
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

        // حذف الصور المرتبطة بالتخفيض
        if ($product->discount_images) {
            $images = json_decode($product->discount_images);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->update([
            'discount_percentage' => 0,
            'discount_images' => null
        ]);

        return redirect('/merchant/discounts')->with('success', 'تم إزالة التخفيض بنجاح!');
    }
}
