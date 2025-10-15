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

                <!-- باقي السلايدر... -->
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

    <!-- أحدث المنتجات -->
    @if($newProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3 section-title">أفضل المنتجات</h2>
                    <p class="text-light">اكتشف أفضل المنتجات في متجرنا</p>
                </div>
            </div>
            <div class="row">
                @foreach($newProducts->take(8) as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="modern-card product-card animate-on-scroll">
                        @if($product->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger fs-7">خصم {{ $product->discount_percentage }}%</span>
                            </div>
                        @endif
                        
                        <div class="card-img-container">
                            @if($product->images)
                                @php
                                    $images = json_decode($product->images);
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" 
                                         class="card-product-image" 
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $product->name }}</h5>
                            <p class="card-text text-secondary">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="price-section mb-2">
                                @if($product->discount_percentage > 0)
                                    @php
                                        $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                    @endphp
                                    <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                @else
                                    <span class="fw-bold text-primary fs-5">{{ number_format($product->price, 2) }} ر.س</span>
                                @endif
                            </div>
                            
                            <div class="card-footer-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-store me-1"></i>
                                        {{ $product->user->name }}
                                    </span>
                                    <span class="text-muted">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ $product->views }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100 btn-view-product">
                                <i class="fas fa-eye me-2"></i>عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- أفضل التجار -->
    @if($merchants->count() > 0)
    <section class="py-5 bg-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3 section-title">أفضل التجار</h2>
                    <p class="text-light">تعرف على أفضل التجار في منصتنا</p>
                </div>
            </div>
            <div class="row">
                @foreach($merchants->take(6) as $merchant)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modern-card merchant-card animate-on-scroll">
                        <div class="card-body text-center p-4">
                            <div class="merchant-avatar">
                                <img src="{{ $merchant->getAvatarUrlAttribute() }}" 
                                     class="merchant-img" 
                                     alt="{{ $merchant->name }}">
                            </div>
                            <h5 class="card-title text-primary mt-3">{{ $merchant->name }}</h5>
                            <p class="card-text text-secondary">{{ $merchant->store_name }}</p>
                            
                            <div class="rating-stars mb-3">
                                @php
                                    $avgRating = $merchant->ratings->avg('rating') ?? 0;
                                    $fullStars = floor($avgRating);
                                    $halfStar = $avgRating - $fullStars >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i == $fullStars + 1 && $halfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="text-muted ms-1">({{ $merchant->ratings_count }})</span>
                            </div>
                            
                            <p class="text-muted small mb-3">{{ $merchant->products_count }} منتج</p>
                            
                            <a href="{{ route('merchants.show', $merchant->id) }}" class="btn btn-outline-primary btn-visit-store">
                                <i class="fas fa-store me-2"></i>زيارة المتجر
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- التجار الجدد -->
    @if($merchants->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3 section-title">التجار الجدد</h2>
                    <p class="text-light">تعرف على أحدث التجار المنضمين إلينا</p>
                </div>
            </div>
            <div class="row">
                @foreach($merchants->sortByDesc('created_at')->take(4) as $merchant)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="modern-card new-merchant-card animate-on-scroll">
                        <div class="card-body text-center p-4">
                            <div class="new-merchant-avatar">
                                <img src="{{ $merchant->getAvatarUrlAttribute() }}" 
                                     class="new-merchant-img" 
                                     alt="{{ $merchant->name }}">
                                <span class="new-badge">جديد</span>
                            </div>
                            <h6 class="card-title text-primary mt-3">{{ $merchant->name }}</h6>
                            <p class="card-text text-secondary small">{{ $merchant->store_name }}</p>
                            <div class="merchant-stats">
                                <span class="badge bg-success">{{ $merchant->store_category_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- المنتجات المستعملة المميزة -->
    @if($topUsedProducts->count() > 0)
    <section class="py-5 bg-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-gold mb-3 section-title">المنتجات المستعملة الأكثر مشاهدة</h2>
                    <p class="text-light">اكتشف أفضل المنتجات المستعملة</p>
                </div>
            </div>
            <div class="row">
                @foreach($topUsedProducts as $product)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="modern-card used-product-card animate-on-scroll">
                        <div class="used-badge">مستعمل</div>
                        <div class="card-img-container">
                            @if($product->images)
                                @php
                                    $images = json_decode($product->images);
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" 
                                         class="card-product-image" 
                                         alt="{{ $product->name }}">
                                @endif
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h6 class="card-title text-primary">{{ $product->name }}</h6>
                            <p class="card-text text-secondary small">{{ Str::limit($product->description, 40) }}</p>
                            
                            <div class="price-section mb-2">
                                <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} ر.س</span>
                            </div>
                            
                            <div class="used-product-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ $product->views }}
                                    </span>
                                    <span class="condition-badge">{{ $product->condition }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
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

    /* تحسينات البطاقات */
    .modern-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%) !important;
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08) !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(99, 102, 241, 0.1) !important;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .modern-card:hover::before {
        transform: scaleX(1);
    }

    .modern-card:hover {
        transform: translateY(-12px) scale(1.02) !important;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15) !important;
    }

    /* تحسينات الصور */
    .card-img-container {
        position: relative;
        overflow: hidden;
        height: 220px;
        border-radius: 15px 15px 0 0;
    }

    .card-product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .modern-card:hover .card-product-image {
        transform: scale(1.1);
    }

    .no-image-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
    }

    /* تحسينات النصوص */
    .card-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .card-text {
        color: #64748b !important;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .text-primary {
        color: #1e293b !important;
    }

    .text-secondary {
        color: #64748b !important;
    }

    /* تحسينات الأزرار */
    .btn-view-product {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-view-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    .btn-visit-store {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-visit-store:hover {
        transform: translateY(-2px);
    }

    /* تحسينات التجار */
    .merchant-avatar {
        position: relative;
        display: inline-block;
    }

    .merchant-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .merchant-card:hover .merchant-img {
        border-color: #6366f1;
        transform: scale(1.1);
    }

    .new-merchant-avatar {
        position: relative;
        display: inline-block;
    }

    .new-merchant-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px solid #10b981;
    }

    .new-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #10b981;
        color: white;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* تحسينات المنتجات المستعملة */
    .used-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #f59e0b;
        color: white;
        border-radius: 8px;
        padding: 4px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .condition-badge {
        background: #fef3c7;
        color: #92400e;
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* تحسينات الأقسام */
    .bg-section {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.03) 0%, rgba(139, 92, 246, 0.03) 100%);
    }

    .section-title {
        position: relative;
        display: inline-block;
        font-weight: 800;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 2px;
    }

    /* تحسينات الحركات */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }

    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }

    /* تحسينات المعلومات الإضافية */
    .card-footer-info, .used-product-info {
        border-top: 1px solid #e2e8f0;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .price-section {
        margin: 1rem 0;
    }

    .merchant-stats {
        margin-top: 1rem;
    }

    /* تحسينات النجوم */
    .rating-stars {
        font-size: 0.9rem;
    }

    /* تحسينات الاستجابة */
    @media (max-width: 768px) {
        .modern-card:hover {
            transform: translateY(-5px) scale(1.01) !important;
        }
        
        .card-img-container {
            height: 180px;
        }
    }
</style>

<script>
    // تشغيل السلايدر تلقائياً
    document.addEventListener('DOMContentLoaded', function() {
        const myCarousel = document.getElementById('plansSlider');
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000,
            wrap: true,
            pause: false
        });

        // إضافة حركات التمرير
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animated');
                }
            });
        };

        // تشغيل عند التحميل وعند التمرير
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // تشغيل مرة أولى عند التحميل
    });
</script>
@endsection
