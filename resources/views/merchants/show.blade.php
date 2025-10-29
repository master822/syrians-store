@extends('layouts.app')

@section('title', $merchant->store_name . ' - متجر التخفيضات')

@section('content')
<div class="container py-4">
    <!-- معلومات المتجر -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $merchant->store_logo_url }}" 
                                 alt="{{ $merchant->store_name }}" 
                                 class="store-logo rounded-circle"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h1 class="store-name text-primary mb-2">{{ $merchant->store_name }}</h1>
                            <p class="store-description text-muted mb-3">{{ $merchant->store_description }}</p>
                            <div class="store-meta">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $merchant->store_city }}
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>
                                            {{ $merchant->store_phone }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="rating-section">
                                <div class="rating-stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating))
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 text-muted">({{ number_format($averageRating, 1) }})</span>
                                </div>
                                <div class="total-ratings mb-3">
                                    <small class="text-muted">{{ $totalRatings }} تقييم</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- منتجات المتجر -->
    <div class="row">
        <div class="col-12">
            <h3 class="section-title mb-4">منتجات المتجر</h3>
            
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
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

                <!-- الترقيم الصفحي -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">لا توجد منتجات في هذا المتجر</h4>
                        <p class="text-muted">لم يقم التاجر بإضافة أي منتجات بعد</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.store-logo {
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.store-logo:hover {
    border-color: #4361ee;
    transform: scale(1.05);
}

.store-name {
    font-size: 1.8rem;
    font-weight: 700;
}

.store-description {
    font-size: 1rem;
    line-height: 1.6;
}

.section-title {
    position: relative;
    display: inline-block;
    font-weight: 700;
    color: #2d3748;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    right: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border-radius: 2px;
}

.rating-stars {
    direction: ltr;
    unicode-bidi: bidi-override;
}

.modern-card {
    background: #ffffff;
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    overflow: hidden;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.card-img-container {
    position: relative;
    overflow: hidden;
    height: 200px;
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

.empty-state {
    padding: 3rem 1rem;
}

@media (max-width: 768px) {
    .store-name {
        font-size: 1.5rem;
    }
    
    .store-logo {
        width: 80px;
        height: 80px;
        margin-bottom: 1rem;
    }
}
</style>
@endsection
