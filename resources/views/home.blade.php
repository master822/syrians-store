@extends('layouts.app')

@section('title', 'الصفحة الرئيسية - متجر التخفيضات')

@section('content')
<div class="container-fluid px-0">
    <!-- سلايدر العروض والخطط -->
    <section class="hero-slider mb-5">
        <div id="plansSlider" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#plansSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#plansSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#plansSlider" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#plansSlider" data-bs-slide-to="3"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <!-- العرض 1: الفترة المجانية -->
                <div class="carousel-item active">
                    <div class="slider-content" style="background: linear-gradient(135deg, var(--dark-card) 0%, var(--dark-surface) 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-gold mb-4">
                                            🎉 الفترة التجريبية المجانية
                                        </h1>
                                        <p class="lead text-light mb-4 fs-5">
                                            انضم الآن واستفد من <span class="text-aqua fw-bold">شهرين مجاناً</span> كاملاً!<br>
                                            أضف حتى 20 منتج وابدأ تجارتك بدون أي تكاليف
                                        </p>
                                        <div class="offer-badge mb-4">
                                            <span class="badge bg-success fs-6 p-3">
                                                <i class="fas fa-gift me-2"></i>مجاني بالكامل - لا توجد رسوم خفية
                                            </span>
                                        </div>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-aqua me-2"></i>20 منتج مجاني
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-aqua me-2"></i>جميع الميزات متاحة
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-aqua me-2"></i>دعم فني كامل
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="{{ route('register') }}" class="btn-gold me-3">
                                                <i class="fas fa-rocket me-2"></i>ابدأ مجاناً الآن
                                            </a>
                                            <a href="#plans" class="btn btn-outline-aqua">
                                                <i class="fas fa-info-circle me-2"></i>المزيد من التفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                                             alt="الفترة المجانية" class="img-fluid" style="max-height: 400px;">
                                        <div class="floating-badge pulse-glow">
                                            <span class="badge bg-gold text-dark fs-6">مجاني</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العرض 2: الخطة الأساسية -->
                <div class="carousel-item">
                    <div class="slider-content" style="background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-warning mb-4">
                                            ⭐ الخطة الأساسية
                                        </h1>
                                        <div class="price-section mb-4">
                                            <span class="text-light fs-3">فقط</span>
                                            <span class="text-warning fw-bold display-5 mx-2">2,000 TL</span>
                                            <span class="text-light fs-3">/شهر</span>
                                        </div>
                                        <p class="lead text-light mb-4 fs-5">
                                            مثالي للتجار الصغار والمبتدئين<br>
                                            <span class="text-warning fw-bold">خصم 25%</span> للاشتراكات السنوية
                                        </p>
                                        <div class="offer-badge mb-4">
                                            <span class="badge bg-danger fs-6 p-3">
                                                <i class="fas fa-bolt me-2"></i>عرض محدود - وفر 500 TL
                                            </span>
                                        </div>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>20 منتج نشط
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>تقارير مبيعات أساسية
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>دعم فني عبر البريد
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="{{ route('register') }}" class="btn-warning me-3">
                                                <i class="fas fa-shopping-cart me-2"></i>اشترك الآن
                                            </a>
                                            <a href="#plans" class="btn btn-outline-warning">
                                                <i class="fas fa-list me-2"></i>مقارنة الخطط
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135675.png" 
                                             alt="الخطة الأساسية" class="img-fluid" style="max-height: 400px;">
                                        <div class="floating-badge pulse-glow">
                                            <span class="badge bg-warning text-dark fs-6">الأكثر طلباً</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العرض 3: الخطة المتوسطة -->
                <div class="carousel-item">
                    <div class="slider-content" style="background: linear-gradient(135deg, #2d5a27 0%, #4a7c3a 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-success mb-4">
                                            💎 الخطة المتوسطة
                                        </h1>
                                        <div class="price-section mb-4">
                                            <span class="text-light fs-3">فقط</span>
                                            <span class="text-success fw-bold display-5 mx-2">4,000 TL</span>
                                            <span class="text-light fs-3">/شهر</span>
                                        </div>
                                        <p class="lead text-light mb-4 fs-5">
                                            للمتاجر المتوسطة والناشئة<br>
                                            <span class="text-success fw-bold">خصم 30%</span> للاشتراكات السنوية
                                        </p>
                                        <div class="offer-badge mb-4">
                                            <span class="badge bg-primary fs-6 p-3">
                                                <i class="fas fa-star me-2"></i>الأفضل قيمة - وفر 1,200 TL
                                            </span>
                                        </div>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>40 منتج نشط
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>تقارير متقدمة
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>دعم فني هاتفي
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>تحليلات متقدمة
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="{{ route('register') }}" class="btn-success me-3">
                                                <i class="fas fa-crown me-2"></i>الترقية الآن
                                            </a>
                                            <a href="#plans" class="btn btn-outline-success">
                                                <i class="fas fa-chart-line me-2"></i>عرض الميزات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135695.png" 
                                             alt="الخطة المتوسطة" class="img-fluid" style="max-height: 400px;">
                                        <div class="floating-badge pulse-glow">
                                            <span class="badge bg-success text-white fs-6">الأفضل قيمة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العرض 4: الخطة الذهبية -->
                <div class="carousel-item">
                    <div class="slider-content" style="background: linear-gradient(135deg, #d4af37 0%, #f7ef8a 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-dark mb-4">
                                            👑 الخطة الذهبية
                                        </h1>
                                        <div class="price-section mb-4">
                                            <span class="text-dark fs-3">فقط</span>
                                            <span class="text-dark fw-bold display-5 mx-2">6,000 TL</span>
                                            <span class="text-dark fs-3">/شهر</span>
                                        </div>
                                        <p class="lead text-dark mb-4 fs-5">
                                            للمتاجر الكبيرة والمحترفين<br>
                                            <span class="text-dark fw-bold">خصم 40%</span> للاشتراكات السنوية
                                        </p>
                                        <div class="offer-badge mb-4">
                                            <span class="badge bg-dark text-warning fs-6 p-3">
                                                <i class="fas fa-gem me-2"></i>بريميوم - وفر 2,400 TL
                                            </span>
                                        </div>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-dark mb-2">
                                                <i class="fas fa-check text-dark me-2"></i>عدد غير محدود من المنتجات
                                            </div>
                                            <div class="feature-item text-dark mb-2">
                                                <i class="fas fa-check text-dark me-2"></i>جميع الميزات المتقدمة
                                            </div>
                                            <div class="feature-item text-dark mb-2">
                                                <i class="fas fa-check text-dark me-2"></i>دعم فني مميز 24/7
                                            </div>
                                            <div class="feature-item text-dark mb-2">
                                                <i class="fas fa-check text-dark me-2"></i>تقارير وتحليلات شاملة
                                            </div>
                                            <div class="feature-item text-dark mb-2">
                                                <i class="fas fa-check text-dark me-2"></i>أولوية في الظهور
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="{{ route('register') }}" class="btn-dark me-3">
                                                <i class="fas fa-gem me-2"></i>الاشتراك المميز
                                            </a>
                                            <a href="#plans" class="btn btn-outline-dark">
                                                <i class="fas fa-medal me-2"></i>عرض التفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" 
                                             alt="الخطة الذهبية" class="img-fluid" style="max-height: 400px;">
                                        <div class="floating-badge pulse-glow">
                                            <span class="badge bg-dark text-warning fs-6">بريميوم</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#plansSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#plansSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- قسم الخطط -->
    <section id="plans" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3">خطط الاشتراك</h2>
                    <p class="text-light">اختر الخطة التي تناسب متجرك</p>
                </div>
            </div>
            <div class="row">
                @foreach([
                    ['name' => 'المجاني', 'price' => 0, 'products' => 20, 'period' => 'شهرين', 'color' => 'success', 'icon' => 'gift'],
                    ['name' => 'الأساسي', 'price' => 2000, 'products' => 20, 'period' => 'شهري', 'color' => 'warning', 'icon' => 'star'],
                    ['name' => 'المتوسط', 'price' => 4000, 'products' => 40, 'period' => 'شهري', 'color' => 'info', 'icon' => 'crown'],
                    ['name' => 'الذهبي', 'price' => 6000, 'products' => 'غير محدود', 'period' => 'شهري', 'color' => 'gold', 'icon' => 'gem']
                ] as $plan)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="elite-card text-center h-100">
                        <div class="card-header bg-{{ $plan['color'] }} text-dark py-4">
                            <i class="fas fa-{{ $plan['icon'] }} fa-3x mb-3"></i>
                            <h4 class="fw-bold">{{ $plan['name'] }}</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="price mb-3">
                                <span class="h2 fw-bold text-{{ $plan['color'] }}">
                                    @if($plan['price'] == 0)
                                        مجاني
                                    @else
                                        {{ number_format($plan['price']) }} TL
                                    @endif
                                </span>
                                <span class="text-muted">/{{ $plan['period'] }}</span>
                            </div>
                            <div class="features">
                                <div class="feature-item mb-3">
                                    <i class="fas fa-box text-{{ $plan['color'] }} me-2"></i>
                                    <span class="text-light">{{ $plan['products'] }} منتج</span>
                                </div>
                                <div class="feature-item mb-3">
                                    <i class="fas fa-chart-bar text-{{ $plan['color'] }} me-2"></i>
                                    <span class="text-light">تقارير {{ $plan['name'] == 'الذهبي' ? 'متقدمة' : 'أساسية' }}</span>
                                </div>
                                <div class="feature-item mb-3">
                                    <i class="fas fa-headset text-{{ $plan['color'] }} me-2"></i>
                                    <span class="text-light">دعم فني {{ $plan['name'] == 'الذهبي' ? '24/7' : 'عادي' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent py-3">
                            <a href="{{ route('register') }}" class="btn btn-{{ $plan['color'] }} w-100">
                                @if($plan['price'] == 0)
                                    ابدأ مجاناً
                                @else
                                    اشترك الآن
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- باقي المحتوى -->
    @if($newProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3">أحدث المنتجات</h2>
                    <p class="text-light">اكتشف أحدث الإضافات إلى متجرنا</p>
                </div>
            </div>
            <div class="row">
                @foreach($newProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="elite-card h-100">
                        @if($product->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
                            </div>
                        @endif
                        
                        <div class="card-img-top position-relative overflow-hidden">
                            @if($product->images)
                                @php
                                    $images = json_decode($product->images);
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" 
                                         class="img-fluid" 
                                         alt="{{ $product->name }}"
                                         style="height: 200px; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-dark d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            @else
                                <div class="bg-dark d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title text-light">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="price-section">
                                    @if($product->discount_percentage > 0)
                                        @php
                                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                        @endphp
                                        <span class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                        <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                    @else
                                        <span class="fw-bold text-light">{{ number_format($product->price, 2) }} ر.س</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span>
                                    <i class="fas fa-store"></i>
                                    {{ $product->user->name }}
                                </span>
                                <span>
                                    <i class="fas fa-eye"></i>
                                    {{ $product->views }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                                عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- باقي الأقسام -->
</div>

<style>
    .hero-slider {
        margin-top: 80px;
    }

    .min-vh-60 {
        min-height: 60vh;
    }

    .slider-content {
        border-radius: 0;
        position: relative;
        overflow: hidden;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: var(--text-secondary);
        border: 2px solid transparent;
    }

    .carousel-indicators button.active {
        background-color: var(--gold-primary);
        border-color: var(--gold-primary);
    }

    .floating-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        color: #000;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: #000;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: #fff;
    }

    .btn-dark {
        background: linear-gradient(135deg, #1f2937, #374151);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(31, 41, 55, 0.4);
        color: #fff;
    }

    .btn-outline-aqua {
        border: 2px solid var(--aqua-primary);
        color: var(--aqua-primary);
        background: transparent;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-outline-aqua:hover {
        background: var(--aqua-primary);
        color: #000;
    }

    .bg-gold {
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary)) !important;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: var(--gold-primary);
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }
</style>

<script>
    // تشغيل السلايدر تلقائياً
    document.addEventListener('DOMContentLoaded', function() {
        const myCarousel = document.getElementById('plansSlider');
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000, // تغيير كل 5 ثواني
            wrap: true,
            pause: false
        });
    });
</script>
@endsection
