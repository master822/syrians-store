@extends('layouts.app')

@section('title', 'المنتجات المستعملة - متجر التخفيضات')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- رأس الصفحة -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="text-primary mb-2"> المنتجات المستعملة</h1>
                </div>
            </div>
            <p class="text-muted mb-4">منتجات مستعملة بحالة جيدة من مستخدمين موثوقين - فرص رائعة بأسعار مناسبة</p>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="modern-card product-card h-100">
                                @if($product->discount_percentage > 0)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-danger fs-7">خصم {{ $product->discount_percentage }}%</span>
                                    </div>
                                @endif
                                
                                <div class="used-badge">مستعمل</div>
                                
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
                                    
                                    <div class="product-meta">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small">
                                                <i class="fas fa-store me-1"></i>
                                                {{ $product->user->name }}
                                            </span>
                                            <span class="text-muted small">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ $product->views }}
                                            </span>
                                        </div>
                                        <div class="condition-badge">
                                            <small class="text-dark"><strong>الحالة:</strong> {{ $product->condition }}</small>
                                        </div>
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

                <!-- التصفح -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">لا توجد منتجات مستعملة حالياً</h4>
                        <p class="text-muted mb-4">كن أول من يضيف منتجاً مستعملاً للبيع</p>
                        @auth
                            @if(Auth::user()->user_type === 'user')
                                <a href="{{ route('user.products.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>إضافة منتج مستعمل
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>انضم كـ مستخدم عادي
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>انضم كـ مستخدم عادي
                            </a>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.modern-card {
    background: #ffffff;
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.used-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #f59e0b;
    color: white;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.card-img-container {
    position: relative;
    overflow: hidden;
    height: 220px;
    border-radius: 12px 12px 0 0;
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

.card-title {
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    color: #2d3748 !important;
}

.card-text {
    color: #64748b !important;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.price-section {
    margin: 1rem 0;
}

.condition-badge {
    background: #fef3c7;
    color: #92400e;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 10px;
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
    padding: 60px 20px;
}

.product-meta {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
    margin-top: 1rem;
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
    .modern-card:hover {
        transform: translateY(-5px);
    }
    
    .card-img-container {
        height: 180px;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-group .btn {
        width: 100%;
    }
}

/* التصفح */
.pagination {
    justify-content: center;
}

.page-link {
    border: none;
    color: #4361ee;
    padding: 10px 18px;
    border-radius: 8px;
    margin: 0 4px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: #4361ee;
    color: white;
    transform: translateY(-2px);
}

.page-item.active .page-link {
    background: #4361ee;
    border-color: #4361ee;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.modern-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
