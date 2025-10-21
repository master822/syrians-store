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

        $plans = [
            [
                'name' => 'الخطة الأساسية',
                'price' => 2000,
                'currency' => 'TL',
                'products_limit' => 20,
                'features' => [
                    'إضافة حتى 20 منتج',
                    'لوحة تحكم أساسية',
                    'دعم فني عبر البريد',
                    'تقارير مبيعات أساسية'
                ],
                'color' => 'primary'
            ],
            [
                'name' => 'الخطة المتوسطة',
                'price' => 4000,
                'currency' => 'TL',
                'products_limit' => 40,
                'features' => [
                    'إضافة حتى 40 منتج',
                    'لوحة تحكم متقدمة',
                    'دعم فني هاتفي',
                    'تقارير مبيعات متقدمة',
                    'تحليلات متقدمة'
                ],
                'color' => 'warning'
            ],
            [
                'name' => 'الخطة الذهبية',
                'price' => 6000,
                'currency' => 'TL',
                'products_limit' => 'غير محدود',
                'features' => [
                    'عدد غير محدود من المنتجات',
                    'جميع الميزات المتقدمة',
                    'دعم فني مميز 24/7',
                    'تقارير وتحليلات شاملة',
                    'أولوية في الظهور',
                    'ميزات حصرية'
                ],
                'color' => 'gold'
            ]
        ];

        return view('merchant.subscription-plans', compact('plans'));
    }

    public function subscribe(Request $request, $plan)
    {
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $user = Auth::user();
        
        // هنا يمكنك إضافة منطق الاشتراك الفعلي
        // مثل الاتصال ببوابة الدفع وتحديث قاعدة البيانات
        
        $planNames = [
            'basic' => 'الخطة الأساسية',
            'medium' => 'الخطة المتوسطة', 
            'gold' => 'الخطة الذهبية'
        ];

        return redirect()->route('merchant.dashboard')
            ->with('success', 'تم الاشتراك في ' . ($planNames[$plan] ?? $plan) . ' بنجاح!');
    }
}
