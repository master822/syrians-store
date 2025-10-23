<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود اللغة في الجلسة أو استخدام اللغة الافتراضية
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // اللغة الافتراضية هي العربية
            App::setLocale('ar');
            Session::put('locale', 'ar');
        }

        return $next($request);
    }
}
