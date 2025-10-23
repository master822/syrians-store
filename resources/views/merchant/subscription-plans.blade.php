@extends('layouts.app')

@section('title', 'خطط الاشتراك - Merchanta')

@section('content')
<div class="container py-5">
    <!-- رأس الصفحة -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">خطط الاشتراك</h1>
            <p class="lead text-muted">اختر الخطة المناسبة لمتجرك وقم بتطويره</p>
            
            @if($isInTrial)
            <div class="alert alert-info d-inline-block">
                <i class="fas fa-gift me-2"></i>
                <strong>فترة تجريبية مجانية!</strong> لديك {{ $daysLeft }} يوم متبقي. استمتع بجميع الميزات مجاناً.
            </div>
            @endif
        </div>
    </div>

    <!-- حالة الاشتراك الحالي -->
    @if($user->current_plan != 'free')
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>اشتراكك الحالي:</strong> {{ $user->getSubscriptionPlanNameAttribute() }}
                        @if($user->subscription_end)
                            - ينتهي في {{ $user->subscription_end->format('Y-m-d') }}
                            (متبقي {{ now()->diffInDays($user->subscription_end, false) }} يوم)
                        @endif
                    </div>
                    <a href="{{ route('subscription.history') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-history me-2"></i>عرض التاريخ
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- البطاقات -->
    <div class="row justify-content-center">
        @foreach($plans as $plan)
        <div class="col-xl-4 col-lg-6 col-md-8 mb-4">
            <div class="card plan-card h-100 border-0 shadow-lg {{ $plan['popular'] ? 'popular' : '' }}">
                @if($plan['popular'])
                <div class="card-header popular-header text-center py-3">
                    <span class="badge bg-warning fs-6"><i class="fas fa-crown me-2"></i>الأكثر شهرة</span>
                </div>
                @endif
                
                <div class="card-body p-4">
                    <!-- رأس البطاقة -->
                    <div class="text-center mb-4">
                        <h4 class="card-title fw-bold text-{{ $plan['color'] }}">{{ $plan['name'] }}</h4>
                        <div class="price-section my-3">
                            <span class="h1 fw-bold text-{{ $plan['color'] }}">{{ number_format($plan['price'], 0) }}</span>
                            <span class="h5 text-muted"> {{ $plan['currency'] }}</span>
                            <div class="text-muted">شهرياً</div>
                        </div>
                    </div>

                    <!-- الميزات -->
                    <ul class="list-unstyled mb-4">
                        @foreach($plan['features'] as $feature)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    <!-- عدد المنتجات -->
                    <div class="product-limit text-center mb-4 p-3 bg-light rounded">
                        <i class="fas fa-boxes fa-2x text-{{ $plan['color'] }} mb-2"></i>
                        <h5 class="text-{{ $plan['color'] }}">{{ $plan['products_limit'] }}</h5>
                        <small class="text-muted">منتج مسموح</small>
                    </div>
                </div>

                <!-- زر الاشتراك -->
                <div class="card-footer bg-transparent border-0 pb-4">
                    @if($user->current_plan == $plan['id'])
                    <button class="btn btn-success w-100 py-3 fw-bold" disabled>
                        <i class="fas fa-check me-2"></i>مفعل حالياً
                    </button>
                    @else
                    <!-- تم التصحيح هنا - استخدام POST form بدلاً من رابط مباشر -->
                    <form action="{{ route('merchant.subscribe', $plan['id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-{{ $plan['color'] }} w-100 py-3 fw-bold">
                            <i class="fas fa-arrow-left me-2"></i>
                            @if($user->current_plan == 'free' && $isInTrial)
                                بدء الاستخدام
                            @else
                                الترقية الآن
                            @endif
                        </button>
                    </form>
                    @endif
                    
                    @if($plan['id'] == 'basic' && $user->current_plan == 'free' && !$isInTrial)
                    <div class="text-center mt-2">
                        <small class="text-muted">بعد انتهاء الفترة التجريبية</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- معلومات إضافية -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body text-center">
                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>معلومات مهمة</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-sync-alt fa-2x text-primary mb-2"></i>
                            <h6>تجديد تلقائي</h6>
                            <p class="text-muted small">يتم التجديد تلقائياً كل شهر</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                            <h6>دفع آمن</h6>
                            <p class="text-muted small">جميع عمليات الدفع مشفرة وآمنة</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-undo-alt fa-2x text-info mb-2"></i>
                            <h6>إلغاء في أي وقت</h6>
                            <p class="text-muted small">يمكنك إلغاء الاشتراك في أي وقت</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.plan-card {
    transition: all 0.3s ease;
    border-radius: 20px;
    overflow: hidden;
}

.plan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.plan-card.popular {
    border: 3px solid #ffc107;
    transform: scale(1.05);
}

.plan-card.popular:hover {
    transform: scale(1.05) translateY(-10px);
}

.popular-header {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    border-bottom: none;
}

.price-section {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.product-limit {
    border-left: 4px solid;
    border-color: inherit;
}

.btn-gold {
    background: linear-gradient(135deg, #ffd700, #ffa500);
    border: none;
    color: #000;
}

.btn-gold:hover {
    background: linear-gradient(135deg, #ffa500, #ff8c00);
    color: #000;
    transform: translateY(-2px);
}

.card-footer .btn {
    border-radius: 12px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.card-footer .btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .plan-card.popular {
        transform: scale(1);
    }
    
    .plan-card.popular:hover {
        transform: translateY(-10px);
    }
}
</style>
@endpush
