@extends('layouts.app')

@section('title', 'منتجات ' . $category->name)

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-primary">{{ $category->name,  }}</h1>
                    
                    @if($category->description)
                        <p class="text-muted">{{ $category->description }}</p>
                    @endif
                </div>
                <div class="text-end">
                     <a href="{{ route('products.search') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i>البحث عن منتجات
            </a>
                    <span class="badge bg-primary fs-6">{{ $products->total() }} منتج</span>
                </div>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        @if($product->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
                            </div>
                        @endif
                        
                        @if($product->is_used)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-warning text-dark">مستعمل</span>
                            </div>
                        @endif
                        
                        @if($product->images)
                            @php
                                $images = json_decode($product->images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                            
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                                
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                            
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
                                <small class="text-muted">
                                    <i class="fas fa-store me-1"></i>{{ $product->user->name }}
                                </small>
                                @if($product->is_used && $product->condition)
                                    <small class="text-muted ms-2">
                                        <i class="fas fa-info-circle me-1"></i>{{ $product->condition }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- الترقيم -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد منتجات في هذا التصنيف</h4>
            <p class="text-muted mb-4">يمكنك استعراض التصنيفات الأخرى أو البحث عن منتجات</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary me-2">
                <i class="fas fa-arrow-right me-2"></i>استعراض جميع المنتجات
            </a>
            <a href="{{ route('products.search') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i>البحث عن منتجات
            </a>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.price-section {
    margin: 15px 0;
}

.product-meta {
    border-top: 1px solid #e9ecef;
    padding-top: 10px;
    margin-top: 10px;
}
</style>
@endsection
