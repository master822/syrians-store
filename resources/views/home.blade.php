@extends('layouts.app')

@section('title', 'الصفحة الرئيسية - متجر التخفيضات')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 slide-in-left">
                <h1 class="display-4 fw-bold mb-4 gradient-text">
                    اكتشف عالماً من <span class="floating">🎯</span> التخفيضات
                </h1>
                <p class="lead mb-4 text-muted">
                    أفضل العروض الحصرية من تجار موثوقين. تسوق بذكاء ووفر أكثر!
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#products" class="btn btn-modern pulse-animation">
                        🛍️ ابدأ التسوق
                    </a>
                    <a href="#discounts" class="btn btn-outline-primary rounded-pill px-4">
                        🔥 عروض اليوم
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center fade-in-up">
                <div class="hero-image position-relative">
                    <div class="floating" style="animation-delay: 0.2s;">
                        <img src="https://cdn-icons-png.flaticon.com/512/3737/3737372.png" 
                             alt="Shopping" class="img-fluid" style="max-height: 400px;">
                    </div>
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="position-absolute top-0 start-0 rounded-circle bg-primary opacity-25" 
                             style="width: 100px; height: 100px; animation: floating 3s ease-in-out infinite 0.5s;"></div>
                        <div class="position-absolute bottom-0 end-0 rounded-circle bg-warning opacity-25" 
                             style="width: 150px; height: 150px; animation: floating 3s ease-in-out infinite 1s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- المنتجات الجديدة -->
@if($newProducts->count() > 0)
<section id="products" class="py-5 mb-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title gradient-text fw-bold display-5">
                    🆕 المنتجات الجديدة
                </h2>
                <p class="text-muted lead">أحدث الإضافات إلى متجرنا</p>
            </div>
        </div>
        <div class="row">
            @foreach($newProducts as $index => $product)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="animated-card h-100 fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    @if($product->discount_percentage > 0)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger fs-6 glow-effect">خصم {{ $product->discount_percentage }}%</span>
                        </div>
                    @endif
                    
                    <div class="product-image-container position-relative overflow-hidden">
                        @if($product->discount_images)
                            @php
                                $images = json_decode($product->discount_images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" 
                                     class="card-img-top product-image" 
                                     alt="{{ $product->name }}"
                                     style="height: 250px; object-fit: cover; transition: transform 0.5s ease;">
                            @else
                                <div class="card-img-top bg-light-gradient d-flex align-items-center justify-content-center" 
                                     style="height: 250px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        @else
                            <div class="card-img-top bg-light-gradient d-flex align-items-center justify-content-center" 
                                 style="height: 250px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                            <a href="/products/{{ $product->id }}" class="btn btn-modern btn-sm opacity-0">
                                👀 عرض سريع
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="price-section">
                                @if($product->discount_percentage > 0)
                                    @php
                                        $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                    @endphp
                                    <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                @else
                                    <span class="fw-bold fs-5 text-dark">{{ number_format($product->price, 2) }} ر.س</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-store me-1"></i>
                                {{ $product->user->name }}
                            </small>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <small class="text-muted">4.5</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="/products/{{ $product->id }}" class="btn btn-outline-primary w-100 rounded-pill">
                            🛒 إضافة إلى السلة
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- التخفيضات -->
@if($activeDiscounts->count() > 0)
<section id="discounts" class="py-5 mb-5 bg-light rounded-4">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title gradient-text fw-bold display-5">
                    🔥 عروض حصرية
                </h2>
                <p class="text-muted lead">لا تفوت هذه الفرص المميزة</p>
            </div>
        </div>
        <div class="row">
            @foreach($activeDiscounts as $index => $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="animated-card h-100 border-warning slide-in-left" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="card-header bg-warning-gradient border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 fw-bold text-white">{{ $product->name }}</h5>
                            <span class="badge bg-white text-warning fs-6 pulse-animation">
                                ⚡ محدود
                            </span>
                        </div>
                    </div>
                    
                    @if($product->discount_images)
                        @php
                            $images = json_decode($product->discount_images);
                            $firstImage = $images[0] ?? null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                    @endif
                    
                    <div class="card-body p-4">
                        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="discount-info text-center mb-3">
                            <span class="badge bg-danger fs-5 px-3 py-2 glow-effect mb-2">
                                خصم {{ $product->discount_percentage }}%
                            </span>
                            <div class="price-comparison mt-2">
                                @php
                                    $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                @endphp
                                <span class="text-success fw-bold fs-4">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                <small class="text-muted text-decoration-line-through d-block fs-6">
                                    {{ number_format($product->price, 2) }} ر.س
                                </small>
                            </div>
                        </div>
                        
                        <div class="merchant-info text-center">
                            <small class="text-muted">
                                <i class="fas fa-crown me-1 text-warning"></i>
                                {{ $product->user->name }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 p-3">
                        <a href="/products/{{ $product->id }}" class="btn btn-warning btn-modern w-100">
                            🎁 استفد من العرض
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- التجار -->
@if($merchants->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title gradient-text fw-bold display-5">
                    🏪 تجارنا المميزون
                </h2>
                <p class="text-muted lead">تعرف على أفضل التجار في منصتنا</p>
            </div>
        </div>
        <div class="row">
            @foreach($merchants as $index => $merchant)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="animated-card text-center p-4 fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="merchant-avatar mb-3">
                        <div class="rounded-circle bg-primary-gradient d-inline-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-store fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $merchant->name }}</h5>
                    <div class="merchant-stats mb-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-box me-1"></i>
                            {{ $merchant->products_count }} منتج
                        </span>
                    </div>
                    <a href="/merchant/{{ $merchant->id }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        زيارة المتجر
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($newProducts->count() == 0 && $activeDiscounts->count() == 0)
<section class="py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="animated-card p-5">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">لا توجد منتجات أو تخفيضات حالياً</h3>
                    <p class="text-muted mb-4">كن أول من يضيف منتجات وتخفيضات!</p>
                    <a href="{{ route('register') }}" class="btn btn-modern">
                        🚀 ابدأ البيع الآن
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<style>
.hero-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-radius: 30px;
    margin: 20px;
}

.bg-warning-gradient {
    background: linear-gradient(135deg, #ffd700 0%, #ff8c00 100%) !important;
}

.bg-primary-gradient {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
}

.bg-light-gradient {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

.product-image-container:hover .product-image {
    transform: scale(1.1);
}

.product-image-container:hover .product-overlay a {
    opacity: 1 !important;
    transform: translateY(0);
}

.product-overlay {
    background: rgba(0, 0, 0, 0.7);
    opacity: 0;
    transition: all 0.3s ease;
}

.product-image-container:hover .product-overlay {
    opacity: 1;
}

.product-overlay a {
    transform: translateY(20px);
    transition: all 0.3s ease 0.1s;
}

.merchant-avatar {
    transition: transform 0.3s ease;
}

.merchant-avatar:hover {
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to product cards
    const productCards = document.querySelectorAll('.animated-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection
