<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $usedProductsCount = Product::where('user_id', $user->id)
                                   ->where('is_used', true)
                                   ->count();

        $activeProductsCount = Product::where('user_id', $user->id)
                                     ->where('is_used', true)
                                     ->where('status', 'active')
                                     ->count();

        $viewsCount = Product::where('user_id', $user->id)->sum('views');

        $recentProducts = Product::where('user_id', $user->id)
                                ->where('is_used', true)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        return view('user.dashboard', compact(
            'user',
            'usedProductsCount',
            'activeProductsCount', 
            'viewsCount',
            'recentProducts'
        ));
    }

    public function myProducts()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)
                          ->where('is_used', true)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('user.my-products', compact('user', 'products'));
    }
}
