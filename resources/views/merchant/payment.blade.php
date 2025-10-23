@extends('layouts.app')

@section('title', 'إتمام الدفع - Merchanta')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-credit-card me-2"></i>إتمام عملية الدفع</h3>
                </div>
                
                <div class="card-body p-5">
                    <!-- معلومات الخطة -->
                    <div class="plan-info text-center mb-5">
                        <h4 class="text-primary">{{ $planDetails['name'] }}</h4>
                        <div class="price-section my-3">
                            <span class="h1 fw-bold text-primary">{{ number_format($planDetails['price'], 0) }}</span>
                            <span class="h5 text-muted"> {{ $planDetails['currency'] }}</span>
                            <div class="text-muted">شهرياً</div>
                        </div>
                        <p class="text-muted">عدد المنتجات المسموح: {{ $planDetails['product_limit'] }}</p>
                    </div>

                    @if($isInTrial)
                    <div class="alert alert-info text-center">
                        <i class="fas fa-gift me-2"></i>
                        <strong>فترة تجريبية مجانية!</strong> لديك {{ $daysLeft }} يوم متبقي.
                    </div>
                    @endif

                    <!-- طرق الدفع -->
                    <div class="payment-methods">
                        <h5 class="text-center mb-4">اختر طريقة الدفع</h5>
                        
                        <form action="{{ route('payment.initiate', $plan) }}" method="POST" id="paymentForm">
                            @csrf
                            
                            <div class="row">
                                @foreach($gateways as $gatewayKey => $gateway)
                                <div class="col-md-6 mb-3">
                                    <input type="radio" 
                                           name="gateway" 
                                           value="{{ $gatewayKey }}" 
                                           id="gateway_{{ $gatewayKey }}" 
                                           class="d-none"
                                           {{ $loop->first ? 'checked' : '' }}>
                                    <label for="gateway_{{ $gatewayKey }}" class="gateway-card d-block">
                                        <div class="card h-100 border-2">
                                            <div class="card-body text-center">
                                                <i class="{{ $gateway['icon'] }} fa-2x text-primary mb-3"></i>
                                                <h6 class="card-title">{{ $gateway['name'] }}</h6>
                                                <p class="card-text text-muted small">{{ $gateway['description'] }}</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <!-- معلومات إضافية -->
                            <div class="payment-info mt-4 p-4 bg-light rounded">
                                <h6 class="text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>معلومات آمنة</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">🔒 دفع آمن</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">🔄 إلغاء في أي وقت</small>
                                    </div>
                                </div>
                            </div>

                            <!-- أزرار الإجراء -->
                            <div class="action-buttons mt-5">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('merchant.subscription.plans') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-arrow-right me-2"></i>رجوع
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary w-100 py-3">
                                            <i class="fas fa-lock me-2"></i>إتمام الدفع
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.gateway-card .card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.gateway-card .card:hover {
    transform: translateY(-5px);
    border-color: #4361ee !important;
}

.gateway-card input[type="radio"]:checked + .card {
    border-color: #4361ee !important;
    background-color: #f8f9ff;
}

.price-section {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.btn-primary {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات لبطاقات طرق الدفع
    const gatewayCards = document.querySelectorAll('.gateway-card');
    
    gatewayCards.forEach(card => {
        card.addEventListener('click', function() {
            // إزالة التحديد من جميع البطاقات
            gatewayCards.forEach(c => {
                c.querySelector('.card').classList.remove('border-primary');
                c.querySelector('.card').style.borderColor = '';
            });
            
            // إضافة التحديد للبطاقة المختارة
            this.querySelector('.card').classList.add('border-primary');
            this.querySelector('.card').style.borderColor = '#4361ee';
        });
    });

    // تفعيل البطاقة الأولى افتراضياً
    const firstCard = document.querySelector('.gateway-card');
    if (firstCard) {
        firstCard.querySelector('.card').classList.add('border-primary');
        firstCard.querySelector('.card').style.borderColor = '#4361ee';
    }
});
</script>
@endpush
