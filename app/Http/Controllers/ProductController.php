<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();
        $categories = Category::where('is_active', true)->get();

        // تحقق من نوع المستخدم وعرض النموذج المناسب
        if ($user->user_type === 'user') {
            return view('products.create-used', compact('categories'));
        } elseif ($user->user_type === 'merchant') {
            return view('products.create-new', compact('categories'));
        } else {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لإضافة منتجات.');
        }
    }

    public function store(Request $request)
    {
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

        // التحقق من نوع المستخدم ونوع المنتج
        if ($user->user_type === 'user' && $request->is_used == false) {
            return redirect()->back()->with('error', 'المستخدمون العاديون يمكنهم فقط إضافة منتجات مستعملة.');
        }

        if ($user->user_type === 'merchant' && $request->is_used == true) {
            return redirect()->back()->with('error', 'التجار يمكنهم فقط إضافة منتجات جديدة.');
        }

        // التحقق من الحد الأقصى للمنتجات
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

        // معالجة الصور
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $product->images = json_encode($imagePaths);
        }

        $product->save();

        // التوجيه إلى الصفحة المناسبة حسب نوع المستخدم
        $redirectRoute = $user->user_type === 'user' ? 'user.products' : 'merchant.products';
        return redirect()->route($redirectRoute)
                        ->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لتعديل هذا المنتج.');
        }
        
        $categories = Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لتعديل هذا المنتج.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'condition' => $product->is_used ? 'required|string|max:255' : 'nullable',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        
        $product->condition = $product->is_used ? $request->condition : null;

        // معالجة حذف الصور
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                Storage::disk('public')->delete($imageToDelete);
            }
            
            // الحصول على الصور الحالية كـ array
            $currentImages = [];
            if ($product->images) {
                $decodedImages = json_decode($product->images, true);
                if (is_array($decodedImages)) {
                    $currentImages = $decodedImages;
                }
            }
            
            $remainingImages = array_diff($currentImages, $request->delete_images);
            $product->images = !empty($remainingImages) ? json_encode(array_values($remainingImages)) : null;
        }

        // معالجة إضافة صور جديدة
        if ($request->hasFile('images')) {
            // الحصول على الصور الحالية كـ array
            $currentImages = [];
            if ($product->images) {
                $decodedImages = json_decode($product->images, true);
                if (is_array($decodedImages)) {
                    $currentImages = $decodedImages;
                }
            }
            
            $newImages = [];
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $newImages[] = $path;
            }
            
            $allImages = array_merge($currentImages, $newImages);
            $product->images = json_encode($allImages);
        }

        $product->save();

        return redirect()->route('products.show', $product->id)
                        ->with('success', 'تم تحديث المنتج بنجاح.');
    }

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
        $products = Product::where('status', 'active')
                          ->where('is_used', true)
                          ->whereHas('user', function($query) {
                              $query->where('user_type', 'user');
                          })
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.used', compact('products'));
    }

    public function newProducts()
    {
        $products = Product::where('status', 'active')
                          ->where('is_used', false)
                          ->whereHas('user', function($query) {
                              $query->where('user_type', 'merchant');
                          })
                          ->with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.new', compact('products'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        
        if (!$category) {
            $category = Category::find($categorySlug);
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

        $productsQuery = Product::where('status', 'active')
                              ->with(['user', 'category']);

        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('description', 'like', "%$query%");
            });
        }

        if ($minPrice) {
            $productsQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

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
            default:
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
        
        $canEdit = Auth::check() && Auth::id() === $product->user_id;

        // الحصول على منتجات مشابهة
        $similarProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->where('status', 'active')
                                 ->with(['user', 'category'])
                                 ->inRandomOrder()
                                 ->take(4)
                                 ->get();
        
        return view('products.show', compact('product', 'canEdit', 'similarProducts'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لحذف هذا المنتج.');
        }

        // حذف الصور من التخزين
        if ($product->images) {
            $images = json_decode($product->images);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        $redirectRoute = Auth::user()->user_type === 'user' ? 'user.products' : 'merchant.products';
        return redirect()->route($redirectRoute)
                        ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
