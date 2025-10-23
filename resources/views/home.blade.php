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
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <!-- العرض 1: الفترة المجانية -->
                <div class="carousel-item active">
                    <div class="slider-content" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-white mb-4">
                                            🎉 مرحباً بك في متجر التخفيضات
                                        </h1>
                                        <p class="lead text-light mb-4 fs-5">
                                            منصة شاملة لبيع وشراء المنتجات الجديدة والمستعملة<br>
                                            مع أفضل العروض والتخفيضات
                                        </p>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>منتجات جديدة من التجار
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>منتجات مستعملة بأسعار مناسبة
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-warning me-2"></i>تخفيضات حصرية يومية
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg me-3">
                                                <i class="fas fa-shopping-bag me-2"></i>تصفح المنتجات
                                            </a>
                                            <a href="{{ route('discounts') }}" class="btn btn-outline-light btn-lg">
                                                <i class="fas fa-tag me-2"></i>عروض التخفيضات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3737/3737728.png" 
                                             alt="متجر التخفيضات" class="img-fluid" style="max-height: 400px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العرض 2: للمستخدمين -->
                <div class="carousel-item">
                    <div class="slider-content" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-white mb-4">
                                            🔄 بيع منتجاتك المستعملة
                                        </h1>
                                        <p class="lead text-light mb-4 fs-5">
                                            لديك منتجات مستعملة؟<br>
                                            بيعها بسهولة وأمان على منصتنا
                                        </p>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-info me-2"></i>إضافة منتجات مجانية
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-info me-2"></i>وصول إلى آلاف المشترين
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-info me-2"></i>دعم فني متكامل
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            @auth
                                                @if(Auth::user()->user_type === 'user')
                                                    <a href="{{ route('user.products.create') }}" class="btn btn-info btn-lg me-3">
                                                        <i class="fas fa-plus me-2"></i>إضافة منتج مستعمل
                                                    </a>
                                                @else
                                                    <a href="{{ route('products.used') }}" class="btn btn-info btn-lg me-3">
                                                        <i class="fas fa-search me-2"></i>تصفح المستعمل
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('register') }}" class="btn btn-info btn-lg me-3">
                                                    <i class="fas fa-user-plus me-2"></i>انضم كـ مستخدم
                                                </a>
                                            @endauth
                                            <a href="{{ route('products.used') }}" class="btn btn-outline-light btn-lg">
                                                <i class="fas fa-recycle me-2"></i>المنتجات المستعملة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" 
                                             alt="المنتجات المستعملة" class="img-fluid" style="max-height: 400px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العرض 3: للتجار -->
                <div class="carousel-item">
                    <div class="slider-content" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="container">
                            <div class="row align-items-center min-vh-60 py-5">
                                <div class="col-lg-6">
                                    <div class="slider-text">
                                        <h1 class="display-4 fw-bold text-white mb-4">
                                            🛍️ أنشئ متجرك الإلكتروني
                                        </h1>
                                        <p class="lead text-light mb-4 fs-5">
                                            للتجار وأصحاب المحلات<br>
                                            عرض منتجاتك وزيادة مبيعاتك
                                        </p>
                                        <div class="slider-features mb-4">
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>متجر إلكتروني متكامل
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>إدارة تخفيضات متقدمة
                                            </div>
                                            <div class="feature-item text-light mb-2">
                                                <i class="fas fa-check text-success me-2"></i>تقارير وأدوات تحليل
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            @auth
                                                @if(Auth::user()->user_type === 'merchant')
                                                    <a href="{{ route('merchant.dashboard') }}" class="btn btn-success btn-lg me-3">
                                                        <i class="fas fa-store me-2"></i>لوحة التحكم
                                                    </a>
                                                @else
                                                    <a href="{{ route('merchants.index') }}" class="btn btn-success btn-lg me-3">
                                                        <i class="fas fa-store me-2"></i>تصفح المتاجر
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('register') }}" class="btn btn-success btn-lg me-3">
                                                    <i class="fas fa-store me-2"></i>انضم كـ تاجر
                                                </a>
                                            @endauth
                                            <a href="{{ route('merchants.index') }}" class="btn btn-outline-light btn-lg">
                                                <i class="fas fa-users me-2"></i>جميع المتاجر
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="slider-image floating-element">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4341/4341139.png" 
                                             alt="المتاجر" class="img-fluid" style="max-height: 400px;">
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

    <!-- أحدث المنتجات -->
    @if($newProducts->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-primary mb-3 section-title">🆕 أحدث المنتجات</h2>
                    <p class="text-muted">اكتشف أحدث المنتجات المضافة من قبل التجار</p>
                </div>
            </div>
            <div class="row">
                @foreach($newProducts->take(8) as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="modern-card product-card h-100" style="position: relative;">
                        @if($product->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
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
                            <h5 class="card-title text-dark">{{ $product->name }}</h5>
                            <p class="card-text text-secondary">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="price-section mb-2">
                                @if($product->discount_percentage > 0)
                                    @php
                                        $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                    @endphp
                                    <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} TL</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} TL</small>
                                @else
                                    <span class="fw-bold text-primary fs-5">{{ number_format($product->price, 2) }} TL</span>
                                @endif
                            </div>
                            
                            <div class="product-meta">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="fas fa-store me-1"></i>
                                        {{ $product->user->name }}
                                    </span>
                                    <span class="text-muted small">
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
            <div class="text-center mt-4">
                <a href="{{ route('products.new') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>عرض جميع المنتجات الجديدة
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- المنتجات المستعملة المميزة -->
    @if($topUsedProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-warning mb-3 section-title">🔥 المنتجات المستعملة الأكثر مشاهدة</h2>
                    <p class="text-muted">اكتشف أفضل المنتجات المستعملة</p>
                </div>
            </div>
            <div class="row">
                @foreach($topUsedProducts as $product)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="modern-card used-product-card h-100" style="position: relative;">
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
                            <h6 class="card-title text-dark">{{ $product->name }}</h6>
                            <p class="card-text text-secondary small">{{ Str::limit($product->description, 40) }}</p>
                            
                            <div class="price-section mb-2">
                                <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} TL</span>
                            </div>
                            
                            <div class="product-meta">
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
            <div class="text-center mt-4">
                <a href="{{ route('products.used') }}" class="btn btn-outline-warning btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>عرض جميع المنتجات المستعملة
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- أفضل التجار -->
    @if($merchants->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="text-success mb-3 section-title">🏆 أفضل المتاجر</h2>
                    <p class="text-muted">تعرف على أفضل التجار في منصتنا</p>
                </div>
            </div>
            <div class="row">
                @foreach($merchants->take(6) as $merchant)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modern-card merchant-card text-center h-100">
                        <div class="card-body p-4">
                            <div class="merchant-avatar mb-3">
                                <img src="{{ $merchant->getAvatarUrlAttribute() }}" 
                                     class="merchant-img" 
                                     alt="{{ $merchant->name }}">
                            </div>
                            <h5 class="card-title text-dark mb-2">{{ $merchant->name }}</h5>
                            <p class="card-text text-secondary mb-3">{{ $merchant->store_name }}</p>
                            
                            <div class="merchant-info">
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
                                
                                <a href="{{ route('merchants.show', $merchant->id) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-store me-2"></i>زيارة المتجر
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('merchants.index') }}" class="btn btn-outline-success btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>عرض جميع المتاجر
                </a>
            </div>
        </div>
    </section>
    @endif
</div>

<style>
.hero-slider {
    margin-top: 0;
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
    background-color: rgba(255, 255, 255, 0.5);
    border: 2px solid transparent;
}

.carousel-indicators button.active {
    background-color: #ffffff;
    border-color: #ffffff;
}

.floating-element {
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
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
    background: linear-gradient(135deg, currentColor, transparent);
    border-radius: 2px;
}

/* تحسينات البطاقات */
.modern-card {
    background: #ffffff;
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

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
    transition: transform 0.5s ease;
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

.used-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #f59e0b;
    color: white;
    border-radius: 8px;
    padding: 6px 12px;
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
    border-color: #10b981;
    transform: scale(1.1);
}

.btn-view-product {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
}

.bg-light {
    background: #f8f9fa !important;
}

/* إصلاح مشكلة البادجة */
.position-absolute {
    z-index: 10 !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
    .slider-text h1 {
        font-size: 2rem;
    }
    
    .slider-actions .btn {
        margin-bottom: 10px;
        width: 100%;
    }
    
    .modern-card:hover {
        transform: translateY(-5px);
    }
    
    .card-img-container {
        height: 180px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تشغيل السلايدر تلقائياً
    const myCarousel = document.getElementById('plansSlider');
    const carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
        wrap: true,
        pause: false
    });

    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.modern-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
