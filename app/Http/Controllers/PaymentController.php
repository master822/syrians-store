<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    public function showPaymentForm($plan, $gateway = null)
    {
        Log::info('🔹 STEP 1: showPaymentForm called', ['plan' => $plan]);
        
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $plans = config('payment.plans');
        
        if (!array_key_exists($plan, $plans)) {
            return redirect()->route('merchant.subscription.plans')->with('error', 'الخطة غير موجودة');
        }

        $planDetails = $plans[$plan];
        $user = Auth::user();
        
        $trialEndsAt = $user->created_at->addDays($user->trial_days);
        $daysLeft = now()->diffInDays($trialEndsAt, false);
        $isInTrial = $daysLeft > 0 && !$user->is_trial_used;

        $gateways = [
            'stripe' => [
                'name' => 'Stripe',
                'icon' => 'fab fa-cc-stripe',
                'description' => 'بطاقات الائتمان (فيزا، ماستركارد)'
            ],
            'paypal' => [
                'name' => 'PayPal',
                'icon' => 'fab fa-paypal',
                'description' => 'حساب PayPal'
            ],
            'moyasar' => [
                'name' => 'Moyasar',
                'icon' => 'fas fa-credit-card',
                'description' => 'بطاقات محلية (مدى، STC Pay)'
            ]
        ];

        return view('merchant.payment', compact('plan', 'planDetails', 'user', 'gateways', 'isInTrial', 'daysLeft'));
    }

    public function initiatePayment(Request $request, $plan)
    {
        Log::info('🔹 STEP 2: initiatePayment STARTED', [
            'plan' => $plan, 
            'gateway' => $request->gateway,
            'user_id' => Auth::id()
        ]);

        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $request->validate([
            'gateway' => 'required|in:stripe,paypal,moyasar'
        ]);

        $plans = config('payment.plans');
        
        if (!array_key_exists($plan, $plans)) {
            return redirect()->route('merchant.subscription.plans')->with('error', 'الخطة غير موجودة');
        }

        $planDetails = $plans[$plan];
        $user = Auth::user();

        $paymentService = new PaymentService($request->gateway);
        
        $metadata = [
            'user_id' => $user->id,
            'plan' => $plan,
            'plan_name' => $planDetails['name'],
            'product_limit' => $planDetails['product_limit'],
            'duration_days' => $planDetails['duration_days']
        ];

        $result = $paymentService->createPayment(
            $planDetails['price'],
            'TRY',
            "اشتراك {$planDetails['name']}",
            $metadata
        );

        Log::info('🔹 STEP 3: PaymentService result', $result);

        if (!$result['success']) {
            return redirect()->route('payment.form', $plan)
                ->with('error', 'فشل في إنشاء عملية الدفع: ' . $result['error']);
        }

        Log::info('🔹 STEP 4: Redirecting to: ' . $result['payment_url']);
        return redirect($result['payment_url']);
    }

    public function paymentSuccess(Request $request)
    {
        Log::info('🎯 STEP 5: paymentSuccess ROUTE REACHED!', $request->all());
        
        try {
            $gateway = $request->get('gateway');
            $paymentId = $request->get('payment_id');
            $successParam = $request->get('success') === 'true';

            Log::info('🔹 STEP 6: Extracted parameters', [
                'gateway' => $gateway,
                'payment_id' => $paymentId,
                'success' => $successParam
            ]);

            if (!$successParam || !$paymentId || !$gateway) {
                Log::error('❌ Invalid payment parameters');
                return redirect()->route('merchant.subscription.plans')
                    ->with('error', 'معلمات الدفع غير صالحة.');
            }

            $paymentService = new PaymentService($gateway);
            $verification = $paymentService->verifyPayment($paymentId);
            
            Log::info('🔹 STEP 7: Payment verification', $verification);

            if (!$verification['success']) {
                return redirect()->route('merchant.subscription.plans')
                    ->with('error', 'فشل في التحقق من الدفع.');
            }

            $metadata = $verification['metadata'];
            $user = User::find($metadata['user_id']);
            $plan = $metadata['plan'];
            $planDetails = config('payment.plans')[$plan];

            if (!$user) {
                return redirect()->route('merchant.subscription.plans')
                    ->with('error', 'المستخدم غير موجود.');
            }

            DB::beginTransaction();

            try {
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_type' => $plan,
                    'amount' => $verification['amount'],
                    'payment_method' => $gateway,
                    'payment_id' => $paymentId,
                    'status' => 'completed',
                    'starts_at' => now(),
                    'ends_at' => now()->addDays($planDetails['duration_days']),
                    'notes' => 'اشتراك شهري في ' . $planDetails['name'] . ' عبر ' . $gateway
                ]);

                $user->update([
                    'current_plan' => $plan,
                    'subscription_start' => now(),
                    'subscription_end' => now()->addDays($planDetails['duration_days']),
                    'product_limit' => $planDetails['product_limit'],
                    'is_trial_used' => true
                ]);

                DB::commit();

                Cache::forget('payment_' . $paymentId);

                Log::info('🎉 STEP 8: SUBSCRIPTION ACTIVATED!', [
                    'user_id' => $user->id,
                    'plan' => $plan,
                    'subscription_id' => $subscription->id
                ]);

                return redirect()->route('merchant.dashboard')
                    ->with('success', 
                        "تم تفعيل الاشتراك في {$planDetails['name']} بنجاح! 🎉
                        يمكنك الآن إضافة حتى {$planDetails['product_limit']} منتج");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Database error: ' . $e->getMessage());
                return redirect()->route('merchant.subscription.plans')
                    ->with('error', 'حدث خطأ في تفعيل الاشتراك.');
            }

        } catch (\Exception $e) {
            Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('merchant.subscription.plans')
                ->with('error', 'حدث خطأ في تفعيل الاشتراك.');
        }
    }

    public function paymentCancel()
    {
        Log::info('Payment cancelled');
        return redirect()->route('merchant.subscription.plans')
            ->with('warning', 'تم إلغاء عملية الدفع.');
    }

    public function subscriptionHistory()
    {
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $subscriptions = Subscription::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $user = Auth::user();
        $trialEndsAt = $user->created_at->addDays($user->trial_days);
        $daysLeft = now()->diffInDays($trialEndsAt, false);
        $isInTrial = $daysLeft > 0 && !$user->is_trial_used;

        return view('merchant.subscription-history', compact('subscriptions', 'isInTrial', 'daysLeft'));
    }

    public function cancelSubscription()
    {
        if (!Auth::check() || !Auth::user()->isMerchant()) {
            return redirect()->route('home')->with('error', 'هذه الصفحة مخصصة للتجار فقط');
        }

        $user = Auth::user();

        if ($user->current_plan === 'free') {
            return redirect()->back()->with('error', 'ليس لديك اشتراك فعال لإلغائه');
        }

        $user->update([
            'current_plan' => 'free',
            'subscription_end' => now(),
            'product_limit' => 5
        ]);

        return redirect()->route('merchant.dashboard')
            ->with('success', 'تم إلغاء الاشتراك بنجاح.');
    }
}
