@extends('layouts.app')

@section('title', 'منتجاتي المستعملة')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-primary">
                    <i class="fas fa-boxes me-2"></i>منتجاتي المستعملة
                </h1>
                <a href="{{ route('user.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>إضافة منتج مستعمل
                </a>
            </div>
            <p class="text-muted">إدارة منتجاتك المستعملة المعروضة للبيع</p>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">إجمالي المنتجات</h6>
                            <h3 class="mb-0">{{ $products->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">المنتجات النشطة</h6>
                            <h3 class="mb-0">{{ $products->where('status', 'active')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">إجمالي المشاهدات</h6>
                            <h3 class="mb-0">{{ $products->sum('views') }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-eye fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">الحد المسموح</h6>
                            <h3 class="mb-0">{{ Auth::user()->product_limit }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100">
                    @if($product->discount_percentage > 0)
                        <div class="position-absolute top-0 start-0 m-2">
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
                                <i class="fas fa-eye me-1"></i>
                                {{ $product->views }} مشاهدة
                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $product->created_at->diffForHumans() }}
                            </small>
                            <span class="badge bg-info mt-1">{{ $product->condition }}</span>
                            <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }} mt-1">
                                {{ $product->status === 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100 btn-sm">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-secondary w-100 btn-sm">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد منتجات</h4>
            <p class="text-muted">لم تقم بإضافة أي منتجات مستعملة بعد</p>
            <a href="{{ route('user.products.create') }}" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-plus me-2"></i>إضافة منتج جديد
            </a>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.product-card:hover {
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

.product-card:hover .card-product-image {
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
</style>
@endsection
