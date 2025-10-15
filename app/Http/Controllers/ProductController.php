<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function usedProducts()
    {
        // عرض المنتجات المستعملة فقط (من المستخدمين العاديين)
        $products = Product::where('status', 'active')
                          ->where('is_used', true)
                          ->whereHas('user', function($query) {
                              $query->where('user_type', 'user'); // فقط من المستخدمين العاديين
                          })
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.used', compact('products'));
    }

    public function newProducts()
    {
        // عرض المنتجات الجديدة فقط (من التجار)
        $products = Product::where('status', 'active')
                          ->where('is_used', false)
                          ->whereHas('user', function($query) {
                              $query->where('user_type', 'merchant'); // فقط من التجار
                          })
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.new', compact('products'));
    }

    public function byCategory($categoryId)
    {
        // البحث باستخدام slug أولاً
        $category = Category::where('slug', $categoryId)->first();
        
        if (!$category) {
            // إذا لم يتم العثور باستخدام slug، جرب البحث باستخدام ID
            $category = Category::find($categoryId);
        }

        if (!$category) {
            abort(404, 'التصنيف غير موجود');
        }

        $products = Product::where('category_id', $category->id)
                          ->where('status', 'active')
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.by-category', compact('products', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $categoryId = $request->get('category_id');
        $productType = $request->get('product_type');
        $sort = $request->get('sort', 'newest');

        // بناء الاستعلام الأساسي
        $productsQuery = Product::where('status', 'active')
                              ->with(['user', 'category']);

        // البحث في النص
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('description', 'like', "%$query%");
            });
        }

        // نطاق السعر
        if ($minPrice) {
            $productsQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        // التصنيف
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // نوع المنتج
        if ($productType === 'new') {
            $productsQuery->where('is_used', false)
                         ->whereHas('user', function($query) {
                             $query->where('user_type', 'merchant');
                         });
        } elseif ($productType === 'used') {
            $productsQuery->where('is_used', true)
                         ->whereHas('user', function($query) {
                             $query->where('user_type', 'user');
                         });
        }

        // الترتيب
        switch ($sort) {
            case 'oldest':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default: // newest
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->paginate(12);

        return view('products.search', compact('products', 'query', 'minPrice', 'maxPrice', 'categoryId', 'productType', 'sort'));
    }

    public function show($id)
    {
        $product = Product::with(['user', 'category'])->findOrFail($id);
        $product->increment('views');

        return view('products.show', compact('product'));
    }

    public function create()
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();
        $categories = Category::where('is_active', true)->get();

        // التحقق من الصلاحيات
        if ($user->user_type === 'user') {
            // المستخدم العادي يمكنه فقط إضافة منتجات مستعملة
            return view('products.create-used', compact('categories'));
        } elseif ($user->user_type === 'merchant') {
            // التاجر يمكنه فقط إضافة منتجات جديدة
            return view('products.create-new', compact('categories'));
        } else {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لإضافة منتجات.');
        }
    }

    public function store(Request $request)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_used' => 'required|boolean',
            'condition' => 'required_if:is_used,true|string|max:255',
        ]);

        // التحقق من الصلاحيات
        if ($user->user_type === 'user' && $request->is_used == false) {
            return redirect()->back()->with('error', 'المستخدمون العاديون يمكنهم فقط إضافة منتجات مستعملة.');
        }

        if ($user->user_type === 'merchant' && $request->is_used == true) {
            return redirect()->back()->with('error', 'التجار يمكنهم فقط إضافة منتجات جديدة.');
        }

        $userProductsCount = Product::where('user_id', $user->id)->count();
        if ($userProductsCount >= $user->product_limit) {
            return redirect()->back()->with('error', 'لقد وصلت إلى الحد الأقصى للمنتجات المسموح بها.');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->user_id = $user->id;
        $product->is_used = $request->is_used;
        $product->condition = $request->is_used ? $request->condition : null;
        $product->status = 'active';

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $product->images = json_encode($imagePaths);
        }

        $product->save();

        $redirectRoute = $user->user_type === 'user' ? 'user.products' : 'merchant.products';
        return redirect()->route($redirectRoute)
                        ->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج.');
        }
        
        $categories = Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_used' => 'required|boolean',
            'condition' => 'required_if:is_used,true|string|max:255',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->is_used = $request->is_used;
        $product->condition = $request->is_used ? $request->condition : null;

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $product->images = json_encode($imagePaths);
        }

        $product->save();

        return redirect()->route('products.show', $product->id)
                        ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا المنتج.');
        }

        if ($product->images) {
            $images = json_decode($product->images);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        $redirectRoute = Auth::user()->user_type === 'user' ? 'user.products' : 'merchant.products';
        return redirect()->route($redirectRoute)
                        ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
