<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpleProductController extends Controller
{
    public function createSimple()
    {
        return "🎉 SUCCESS: Simple Product Create Page is working!";
    }
    
    public function createWithAuth()
    {
        if (!Auth::check()) {
            return "❌ NOT LOGGED IN";
        }
        
        $user = Auth::user();
        return "🎉 SUCCESS: Logged in as " . $user->name . " (" . $user->user_type . ")";
    }
    
    public function createWithView()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        return view('products.create-new');
    }
}
