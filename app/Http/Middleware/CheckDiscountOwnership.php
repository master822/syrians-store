<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class CheckDiscountOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $productId = $request->route('id');
        $product = Product::findOrFail($productId);

        // التحقق من أن المستخدم هو مالك المنتج للتخفيض
        if ($product->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لتعديل هذا التخفيض');
        }

        return $next($request);
    }
}
