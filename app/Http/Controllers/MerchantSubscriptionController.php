<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantSubscriptionController extends Controller
{
    public function plans()
    {
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $user = Auth::user();
        
        // حساب الأيام المتبقية في الفترة التجريبية
        $trialEndsAt = $user->created_at->addDays($user->trial_days);
        $daysLeft = now()->diffInDays($trialEndsAt, false);
        $isInTrial = $daysLeft > 0 && !$user->is_trial_used;

        $plans = [
            [
                'id' => 'basic',
                'name' => 'الخطة الأساسية',
                'price' => 2000,
                'currency' => 'TL',
                'products_limit' => 20,
                'features' => [
                    'إضافة حتى 20 منتج',
                    'لوحة تحكم أساسية',
                    'دعم فني عبر البريد',
                    'تقارير مبيعات أساسية',
                    'فترة تجريبية 60 يوم'
                ],
                'color' => 'primary',
                'popular' => false
            ],
            [
                'id' => 'medium',
                'name' => 'الخطة المتوسطة', 
                'price' => 4000,
                'currency' => 'TL',
                'products_limit' => 40,
                'features' => [
                    'إضافة حتى 40 منتج',
                    'لوحة تحكم متقدمة',
                    'دعم فني هاتفي',
                    'تقارير مبيعات متقدمة',
                    'تحليلات متقدمة',
                    'أولوية في الدعم'
                ],
                'color' => 'warning',
                'popular' => true
            ],
            [
                'id' => 'premium',
                'name' => 'الخطة المميزة',
                'price' => 6000,
                'currency' => 'TL',
                'products_limit' => 'غير محدود',
                'features' => [
                    'عدد غير محدود من المنتجات',
                    'جميع الميزات المتقدمة',
                    'دعم فني مميز 24/7',
                    'تقارير وتحليلات شاملة',
                    'أولوية في الظهور',
                    'ميزات حصرية',
                    'تخصيص متقدم'
                ],
                'color' => 'gold',
                'popular' => false
            ]
        ];

        return view('merchant.subscription-plans', compact('plans', 'user', 'isInTrial', 'daysLeft'));
    }

    public function subscribe(Request $request, $plan)
    {
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $validPlans = ['basic', 'medium', 'premium'];
        if (!in_array($plan, $validPlans)) {
            return redirect()->route('merchant.subscription.plans')->with('error', 'الخطة غير موجودة');
        }

        // التوجيه لصفحة الدفع - تم التصحيح
        return redirect()->route('payment.form', ['plan' => $plan]);
    }
}
