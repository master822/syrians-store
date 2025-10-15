@extends('layouts.app')

@section('title', 'جميع المنتجات')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center section-title gradient-text">🛍️ جميع المنتجات</h1>
            <p class="text-center text-muted">اكتشف أفضل المنتجات من تجارنا المميزين</p>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="animated-card h-100">
                    @if($product->discount_percentage > 0)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger glow-effect">خصم {{ $product->discount_percentage }}%</span>
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
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light-gradient d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        @else
                            <div class="card-img-top bg-light-gradient d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
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
                                    <span class="fw-bold">{{ number_format($product->price, 2) }} ر.س</span>
                                @endif
                            </div>
                            <span class="badge bg-secondary">
                                @switch($product->category)
                                    @case('clothes') 👕 @break
                                    @case('electronics') 📱 @break
                                    @case('home') 🏠 @break
                                    @case('food') 🍎 @break
                                @endswitch
                            </span>
                        </div>
                        
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-store me-1"></i>
                            بواسطة: {{ $product->user->name }}
                        </small>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary w-100">
                            عرض التفاصيل
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
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد منتجات متاحة حالياً</h4>
            <p class="text-muted">يمكنك العودة لاحقاً أو استعراض الأقسام الأخرى</p>
            <a href="{{ url('/') }}" class="btn btn-modern">العودة للرئيسية</a>
        </div>
    @endif
</div>
@endsection
