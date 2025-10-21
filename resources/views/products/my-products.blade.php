@extends('layouts.app')

@section('title', 'منتجاتي')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary">منتجاتي</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                </a>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="modern-card product-card">
                            @if($product->discount_percentage > 0)
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
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
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="price-section mb-2">
                                    @if($product->discount_percentage > 0)
                                        @php
                                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                        @endphp
                                        <span class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                        <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                    @else
                                        <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} ر.س</span>
                                    @endif
                                </div>
                                
                                <div class="product-status mb-2">
                                    <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    @if($product->is_used)
                                        <span class="badge bg-info">مستعمل</span>
                                    @endif
                                </div>
                                
                                <div class="product-actions d-flex gap-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i>عرض
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm flex-fill">
                                        <i class="fas fa-edit me-1"></i>تعديل
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            <i class="fas fa-trash me-1"></i>حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">لا توجد منتجات</h4>
                        <p class="text-muted mb-4">لم تقم بإضافة أي منتجات بعد</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    border: 1px solid #e2e8f0;
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

.empty-state {
    padding: 3rem 1rem;
}

.product-actions .btn {
    font-size: 0.8rem;
    padding: 0.4rem 0.6rem;
}

.price-section {
    margin: 1rem 0;
}

.product-status {
    margin-bottom: 1rem;
}
</style>
@endsection
