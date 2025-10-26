<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isMerchant()) {
            $user = Auth::user();
            
            // التحقق من الفترة التجريبية
            if (!$user->is_trial_used && $user->created_at->addDays($user->trial_days)->isFuture()) {
                // لا يزال في الفترة التجريبية
                return $next($request);
            }

            // التحقق من الاشتراك النشط
            if ($user->subscription_end && $user->subscription_end->isPast()) {
                // انتهى الاشتراك، الرجوع للخطة المجانية
                $user->update([
                    'current_plan' => 'free',
                    'product_limit' => 5
                ]);
                
                if ($request->route()->getName() !== 'merchant.subscription.plans') {
                    return redirect()->route('merchant.subscription.plans')
                        ->with('warning', 'انتهت فترة اشتراكك. يرجى تجديد الاشتراك للمتابعة.');
                }
            }
        }

        return $next($request);
    }
}
