@extends('layouts.app')

@section('title', 'جميع التجار - متجر التخفيضات')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-primary mb-3">🛍️ جميع التجار</h1>
            <p class="text-muted">اكتشف أفضل المتاجر والعلامات التجارية في منصتنا</p>
        </div>
    </div>

    <!-- فلترة التجار -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body">
                    <div class="row g-3">
                        
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة التجار -->
    <div class="row">
        @if($merchants->count() > 0)
            @foreach($merchants as $merchant)
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="modern-card merchant-card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="{{ $merchant->store_logo_url }}" 
                                     alt="{{ $merchant->store_name }}" 
                                     class="merchant-logo rounded-circle"
                                     style="width: 70px; height: 70px; object-fit: cover;">
                            </div>
                            <div class="col-9">
                                <h5 class="merchant-name mb-1">{{ $merchant->store_name }}</h5>
                                <p class="merchant-category text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $merchant->getCategoryName($merchant->store_category) }}
                                </p>
                                <div class="merchant-info">
                                    <div class="rating-stars mb-2">
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
                                        <span class="text-muted ms-1">({{ number_format($avgRating, 1) }})</span>
                                    </div>
                                    <div class="merchant-stats">
                                        <small class="text-muted me-3">
                                            <i class="fas fa-box me-1"></i>
                                            {{ $merchant->products_count }} منتج
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $merchant->store_city }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('merchants.show', $merchant->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-store me-1"></i>زيارة المتجر
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-store fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">لا توجد متاجر</h4>
                        <p class="text-muted">لم يتم العثور على متاجر في هذه الفئة</p>
                        <a href="{{ route('merchants.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>عرض جميع المتاجر
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- الترقيم الصفحي -->
    @if($merchants->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center mt-4">
                {{ $merchants->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.merchant-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.merchant-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #4361ee;
}

.merchant-logo {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.merchant-card:hover .merchant-logo {
    border-color: #4361ee;
    transform: scale(1.1);
}

.merchant-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.merchant-category {
    font-size: 0.85rem;
}

.rating-stars {
    direction: ltr;
    unicode-bidi: bidi-override;
}

.merchant-stats {
    font-size: 0.8rem;
}

.btn-outline-primary.active {
    background-color: #4361ee;
    border-color: #4361ee;
    color: white;
}

.modern-card {
    background: #ffffff;
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.empty-state {
    padding: 3rem 1rem;
}

@media (max-width: 768px) {
    .merchant-logo {
        width: 50px !important;
        height: 50px !important;
    }
    
    .merchant-name {
        font-size: 1rem;
    }
    
    .btn-group {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .btn-group .btn {
        flex: 1;
        min-width: 120px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.merchant-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
