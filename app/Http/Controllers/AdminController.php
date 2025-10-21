<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // التحقق من أن المستخدم مدير
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $stats = [
            'total_users' => User::where('user_type', 'user')->count(),
            'total_merchants' => User::where('user_type', 'merchant')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'total_ratings' => Rating::count(),
            'pending_products' => Product::where('status', 'pending')->count(),
            'today_registrations' => User::whereDate('created_at', today())->count(),
        ];

        // إحصائيات الاشتراكات
        $subscriptionStats = [
            'free_merchants' => User::where('user_type', 'merchant')->where('subscription_plan', 'free')->count(),
            'basic_merchants' => User::where('user_type', 'merchant')->where('subscription_plan', 'basic')->count(),
            'medium_merchants' => User::where('user_type', 'merchant')->where('subscription_plan', 'medium')->count(),
            'premium_merchants' => User::where('user_type', 'merchant')->where('subscription_plan', 'premium')->count(),
        ];

        // الإيرادات (محاكاة)
        $revenueStats = [
            'monthly_revenue' => 150000, // محاكاة
            'total_revenue' => 4500000, // محاكاة
            'pending_payments' => 25000, // محاكاة
        ];

        // أحدث المستخدمين
        $recentUsers = User::latest()->take(5)->get();
        
        // أحدث المنتجات
        $recentProducts = Product::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'subscriptionStats', 'revenueStats', 'recentUsers', 'recentProducts'));
    }

    public function users()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $products = Product::with('user', 'category')->latest()->paginate(15);
        return view('admin.products', compact('products'));
    }

    public function merchants()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $merchants = User::where('user_type', 'merchant')->latest()->paginate(15);
        return view('admin.merchants', compact('merchants'));
    }

    public function categories()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $categories = Category::latest()->paginate(15);
        return view('admin.categories', compact('categories'));
    }

    public function settings()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        // هنا يمكنك حفظ الإعدادات في قاعدة البيانات أو ملف البيئة
        // هذا مثال مبسط

        return redirect()->route('admin.settings')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }

    public function toggleUserStatus($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'مفعل' : 'معطل';
        return back()->with('success', 'تم ' . $status . ' المستخدم بنجاح.');
    }

    public function toggleProductStatus($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $product = Product::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        $status = $product->status === 'active' ? 'تفعيل' : 'تعطيل';
        return back()->with('success', 'تم ' . $status . ' المنتج بنجاح.');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $user = User::findOrFail($id);
        
        // حذف المنتجات المرتبطة أولاً
        $user->products()->delete();
        $user->delete();

        return back()->with('success', 'تم حذف المستخدم وجميع منتجاته بنجاح.');
    }

    public function deleteProduct($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'تم حذف المنتج بنجاح.');
    }

    public function viewUser($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $user = User::with(['products' => function($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('admin.user-details', compact('user'));
    }

    public function viewMerchantStore($id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $merchant = User::where('id', $id)
                        ->where('user_type', 'merchant')
                        ->with(['products' => function($query) {
                            $query->where('status', 'active')->latest();
                        }])
                        ->firstOrFail();

        return view('admin.merchant-store', compact('merchant'));
    }
}
