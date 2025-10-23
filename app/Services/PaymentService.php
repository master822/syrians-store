<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PaymentService
{
    private $gateway;
    
    public function __construct($gateway = null)
    {
        $this->gateway = $gateway;
        Log::info("🎯 PaymentService initialized with gateway: {$gateway}");
    }

    public function createPayment($amount, $currency, $description, $metadata = [])
    {
        Log::info("🎯 Creating payment with gateway: {$this->gateway}", [
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'metadata' => $metadata
        ]);

        try {
            // محاكاة إنشاء جلسة دفع
            $paymentId = 'pay_' . uniqid();
            
            // حفظ البيانات في الكاش
            $paymentData = [
                'payment_id' => $paymentId,
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'metadata' => $metadata,
                'gateway' => $this->gateway,
                'status' => 'pending',
                'created_at' => now()
            ];
            
            Cache::put('payment_' . $paymentId, $paymentData, now()->addHours(24));

            // إنشاء رابط الدفع - تم التصحيح هنا
            $paymentUrl = $this->generatePaymentUrl($paymentId);

            Log::info("🎯 Payment created successfully", [
                'payment_id' => $paymentId,
                'payment_url' => $paymentUrl,
                'gateway' => $this->gateway
            ]);

            return [
                'success' => true,
                'payment_id' => $paymentId,
                'payment_url' => $paymentUrl,
                'message' => 'تم إنشاء عملية الدفع بنجاح'
            ];

        } catch (\Exception $e) {
            Log::error('❌ Payment creation failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'فشل في إنشاء عملية الدفع: ' . $e->getMessage()
            ];
        }
    }

    public function verifyPayment($paymentId)
    {
        Log::info("🎯 Verifying payment: {$paymentId}");

        try {
            // استرجاع بيانات الدفع من الكاش
            $paymentData = Cache::get('payment_' . $paymentId);
            
            if (!$paymentData) {
                Log::error("❌ Payment not found in cache: {$paymentId}");
                return [
                    'success' => false,
                    'error' => 'عملية الدفع غير موجودة أو انتهت صلاحيتها'
                ];
            }

            Log::info("🎯 Payment data found", [
                'payment_id' => $paymentId,
                'status' => $paymentData['status'],
                'gateway' => $paymentData['gateway']
            ]);

            // محاكاة التحقق من الدفع - نجاح دائم في هذا المثال
            $paymentData['status'] = 'completed';
            Cache::put('payment_' . $paymentId, $paymentData, now()->addHours(1));

            Log::info("✅ Payment verified successfully", [
                'payment_id' => $paymentId,
                'status' => 'completed',
                'amount' => $paymentData['amount'],
                'metadata' => $paymentData['metadata']
            ]);

            return [
                'success' => true,
                'payment_id' => $paymentId,
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'metadata' => $paymentData['metadata'],
                'gateway' => $paymentData['gateway'],
                'message' => 'تم التحقق من الدفع بنجاح'
            ];

        } catch (\Exception $e) {
            Log::error('❌ Payment verification failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'فشل في التحقق من الدفع: ' . $e->getMessage()
            ];
        }
    }

    private function generatePaymentUrl($paymentId)
    {
        // إنشاء رابط دفع وهمي - تم التصحيح هنا
        $baseUrl = url('/');
        
        // دائماً نعود إلى صفحة النجاح مباشرة
        return $baseUrl . "/payment/success?gateway=" . $this->gateway . "&payment_id=" . $paymentId . "&success=true";
    }

    public function getPaymentStatus($paymentId)
    {
        $paymentData = Cache::get('payment_' . $paymentId);
        
        if (!$paymentData) {
            return [
                'success' => false,
                'error' => 'عملية الدفع غير موجودة'
            ];
        }

        return [
            'success' => true,
            'status' => $paymentData['status'],
            'data' => $paymentData
        ];
    }
}
