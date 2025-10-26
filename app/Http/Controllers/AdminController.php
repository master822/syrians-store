<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Subscription;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        // إحصائيات أساسية
        $stats = [
            'total_users' => User::where('user_type', 'user')->count(),
            'total_merchants' => User::where('user_type', 'merchant')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'pending_products' => Product::where('status', 'pending')->count(),
            'today_registrations' => User::whereDate('created_at', today())->count(),
            'today_logins' => DB::table('sessions')->whereDate('last_activity', today())->count(),
        ];

        // إحصائيات الاشتراكات
        $subscriptionStats = [
            'free_merchants' => User::where('user_type', 'merchant')->where('current_plan', 'free')->count(),
            'basic_merchants' => User::where('user_type', 'merchant')->where('current_plan', 'basic')->count(),
            'medium_merchants' => User::where('user_type', 'merchant')->where('current_plan', 'medium')->count(),
            'premium_merchants' => User::where('user_type', 'merchant')->where('current_plan', 'premium')->count(),
            'total_subscriptions' => Subscription::where('status', 'completed')->count(),
            'monthly_revenue' => Subscription::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'total_revenue' => Subscription::where('status', 'completed')->sum('amount'),
        ];

        // الإيرادات الشهرية (آخر 6 أشهر) - متوافقة مع SQLite
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Subscription::where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            
            $monthlyRevenue[] = [
                'year' => $month->year,
                'month' => $month->month,
                'revenue' => $revenue,
                'month_name' => $month->translatedFormat('F Y')
            ];
        }

        // التسجيلات الشهرية (آخر 6 أشهر) - متوافقة مع SQLite
        $monthlyRegistrations = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $monthlyRegistrations[] = [
                'year' => $month->year,
                'month' => $month->month,
                'count' => $count,
                'month_name' => $month->translatedFormat('F Y')
            ];
        }

        // أحدث الاشتراكات
        $recentSubscriptions = Subscription::with('user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // أحدث المستخدمين
        $recentUsers = User::latest()->take(5)->get();
        
        // أحدث المنتجات
        $recentProducts = Product::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'subscriptionStats', 
            'monthlyRevenue',
            'monthlyRegistrations',
            'recentSubscriptions',
            'recentUsers', 
            'recentProducts'
        ));
    }

    // دوال إدارة المستخدمين
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

    // إعدادات الموقع
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

        // حفظ الإعدادات في ملف البيئة
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // تحديث القيم
        $envContent = preg_replace('/APP_NAME=.*/', 'APP_NAME="' . $request->site_name . '"', $envContent);
        
        if ($request->contact_email) {
            $envContent = preg_replace('/MAIL_FROM_ADDRESS=.*/', 'MAIL_FROM_ADDRESS=' . $request->contact_email, $envContent);
        }

        file_put_contents($envPath, $envContent);

        return redirect()->route('admin.settings')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }

    // الملف الشخصي للمسؤول
    public function showProfile()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون至少 8 أحرف على الأقل',
            'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        // التحقق من كلمة المرور الحالية إذا تم إدخال كلمة مرور جديدة
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }
        }

        // تحديث البيانات الأساسية
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;

        // تحديث كلمة المرور إذا تم إدخال كلمة مرور جديدة
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    // دوال التحكم في المستخدمين والمنتجات
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

    // تقارير الاشتراكات
    public function subscriptions()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $subscriptions = Subscription::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.subscriptions', compact('subscriptions'));
    }

    public function revenue()
    {
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        // إحصائيات الإيرادات - متوافقة مع SQLite
        $revenueStats = [
            'today' => Subscription::where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('amount'),
            'this_week' => Subscription::where('status', 'completed')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('amount'),
            'this_month' => Subscription::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'this_year' => Subscription::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'total' => Subscription::where('status', 'completed')->sum('amount'),
        ];

        // الإيرادات حسب الخطة
        $revenueByPlan = Subscription::where('status', 'completed')
            ->select('plan_type', DB::raw('SUM(amount) as revenue'))
            ->groupBy('plan_type')
            ->get();

        // الإيرادات الشهرية (آخر 12 شهر) - متوافقة مع SQLite
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Subscription::where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            
            $count = Subscription::where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $monthlyRevenue[] = [
                'year' => $month->year,
                'month' => $month->month,
                'revenue' => $revenue,
                'count' => $count,
                'month_name' => $month->translatedFormat('F Y')
            ];
        }

        return view('admin.revenue', compact('revenueStats', 'revenueByPlan', 'monthlyRevenue'));
    }
}
