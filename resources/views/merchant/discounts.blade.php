@extends('layouts.app')

@section('title', 'إدارة التخفيضات')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary">
                    <i class="fas fa-tag me-2"></i>التخفيضات
                </h1>
                <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>إنشاء تخفيض جديد
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="modern-card product-card">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                        </div>
                        
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
                                @php
                                    $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                @endphp
                                <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} TL</span>
                                <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} TL</small>
                            </div>
                            
                            <div class="product-meta mb-3">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>
                                        <i class="fas fa-eye me-1"></i>
                                        {{ $product->views }} مشاهدة
                                    </span>
                                    <span class="text-success">
                                        وفر {{ number_format($product->price - $discountedPrice, 2) }} TL
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            <div class="btn-group w-100">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('merchant.discounts.edit', $product->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('merchant.discounts.remove', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('هل أنت متأكد من إزالة التخفيض؟')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h4 class="text-primary">لا توجد تخفيضات</h4>
                    <p class="text-muted">لم تقم بإنشاء أي تخفيضات بعد</p>
                    <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>إنشاء أول تخفيض
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
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

.card-action .btn-group {
    border-radius: 0 0 15px 15px;
    overflow: hidden;
}

.card-action .btn {
    border-radius: 0;
    flex: 1;
}

.product-meta {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}
</style>
@endsection
