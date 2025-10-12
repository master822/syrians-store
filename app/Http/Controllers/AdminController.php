<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

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
            'users' => User::count(),
            'merchants' => User::where('user_type', 'merchant')->count(),
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count()
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        // التحقق من أن المستخدم مدير
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        // التحقق من أن المستخدم مدير
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        $products = Product::with('user')->latest()->paginate(10);
        return view('admin.products', compact('products'));
    }
}
