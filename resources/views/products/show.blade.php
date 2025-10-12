@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5 fade-in">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card product-card">
                <div class="card-body p-0">
                    @if($product->images)
                        @php
                            $images = json_decode($product->images);
                            $firstImage = $images[0] ?? null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top w-100" alt="{{ $product->name }}" style="height: 400px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <span class="text-muted">لا توجد صورة</span>
                            </div>
                        @endif
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <span class="text-muted">لا توجد صورة</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card animated-card">
                <div class="card-header">
                    <h2 class="mb-0">{{ $product->name }}</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="text-success mb-3">{{ number_format($product->price) }} ل.س</h3>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge {{ $product->is_used ? 'bg-warning' : 'bg-success' }}">
                                {{ $product->is_used ? '🔄 منتج مستعمل' : '🆕 منتج جديد' }}
                            </span>
                            <span class="badge bg-info">
                                <i class="fas fa-eye me-1"></i>{{ $product->views }} مشاهدة
                            </span>
                        </div>
                    </div>

                    @if($product->is_used && $product->condition)
                        <div class="mb-4">
                            <h5>حالة المنتج</h5>
                            <p class="text-muted">{{ $product->condition }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>الوصف</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>البائع</h5>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">{{ $product->user->name }}</h6>
                                <small class="text-muted">{{ $product->user->city }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-lg flex-fill">
                            <i class="fas fa-shopping-cart me-2"></i>إضافة إلى السلة
                        </button>
                        <button class="btn btn-outline-warning btn-lg">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    border-radius: 20px;
    overflow: hidden;
}

.product-card img {
    border-radius: 20px;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .product-card img {
        height: 300px !important;
    }
    
    .btn-lg {
        padding: 12px 20px;
        font-size: 1rem;
    }
}
</style>
@endsection
