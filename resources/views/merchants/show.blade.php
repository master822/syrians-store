@extends('layouts.app')

@section('title', $merchant->store_name)

@section('content')
<div class="container py-4">
    <!-- رأس المتجر -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="modern-card p-4">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <img src="{{ $merchant->getStoreLogoUrlAttribute() }}" 
                             alt="{{ $merchant->store_name }}" 
                             class="store-logo rounded-circle mb-3">
                    </div>
                    <div class="col-md-6">
                        <h1 class="text-primary mb-2">{{ $merchant->store_name }}</h1>
                        <p class="text-muted mb-3">{{ $merchant->store_description }}</p>
                        
                        <div class="store-info">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $merchant->store_city }}</p>
                                    <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i>{{ $merchant->store_phone }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><i class="fas fa-box text-primary me-2"></i>{{ $merchant->products_count }} منتج</p>
                                    <p class="mb-1"><i class="fas fa-star text-warning me-2"></i>التقييم: {{ number_format($averageRating, 1) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
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
                            </div>
                            <p class="text-muted">({{ $totalRatings }} تقييم)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- منتجات المتجر -->
    <div class="row">
        <div class="col-12">
            <h3 class="text-primary mb-4">منتجات المتجر</h3>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="modern-card product-card">
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
                        </div>
                        
                        <div class="card-action">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- التصفح -->
        <div class="row mt-4">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-primary">لا توجد منتجات</h4>
                    <p class="text-muted">هذا المتجر لا يحتوي على منتجات حالياً</p>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.store-logo {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 3px solid #e9ecef;
}

.store-info p {
    margin-bottom: 0.5rem;
}

.rating-stars {
    font-size: 1.2rem;
}

.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: none;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-img-container {
    height: 200px;
    overflow: hidden;
    border-radius: 15px 15px 0 0;
}

.card-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .card-product-image {
    transform: scale(1.05);
}

.no-image-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.card-action .btn {
    border-radius: 0 0 15px 15px;
}
</style>
@endsection
