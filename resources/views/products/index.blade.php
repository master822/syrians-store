@extends('layouts.app')

@section('title', 'جميع المنتجات')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center text-primary mb-3">جميع المنتجات</h1>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="modern-card product-card h-100">
                    @if($product->discount_percentage > 0)
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                            <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
                        </div>
                    @endif
                    
                    <div class="card-img-container">
                        @if($product->images)
                            @php
                                $images = json_decode($product->images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage && file_exists(storage_path('app/public/' . $firstImage)))
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
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="price-section mb-2">
                            @if($product->discount_percentage > 0)
                                @php
                                    $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                @endphp
                                <span class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} TL</span>
                                <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} TL</small>
                            @else
                                <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} TL</span>
                            @endif
                        </div>
                        
                        <div class="product-info mb-3">
                            <small class="text-muted d-block">
                                <i class="fas fa-store me-1"></i>
                                {{ $product->user->name }}
                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-eye me-1"></i>
                                {{ $product->views }} مشاهدة
                            </small>
                            @if($product->is_used)
                                <span class="badge bg-info mt-1">مستعمل</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-2"></i>عرض المنتج
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد منتجات</h4>
            <p class="text-muted">لم يتم إضافة أي منتجات بعد</p>
            @auth
                @if(auth()->user()->isMerchant() || auth()->user()->isRegularUser())
                    <a href="{{ auth()->user()->isMerchant() ? route('merchant.products.create') : route('user.products.create') }}" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    position: relative;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-img-container {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.card-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.modern-card:hover .card-product-image {
    transform: scale(1.05);
}

.no-image-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
}

.price-section {
    margin: 1rem 0;
}

.product-info {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
}

/* إصلاح مشكلة البادجة */
.position-absolute {
    z-index: 10 !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
</style>
@endsection
