@extends('layouts.app')

@section('title', 'خطط الاشتراك - لوحة المتجر')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="text-primary mb-3">خطط الاشتراك للتجار</h2>
                <p class="text-dark fs-5">اختر الخطة المناسبة لمتجرك وقم بتطويره</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach($plans as $plan)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="modern-card text-center h-100 subscription-plan-card">
                <div class="card-header bg-{{ $plan['color'] }} text-white py-4 rounded-top">
                    <h4 class="fw-bold mb-0">{{ $plan['name'] }}</h4>
                </div>
                <div class="card-body p-4">
                    <div class="price-section mb-4">
                        <span class="h1 fw-bold text-{{ $plan['color'] }}">
                            {{ number_format($plan['price']) }}
                        </span>
                        <span class="text-dark fs-4">{{ $plan['currency'] }}</span>
                        <div class="text-muted">/شهرياً</div>
                    </div>
                    
                    <div class="products-limit mb-4">
                        <h5 class="text-dark">{{ $plan['products_limit'] }} منتج</h5>
                    </div>
                    
                    <div class="features-list mb-4">
                        @foreach($plan['features'] as $feature)
                        <div class="feature-item d-flex align-items-center mb-2">
                            <i class="fas fa-check text-{{ $plan['color'] }} me-2"></i>
                            <span class="text-dark">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="subscription-action">
                        <form action="{{ route('merchant.subscribe', ['plan' => strtolower(str_replace(' ', '_', $plan['name']))]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $plan['color'] }} w-100 btn-lg">
                                <i class="fas fa-crown me-2"></i>اشترك الآن
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- معلومات إضافية -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="modern-card p-4">
                <h4 class="text-primary mb-4">معلومات مهمة</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <h6 class="text-dark"><i class="fas fa-sync-alt text-primary me-2"></i>تجديد تلقائي</h6>
                            <p class="text-muted mb-0">يتم تجديد الاشتراك تلقائياً كل شهر</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <h6 class="text-dark"><i class="fas fa-undo text-primary me-2"></i>إلغاء في أي وقت</h6>
                            <p class="text-muted mb-0">يمكنك إلغاء الاشتراك في أي وقت</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <h6 class="text-dark"><i class="fas fa-shield-alt text-primary me-2"></i>ضمان استرجاع</h6>
                            <p class="text-muted mb-0">ضمان استرجاع الأموال خلال 7 أيام</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <h6 class="text-dark"><i class="fas fa-headset text-primary me-2"></i>دعم فني</h6>
                            <p class="text-muted mb-0">فريق دعم فني متاح على مدار الساعة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .subscription-plan-card {
        transition: all 0.3s ease;
    }

    .subscription-plan-card:hover {
        transform: translateY(-10px);
    }

    .bg-gold {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .btn-gold {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        color: white;
    }

    .btn-gold:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
    }

    .text-gold {
        color: #f59e0b !important;
    }

    .feature-item {
        text-align: right;
    }

    .price-section {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1rem;
    }

    .products-limit {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
    }

    .subscription-action {
        margin-top: 2rem;
    }

    .info-item {
        padding: 1rem;
        border-radius: 10px;
        background: #f8fafc;
    }
</style>
@endsection
