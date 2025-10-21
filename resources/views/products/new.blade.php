@extends('layouts.app')

@section('title', 'المنتجات الجديدة')

@section('content')
<div class="container py-4 fade-in">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="section-title gradient-text">🆕 المنتجات الجديدة</h1>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">
                        جميع المنتجات
                    </a>
                    <a href="{{ route('products.used') }}" class="btn btn-outline-warning btn-sm">
                        المنتجات المستعملة
                    </a>
                    @auth
                        @if(auth()->user()->user_type === 'merchant')
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                إضافة منتج جديد
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <p class="text-muted mb-4">منتجات جديدة وعالية الجودة من تجار موثوقين - أحدث العروض وأجود المنتجات</p>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card product-card h-100">
                                @if($product->images)
                                    @php
                                        $images = json_decode($product->images);
                                        $firstImage = $images[0] ?? null;
                                    @endphp
                                    @if($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <span class="text-muted">لا توجد صورة</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="text-muted">لا توجد صورة</span>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h5 text-success">{{ number_format($product->price) }} ل.س</span>
                                            <span class="badge bg-success">🆕 جديد</span>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-tag me-1"></i>
                                                @if($product->category)
                                                    {{ $product->category->name }}
                                                @else
                                                    غير مصنف
                                                @endif
                                            </small>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-store me-1"></i>
                                                {{ $product->user->store_name ?? $product->user->name }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ $product->views }}
                                            </small>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm flex-fill">
                                                عرض التفاصيل
                                            </a>
                                            @auth
                                                @if(Auth::id() === $product->user_id)
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm">
                                                        تعديل
                                                    </a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">لا توجد منتجات جديدة حالياً</h3>
                        <p class="text-muted mb-4">التجار يمكنهم إضافة منتجات جديدة للبيع في منصتنا!</p>
                        @auth
                            @if(auth()->user()->user_type === 'merchant')
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                                    إضافة منتج جديد
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                    سجل كتاجر
                                </a>
                            @endif
                        @else
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                    سجل كتاجر
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                                    تسجيل الدخول
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    border-color: var(--primary-red);
}

.empty-state {
    padding: 3rem 1rem;
}

@media (max-width: 768px) {
    .container {
        padding: 0.5rem;
    }
    
    .section-title {
        font-size: 1.4rem;
        text-align: center;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .product-card .card-body {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection
